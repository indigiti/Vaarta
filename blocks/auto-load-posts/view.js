import { getConfig, getElement, store, withScope } from '@wordpress/interactivity';

const api = store( 'vaarta/auto-load-posts', {
	actions: {
		*loadNext() {
			const { ref } = getElement();
			const root = ref.closest( '.vaarta-auto-load' );

			if ( ! root || root.dataset.loading === 'true' || root.dataset.done === 'true' ) {
				return;
			}

			const loaded = Number.parseInt( root.dataset.loaded || '0', 10 );
			const max = Number.parseInt( root.dataset.maxPosts || '3', 10 );

			if ( loaded >= max ) {
				root.dataset.done = 'true';
				return;
			}

			const currentId = Number.parseInt( root.dataset.currentPost || '0', 10 );
			if ( ! currentId ) {
				root.dataset.done = 'true';
				return;
			}

			root.dataset.loading = 'true';
			root.classList.add( 'is-loading' );

			const { restUrl } = getConfig( 'vaarta/auto-load-posts' );

			try {
				const response = yield fetch(
					restUrl + '?post=' + encodeURIComponent( currentId ),
					{ credentials: 'same-origin' }
				);

				if ( ! response.ok ) {
					throw new Error( 'Could not load the next article.' );
				}

				const payload = yield response.json();

				if ( payload.done || ! payload.html ) {
					root.dataset.done = 'true';
					return;
				}

				const container = root.querySelector( '.vaarta-auto-load__items' );
				const template = document.createElement( 'template' );
				template.innerHTML = payload.html.trim();
				const article = template.content.firstElementChild;

				if ( article && container ) {
					container.append( article );
					root.dataset.currentPost = String( payload.id );
					root.dataset.loaded = String( loaded + 1 );

					if ( root._vaartaHistoryObserver ) {
						root._vaartaHistoryObserver.observe( article );
					}

					document.dispatchEvent(
						new CustomEvent( 'vaarta:autoload', {
							detail: {
								id: payload.id,
								url: payload.url,
								title: payload.title
							}
						} )
					);
				}

				if ( loaded + 1 >= max ) {
					root.dataset.done = 'true';
				}
			} catch ( error ) {
				root.dataset.done = 'true';
				root.classList.add( 'has-error' );
			} finally {
				root.dataset.loading = 'false';
				root.classList.remove( 'is-loading' );
			}
		}
	},
	callbacks: {
		init() {
			const { ref } = getElement();
			const root = ref;
			const sentinel = root.querySelector( '.vaarta-auto-load__sentinel' );

			if ( ! sentinel || root._vaartaLoadObserver ) {
				return;
			}

			const scopedLoad = withScope( () => api.actions.loadNext() );

			root._vaartaLoadObserver = new IntersectionObserver(
				( entries ) => {
					if ( entries.some( ( entry ) => entry.isIntersecting ) ) {
						scopedLoad();
					}
				},
				{ rootMargin: '900px 0px' }
			);
			root._vaartaLoadObserver.observe( sentinel );

			root._vaartaHistoryObserver = new IntersectionObserver(
				( entries ) => {
					entries.forEach( ( entry ) => {
						if ( ! entry.isIntersecting || entry.intersectionRatio < 0.45 ) {
							return;
						}

						const url = entry.target.dataset.vaartaArticleUrl;
						const title = entry.target.dataset.vaartaArticleTitle;

						if ( url ) {
							history.replaceState( { vaartaAutoload: true }, '', url );
						}

						if ( title ) {
							document.title = title;
						}
					} );
				},
				{ threshold: [ 0.45, 0.65 ] }
			);
		}
	}
} );
