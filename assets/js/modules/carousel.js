( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
	}

	var api = window.vaartaCarousel = window.vaartaCarousel || {};
	var states = new WeakMap();
	var instagramStates = new WeakMap();
	var resizeTimer = null;

	function boolData( element, name, fallback ) {
		if ( ! element || ! element.hasAttribute( 'data-' + name ) ) {
			return !! fallback;
		}
		var value = String( element.getAttribute( 'data-' + name ) ).toLowerCase();
		return ! ( 'false' === value || '0' === value || 'no' === value || 'off' === value );
	}

	function getColumns( block ) {
		var value = parseInt( window.getComputedStyle( block ).getPropertyValue( '--cs-carousel-columns' ), 10 );
		return Number.isFinite( value ) && value > 0 ? value : 1;
	}

	function getFlickity( slider ) {
		if ( ! slider || ! window.Flickity ) {
			return null;
		}
		if ( 'function' === typeof window.Flickity.data ) {
			return window.Flickity.data( slider ) || null;
		}
		return null;
	}

	function whenImagesReady( element, callback ) {
		if ( 'function' === typeof window.imagesLoaded ) {
			window.imagesLoaded( element, callback );
			return;
		}
		callback();
	}

	function updateCounter( block, instance ) {
		if ( ! instance ) {
			return;
		}
		var wrapper = block.querySelector( '.cs-carousel__counters' );
		var current = block.querySelector( '.cs-carousel__counters-current' );
		var total = block.querySelector( '.cs-carousel__counters-total' );
		if ( current ) {
			current.textContent = String( ( instance.selectedIndex || 0 ) + 1 );
		}
		if ( total ) {
			total.textContent = String( instance.slides ? instance.slides.length : 0 );
		}
		if ( wrapper ) {
			wrapper.classList.add( 'cs-carousel__counters-visible' );
		}
	}

	function updateArrows( block, instance, wrapAround ) {
		if ( ! instance || wrapAround ) {
			return;
		}
		var prev = block.querySelector( '.cs-carousel__arrow-previous, .carousel-previous' );
		var next = block.querySelector( '.cs-carousel__arrow-next, .carousel-next' );
		if ( prev ) {
			prev.classList.toggle( 'disabled', 0 === instance.selectedIndex );
		}
		if ( next ) {
			var last = instance.slides ? instance.slides.length - 1 : 0;
			next.classList.toggle( 'disabled', instance.selectedIndex >= last );
		}
	}

	function bindControls( block, state ) {
		if ( state.controlsBound ) {
			return;
		}
		state.controlsBound = true;
		block.addEventListener( 'click', function ( event ) {
			var previous = event.target.closest( '.cs-carousel__arrow-previous, .carousel-previous' );
			var next = event.target.closest( '.cs-carousel__arrow-next, .carousel-next' );
			if ( ! previous && ! next ) {
				return;
			}
			event.preventDefault();
			var instance = getFlickity( state.slider );
			if ( ! instance ) {
				return;
			}
			var rtl = document.body.classList.contains( 'rtl' );
			if ( previous ) {
				if ( rtl ) {
					instance.next();
				} else {
					instance.previous();
				}
			} else if ( rtl ) {
				instance.previous();
			} else {
				instance.next();
			}
		} );
	}

	function createEditorialInstance( block, type ) {
		if ( ! window.Flickity ) {
			return null;
		}

		var slider = block.querySelector( '.cs-carousel__items' );
		if ( ! slider ) {
			return null;
		}
		var init = block.querySelector( '.cs-flickity-init' ) || slider;
		var cells = slider.querySelectorAll( '.cs-carousel__cell' );
		var columns = getColumns( block );
		var rtl = document.body.classList.contains( 'rtl' );
		var wrapAround = boolData( init, 'wraparound', false );
		var pageDots = boolData( init, 'pagedots', false );
		var autoPlay = boolData( init, 'autoplay', false );
		var groupCells = 'large' === type && boolData( init, 'groupcells', false );
		var shouldEnable = cells.length >= columns + 1;
		var existing = getFlickity( slider );
		var state = states.get( block ) || { slider: slider, controlsBound: false, columns: null, instance: null };
		state.slider = slider;
		bindControls( block, state );

		if ( ! shouldEnable ) {
			if ( existing ) {
				existing.destroy();
			}
			state.instance = null;
			state.columns = columns;
			states.set( block, state );
			return null;
		}

		var needsRecreate = ! existing || state.columns !== columns || state.type !== type;
		if ( needsRecreate && existing ) {
			existing.destroy();
			existing = null;
		}

		if ( ! existing ) {
			var options = {
				autoPlay: autoPlay ? 5000 : false,
				prevNextButtons: false,
				pageDots: pageDots,
				rightToLeft: rtl,
				wrapAround: wrapAround,
				resize: true
			};

			if ( 'wide' === type ) {
				options.cellAlign = rtl ? 'right' : 'left';
			} else {
				options.groupCells = groupCells ? columns : false;
				options.selectedAttraction = 0.006;
				options.friction = 0.14;
				block.classList.toggle( 'cs-groupcells-active', groupCells );
			}

			existing = new window.Flickity( slider, options );
		}

		state.instance = existing;
		state.columns = columns;
		state.type = type;
		state.wrapAround = wrapAround;
		states.set( block, state );

		if ( ! state.selectBound && existing ) {
			state.selectBound = true;
			existing.on( 'select', function () {
				updateCounter( block, existing );
				updateArrows( block, existing, wrapAround );
			} );
		}
		updateCounter( block, existing );
		updateArrows( block, existing, wrapAround );
		block.dataset.vaartaCarousel = 'true';
		return existing;
	}

	function createTwitterInstance( block ) {
		if ( ! window.Flickity ) {
			return null;
		}
		var slider = block.querySelector( '.cs-twitter-carousel__items' );
		if ( ! slider ) {
			return null;
		}
		var cells = slider.querySelectorAll( '.cs-twitter-carousel__cell' );
		var rtl = document.body.classList.contains( 'rtl' );
		var wrapAround = boolData( block, 'wraparound', false );
		var autoPlay = boolData( block, 'autoplay', false );
		var state = states.get( block ) || { slider: slider, controlsBound: false };
		state.slider = slider;
		bindControls( block, state );
		var instance = getFlickity( slider );

		if ( cells.length < 2 ) {
			if ( instance ) {
				instance.destroy();
			}
			states.set( block, state );
			return null;
		}
		if ( ! instance ) {
			instance = new window.Flickity( slider, {
				cellAlign: rtl ? 'right' : 'left',
				wrapAround: wrapAround,
				autoPlay: autoPlay ? 5000 : false,
				prevNextButtons: false,
				pageDots: true,
				rightToLeft: rtl,
				resize: true
			} );
		}
		state.instance = instance;
		state.wrapAround = wrapAround;
		states.set( block, state );
		if ( ! state.selectBound ) {
			state.selectBound = true;
			instance.on( 'select', function () {
				updateArrows( block, instance, wrapAround );
			} );
		}
		updateArrows( block, instance, wrapAround );
		block.dataset.vaartaCarousel = 'true';
		return instance;
	}

	function startTicker( element, state ) {
		if ( state.frame || runtime.prefersReducedMotion() || ! state.visible ) {
			return;
		}
		function tick() {
			if ( ! state.visible || runtime.prefersReducedMotion() ) {
				state.frame = null;
				return;
			}
			state.instance.x -= 0.25;
			state.instance.settle( state.instance.x );
			state.frame = window.requestAnimationFrame( tick );
		}
		state.frame = window.requestAnimationFrame( tick );
	}

	function stopTicker( state ) {
		if ( state.frame ) {
			window.cancelAnimationFrame( state.frame );
			state.frame = null;
		}
	}

	function initInstagram( element ) {
		if ( ! element || ! window.Flickity || instagramStates.has( element ) ) {
			return;
		}
		var rtl = document.body.classList.contains( 'rtl' );
		var instance = getFlickity( element );
		if ( ! instance ) {
			instance = new window.Flickity( element, {
				freeScroll: true,
				accessibility: true,
				resize: true,
				wrapAround: true,
				prevNextButtons: false,
				pageDots: false,
				percentPosition: true,
				setGallerySize: true,
				adaptiveHeight: true,
				rightToLeft: rtl,
				on: {
					ready: function () {
						element.classList.add( 'is-animate' );
					}
				}
			} );
		}
		instance.x = 0;
		var state = { instance: instance, frame: null, visible: true, observer: null };
		instagramStates.set( element, state );

		if ( 'IntersectionObserver' in window ) {
			state.observer = new IntersectionObserver( function ( entries ) {
				state.visible = entries.some( function ( entry ) { return entry.isIntersecting; } );
				if ( state.visible ) {
					startTicker( element, state );
				} else {
					stopTicker( state );
				}
			}, { rootMargin: '200px 0px' } );
			state.observer.observe( element );
		} else {
			startTicker( element, state );
		}
	}

	function initRoot( root ) {
		var scope = root && root.querySelectorAll ? root : document;
		var run = function ( selector, callback ) {
			if ( scope.matches && scope.matches( selector ) ) {
				callback( scope );
			}
			Array.prototype.forEach.call( scope.querySelectorAll( selector ), callback );
		};

		run( '.cnvs-block-posts-layout-wide-type-1', function ( block ) {
			whenImagesReady( block, function () { createEditorialInstance( block, 'wide' ); } );
		} );
		run( '.cnvs-block-posts-layout-large-type-1', function ( block ) {
			whenImagesReady( block, function () { createEditorialInstance( block, 'large' ); } );
		} );
		run( '.cs-twitter-carousel', function ( block ) {
			whenImagesReady( block, function () { createTwitterInstance( block ); } );
		} );
		run( '.pk-instagram-template-carousel .pk-instagram-items-carousel, .pk-instagram-template-carousel-full .pk-instagram-items-carousel-full', function ( element ) {
			whenImagesReady( element, function () { initInstagram( element ); } );
		} );
	}

	api.init = initRoot;
	api.getInstance = function ( element ) {
		return getFlickity( element );
	};

	window.addEventListener( 'resize', function () {
		window.clearTimeout( resizeTimer );
		resizeTimer = window.setTimeout( function () {
			document.querySelectorAll( '.cnvs-block-posts-layout-wide-type-1' ).forEach( function ( block ) { createEditorialInstance( block, 'wide' ); } );
			document.querySelectorAll( '.cnvs-block-posts-layout-large-type-1' ).forEach( function ( block ) { createEditorialInstance( block, 'large' ); } );
		}, 120 );
	}, { passive: true } );

	document.body.addEventListener( 'post-load', function ( event ) {
		initRoot( event.target && event.target.querySelectorAll ? event.target : document );
	} );
	document.addEventListener( 'vaarta:posts-added', function ( event ) {
		var detail = event.detail || {};
		if ( detail.area ) {
			initRoot( detail.area );
		}
	} );
	document.addEventListener( 'vaarta:next-post-added', function ( event ) {
		var detail = event.detail || {};
		if ( detail.container ) {
			initRoot( detail.container );
		}
	} );

	if ( window.wp && window.wp.hooks && 'function' === typeof window.wp.hooks.addAction ) {
		window.wp.hooks.addAction( 'canvas.components.serverSideRender.onChange', 'vaarta/init-carousel', function ( props ) {
			if ( props && 'canvas/posts' === props.block ) {
				initRoot( document );
			}
		} );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () { initRoot( document ); }, { once: true } );
	} else {
		initRoot( document );
	}
} )();