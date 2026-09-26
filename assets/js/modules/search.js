( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
	}

	var panel = document.querySelector( '.cs-search' );
	var focusTimeout = null;
	var lastTrigger = null;

	function setExpanded( expanded ) {
		document.querySelectorAll( '.cs-header__search-toggle' ).forEach( function ( toggle ) {
			toggle.setAttribute( 'aria-expanded', expanded ? 'true' : 'false' );
		} );
	}

	function focusInput() {
		window.clearTimeout( focusTimeout );
		focusTimeout = window.setTimeout( function () {
			var input = panel ? panel.querySelector( '.cs-search__input' ) : null;
			if ( input ) {
				input.focus( { preventScroll: true } );
			}
		}, runtime.prefersReducedMotion() ? 0 : 220 );
	}

	function open( options ) {
		if ( ! panel ) {
			return;
		}

		options = options || {};
		if ( options.trigger ) {
			lastTrigger = options.trigger;
		}

		if ( document.body.classList.contains( 'cs-search-type-two' ) ) {
			document.body.classList.add( 'cs-search-type-two-visible' );
		}

		panel.setAttribute( 'aria-hidden', 'false' );
		setExpanded( true );
		runtime.fadeIn( panel, 200 );
		focusInput();
		runtime.emit( 'vaarta:search-open', { panel: panel } );
	}

	function close( options ) {
		if ( ! panel ) {
			return;
		}

		options = options || {};
		window.clearTimeout( focusTimeout );
		document.body.classList.remove( 'cs-search-type-two-visible' );
		setExpanded( false );

		runtime.fadeOut( panel, 200 ).then( function () {
			panel.setAttribute( 'aria-hidden', 'true' );
			if ( false !== options.restoreFocus && lastTrigger && document.documentElement.contains( lastTrigger ) ) {
				lastTrigger.focus( { preventScroll: true } );
			}
		} );

		runtime.emit( 'vaarta:search-close', { panel: panel } );
	}

	function toggle( trigger ) {
		if ( document.body.classList.contains( 'cs-search-type-two' ) ) {
			open( { trigger: trigger } );
			return;
		}

		if ( runtime.isVisible( panel ) ) {
			close();
		} else {
			open( { trigger: trigger } );
		}
	}

	document.addEventListener( 'click', function ( event ) {
		var toggleButton = event.target.closest( '.cs-header__search-toggle' );
		if ( toggleButton ) {
			event.preventDefault();
			lastTrigger = toggleButton;
			toggle( toggleButton );
			return;
		}

		if ( event.target.closest( '.cs-search__close' ) ) {
			event.preventDefault();
			close();
		}
	} );

	window.vaartaSearch = {
		open: open,
		close: close,
		toggle: toggle
	};
} )();