( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
	}

	var transitionTimer = null;

	function setExpanded( expanded ) {
		document.querySelectorAll( '.cs-header__offcanvas-toggle' ).forEach( function ( toggle ) {
			toggle.setAttribute( 'aria-expanded', expanded ? 'true' : 'false' );
		} );

		var panel = document.querySelector( '.cs-offcanvas' );
		if ( panel ) {
			panel.setAttribute( 'aria-hidden', expanded ? 'false' : 'true' );
		}
	}

	function open() {
		window.clearTimeout( transitionTimer );
		document.body.classList.add( 'cs-offcanvas-transition' );
		document.body.classList.add( 'cs-offcanvas-active' );
		setExpanded( true );
		runtime.emit( 'vaarta:offcanvas-open' );
	}

	function close() {
		document.body.classList.remove( 'cs-offcanvas-active' );
		setExpanded( false );
		window.clearTimeout( transitionTimer );
		transitionTimer = window.setTimeout( function () {
			document.body.classList.remove( 'cs-offcanvas-transition' );
		}, runtime.prefersReducedMotion() ? 0 : 400 );
		runtime.emit( 'vaarta:offcanvas-close' );
	}

	function toggle() {
		if ( document.body.classList.contains( 'cs-offcanvas-active' ) ) {
			close();
		} else {
			open();
		}
	}

	document.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( '.cs-header__offcanvas-toggle, .cs-site-overlay, .cs-offcanvas__toggle' ) ) {
			event.preventDefault();
			toggle();
		}
	} );

	window.vaartaOffcanvas = {
		open: open,
		close: close,
		toggle: toggle
	};
} )();