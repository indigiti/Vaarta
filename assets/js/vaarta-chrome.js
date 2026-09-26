( function () {
	'use strict';

	var state = {
		lastSearchTrigger: null,
		lastOffcanvasTrigger: null,
		lastFullscreenTrigger: null,
		searchOpen: false,
		offcanvasOpen: false,
		fullscreenOpen: false
	};

	var selectors = {
		search: '.cs-search',
		searchToggle: '.cs-header__search-toggle',
		searchClose: '.cs-search__close',
		offcanvas: '.cs-offcanvas',
		offcanvasToggle: '.cs-header__offcanvas-toggle',
		offcanvasClose: '.cs-offcanvas__toggle',
		fullscreen: '.cs-fullscreen-menu',
		fullscreenToggle: '.cs-header__fullscreen-menu-toggle',
		fullscreenClose: '.cs-fullscreen-menu__header-toggle',
		schemeToggle: '.cs-site-scheme-toggle',
		primaryNav: '.cs-header__nav-inner'
	};

	function each( selector, callback ) {
		Array.prototype.forEach.call( document.querySelectorAll( selector ), callback );
	}

	function isVisible( element ) {
		if ( ! element ) {
			return false;
		}

		var style = window.getComputedStyle( element );
		return 'none' !== style.display && 'hidden' !== style.visibility && 0 !== parseFloat( style.opacity || '1' );
	}

	function makeKeyboardButton( element, label, controls ) {
		if ( ! element ) {
			return;
		}

		if ( ! element.hasAttribute( 'role' ) ) {
			element.setAttribute( 'role', 'button' );
		}
		if ( ! element.hasAttribute( 'tabindex' ) ) {
			element.setAttribute( 'tabindex', '0' );
		}
		if ( label && ! element.hasAttribute( 'aria-label' ) ) {
			element.setAttribute( 'aria-label', label );
		}
		if ( controls ) {
			element.setAttribute( 'aria-controls', controls );
			if ( ! element.hasAttribute( 'aria-expanded' ) ) {
				element.setAttribute( 'aria-expanded', 'false' );
			}
		}
	}

	function setExpanded( selector, expanded ) {
		each( selector, function ( element ) {
			element.setAttribute( 'aria-expanded', expanded ? 'true' : 'false' );
		} );
	}

	function setPanelState( panel, open ) {
		if ( ! panel ) {
			return;
		}

		panel.setAttribute( 'aria-hidden', open ? 'false' : 'true' );
		if ( 'inert' in panel ) {
			panel.inert = ! open;
		}
	}

	function focusFirst( panel, preferredSelector ) {
		if ( ! panel ) {
			return;
		}

		var target = preferredSelector ? panel.querySelector( preferredSelector ) : null;
		if ( ! target ) {
			target = panel.querySelector( 'a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])' );
		}

		if ( target ) {
			target.focus( { preventScroll: true } );
		} else if ( panel.hasAttribute( 'tabindex' ) ) {
			panel.focus( { preventScroll: true } );
		}
	}

	function restoreFocus( element ) {
		if ( element && document.documentElement.contains( element ) ) {
			element.focus( { preventScroll: true } );
		}
	}

	function syncSchemeToggle() {
		var dark = 'dark' === document.body.getAttribute( 'data-site-scheme' );
		each( selectors.schemeToggle, function ( toggle ) {
			makeKeyboardButton( toggle, 'Toggle color scheme' );
			toggle.setAttribute( 'aria-pressed', dark ? 'true' : 'false' );
		} );
	}

	function syncPanels() {
		var search = document.querySelector( selectors.search );
		var offcanvas = document.querySelector( selectors.offcanvas );
		var fullscreen = document.querySelector( selectors.fullscreen );

		var searchOpen = isVisible( search );
		var offcanvasOpen = document.body.classList.contains( 'cs-offcanvas-active' );
		var fullscreenOpen = document.body.classList.contains( 'cs-fullscreen-menu-active' );

		setPanelState( search, searchOpen );
		setPanelState( offcanvas, offcanvasOpen );
		setPanelState( fullscreen, fullscreenOpen );

		setExpanded( selectors.searchToggle, searchOpen );
		setExpanded( selectors.offcanvasToggle, offcanvasOpen );
		setExpanded( selectors.fullscreenToggle, fullscreenOpen );

		if ( searchOpen && ! state.searchOpen ) {
			window.setTimeout( function () {
				focusFirst( search, '.cs-search__input' );
			}, 30 );
		} else if ( ! searchOpen && state.searchOpen ) {
			restoreFocus( state.lastSearchTrigger );
		}

		if ( offcanvasOpen && ! state.offcanvasOpen ) {
			window.setTimeout( function () {
				focusFirst( offcanvas, '.cs-offcanvas__toggle' );
			}, 30 );
		} else if ( ! offcanvasOpen && state.offcanvasOpen ) {
			restoreFocus( state.lastOffcanvasTrigger );
		}

		if ( fullscreenOpen && ! state.fullscreenOpen ) {
			window.setTimeout( function () {
				focusFirst( fullscreen, '.cs-fullscreen-menu__header-toggle' );
			}, 30 );
		} else if ( ! fullscreenOpen && state.fullscreenOpen ) {
			restoreFocus( state.lastFullscreenTrigger );
		}

		state.searchOpen = searchOpen;
		state.offcanvasOpen = offcanvasOpen;
		state.fullscreenOpen = fullscreenOpen;
		syncSchemeToggle();
	}

	function trapFocus( panel, event ) {
		if ( ! panel || 'Tab' !== event.key ) {
			return;
		}

		var focusable = Array.prototype.filter.call(
			panel.querySelectorAll( 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])' ),
			function ( element ) {
				return isVisible( element );
			}
		);

		if ( ! focusable.length ) {
			return;
		}

		var first = focusable[0];
		var last = focusable[ focusable.length - 1 ];

		if ( event.shiftKey && document.activeElement === first ) {
			event.preventDefault();
			last.focus();
		} else if ( ! event.shiftKey && document.activeElement === last ) {
			event.preventDefault();
			first.focus();
		}
	}

	function closeActiveChrome() {
		if ( document.body.classList.contains( 'cs-fullscreen-menu-active' ) ) {
			var fullscreenClose = document.querySelector( selectors.fullscreenClose );
			if ( fullscreenClose ) {
				fullscreenClose.click();
				return true;
			}
		}

		if ( document.body.classList.contains( 'cs-offcanvas-active' ) ) {
			var offcanvasClose = document.querySelector( selectors.offcanvasClose );
			if ( offcanvasClose ) {
				offcanvasClose.click();
				return true;
			}
		}

		var search = document.querySelector( selectors.search );
		if ( isVisible( search ) ) {
			var searchClose = document.querySelector( selectors.searchClose );
			if ( searchClose ) {
				searchClose.click();
				return true;
			}
		}

		return false;
	}

	function initPrimaryNavigation() {
		each( selectors.primaryNav + ' .menu-item-has-children', function ( item, index ) {
			var link = item.querySelector( ':scope > a' );
			var submenu = item.querySelector( ':scope > .sub-menu' );
			if ( ! link || ! submenu ) {
				return;
			}

			if ( ! submenu.id ) {
				submenu.id = 'vaarta-submenu-' + index;
			}

			link.setAttribute( 'aria-haspopup', 'true' );
			link.setAttribute( 'aria-controls', submenu.id );
			link.setAttribute( 'aria-expanded', item.classList.contains( 'submenu-visible' ) ? 'true' : 'false' );

			link.addEventListener( 'keydown', function ( event ) {
				if ( 'ArrowDown' === event.key ) {
					event.preventDefault();
					item.classList.add( 'submenu-visible' );
					link.setAttribute( 'aria-expanded', 'true' );
					var firstLink = submenu.querySelector( 'a[href]' );
					if ( firstLink ) {
						firstLink.focus();
					}
				} else if ( 'Escape' === event.key ) {
					event.preventDefault();
					item.classList.remove( 'submenu-visible' );
					link.setAttribute( 'aria-expanded', 'false' );
					link.focus();
				}
			} );

			item.addEventListener( 'mouseenter', function () {
				link.setAttribute( 'aria-expanded', 'true' );
			} );
			item.addEventListener( 'mouseleave', function () {
				if ( ! item.classList.contains( 'submenu-visible' ) ) {
					link.setAttribute( 'aria-expanded', 'false' );
				}
			} );
		} );
	}

	function initMarkup() {
		var search = document.querySelector( selectors.search );
		var offcanvas = document.querySelector( selectors.offcanvas );
		var fullscreen = document.querySelector( selectors.fullscreen );

		if ( search && ! search.id ) {
			search.id = 'vaarta-site-search';
		}
		if ( offcanvas && ! offcanvas.id ) {
			offcanvas.id = 'vaarta-offcanvas';
		}
		if ( fullscreen && ! fullscreen.id ) {
			fullscreen.id = 'vaarta-fullscreen-menu';
		}

		each( selectors.searchToggle, function ( toggle ) {
			makeKeyboardButton( toggle, 'Open search', 'vaarta-site-search' );
		} );
		each( selectors.offcanvasToggle, function ( toggle ) {
			makeKeyboardButton( toggle, 'Open menu', 'vaarta-offcanvas' );
		} );
		each( selectors.fullscreenToggle, function ( toggle ) {
			makeKeyboardButton( toggle, 'Open full-screen menu', 'vaarta-fullscreen-menu' );
		} );
		each( selectors.offcanvasClose, function ( toggle ) {
			makeKeyboardButton( toggle, 'Close menu', 'vaarta-offcanvas' );
		} );
		each( selectors.fullscreenClose, function ( toggle ) {
			makeKeyboardButton( toggle, 'Close full-screen menu', 'vaarta-fullscreen-menu' );
		} );

		each( selectors.searchClose, function ( button ) {
			button.setAttribute( 'type', 'button' );
			if ( ! button.hasAttribute( 'aria-label' ) ) {
				button.setAttribute( 'aria-label', 'Close search' );
			}
		} );
		each( '.cs-search__submit', function ( button ) {
			button.setAttribute( 'type', 'submit' );
			if ( ! button.hasAttribute( 'aria-label' ) ) {
				button.setAttribute( 'aria-label', 'Search' );
			}
		} );
		each( '.cs-search__input', function ( input ) {
			if ( ! input.hasAttribute( 'aria-label' ) ) {
				input.setAttribute( 'aria-label', input.getAttribute( 'placeholder' ) || 'Search' );
			}
		} );

		initPrimaryNavigation();
		syncPanels();
	}

	document.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( selectors.searchToggle ) ) {
			state.lastSearchTrigger = event.target.closest( selectors.searchToggle );
		}
		if ( event.target.closest( selectors.offcanvasToggle ) ) {
			state.lastOffcanvasTrigger = event.target.closest( selectors.offcanvasToggle );
		}
		if ( event.target.closest( selectors.fullscreenToggle ) ) {
			state.lastFullscreenTrigger = event.target.closest( selectors.fullscreenToggle );
		}

		window.setTimeout( syncPanels, 0 );
		window.setTimeout( syncPanels, 420 );
	} );

	document.addEventListener( 'keydown', function ( event ) {
		var keyboardButton = event.target.closest( '[role="button"]' );
		if ( keyboardButton && ( 'Enter' === event.key || ' ' === event.key ) ) {
			if ( ! keyboardButton.matches( 'button, input, select, textarea, a[href]' ) ) {
				event.preventDefault();
				keyboardButton.click();
				return;
			}
		}

		if ( 'Escape' === event.key && closeActiveChrome() ) {
			event.preventDefault();
			window.setTimeout( syncPanels, 0 );
			return;
		}

		if ( document.body.classList.contains( 'cs-fullscreen-menu-active' ) ) {
			trapFocus( document.querySelector( selectors.fullscreen ), event );
		} else if ( document.body.classList.contains( 'cs-offcanvas-active' ) ) {
			trapFocus( document.querySelector( selectors.offcanvas ), event );
		}
	} );

	function observeState() {
		var observer = new MutationObserver( function () {
			window.requestAnimationFrame( syncPanels );
		} );

		observer.observe( document.body, {
			attributes: true,
			attributeFilter: [ 'class', 'data-site-scheme' ]
		} );

		var search = document.querySelector( selectors.search );
		if ( search ) {
			observer.observe( search, {
				attributes: true,
				attributeFilter: [ 'class', 'style', 'aria-hidden' ]
			} );
		}
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () {
			initMarkup();
			observeState();
		} );
	} else {
		initMarkup();
		observeState();
	}
} )();
