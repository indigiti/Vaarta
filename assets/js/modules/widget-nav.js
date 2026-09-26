( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	var api = window.vaartaWidgetNav = window.vaartaWidgetNav || {};
	var initialized = new WeakSet();

	if ( ! runtime ) {
		return;
	}

	function directChild( parent, selector ) {
		for ( var index = 0; index < parent.children.length; index++ ) {
			if ( parent.children[ index ].matches && parent.children[ index ].matches( selector ) ) {
				return parent.children[ index ];
			}
		}
		return null;
	}

	function setExpanded( item, expanded ) {
		item.classList.toggle( 'menu-item-expanded', expanded );
		var toggle = directChild( item, '.vaarta-widget-nav-toggle' );
		if ( toggle ) {
			toggle.setAttribute( 'aria-expanded', expanded ? 'true' : 'false' );
		}
	}

	function animateSubmenu( submenu, open ) {
		if ( ! submenu ) {
			return;
		}

		if ( submenu.getAnimations ) {
			submenu.getAnimations().forEach( function ( animation ) { animation.cancel(); } );
		}

		if ( runtime.prefersReducedMotion() || ! submenu.animate ) {
			submenu.style.display = open ? 'block' : 'none';
			return;
		}

		var startHeight;
		var endHeight;

		if ( open ) {
			submenu.style.display = 'block';
			startHeight = 0;
			endHeight = submenu.scrollHeight;
		} else {
			startHeight = submenu.getBoundingClientRect().height;
			endHeight = 0;
		}

		submenu.style.overflow = 'hidden';
		var animation = submenu.animate(
			[ { height: startHeight + 'px', opacity: open ? 0 : 1 }, { height: endHeight + 'px', opacity: open ? 1 : 0 } ],
			{ duration: 350, easing: 'ease' }
		);

		animation.finished.catch( function () {} ).then( function () {
			submenu.style.removeProperty( 'height' );
			submenu.style.removeProperty( 'overflow' );
			submenu.style.removeProperty( 'opacity' );
			submenu.style.display = open ? 'block' : 'none';
		} );
	}

	function closeItem( item ) {
		var submenu = directChild( item, '.sub-menu' );
		if ( submenu ) {
			submenu.classList.remove( 'submenu-visible' );
			animateSubmenu( submenu, false );
		}
		setExpanded( item, false );
	}

	function openItem( item ) {
		var submenu = directChild( item, '.sub-menu' );
		if ( ! submenu ) {
			return;
		}

		var list = item.parentElement;
		if ( list ) {
			Array.prototype.forEach.call( list.children, function ( sibling ) {
				if ( sibling !== item && sibling.classList && sibling.classList.contains( 'menu-item-expanded' ) ) {
					closeItem( sibling );
				}
			} );
		}

		submenu.classList.add( 'submenu-visible' );
		animateSubmenu( submenu, true );
		setExpanded( item, true );
	}

	function toggleItem( item ) {
		var submenu = directChild( item, '.sub-menu' );
		if ( ! submenu ) {
			return;
		}

		if ( submenu.classList.contains( 'submenu-visible' ) ) {
			closeItem( item );
		} else {
			openItem( item );
		}
	}

	function initItem( item ) {
		if ( initialized.has( item ) ) {
			return;
		}

		var submenu = directChild( item, '.sub-menu' );
		var link = directChild( item, 'a' );
		if ( ! submenu ) {
			return;
		}

		var toggle = directChild( item, '.vaarta-widget-nav-toggle' );
		if ( ! toggle ) {
			toggle = document.createElement( 'span' );
			toggle.className = 'vaarta-widget-nav-toggle';
			item.appendChild( toggle );
		}

		toggle.setAttribute( 'role', 'button' );
		toggle.setAttribute( 'tabindex', '0' );
		toggle.setAttribute( 'aria-expanded', item.classList.contains( 'menu-item-expanded' ) ? 'true' : 'false' );
		toggle.setAttribute( 'aria-label', 'Toggle submenu' );

		if ( ! submenu.classList.contains( 'submenu-visible' ) ) {
			submenu.style.display = 'none';
		}

		if ( link && '#' === link.getAttribute( 'href' ) ) {
			link.dataset.vaartaWidgetNavParent = 'true';
		}

		initialized.add( item );
	}

	function init( root ) {
		var scope = root && root.querySelectorAll ? root : document;
		var selector = '.widget_nav_menu .menu-item-has-children';

		if ( scope.matches && scope.matches( selector ) ) {
			initItem( scope );
		}
		Array.prototype.forEach.call( scope.querySelectorAll( selector ), initItem );
	}

	document.addEventListener( 'click', function ( event ) {
		var toggle = event.target.closest( '.vaarta-widget-nav-toggle' );
		if ( toggle ) {
			event.preventDefault();
			toggleItem( toggle.closest( '.menu-item-has-children' ) );
			return;
		}

		var parentLink = event.target.closest( '.widget_nav_menu a[data-vaarta-widget-nav-parent="true"]' );
		if ( parentLink ) {
			event.preventDefault();
			toggleItem( parentLink.closest( '.menu-item-has-children' ) );
		}
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Enter' !== event.key && ' ' !== event.key ) {
			return;
		}
		var toggle = event.target.closest( '.vaarta-widget-nav-toggle' );
		if ( ! toggle ) {
			return;
		}
		event.preventDefault();
		toggleItem( toggle.closest( '.menu-item-has-children' ) );
	} );

	document.addEventListener( 'vaarta:posts-added', function ( event ) { init( event.target || document ); } );
	document.addEventListener( 'vaarta:next-post-added', function ( event ) { init( event.target || document ); } );

	api.init = init;
	api.toggle = toggleItem;

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () { init( document ); }, { once: true } );
	} else {
		init( document );
	}
} )();
