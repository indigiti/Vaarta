( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
	}

	var api = window.vaartaLoadMore = window.vaartaLoadMore || {};
	var initialized = new WeakSet();
	var observers = new WeakMap();

	function decodeAreaSettings( area ) {
		if ( area.classList.contains( 'cs-posts-area-posts' ) ) {
			return window.vaartaPagination || window.csco_ajax_pagination || null;
		}

		var encoded = area.getAttribute( 'data-posts-area' );
		if ( ! encoded ) {
			return null;
		}

		try {
			return JSON.parse( window.atob( encoded ) );
		} catch ( error ) {
			return null;
		}
	}

	function isInfinite( settings ) {
		return true === settings.infinite_load || 'true' === settings.infinite_load;
	}

	function ensureButton( area, settings ) {
		var pagination = area.querySelector( '.cs-posts-area__pagination' );
		var button = area.querySelector( '.cs-load-more' );

		if ( button ) {
			return button;
		}

		if ( ! pagination ) {
			pagination = document.createElement( 'div' );
			pagination.className = 'cs-posts-area__pagination';
			area.appendChild( pagination );
		}

		button = document.createElement( 'button' );
		button.className = 'cs-load-more';
		button.type = 'button';
		button.innerHTML = '<span class="cs-button-label"></span><span class="cs-button-arrow"><span class="cs-loader-button"></span></span>';
		button.querySelector( '.cs-button-label' ).textContent = settings.translation && settings.translation.load_more ? settings.translation.load_more : 'Load More';
		pagination.appendChild( button );

		return button;
	}

	function normalizeSettings( settings ) {
		return {
			type: settings.type || 'ajax_restapi',
			nonce: settings.nonce || '',
			url: settings.url || '',
			rest_url: settings.rest_url || '',
			posts_per_page: Math.max( 1, parseInt( settings.posts_per_page, 10 ) || 10 ),
			query_data: settings.query_data || '{}',
			attributes: settings.attributes || 'false',
			options: settings.options || 'false',
			infinite_load: settings.infinite_load,
			translation: settings.translation || {}
		};
	}

	function requestBody( settings, page ) {
		var body = new URLSearchParams();
		body.set( 'page', String( page ) );
		body.set( 'posts_per_page', String( settings.posts_per_page ) );
		body.set( 'query_data', 'string' === typeof settings.query_data ? settings.query_data : JSON.stringify( settings.query_data || {} ) );
		body.set( 'attributes', 'string' === typeof settings.attributes ? settings.attributes : JSON.stringify( settings.attributes || false ) );
		body.set( 'options', 'string' === typeof settings.options ? settings.options : JSON.stringify( settings.options || false ) );

		if ( 'ajax_restapi' === settings.type ) {
			body.set( 'nonce', settings.nonce );
		} else {
			body.set( 'action', 'csco_ajax_load_more' );
			body.set( '_ajax_nonce', settings.nonce );
		}

		return body;
	}

	function appendContent( area, html ) {
		var template = document.createElement( 'template' );
		template.innerHTML = html.trim();
		var elements = Array.prototype.slice.call( template.content.children );
		var masonry = area.querySelector( '.cs-posts-area__masonry, .cs-block-posts-layout-masonry-type-1' );
		var target = area.querySelector( '.cs-posts-area__main' );

		if ( ! elements.length || ( ! masonry && ! target ) ) {
			return 0;
		}

		if ( masonry ) {
			if ( window.vaartaMasonry && 'function' === typeof window.vaartaMasonry.append ) {
				window.vaartaMasonry.append( masonry, elements );
			} else {
				elements.forEach( function ( element ) {
					masonry.appendChild( element );
				} );
			}
		} else {
			elements.forEach( function ( element ) {
				target.appendChild( element );
			} );
		}

		document.body.dispatchEvent( new CustomEvent( 'post-load', { bubbles: true } ) );
		runtime.emit( 'vaarta:posts-added', { area: area, elements: elements } );

		if ( window.FB && window.FB.XFBML && 'function' === typeof window.FB.XFBML.parse ) {
			window.FB.XFBML.parse();
		}

		return elements.length;
	}

	function finishButton( button, settings ) {
		button.disabled = false;
		button.removeAttribute( 'aria-busy' );
		button.classList.remove( 'loading' );
		var label = button.querySelector( '.cs-button-label' );
		if ( label ) {
			label.textContent = settings.translation.load_more || 'Load More';
		}
	}

	async function load( area ) {
		if ( area.dataset.vaartaLoading === 'true' ) {
			return;
		}

		var settings = area.vaartaPaginationSettings;
		var button = area.querySelector( '.cs-load-more' );
		if ( ! settings || ! button ) {
			return;
		}

		var page = Math.max( 2, parseInt( area.dataset.vaartaPage, 10 ) || 2 );
		var endpoint = 'ajax_restapi' === settings.type ? settings.rest_url : settings.url;
		if ( ! endpoint ) {
			return;
		}

		area.dataset.vaartaLoading = 'true';
		button.disabled = true;
		button.setAttribute( 'aria-busy', 'true' );
		button.classList.add( 'loading' );
		var label = button.querySelector( '.cs-button-label' );
		if ( label && settings.translation.loading ) {
			label.textContent = settings.translation.loading;
		}

		try {
			var response = await fetch( endpoint, {
				method: 'POST',
				credentials: 'same-origin',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
				body: requestBody( settings, page ).toString()
			} );
			var payload = await response.json();

			if ( ! response.ok || ! payload || ! payload.success || ! payload.data ) {
				throw new Error( 'Pagination request failed' );
			}

			var added = payload.data.content ? appendContent( area, payload.data.content ) : 0;
			area.dataset.vaartaPage = String( page + 1 );

			if ( payload.data.posts_end || ! added ) {
				var observer = observers.get( area );
				if ( observer ) {
					observer.disconnect();
					observers.delete( area );
				}
				button.remove();
				return;
			}
		} catch ( error ) {
			area.dispatchEvent( new CustomEvent( 'vaarta:pagination-error', { bubbles: true, detail: { error: error } } ) );
		} finally {
			area.dataset.vaartaLoading = 'false';
			if ( button.isConnected ) {
				finishButton( button, settings );
			}
		}
	}

	function initArea( area ) {
		if ( initialized.has( area ) ) {
			return;
		}

		var rawSettings = decodeAreaSettings( area );
		if ( ! rawSettings ) {
			return;
		}

		var settings = normalizeSettings( rawSettings );
		var button = ensureButton( area, settings );
		area.vaartaPaginationSettings = settings;
		area.dataset.vaartaPage = area.dataset.vaartaPage || '2';
		area.dataset.vaartaLoading = 'false';
		button.type = 'button';
		button.dataset.vaartaPagination = 'true';
		initialized.add( area );

		if ( isInfinite( settings ) && 'IntersectionObserver' in window ) {
			var observer = new IntersectionObserver( function ( entries ) {
				if ( entries.some( function ( entry ) { return entry.isIntersecting; } ) ) {
					load( area );
				}
			}, { rootMargin: '4000px 0px' } );
			observer.observe( button );
			observers.set( area, observer );
		}
	}

	api.init = function ( root ) {
		var scope = root && root.querySelectorAll ? root : document;
		if ( scope.matches && scope.matches( '.cs-posts-area' ) ) {
			initArea( scope );
		}
		Array.prototype.forEach.call( scope.querySelectorAll( '.cs-posts-area' ), initArea );
	};

	api.load = load;

	document.addEventListener( 'click', function ( event ) {
		var button = event.target.closest( '.cs-load-more[data-vaarta-pagination="true"]' );
		if ( ! button ) {
			return;
		}
		event.preventDefault();
		var area = button.closest( '.cs-posts-area' );
		if ( area ) {
			load( area );
		}
	} );

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () { api.init( document ); } );
	} else {
		api.init( document );
	}
} )();