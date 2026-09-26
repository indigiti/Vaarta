( function () {
	'use strict';

	var api = window.vaartaRuntime = window.vaartaRuntime || {};
	var animations = new WeakMap();

	api.prefersReducedMotion = function () {
		return window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	};

	api.isVisible = function ( element ) {
		if ( ! element ) {
			return false;
		}

		var style = window.getComputedStyle( element );
		return 'none' !== style.display && 'hidden' !== style.visibility;
	};

	api.cancelAnimation = function ( element ) {
		var animation = animations.get( element );
		if ( animation ) {
			animation.cancel();
			animations.delete( element );
		}
	};

	api.fadeIn = function ( element, duration ) {
		if ( ! element ) {
			return Promise.resolve();
		}

		api.cancelAnimation( element );
		element.style.display = 'block';

		if ( api.prefersReducedMotion() || ! element.animate ) {
			element.style.removeProperty( 'opacity' );
			return Promise.resolve();
		}

		var animation = element.animate(
			[ { opacity: 0 }, { opacity: 1 } ],
			{ duration: duration || 200, easing: 'ease-out' }
		);
		animations.set( element, animation );

		return animation.finished.catch( function () {} ).then( function () {
			if ( animations.get( element ) === animation ) {
				animations.delete( element );
				element.style.removeProperty( 'opacity' );
			}
		} );
	};

	api.fadeOut = function ( element, duration ) {
		if ( ! element ) {
			return Promise.resolve();
		}

		api.cancelAnimation( element );

		if ( api.prefersReducedMotion() || ! element.animate ) {
			element.style.display = 'none';
			element.style.removeProperty( 'opacity' );
			return Promise.resolve();
		}

		var animation = element.animate(
			[ { opacity: 1 }, { opacity: 0 } ],
			{ duration: duration || 200, easing: 'ease-in' }
		);
		animations.set( element, animation );

		return animation.finished.catch( function () {} ).then( function () {
			if ( animations.get( element ) === animation ) {
				animations.delete( element );
				element.style.display = 'none';
				element.style.removeProperty( 'opacity' );
			}
		} );
	};

	api.emit = function ( name, detail ) {
		document.dispatchEvent( new CustomEvent( name, { detail: detail || {} } ) );
	};

	api.getCookie = function ( name ) {
		var escaped = name.replace( /([.$?*|{}()\[\]\\/+^])/g, '\\$1' );
		var match = document.cookie.match( new RegExp( '(?:^|; )' + escaped + '=([^;]*)' ) );
		return match ? decodeURIComponent( match[1] ) : undefined;
	};

	api.setCookie = function ( name, value, maxAge ) {
		var cookie = encodeURIComponent( name ) + '=' + encodeURIComponent( value );
		cookie += '; path=/; SameSite=Lax';
		if ( 'number' === typeof maxAge ) {
			cookie += '; max-age=' + Math.max( 0, Math.floor( maxAge ) );
		}
		document.cookie = cookie;
	};
} )();
