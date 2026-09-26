( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
	}

	function setExpanded( expanded ) {
		document.querySelectorAll( '.cs-header__fullscreen-menu-toggle' ).forEach( function ( toggle ) {
			toggle.classList.toggle( 'active', expanded );
			toggle.setAttribute( 'aria-expanded', expanded ? 'true' : 'false' );
		} );

		var panel = document.querySelector( '.cs-fullscreen-menu' );
		if ( panel ) {
			panel.setAttribute( 'aria-hidden', expanded ? 'false' : 'true' );
		}
	}

	function open() {
		if ( window.vaartaSearch && 'function' === typeof window.vaartaSearch.close ) {
			window.vaartaSearch.close( { restoreFocus: false } );
		}

		document.body.classList.add( 'cs-fullscreen-menu-active' );
		setExpanded( true );
		runtime.emit( 'vaarta:fullscreen-open' );
	}

	function close() {
		document.body.classList.remove( 'cs-fullscreen-menu-active' );
		setExpanded( false );
		runtime.emit( 'vaarta:fullscreen-close' );
	}

	function toggle() {
		if ( document.body.classList.contains( 'cs-fullscreen-menu-active' ) ) {
			close();
		} else {
			open();
		}
	}

	document.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( '.cs-header__fullscreen-menu-toggle' ) ) {
			event.preventDefault();
			toggle();
			return;
		}

		if ( event.target.closest( '.cs-fullscreen-menu__header-toggle' ) ) {
			event.preventDefault();
			close();
		}
	} );

	window.vaartaFullscreen = {
		open: open,
		close: close,
		toggle: toggle
	};
} )();