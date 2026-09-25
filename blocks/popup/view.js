import { getElement, store, withScope, withSyncEvent } from '@wordpress/interactivity';

function getRoot( element ) {
	return element && element.closest( '.vaarta-popup' );
}

function getDialog( root ) {
	return root && root.querySelector( '.vaarta-popup__dialog' );
}

function getSessionKey( root ) {
	return 'vaarta-popup:' + ( root?.dataset.popupKey || 'default' );
}

function wasShown( root ) {
	if ( root?.dataset.trigger === 'button' || root?.dataset.oncePerSession !== 'true' ) {
		return false;
	}

	try {
		return sessionStorage.getItem( getSessionKey( root ) ) === '1';
	} catch ( error ) {
		return false;
	}
}

function markShown( root ) {
	if ( root?.dataset.trigger === 'button' || root?.dataset.oncePerSession !== 'true' ) {
		return;
	}

	try {
		sessionStorage.setItem( getSessionKey( root ), '1' );
	} catch ( error ) {
		// Session storage may be disabled.
	}
}

function openPopup( root ) {
	const dialog = getDialog( root );
	if ( ! root || ! dialog || wasShown( root ) ) {
		return;
	}

	dialog.hidden = false;
	root.classList.add( 'is-open' );
	document.documentElement.classList.add( 'vaarta-popup-open' );
	markShown( root );

	window.setTimeout( () => {
		const focusTarget = dialog.querySelector( 'input, button:not(.vaarta-popup__close), a, textarea, select' );
		( focusTarget || dialog.querySelector( '.vaarta-popup__close' ) )?.focus();
	}, 0 );
}

function closePopup( root ) {
	const dialog = getDialog( root );
	if ( ! root || ! dialog ) {
		return;
	}

	dialog.hidden = true;
	root.classList.remove( 'is-open' );

	if ( ! document.querySelector( '.vaarta-popup.is-open' ) ) {
		document.documentElement.classList.remove( 'vaarta-popup-open' );
	}

	root.querySelector( '.vaarta-popup__trigger' )?.focus();
}

store( 'vaarta/popup', {
	actions: {
		open() {
			openPopup( getRoot( getElement().ref ) );
		},
		close() {
			closePopup( getRoot( getElement().ref ) );
		},
		backdrop: withSyncEvent( ( event ) => {
			if ( event.target.classList.contains( 'vaarta-popup__dialog' ) ) {
				closePopup( getRoot( event.target ) );
			}
		} ),
		keydown: withSyncEvent( ( event ) => {
			if ( event.key !== 'Escape' ) {
				return;
			}

			const root = getRoot( getElement().ref );
			if ( root?.classList.contains( 'is-open' ) ) {
				closePopup( root );
			}
		} )
	},
	callbacks: {
		init() {
			const { ref } = getElement();
			const root = ref;
			if ( ! root || wasShown( root ) ) {
				return;
			}

			const trigger = root.dataset.trigger;

			if ( trigger === 'delay' ) {
				const delay = Number.parseInt( root.dataset.delayMs || '5000', 10 );
				const scopedOpen = withScope( () => openPopup( root ) );
				window.setTimeout( scopedOpen, delay );
				return;
			}

			if ( trigger === 'scroll' ) {
				const threshold = Number.parseInt( root.dataset.scrollPercent || '50', 10 );
				const scopedCheck = withScope( () => {
					const scrollable = document.documentElement.scrollHeight - window.innerHeight;
					const progress = scrollable > 0 ? ( window.scrollY / scrollable ) * 100 : 100;

					if ( progress >= threshold ) {
						window.removeEventListener( 'scroll', scopedCheck );
						openPopup( root );
					}
				} );

				window.addEventListener( 'scroll', scopedCheck, { passive: true } );
				scopedCheck();
			}
		}
	}
} );
