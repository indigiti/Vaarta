( function () {
	'use strict';

	var api = window.vaartaPlayerControls = window.vaartaPlayerControls || {};
	var selector = '.cs-player-control';

	function siblings( control ) {
		if ( ! control || ! control.parentElement ) {
			return [];
		}

		return Array.prototype.filter.call( control.parentElement.children, function ( element ) {
			return element !== control && element.matches && element.matches( selector );
		} );
	}

	function setSiblingOpacity( control, opacity ) {
		siblings( control ).forEach( function ( sibling ) {
			sibling.style.opacity = opacity;
		} );
	}

	document.addEventListener( 'pointerover', function ( event ) {
		var control = event.target.closest( selector );
		if ( ! control || ( event.relatedTarget && control.contains( event.relatedTarget ) ) ) {
			return;
		}
		setSiblingOpacity( control, '0.5' );
	} );

	document.addEventListener( 'pointerout', function ( event ) {
		var control = event.target.closest( selector );
		if ( ! control || ( event.relatedTarget && control.contains( event.relatedTarget ) ) ) {
			return;
		}
		setSiblingOpacity( control, '1' );
	} );

	api.refresh = function ( root ) {
		var scope = root && root.querySelectorAll ? root : document;
		scope.querySelectorAll( selector ).forEach( function ( control ) {
			control.style.removeProperty( 'opacity' );
		} );
	};
} )();
