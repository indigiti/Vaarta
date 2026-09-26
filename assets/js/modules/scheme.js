( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime || ! document.body ) {
		return;
	}

	var schemeVariables = {
		'body': '--cs-color-site-background',
		'.cs-topbar': '--cs-color-topbar-background',
		'.cs-header': '--cs-color-header-background',
		'.cs-header__nav-inner .sub-menu': '--cs-color-submenu-background',
		'.cs-header__multi-column-container': '--cs-color-submenu-background',
		'.cs-header__widgets': '--cs-color-submenu-background',
		'.cs-offcanvas__header': '--cs-color-header-background',
		'.cs-search': '--cs-color-search-background',
		'.cs-footer': '--cs-color-footer-background',
		'.cs-fullscreen-menu': '--cs-color-fullscreen-menu-background',
		'.cs-header__featured-column-container': '--cs-color-featured-column-background'
	};

	function detectScheme( color ) {
		var level = 190;
		var alpha = 1;
		var rgba = [ 255, 255, 255 ];
		var match;

		color = ( color || '' ).trim();

		if ( '#' === color.charAt( 0 ) ) {
			color = color.replace( '#', '' ).trim();
			if ( 3 === color.length ) {
				color = color.charAt( 0 ) + color.charAt( 0 ) + color.charAt( 1 ) + color.charAt( 1 ) + color.charAt( 2 ) + color.charAt( 2 );
			}
			rgba[0] = parseInt( color.substr( 0, 2 ), 16 );
			rgba[1] = parseInt( color.substr( 2, 2 ), 16 );
			rgba[2] = parseInt( color.substr( 4, 2 ), 16 );
		} else if ( match = color.replace( /\s/g, '' ).match( /^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i ) ) {
			rgba[0] = parseInt( match[1], 10 );
			rgba[1] = parseInt( match[2], 10 );
			rgba[2] = parseInt( match[3], 10 );
			if ( undefined !== match[4] ) {
				alpha = parseFloat( match[4] );
			}
		}

		rgba = rgba.map( function ( channel ) {
			return channel + Math.ceil( ( 255 - channel ) * ( 1 - alpha ) );
		} );

		var brightness = ( rgba[0] * 299 + rgba[1] * 587 + rgba[2] * 114 ) / 1000;
		if ( rgba[0] === rgba[1] && rgba[1] === rgba[2] ) {
			return brightness < level ? 'dark' : 'default';
		}
		return brightness < level ? 'inverse' : 'default';
	}

	function syncIndividualSchemes() {
		Object.keys( schemeVariables ).forEach( function ( selector ) {
			document.querySelectorAll( selector ).forEach( function ( element ) {
				var color = window.getComputedStyle( element ).getPropertyValue( schemeVariables[ selector ] );
				element.setAttribute( 'data-scheme', detectScheme( color ) );
			} );
		} );
	}

	function syncToggles( scheme ) {
		document.querySelectorAll( '.cs-site-scheme-toggle' ).forEach( function ( toggle ) {
			toggle.setAttribute( 'aria-pressed', 'dark' === scheme ? 'true' : 'false' );
		} );
	}

	function changeScheme( scheme, persist ) {
		scheme = 'dark' === scheme ? 'dark' : 'default';
		document.body.classList.add( 'cs-scheme-toggled' );
		document.body.setAttribute( 'data-site-scheme', scheme );
		syncIndividualSchemes();
		syncToggles( scheme );

		if ( persist ) {
			runtime.setCookie( '_color_schema', scheme, 2592000 );
			runtime.setCookie( '_color_system_schema', '', 0 );
		}

		window.setTimeout( function () {
			document.body.classList.remove( 'cs-scheme-toggled' );
		}, runtime.prefersReducedMotion() ? 0 : 100 );

		runtime.emit( 'vaarta:scheme-change', { scheme: scheme, persisted: !! persist } );
	}

	function systemScheme() {
		return window.matchMedia && window.matchMedia( '(prefers-color-scheme: dark)' ).matches ? 'dark' : 'default';
	}

	function configuredScheme() {
		var localize = window.csLocalize || {};
		var mode = localize.siteSchemeMode || 'system';
		var scheme = 'dark' === mode ? 'dark' : 'default';

		if ( 'system' === mode ) {
			scheme = systemScheme();
		}

		if ( localize.siteSchemeToogle ) {
			var stored = runtime.getCookie( '_color_schema' );
			if ( 'default' === stored || 'dark' === stored ) {
				scheme = stored;
			}
		}

		return scheme;
	}

	function initialize() {
		var system = systemScheme();
		runtime.setCookie( '_color_system_schema', system, 2592000 );
		changeScheme( configuredScheme(), false );
	}

	document.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( '.cs-site-scheme-toggle' ) ) {
			event.preventDefault();
			changeScheme( 'dark' === document.body.getAttribute( 'data-site-scheme' ) ? 'default' : 'dark', true );
		}
	} );

	if ( window.matchMedia ) {
		var media = window.matchMedia( '(prefers-color-scheme: dark)' );
		var onSystemChange = function () {
			var localize = window.csLocalize || {};
			if ( 'system' !== ( localize.siteSchemeMode || 'system' ) || runtime.getCookie( '_color_schema' ) ) {
				return;
			}
			initialize();
		};

		if ( media.addEventListener ) {
			media.addEventListener( 'change', onSystemChange );
		}
	}

	initialize();

	window.vaartaScheme = {
		change: changeScheme,
		detect: detectScheme,
		refresh: syncIndividualSchemes
	};
} )();