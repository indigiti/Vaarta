( function () {
	'use strict';

	var api = window.vaartaTileHover = window.vaartaTileHover || {};
	var selector = '.cs-block-posts-layout-tile-hover .cs-entry__outer';
	var breakpoint = 1020;

	function entries( root ) {
		var scope = root && root.querySelectorAll ? root : document;
		var items = [];

		if ( scope.matches && scope.matches( selector ) ) {
			items.push( scope );
		}

		Array.prototype.push.apply( items, scope.querySelectorAll( selector ) );
		return items;
	}

	function refresh( root ) {
		var compact = window.innerWidth < breakpoint;
		entries( root ).forEach( function ( entry ) {
			if ( compact ) {
				entry.setAttribute( 'data-scheme', 'inverse' );
			} else if ( ! entry.matches( ':hover' ) ) {
				entry.removeAttribute( 'data-scheme' );
			}
		} );
	}

	document.addEventListener( 'pointerover', function ( event ) {
		var entry = event.target.closest( selector );
		if ( ! entry || ( event.relatedTarget && entry.contains( event.relatedTarget ) ) ) {
			return;
		}

		if ( window.innerWidth >= breakpoint ) {
			entry.setAttribute( 'data-scheme', 'inverse' );
		}
	} );

	document.addEventListener( 'pointerout', function ( event ) {
		var entry = event.target.closest( selector );
		if ( ! entry || ( event.relatedTarget && entry.contains( event.relatedTarget ) ) ) {
			return;
		}

		if ( window.innerWidth >= breakpoint ) {
			entry.removeAttribute( 'data-scheme' );
		}
	} );

	window.addEventListener( 'resize', function () { refresh( document ); } );
	document.addEventListener( 'vaarta:posts-added', function () { refresh( document ); } );
	document.addEventListener( 'vaarta:next-post-added', function () { refresh( document ); } );

	api.refresh = refresh;

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () { refresh( document ); }, { once: true } );
	} else {
		refresh( document );
	}
} )();
