( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
	}

	var api = window.vaartaNavigation = window.vaartaNavigation || {};
	var resizeTimer = null;
	var scrollTicking = false;
	var touchBound = false;
	var state = {
		headerSmart: null,
		headerBefore: null,
		headerStretch: null,
		headerCopy: null,
		adminBar: null,
		smartStart: 0,
		headerLargeHeight: 0,
		headerCompactHeight: 0,
		headerPadding: 0,
		headerTopbar: 0,
		headerDelta: 0,
		adminBarHeight: 0,
		scrollPoint: 200,
		scrollPrev: 200,
		scrollUpAmount: 0
	};

	function numberVar( name ) {
		var value = parseInt( window.getComputedStyle( document.documentElement ).getPropertyValue( name ), 10 );
		return Number.isFinite( value ) ? value : 0;
	}

	function emitLegacy( name ) {
		document.dispatchEvent( new CustomEvent( name, { bubbles: false } ) );
	}

	function ensureStretchCopy() {
		var stretch = document.querySelector( '.cs-navbar-smart-enabled .cs-header-stretch' );
		var siteInner = document.querySelector( '.cs-site-inner' );
		if ( ! stretch || ! siteInner ) {
			return null;
		}

		var copy = document.querySelector( '.cs-header-stretch-copy' );
		if ( ! copy ) {
			copy = document.createElement( 'div' );
			copy.className = 'cs-header-stretch-copy';
			copy.innerHTML = stretch.innerHTML;
			[ 'cs-header-one', 'cs-header-two', 'cs-header-three', 'cs-header-four' ].forEach( function ( className ) {
				if ( stretch.classList.contains( className ) ) {
					copy.classList.add( className );
				}
			} );
			siteInner.insertBefore( copy, siteInner.firstChild );
		}
		return copy;
	}

	function smartLevels() {
		var windowWidth = window.innerWidth || document.documentElement.clientWidth;
		document.querySelectorAll( '.cs-header__nav-inner li' ).forEach( function ( item ) {
			item.classList.remove( 'cs-sm__level', 'cs-sm-position-left', 'cs-sm-position-right' );
		} );
		document.querySelectorAll( '.cs-header__nav-inner li .sub-menu' ).forEach( function ( menu ) {
			menu.classList.remove( 'cs-mm__position-init' );
		} );

		document.querySelectorAll( '.cs-header__nav-inner > li.menu-item:not(.cs-mm)' ).forEach( function ( parent ) {
			var position = 'cs-sm-position-right';
			var previousWidth = 0;

			parent.querySelectorAll( '.sub-menu' ).forEach( function ( submenu ) {
				var owner = submenu.parentElement;
				if ( owner && owner.nextElementSibling ) {
					owner.nextElementSibling.classList.add( 'cs-sm__level' );
				}

				if ( owner && owner.classList.contains( 'cs-sm__level' ) ) {
					owner.classList.remove( 'cs-mm-level' );
					position = 'cs-sm-position-right';
					previousWidth = 0;
				}

				var rect = submenu.getBoundingClientRect();
				var width = rect.width || submenu.offsetWidth;
				if ( 'cs-sm-position-right' === position && rect.left + width > windowWidth ) {
					position = 'cs-sm-position-left';
				}
				if ( 'cs-sm-position-left' === position && rect.left - ( width + previousWidth ) < 0 ) {
					position = 'cs-sm-position-right';
				}

				previousWidth = width;
				submenu.classList.add( 'cs-sm-position-init' );
				if ( owner ) {
					owner.classList.add( position );
				}
			} );
		} );
	}

	function prepareTouchNavigation() {
		var touchCapable = 'ontouchstart' in document.documentElement || ( window.matchMedia && window.matchMedia( '(pointer: coarse)' ).matches );
		document.querySelectorAll( '.cs-header__nav-inner .menu-item-has-children' ).forEach( function ( item ) {
			item.classList.remove( 'submenu-visible' );
			item.classList.toggle( 'touch-device', !! touchCapable );
			var link = item.querySelector( ':scope > a' );
			if ( ! link ) {
				return;
			}

			var oldCaret = link.querySelector( ':scope > .expanded' );
			if ( oldCaret ) {
				oldCaret.remove();
			}
			if ( touchCapable ) {
				var caret = document.createElement( 'span' );
				caret.className = 'expanded';
				caret.setAttribute( 'aria-hidden', 'true' );
				link.appendChild( caret );
			}
		} );
	}

	function bindTouchNavigation() {
		if ( touchBound ) {
			return;
		}
		touchBound = true;

		document.addEventListener( 'touchstart', function ( event ) {
			var nav = event.target.closest( '.cs-header__nav-inner' );
			if ( ! nav ) {
				document.querySelectorAll( '.cs-header__nav-inner .menu-item-has-children.submenu-visible' ).forEach( function ( item ) {
					item.classList.remove( 'submenu-visible' );
				} );
				return;
			}

			var caret = event.target.closest( '.expanded' );
			var link = event.target.closest( '.menu-item-has-children > a' );
			if ( caret ) {
				event.preventDefault();
				var caretOwner = caret.closest( '.menu-item-has-children' );
				if ( caretOwner ) {
					caretOwner.classList.toggle( 'submenu-visible' );
				}
				return;
			}

			if ( link && '#' === link.getAttribute( 'href' ) ) {
				event.preventDefault();
				var owner = link.closest( '.menu-item-has-children' );
				if ( owner ) {
					owner.classList.toggle( 'submenu-visible' );
				}
			}

			var current = event.target.closest( '.menu-item' );
			if ( current && current.parentElement ) {
				Array.prototype.forEach.call( current.parentElement.children, function ( sibling ) {
					if ( sibling !== current ) {
						sibling.classList.remove( 'submenu-visible' );
						sibling.querySelectorAll( '.submenu-visible' ).forEach( function ( child ) {
							child.classList.remove( 'submenu-visible' );
						} );
					}
				} );
			}
		}, { passive: false } );
	}

	function measureSticky() {
		state.headerLargeHeight = numberVar( '--cs-header-initial-height' );
		state.headerCompactHeight = numberVar( '--cs-header-height' );
		state.headerPadding = numberVar( '--cs-header-padding' );
		state.headerTopbar = numberVar( '--cs-header-topbar-height' );
		state.headerSmart = document.querySelector( '.cs-navbar-smart-enabled .cs-header, .cs-navbar-sticky-enabled .cs-header' );
		state.headerBefore = document.querySelector( '.cs-header-before' );
		state.headerStretch = document.querySelector( '.cs-navbar-smart-enabled .cs-header-stretch' );
		state.headerCopy = ensureStretchCopy();
		state.adminBar = document.getElementById( 'wpadminbar' );
		state.adminBarHeight = state.adminBar ? state.adminBar.getBoundingClientRect().height : 0;
		state.headerDelta = state.headerStretch ? Math.max( 0, state.headerLargeHeight - state.headerCompactHeight ) : 0;

		if ( state.headerBefore ) {
			state.smartStart = state.headerBefore.getBoundingClientRect().top + window.scrollY;
		} else if ( state.headerSmart ) {
			state.smartStart = state.headerSmart.getBoundingClientRect().top + window.scrollY + state.adminBarHeight;
		} else {
			state.smartStart = state.adminBarHeight;
		}
	}

	function hideSearch() {
		if ( window.vaartaSearch && 'function' === typeof window.vaartaSearch.close ) {
			window.vaartaSearch.close( { restoreFocus: false } );
		}
	}

	function setVisible( visible, target ) {
		if ( ! target ) {
			return;
		}
		target.classList.toggle( 'cs-header-smart-visible', visible );
		emitLegacy( visible ? 'sticky-nav-visible' : 'sticky-nav-hide' );
		runtime.emit( visible ? 'vaarta:sticky-visible' : 'vaarta:sticky-hide', { header: target } );
	}

	function processSticky() {
		scrollTicking = false;
		var headerSmart = state.headerSmart;
		if ( ! headerSmart ) {
			return;
		}

		var scrolled = Math.max( 0, window.scrollY || window.pageYOffset || 0 );
		var headerSmartPosition = headerSmart.getBoundingClientRect().top + scrolled;
		var threshold = state.smartStart + state.headerDelta + state.scrollPoint + 10;

		if ( scrolled > threshold && scrolled > state.scrollPrev ) {
			if ( ! state.headerStretch && scrolled > state.smartStart + state.headerLargeHeight + 200 + state.headerPadding + state.headerTopbar ) {
				setVisible( false, headerSmart );
			}
			if ( state.headerStretch && state.headerCopy && scrolled > state.smartStart + state.headerDelta + state.headerLargeHeight + state.headerPadding + state.headerTopbar ) {
				setVisible( false, state.headerCopy );
			}
			hideSearch();
		} else if ( state.scrollUpAmount >= state.scrollPoint || 0 === scrolled ) {
			if ( state.headerStretch && state.headerCopy ) {
				var copyThreshold = state.smartStart + state.headerDelta + state.headerLargeHeight + state.headerPadding + state.headerTopbar;
				setVisible( scrolled > copyThreshold, state.headerCopy );
			} else {
				setVisible( true, headerSmart );
			}
		}

		if ( ! state.headerStretch ) {
			var stickyThreshold = state.smartStart + state.headerLargeHeight + state.headerPadding + state.headerTopbar;
			if ( scrolled > stickyThreshold ) {
				headerSmart.classList.add( 'cs-scroll-sticky' );
				document.body.classList.add( 'cs-header-scroll-sticky' );
			} else if ( headerSmartPosition <= state.smartStart ) {
				headerSmart.classList.remove( 'cs-scroll-sticky', 'cs-header-smart-visible' );
				document.body.classList.remove( 'cs-header-scroll-sticky' );
				emitLegacy( 'sticky-nav-hide' );
			}
		}

		if ( scrolled < state.scrollPrev ) {
			state.scrollUpAmount += state.scrollPrev - scrolled;
		} else {
			state.scrollUpAmount = 0;
		}

		if ( state.adminBar && window.innerWidth <= 600 && scrolled >= state.adminBarHeight ) {
			emitLegacy( 'adminbar-mobile-scrolled' );
		} else {
			emitLegacy( 'adminbar-mobile-no-scrolled' );
		}
		state.scrollPrev = scrolled;
	}

	function onScroll() {
		if ( scrollTicking ) {
			return;
		}
		scrollTicking = true;
		window.requestAnimationFrame( processSticky );
	}

	function refresh() {
		smartLevels();
		prepareTouchNavigation();
		measureSticky();
		processSticky();
	}

	api.refresh = refresh;
	api.smartLevels = smartLevels;
	api.processSticky = processSticky;

	bindTouchNavigation();
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	window.addEventListener( 'resize', function () {
		window.clearTimeout( resizeTimer );
		resizeTimer = window.setTimeout( refresh, 100 );
	}, { passive: true } );

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', refresh, { once: true } );
	} else {
		refresh();
	}
} )();