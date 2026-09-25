import { getConfig, getElement, store } from '@wordpress/interactivity';

function getRoot( element ) {
	return element.closest( '.vaarta-search-overlay' );
}

function setStatus( root, message ) {
	const status = root.querySelector( '.vaarta-search-overlay__status' );
	if ( status ) {
		status.textContent = message;
	}
}

function getFocusable( container ) {
	return Array.from(
		container.querySelectorAll(
			'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
		)
	).filter( ( element ) => ! element.hidden && element.offsetParent !== null );
}

function trapFocus( event, dialog ) {
	if ( event.key !== 'Tab' || ! dialog ) {
		return false;
	}

	const focusable = getFocusable( dialog );
	if ( ! focusable.length ) {
		event.preventDefault();
		dialog.focus?.();
		return true;
	}

	const first = focusable[ 0 ];
	const last = focusable[ focusable.length - 1 ];

	if ( event.shiftKey && document.activeElement === first ) {
		event.preventDefault();
		last.focus();
		return true;
	}

	if ( ! event.shiftKey && document.activeElement === last ) {
		event.preventDefault();
		first.focus();
		return true;
	}

	return false;
}

function clearResults( root ) {
	const results = root.querySelector( '.vaarta-search-overlay__results' );
	if ( results ) {
		results.replaceChildren();
	}
}

function renderResults( root, payload ) {
	const results = root.querySelector( '.vaarta-search-overlay__results' );
	if ( ! results ) {
		return;
	}

	results.replaceChildren();

	payload.results.forEach( ( item ) => {
		const article = document.createElement( 'article' );
		article.className = 'vaarta-search-result';

		if ( item.image ) {
			const imageLink = document.createElement( 'a' );
			imageLink.className = 'vaarta-search-result__media';
			imageLink.href = item.url;
			imageLink.tabIndex = -1;
			imageLink.setAttribute( 'aria-hidden', 'true' );

			const image = document.createElement( 'img' );
			image.src = item.image;
			image.alt = '';
			image.loading = 'lazy';

			imageLink.append( image );
			article.append( imageLink );
		}

		const body = document.createElement( 'div' );
		body.className = 'vaarta-search-result__body';

		if ( item.category ) {
			const category = document.createElement( 'div' );
			category.className = 'vaarta-search-result__category';
			category.textContent = item.category;
			body.append( category );
		}

		const heading = document.createElement( 'h3' );
		heading.className = 'vaarta-search-result__title';

		const link = document.createElement( 'a' );
		link.href = item.url;
		link.textContent = item.title;

		heading.append( link );
		body.append( heading );

		const meta = document.createElement( 'div' );
		meta.className = 'vaarta-search-result__meta';
		meta.textContent = item.readingTime + ' min read';
		body.append( meta );

		article.append( body );
		results.append( article );
	} );
}

store( 'vaarta/search-overlay', {
	actions: {
		open() {
			const { ref } = getElement();
			const root = getRoot( ref );
			const dialog = root && root.querySelector( '.vaarta-search-overlay__dialog' );
			const input = root && root.querySelector( '.vaarta-search-overlay__input' );

			if ( dialog ) {
				dialog.hidden = false;
				document.documentElement.classList.add( 'vaarta-search-open' );
				window.setTimeout( () => input && input.focus(), 0 );
			}
		},
		close() {
			const { ref } = getElement();
			const root = getRoot( ref );
			const dialog = root && root.querySelector( '.vaarta-search-overlay__dialog' );
			const trigger = root && root.querySelector( '.vaarta-search-overlay__trigger' );

			if ( dialog ) {
				dialog.hidden = true;
				document.documentElement.classList.remove( 'vaarta-search-open' );
				trigger && trigger.focus();
			}
		},
		keydown( event ) {
			const { ref } = getElement();
			const root = getRoot( ref );
			const dialog = root && root.querySelector( '.vaarta-search-overlay__dialog' );

			if ( ! dialog || dialog.hidden ) {
				return;
			}

			if ( trapFocus( event, dialog ) ) {
				return;
			}

			if ( event.key === 'Escape' ) {
				dialog.hidden = true;
				document.documentElement.classList.remove( 'vaarta-search-open' );
				const trigger = root.querySelector( '.vaarta-search-overlay__trigger' );
				trigger && trigger.focus();
			}
		},
		*search() {
			const { ref } = getElement();
			const root = getRoot( ref );
			const query = ref.value.trim();
			const { restUrl, minChars } = getConfig( 'vaarta/search-overlay' );
			const limit = Number.parseInt( root.dataset.resultsLimit || '6', 10 );

			yield new Promise( ( resolve ) => window.setTimeout( resolve, 220 ) );

			if ( ref.value.trim() !== query ) {
				return;
			}

			if ( query.length < minChars ) {
				clearResults( root );
				setStatus( root, query.length ? 'Keep typing…' : '' );
				return;
			}

			root.classList.add( 'is-loading' );
			setStatus( root, 'Searching…' );

			try {
				const response = yield fetch(
					restUrl + '?q=' + encodeURIComponent( query ) + '&limit=' + encodeURIComponent( limit ),
					{ credentials: 'same-origin' }
				);

				if ( ! response.ok ) {
					throw new Error( 'Search request failed.' );
				}

				const payload = yield response.json();

				if ( ref.value.trim() !== query ) {
					return;
				}

				renderResults( root, payload );
				setStatus(
					root,
					payload.total
						? payload.total + ( payload.total === 1 ? ' result' : ' results' )
						: 'No stories found.'
				);
			} catch ( error ) {
				clearResults( root );
				setStatus( root, 'Search is temporarily unavailable.' );
			} finally {
				root.classList.remove( 'is-loading' );
			}
		}
	}
} );
