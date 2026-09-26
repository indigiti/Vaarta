( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	var config = window.vaartaMegaMenuConfig || window.csco_mega_menu || null;
	var api = window.vaartaMegaMenu = window.vaartaMegaMenu || {};

	// Capture the server-provided endpoint before DOM ready, then make the old
	// Webpack loader's dependency unavailable. Its callbacks may remain in the
	// compiled file during migration, but they cannot issue requests.
	if ( config ) {
		window.vaartaMegaMenuConfig = config;
	}
	if ( 'undefined' !== typeof window.csco_mega_menu ) {
		window.csco_mega_menu = undefined;
	}

	if ( ! runtime ) {
		return;
	}

	function detachLegacyHandlers() {
		if ( ! window.jQuery ) {
			return;
		}
		var $ = window.jQuery;
		$( '.cs-header__nav .menu-item.cs-mega-menu-posts' ).off( 'mouseenter' );
		$( '.cs-header__nav .menu-item.cs-mega-menu-term' ).off( 'mouseenter' );
		$( '.cs-header__nav .menu-item.cs-mega-menu-child' ).off( 'mouseenter' );
		$( '.cs-header__nav .menu-item.cs-mega-menu-terms' ).off( 'mouseenter' );
	}

	function directLink( item ) {
		if ( ! item ) {
			return null;
		}
		for ( var index = 0; index < item.children.length; index++ ) {
			if ( 'A' === item.children[ index ].tagName ) {
				return item.children[ index ];
			}
		}
		return null;
	}

	function resolveContainers( item, term ) {
		var menuContainer = null;
		var postsContainer = null;

		if ( item.classList.contains( 'cs-mega-menu-term' ) || item.classList.contains( 'cs-mega-menu-posts' ) ) {
			menuContainer = item;
			postsContainer = item.querySelector( '.cs-mm__posts' );
		} else if ( item.classList.contains( 'cs-mega-menu-child-term' ) ) {
			menuContainer = item.closest( '.sub-menu' );
			if ( menuContainer && term ) {
				postsContainer = Array.prototype.find.call(
					menuContainer.querySelectorAll( '.cs-mm__posts[data-term]' ),
					function ( container ) {
						return String( container.getAttribute( 'data-term' ) ) === String( term );
					}
				) || null;
			}
		}

		return { menu: menuContainer, posts: postsContainer };
	}

	function setActive( item, menuContainer, postsContainer ) {
		menuContainer.querySelectorAll( '.menu-item, .cs-mm__posts' ).forEach( function ( element ) {
			element.classList.remove( 'cs-active-item' );
		} );
		item.classList.add( 'cs-active-item' );
		postsContainer.classList.add( 'cs-active-item' );
	}

	function buildUrl( link ) {
		if ( ! config || ! config.rest_url || ! link ) {
			return null;
		}

		var url = new URL( config.rest_url, window.location.href );
		var term = link.getAttribute( 'data-term' ) || '';
		var posts = link.getAttribute( 'data-posts' ) || '';
		var perPage = parseInt( link.getAttribute( 'data-numberposts' ), 10 ) || 4;

		if ( term ) {
			url.searchParams.set( 'term', term );
		}
		if ( posts ) {
			url.searchParams.set( 'posts', posts );
		}
		url.searchParams.set( 'per_page', String( Math.min( 8, Math.max( 1, perPage ) ) ) );
		return url;
	}

	async function load( item ) {
		if ( ! item || ! item.classList ) {
			return false;
		}

		var link = directLink( item );
		var term = link ? link.getAttribute( 'data-term' ) : '';
		var containers = resolveContainers( item, term );
		if ( ! containers.menu || ! containers.posts ) {
			return false;
		}

		setActive( item, containers.menu, containers.posts );
		if ( item.classList.contains( 'cs-mm-loading' ) || item.classList.contains( 'loaded' ) ) {
			return true;
		}

		var url = buildUrl( link );
		if ( ! url ) {
			return false;
		}

		item.classList.add( 'cs-mm-loading' );
		containers.posts.classList.add( 'cs-mm-loading' );
		containers.posts.setAttribute( 'aria-busy', 'true' );

		try {
			var response = await fetch( url.toString(), {
				method: 'GET',
				credentials: 'same-origin',
				headers: { 'Accept': 'application/json' }
			} );
			var payload = await response.json();

			if ( ! response.ok || ! payload || 'success' !== payload.status ) {
				throw new Error( 'Mega-menu request failed' );
			}

			item.classList.add( 'loaded' );
			containers.posts.classList.add( 'loaded' );
			if ( payload.content ) {
				containers.posts.innerHTML = payload.content;
			}

			runtime.emit( 'vaarta:mega-menu-loaded', {
				item: item,
				container: containers.posts
			} );
			return true;
		} catch ( error ) {
			containers.posts.dispatchEvent( new CustomEvent( 'vaarta:mega-menu-error', {
				bubbles: true,
				detail: { error: error }
			} ) );
			return false;
		} finally {
			item.classList.remove( 'cs-mm-loading' );
			containers.posts.classList.remove( 'cs-mm-loading' );
			containers.posts.removeAttribute( 'aria-busy' );
		}
	}

	function firstTab( container ) {
		return container ? container.querySelector( '.cs-mega-menu-child' ) : null;
	}

	function handleHover( item ) {
		if ( item.classList.contains( 'cs-mega-menu-terms' ) ) {
			var tab = firstTab( item );
			if ( tab ) {
				load( tab );
			}
			return;
		}

		if ( item.classList.contains( 'cs-mega-menu-posts' ) ||
			item.classList.contains( 'cs-mega-menu-term' ) ||
			item.classList.contains( 'cs-mega-menu-child' ) ) {
			load( item );
		}
	}

	function init( root ) {
		detachLegacyHandlers();
		window.setTimeout( detachLegacyHandlers, 0 );

		var scope = root && root.querySelectorAll ? root : document;
		scope.querySelectorAll( '.cs-header__nav .menu-item.cs-mega-menu-terms' ).forEach( function ( item ) {
			var tab = firstTab( item );
			if ( tab ) {
				load( tab );
			}
		} );
		scope.querySelectorAll( '.cs-header__nav .menu-item.cs-mega-menu-posts, .cs-header__nav .menu-item.cs-mega-menu-term' ).forEach( load );
	}

	document.addEventListener( 'mouseover', function ( event ) {
		var item = event.target.closest( '.cs-header__nav .menu-item' );
		if ( ! item || ( event.relatedTarget && item.contains( event.relatedTarget ) ) ) {
			return;
		}
		handleHover( item );
	} );

	api.load = load;
	api.init = init;
	api.getConfig = function () {
		return config ? { restUrl: config.rest_url || '' } : { restUrl: '' };
	};

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () { init( document ); }, { once: true } );
	} else {
		init( document );
	}
} )();