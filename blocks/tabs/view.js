import { getElement, store, withSyncEvent } from '@wordpress/interactivity';

function activateButton( button ) {
	const root = button && button.closest( '.vaarta-tabs' );
	if ( ! root ) {
		return;
	}

	const index = Number.parseInt( button.dataset.vaartaTabIndex || '0', 10 );
	const buttons = root.querySelectorAll( '[role="tab"]' );
	const panels = root.querySelectorAll( '[role="tabpanel"]' );

	buttons.forEach( ( item, itemIndex ) => {
		const active = itemIndex === index;
		item.setAttribute( 'aria-selected', active ? 'true' : 'false' );
		item.setAttribute( 'tabindex', active ? '0' : '-1' );
	} );

	panels.forEach( ( panel, panelIndex ) => {
		panel.hidden = panelIndex !== index;
	} );
}

store( 'vaarta/tabs', {
	actions: {
		activate() {
			const { ref } = getElement();
			activateButton( ref );
		},
		keyboard: withSyncEvent( ( event ) => {
			if ( ! [ 'ArrowLeft', 'ArrowRight', 'Home', 'End' ].includes( event.key ) ) {
				return;
			}

			const { ref } = getElement();
			const root = ref && ref.closest( '.vaarta-tabs' );
			if ( ! root ) {
				return;
			}

			const buttons = Array.from( root.querySelectorAll( '[role="tab"]' ) );
			const current = buttons.indexOf( ref );

			if ( current < 0 || ! buttons.length ) {
				return;
			}

			event.preventDefault();

			let next = current;
			if ( event.key === 'ArrowRight' ) {
				next = ( current + 1 ) % buttons.length;
			} else if ( event.key === 'ArrowLeft' ) {
				next = ( current - 1 + buttons.length ) % buttons.length;
			} else if ( event.key === 'Home' ) {
				next = 0;
			} else if ( event.key === 'End' ) {
				next = buttons.length - 1;
			}

			buttons[ next ].focus();
			activateButton( buttons[ next ] );
		} )
	}
} );
