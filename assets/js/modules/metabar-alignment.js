( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	var api = window.vaartaMetabarAlignment = window.vaartaMetabarAlignment || {};
	var ticking = false;

	if ( ! runtime ) {
		return;
	}

	function outerMetrics( element ) {
		var rect = element.getBoundingClientRect();
		var style = window.getComputedStyle( element );
		var marginTop = parseFloat( style.marginTop ) || 0;
		var marginBottom = parseFloat( style.marginBottom ) || 0;

		return {
			top: rect.top + window.pageYOffset - marginTop,
			height: rect.height + marginTop + marginBottom
		};
	}

	function processPrimary( primary ) {
		var content = primary.querySelector( '.entry-content' );
		var sidebar = primary.querySelector( '.cs-entry__metabar-inner' );

		if ( ! content || ! sidebar ) {
			return;
		}

		var layouts = content.querySelectorAll( ':scope > .alignfull, :scope > .alignwide' );
		if ( ! layouts.length ) {
			sidebar.style.opacity = '1';
			return;
		}

		var sidebarMetrics = outerMetrics( sidebar );
		var disabled = Array.prototype.some.call( layouts, function ( layout ) {
			if ( 'none' === window.getComputedStyle( layout ).transform ) {
				return false;
			}

			var metrics = outerMetrics( layout );
			var pointTop = metrics.top - 20;
			var pointBottom = metrics.top + metrics.height - 20;

			return sidebarMetrics.top + sidebarMetrics.height >= pointTop && sidebarMetrics.top <= pointBottom;
		} );

		sidebar.style.opacity = disabled ? '0' : '1';
	}

	function process( root ) {
		var scope = root && root.querySelectorAll ? root : document;
		var primaries = [];

		if ( scope.matches && scope.matches( '.cs-site-primary' ) ) {
			primaries.push( scope );
		}

		Array.prototype.push.apply( primaries, scope.querySelectorAll( '.cs-site-primary' ) );
		primaries.forEach( processPrimary );
	}

	function schedule() {
		if ( ticking ) {
			return;
		}

		ticking = true;
		window.requestAnimationFrame( function () {
			process( document );
			ticking = false;
		} );
	}

	api.refresh = function ( root ) {
		process( root || document );
	};

	window.addEventListener( 'scroll', schedule, { passive: true } );
	window.addEventListener( 'resize', schedule );
	window.addEventListener( 'image-load', schedule );
	document.addEventListener( 'post-load', schedule );
	document.addEventListener( 'vaarta:posts-added', schedule );
	document.addEventListener( 'vaarta:next-post-added', schedule );

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () { process( document ); }, { once: true } );
	} else {
		process( document );
	}
} )();
