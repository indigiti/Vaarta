( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	var source = window.csco_ajax_nextpost;
	var api = window.vaartaContinuousReading = window.vaartaContinuousReading || {};

	if ( ! runtime ) {
		return;
	}

	var config = source ? {
		type: source.type || 'ajax_restapi',
		not_in: Array.isArray( source.not_in ) ? source.not_in.slice() : [],
		next_post: parseInt( source.next_post, 10 ) || 0,
		nonce: source.nonce || '',
		rest_url: source.rest_url || '',
		url: source.url || ''
	} : null;
	var container = null;
	var sentinel = null;
	var observer = null;
	var loading = false;

	// The compiled bundle checks this global before initiating its own request.
	// Keep its history-sync listener alive for compatibility, but neutralize the
	// legacy loading branch now owned by this module.
	if ( source && config && config.next_post ) {
		source.next_post = false;
	}

	function ensureContainer() {
		container = document.querySelector( '.cs-nextpost-inner' );
		if ( ! container ) {
			var current = document.querySelector( '.cs-site-primary > .cs-site-content' );
			if ( ! current || ! current.parentNode ) {
				return null;
			}
			container = document.createElement( 'div' );
			container.className = 'cs-nextpost-inner';
			current.parentNode.insertBefore( container, current.nextSibling );
		}

		if ( ! sentinel || ! sentinel.isConnected ) {
			sentinel = document.createElement( 'div' );
			sentinel.className = 'vaarta-nextpost-sentinel';
			sentinel.setAttribute( 'aria-hidden', 'true' );
			container.appendChild( sentinel );
		}

		return container;
	}

	function requestBody() {
		var body = new URLSearchParams();
		body.set( 'next_post', String( config.next_post ) );
		body.set( 'nonce', config.nonce );
		config.not_in.forEach( function ( id ) {
			body.append( 'not_in[]', String( parseInt( id, 10 ) || 0 ) );
		} );

		if ( 'ajax_restapi' !== config.type ) {
			body.set( 'action', 'csco_ajax_load_nextpost' );
		}

		return body;
	}

	function insertContent( html ) {
		if ( ! html || ! ensureContainer() ) {
			return [];
		}

		var template = document.createElement( 'template' );
		template.innerHTML = html.trim();
		var elements = Array.prototype.slice.call( template.content.children );
		elements.forEach( function ( element ) {
			container.insertBefore( element, sentinel );
		} );

		document.body.dispatchEvent( new CustomEvent( 'post-load', { bubbles: true } ) );
		runtime.emit( 'vaarta:next-post-added', { container: container, elements: elements } );

		if ( window.FB && window.FB.XFBML && 'function' === typeof window.FB.XFBML.parse ) {
			window.FB.XFBML.parse();
		}

		return elements;
	}

	function setBusy( busy ) {
		if ( ! ensureContainer() ) {
			return;
		}

		container.setAttribute( 'aria-busy', busy ? 'true' : 'false' );
		var loader = container.parentNode ? container.parentNode.querySelector( ':scope > .cs-nextpost-loading' ) : null;

		if ( busy && ! loader && container.parentNode ) {
			loader = document.createElement( 'div' );
			loader.className = 'cs-nextpost-loading';
			loader.setAttribute( 'aria-hidden', 'true' );
			container.parentNode.insertBefore( loader, container.nextSibling );
		} else if ( ! busy && loader ) {
			loader.remove();
		}
	}

	async function load() {
		if ( loading || ! config || ! config.next_post ) {
			return false;
		}

		var endpoint = 'ajax_restapi' === config.type ? config.rest_url : config.url;
		if ( ! endpoint ) {
			return false;
		}

		loading = true;
		setBusy( true );

		try {
			var response = await fetch( endpoint, {
				method: 'POST',
				credentials: 'same-origin',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
				body: requestBody().toString()
			} );
			var payload = await response.json();

			if ( ! response.ok || ! payload || ! payload.success || ! payload.data ) {
				throw new Error( 'Continuous-reading request failed' );
			}

			var elements = insertContent( payload.data.content || '' );
			config.not_in = Array.isArray( payload.data.not_in ) ? payload.data.not_in.slice() : config.not_in;
			config.next_post = parseInt( payload.data.next_post, 10 ) || 0;

			if ( ! config.next_post && observer ) {
				observer.disconnect();
				observer = null;
			}

			return elements.length > 0;
		} catch ( error ) {
			if ( container ) {
				container.dispatchEvent( new CustomEvent( 'vaarta:continuous-reading-error', {
					bubbles: true,
					detail: { error: error }
				} ) );
			}
			return false;
		} finally {
			loading = false;
			setBusy( false );
		}
	}

	api.load = load;
	api.getState = function () {
		return config ? {
			nextPost: config.next_post,
			notIn: config.not_in.slice(),
			loading: loading
		} : { nextPost: 0, notIn: [], loading: false };
	};

	api.init = function () {
		if ( ! config || ! config.next_post || ! ensureContainer() ) {
			return;
		}

		if ( 'IntersectionObserver' in window ) {
			observer = new IntersectionObserver( function ( entries ) {
				if ( entries.some( function ( entry ) { return entry.isIntersecting; } ) ) {
					load();
				}
			}, { rootMargin: '4000px 0px' } );
			observer.observe( sentinel );
		}
	};

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', api.init );
	} else {
		api.init();
	}
} )();