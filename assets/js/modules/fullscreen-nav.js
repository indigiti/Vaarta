( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
	}

	var columns = Array.from( document.querySelectorAll( '.cs-fullscreen-menu__nav-col' ) );
	var hideTimers = [];
	var slideAnimations = new WeakMap();

	function directChild( element, className ) {
		if ( ! element ) {
			return null;
		}

		return Array.from( element.children ).find( function ( child ) {
			return child.classList.contains( className );
		} ) || null;
	}

	function menuLevel( element ) {
		if ( element.closest( '.cs-fullscreen-menu__nav-inner' ) ) {
			return 1;
		}
		if ( element.closest( '.cs-fullscreen-menu__nav-col-first' ) ) {
			return 2;
		}
		if ( element.closest( '.cs-fullscreen-menu__nav-col-last' ) ) {
			return 3;
		}
		return 0;
	}

	function clearHideTimers( level ) {
		for ( var index = 0; index < level; index++ ) {
			window.clearTimeout( hideTimers[ index ] );
		}
	}

	function cancelSlide( submenu ) {
		var animation = slideAnimations.get( submenu );
		if ( animation ) {
			animation.cancel();
			slideAnimations.delete( submenu );
		}
	}

	function slideOpen( submenu ) {
		if ( ! submenu ) {
			return;
		}

		cancelSlide( submenu );
		submenu.classList.add( 'submenu-visible' );
		submenu.style.display = 'block';

		if ( runtime.prefersReducedMotion() || ! submenu.animate ) {
			return;
		}

		var height = submenu.scrollHeight;
		submenu.style.overflow = 'hidden';
		var animation = submenu.animate(
			[ { height: '0px', opacity: 0 }, { height: height + 'px', opacity: 1 } ],
			{ duration: 350, easing: 'ease' }
		);
		slideAnimations.set( submenu, animation );
		animation.finished.catch( function () {} ).then( function () {
			if ( slideAnimations.get( submenu ) === animation ) {
				slideAnimations.delete( submenu );
				submenu.style.removeProperty( 'height' );
				submenu.style.removeProperty( 'overflow' );
				submenu.style.removeProperty( 'opacity' );
			}
		} );
	}

	function slideClose( submenu ) {
		if ( ! submenu ) {
			return;
		}

		cancelSlide( submenu );
		submenu.classList.remove( 'submenu-visible' );

		if ( runtime.prefersReducedMotion() || ! submenu.animate ) {
			submenu.style.display = 'none';
			return;
		}

		var height = submenu.getBoundingClientRect().height || submenu.scrollHeight;
		submenu.style.overflow = 'hidden';
		var animation = submenu.animate(
			[ { height: height + 'px', opacity: 1 }, { height: '0px', opacity: 0 } ],
			{ duration: 350, easing: 'ease' }
		);
		slideAnimations.set( submenu, animation );
		animation.finished.catch( function () {} ).then( function () {
			if ( slideAnimations.get( submenu ) === animation ) {
				slideAnimations.delete( submenu );
				submenu.style.display = 'none';
				submenu.style.removeProperty( 'height' );
				submenu.style.removeProperty( 'overflow' );
				submenu.style.removeProperty( 'opacity' );
			}
		} );
	}

	function normalizeDeepToggles() {
		document.querySelectorAll( '.cs-fullscreen-menu__nav-col-last > .sub-menu > .menu-item-has-children' ).forEach( function ( item ) {
			var submenu = directChild( item, 'sub-menu' );
			if ( ! submenu ) {
				return;
			}

			var toggle = Array.from( item.children ).find( function ( child ) {
				return 'SPAN' === child.tagName && ! child.classList.contains( 'sub-menu' );
			} );

			if ( ! toggle ) {
				toggle = document.createElement( 'span' );
				item.appendChild( toggle );
			}

			toggle.classList.add( 'vaarta-fullscreen-submenu-toggle' );
			toggle.setAttribute( 'role', 'button' );
			toggle.setAttribute( 'tabindex', '0' );
			toggle.setAttribute( 'aria-expanded', submenu.classList.contains( 'submenu-visible' ) ? 'true' : 'false' );
			toggle.setAttribute( 'aria-label', 'Toggle submenu' );
		} );
	}

	function toggleDeepSubmenu( toggle ) {
		var item = toggle ? toggle.parentElement : null;
		var submenu = toggle ? toggle.previousElementSibling : null;
		if ( ! item || ! submenu || ! submenu.classList.contains( 'sub-menu' ) ) {
			return;
		}

		var opening = ! submenu.classList.contains( 'submenu-visible' );
		var list = item.parentElement;
		if ( opening && list ) {
			list.querySelectorAll( ':scope > .menu-item > .sub-menu.submenu-visible' ).forEach( function ( siblingSubmenu ) {
				if ( siblingSubmenu !== submenu ) {
					slideClose( siblingSubmenu );
					var siblingItem = siblingSubmenu.parentElement;
					if ( siblingItem ) {
						siblingItem.classList.remove( 'menu-item-expanded' );
						var siblingToggle = directChild( siblingItem, 'vaarta-fullscreen-submenu-toggle' );
						if ( siblingToggle ) {
							siblingToggle.setAttribute( 'aria-expanded', 'false' );
						}
					}
				}
			} );
		}

		item.classList.toggle( 'menu-item-expanded', opening );
		toggle.setAttribute( 'aria-expanded', opening ? 'true' : 'false' );
		if ( opening ) {
			slideOpen( submenu );
		} else {
			slideClose( submenu );
		}
	}

	function populateColumn( item ) {
		var level = menuLevel( item );
		if ( ! level ) {
			return;
		}

		var submenu = directChild( item, 'sub-menu' );
		if ( submenu ) {
			clearHideTimers( level );
		}

		var column = columns[ level - 1 ];
		if ( ! column ) {
			return;
		}

		column.replaceChildren();
		if ( submenu ) {
			column.appendChild( submenu.cloneNode( true ) );
		}
		column.classList.add( 'visible' );
		normalizeDeepToggles();
	}

	function containerLevel( element ) {
		if ( element.classList.contains( 'cs-fullscreen-menu__nav-inner' ) ) {
			return 1;
		}
		if ( element.classList.contains( 'cs-fullscreen-menu__nav-col-first' ) ) {
			return 2;
		}
		if ( element.classList.contains( 'cs-fullscreen-menu__nav-col-last' ) ) {
			return 3;
		}
		return 0;
	}

	function scheduleColumnHide() {
		hideTimers[0] = window.setTimeout( function () {
			if ( columns[0] ) {
				columns[0].classList.remove( 'visible' );
			}
		}, 200 );
		hideTimers[1] = window.setTimeout( function () {
			if ( columns[1] ) {
				columns[1].classList.remove( 'visible' );
			}
		}, 200 );
	}

	document.addEventListener( 'mouseover', function ( event ) {
		var item = event.target.closest( '.cs-fullscreen-menu .menu-item' );
		if ( item && ( ! event.relatedTarget || ! item.contains( event.relatedTarget ) ) ) {
			populateColumn( item );
		}

		var container = event.target.closest( '.cs-fullscreen-menu__nav-col, .cs-fullscreen-menu__nav-inner' );
		if ( container && ( ! event.relatedTarget || ! container.contains( event.relatedTarget ) ) ) {
			clearHideTimers( containerLevel( container ) );
		}
	} );

	document.addEventListener( 'mouseout', function ( event ) {
		var container = event.target.closest( '.cs-fullscreen-menu__nav-col, .cs-fullscreen-menu__nav-inner' );
		if ( container && ( ! event.relatedTarget || ! container.contains( event.relatedTarget ) ) ) {
			scheduleColumnHide();
		}
	} );

	document.addEventListener( 'click', function ( event ) {
		var toggle = event.target.closest( '.vaarta-fullscreen-submenu-toggle' );
		if ( toggle ) {
			event.preventDefault();
			toggleDeepSubmenu( toggle );
			return;
		}

		var link = event.target.closest( '.cs-fullscreen-menu__nav-col-last > .sub-menu > .menu-item-has-children > a' );
		if ( link && '#' === link.getAttribute( 'href' ) ) {
			var item = link.parentElement;
			var itemToggle = item ? item.querySelector( ':scope > .vaarta-fullscreen-submenu-toggle' ) : null;
			if ( itemToggle ) {
				event.preventDefault();
				toggleDeepSubmenu( itemToggle );
			}
		}
	} );

	document.addEventListener( 'keydown', function ( event ) {
		var toggle = event.target.closest( '.vaarta-fullscreen-submenu-toggle' );
		if ( toggle && ( 'Enter' === event.key || ' ' === event.key ) ) {
			event.preventDefault();
			toggleDeepSubmenu( toggle );
		}
	} );

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', normalizeDeepToggles, { once: true } );
	} else {
		normalizeDeepToggles();
	}

	window.vaartaFullscreenNav = {
		refresh: normalizeDeepToggles,
		populate: populateColumn
	};
} )();