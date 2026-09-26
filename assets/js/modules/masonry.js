( function () {
	'use strict';

	var api = window.vaartaMasonry = window.vaartaMasonry || {};
	var instances = new WeakMap();
	var selector = '.cs-posts-area__masonry, .cs-block-posts-layout-masonry-type-1';

	function ensureColumns( container ) {
		var columns = container.querySelectorAll( ':scope > .cs-posts-area__masonry-col' );
		if ( columns.length ) {
			return;
		}

		for ( var index = 1; index <= 4; index++ ) {
			var column = document.createElement( 'div' );
			column.className = 'cs-posts-area__masonry-col cs-posts-area__masonry-col-' + index;
			container.appendChild( column );
		}
	}

	function getInstance( container ) {
		if ( ! container || ! window.Colcade ) {
			return null;
		}

		var instance = instances.get( container ) || window.Colcade.data( container );
		if ( instance ) {
			instances.set( container, instance );
			return instance;
		}

		ensureColumns( container );
		instance = new window.Colcade( container, {
			columns: '.cs-posts-area__masonry-col',
			items: '.cs-posts-area-card'
		} );
		instances.set( container, instance );
		return instance;
	}

	function initContainer( container ) {
		if ( ! container ) {
			return null;
		}

		ensureColumns( container );
		var instance = getInstance( container );
		if ( instance ) {
			instance.reload();
			container.dataset.vaartaMasonry = 'true';
		}
		return instance;
	}

	api.init = function ( root ) {
		var scope = root && root.querySelectorAll ? root : document;
		if ( scope.matches && scope.matches( selector ) ) {
			initContainer( scope );
		}
		Array.prototype.forEach.call( scope.querySelectorAll( selector ), initContainer );
	};

	api.append = function ( container, elements ) {
		if ( ! container || ! elements || ! elements.length ) {
			return false;
		}

		var instance = initContainer( container );
		if ( ! instance ) {
			elements.forEach( function ( element ) {
				container.appendChild( element );
			} );
			return false;
		}

		instance.append( elements );
		return true;
	};

	api.layout = function ( container ) {
		var instance = getInstance( container );
		if ( instance ) {
			instance.reload();
		}
	};

	// Run after the legacy document-ready initializer. This adopts its Colcade
	// instance when present and creates one only for containers it never saw.
	window.addEventListener( 'load', function () {
		api.init( document );
	} );

	document.addEventListener( 'vaarta:posts-added', function ( event ) {
		var detail = event.detail || {};
		if ( detail.area ) {
			api.init( detail.area );
		}
	} );
} )();