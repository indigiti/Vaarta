( function () {
	'use strict';

	var api = window.vaartaStickySidebar = window.vaartaStickySidebar || {};
	var smartSelectors = [
		'.cs-navbar-smart-enabled .cs-entry__metabar-inner',
		'.cs-sticky-sidebar-enabled.cs-navbar-smart-enabled.cs-stick-to-top .cs-sidebar__inner',
		'.cs-sticky-sidebar-enabled.cs-navbar-smart-enabled.cs-stick-last .cs-sidebar__inner .widget:last-child',
		'.cs-sticky-sidebar-enabled.cs-navbar-smart-enabled .cnvs-block-section-sidebar-sticky-top .cnvs-block-section-sidebar-inner',
		'.cs-sticky-sidebar-enabled.cs-navbar-smart-enabled .cnvs-block-section-sidebar-sticky-top-last-block .cnvs-block-section-sidebar-inner > :last-child'
	];
	var stickySelectors = [
		'.cs-navbar-sticky-enabled .cs-entry__metabar-inner',
		'.cs-sticky-sidebar-enabled.cs-navbar-sticky-enabled.cs-stick-to-top .cs-sidebar__inner',
		'.cs-sticky-sidebar-enabled.cs-navbar-sticky-enabled.cs-stick-last .cs-sidebar__inner .widget:last-child',
		'.cs-sticky-sidebar-enabled.cs-navbar-sticky-enabled .cnvs-block-section-sidebar-sticky-top .cnvs-block-section-sidebar-inner',
		'.cs-sticky-sidebar-enabled.cs-navbar-sticky-enabled .cnvs-block-section-sidebar-sticky-top-last-block .cnvs-block-section-sidebar-inner > :last-child'
	];
	var state = {
		headerStickHeight: 0,
		headerStretchHeight: 0,
		headerScrollHeight: 0,
		adminBarHeight: 0
	};
	var resizeTimer = null;

	if ( /firefox/i.test( window.navigator.userAgent || '' ) ) {
		smartSelectors.push( '.cs-sticky-sidebar-enabled.cs-stick-to-bottom .cs-sidebar__inner' );
		stickySelectors.push( '.cs-sticky-sidebar-enabled.cs-stick-to-bottom .cs-sidebar__inner' );
	}

	function cssNumber( name ) {
		var value = parseInt( window.getComputedStyle( document.documentElement ).getPropertyValue( name ), 10 );
		return Number.isFinite( value ) ? value : 0;
	}

	function height( element ) {
		return element ? element.getBoundingClientRect().height : 0;
	}

	function nodes( selectors ) {
		return Array.prototype.slice.call( document.querySelectorAll( selectors.join( ',' ) ) );
	}

	function setTop( selectors, top ) {
		nodes( selectors ).forEach( function ( element ) {
			element.style.top = top + 'px';
		} );
	}

	function clearTop() {
		nodes( smartSelectors.concat( stickySelectors ) ).forEach( function ( element ) {
			element.style.removeProperty( 'top' );
		} );
	}

	function measure() {
		var header = document.querySelector( '.cs-header' );
		var smartHeader = document.querySelector( '.cs-navbar-smart-enabled .cs-header' );
		var adminBar = document.getElementById( 'wpadminbar' );
		var hasSmartHeader = !! smartHeader;

		state.adminBarHeight = height( adminBar );
		state.headerStickHeight = hasSmartHeader ? cssNumber( '--cs-header-height' ) : height( header );
		state.headerStretchHeight = hasSmartHeader ? cssNumber( '--cs-header-height' ) : height( document.querySelector( '.cs-header-stretch' ) );
	}

	function offset( headerHeight ) {
		return ( headerHeight || 0 ) + ( state.headerScrollHeight || 0 ) + ( state.adminBarHeight || 0 ) + 20;
	}

	function preferredHeaderHeight() {
		return state.headerStretchHeight || state.headerStickHeight || 0;
	}

	function applyInitial() {
		if ( window.innerWidth < 1020 ) {
			clearTop();
			return;
		}

		if ( document.body.classList.contains( 'cs-navbar-smart-enabled' ) ) {
			setTop( smartSelectors, offset( preferredHeaderHeight() ) );
		} else if ( document.body.classList.contains( 'cs-navbar-sticky-enabled' ) ) {
			setTop( stickySelectors, offset( preferredHeaderHeight() ) );
		}
	}

	function onStickyVisible() {
		state.headerStickHeight = cssNumber( '--cs-header-height' );
		if ( window.innerWidth >= 1020 ) {
			setTop( smartSelectors, offset( preferredHeaderHeight() ) );
		}
	}

	function onStickyHide() {
		state.headerStickHeight = 0;
		if ( window.innerWidth >= 1020 ) {
			setTop( smartSelectors, offset( 0 ) );
		}
	}

	function onStretchSmall() {
		state.headerStretchHeight = cssNumber( '--cs-header-height' );
		var stretch = document.querySelector( '.cs-header-stretch' );
		if ( window.innerWidth >= 1020 && stretch && stretch.classList.contains( 'cs-scroll-sticky' ) && ! stretch.classList.contains( 'cs-scroll-active' ) ) {
			setTop( smartSelectors, offset( preferredHeaderHeight() ) );
		}
	}

	function refresh() {
		measure();
		applyInitial();
	}

	document.addEventListener( 'entry-header-scrolled', function () {
		state.headerScrollHeight = cssNumber( '--cs-header-height' );
		applyInitial();
	} );
	document.addEventListener( 'entry-header-no-scrolled', function () {
		state.headerScrollHeight = 0;
		applyInitial();
	} );
	document.addEventListener( 'sticky-nav-visible', onStickyVisible );
	document.addEventListener( 'sticky-nav-hide', onStickyHide );
	document.addEventListener( 'vaarta:sticky-visible', onStickyVisible );
	document.addEventListener( 'vaarta:sticky-hide', onStickyHide );
	document.addEventListener( 'stretch-nav-to-small', onStretchSmall );
	document.addEventListener( 'stretch-nav-to-big', function () {
		state.headerStretchHeight = cssNumber( '--cs-header-initial-height' );
	} );
	document.addEventListener( 'vaarta:posts-added', applyInitial );
	document.addEventListener( 'vaarta:next-post-added', applyInitial );

	window.addEventListener( 'resize', function () {
		window.clearTimeout( resizeTimer );
		resizeTimer = window.setTimeout( refresh, 80 );
	}, { passive: true } );

	api.refresh = refresh;
	api.getOffset = function () {
		return offset( preferredHeaderHeight() );
	};

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', refresh, { once: true } );
	} else {
		refresh();
	}
} )();
