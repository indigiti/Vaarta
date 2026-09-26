( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	var api = window.vaartaVideoBackground = window.vaartaVideoBackground || {};
	var players = new Map();
	var attributes = new Map();
	var apiPromise = null;
	var apiResolve = null;
	var ticking = false;
	var uidCounter = 0;

	if ( ! runtime || ! document.body || document.body.classList.contains( 'wp-admin' ) ) {
		return;
	}

	function youtubeReady() {
		return !! ( window.YT && 'function' === typeof window.YT.Player );
	}

	function resolveYoutube() {
		if ( apiResolve && youtubeReady() ) {
			apiResolve( window.YT );
			apiResolve = null;
		}
	}

	function ensureYoutubeApi() {
		if ( youtubeReady() ) {
			return Promise.resolve( window.YT );
		}

		if ( apiPromise ) {
			return apiPromise;
		}

		apiPromise = new Promise( function ( resolve ) {
			apiResolve = resolve;
		} );

		var previousIframeReady = window.onYouTubeIframeAPIReady;
		var previousPlayerReady = window.onYouTubePlayerAPIReady;
		var ready = function () {
			if ( 'function' === typeof previousIframeReady ) {
				previousIframeReady();
			}
			if ( 'function' === typeof previousPlayerReady && previousPlayerReady !== previousIframeReady ) {
				previousPlayerReady();
			}
			resolveYoutube();
		};
		window.onYouTubeIframeAPIReady = ready;
		window.onYouTubePlayerAPIReady = ready;

		if ( ! document.querySelector( 'script[data-vaarta-youtube-api]' ) ) {
			var script = document.createElement( 'script' );
			script.src = 'https://www.youtube.com/iframe_api';
			script.async = true;
			script.setAttribute( 'data-vaarta-youtube-api', 'true' );
			var firstScript = document.getElementsByTagName( 'script' )[0];
			if ( firstScript && firstScript.parentNode ) {
				firstScript.parentNode.insertBefore( script, firstScript );
			} else {
				document.head.appendChild( script );
			}
		}

		return apiPromise;
	}

	function isInViewport( element ) {
		if ( ! element || ! element.isConnected ) {
			return false;
		}
		var rect = element.getBoundingClientRect();
		return rect.bottom > 0 && rect.top < ( window.innerHeight || document.documentElement.clientHeight );
	}

	function shellFor( wrapper ) {
		return wrapper.closest( '.cs-overlay, .cs-video-wrap' ) || wrapper;
	}

	function stateControl( wrapper ) {
		return shellFor( wrapper ).querySelector( '.cs-player-state' );
	}

	function playerForWrapper( wrapper ) {
		var uid = wrapper ? wrapper.getAttribute( 'data-vaarta-video-uid' ) : '';
		return uid ? players.get( uid ) : null;
	}

	function wrapperForControl( control ) {
		var shell = control.closest( '.cs-overlay, .cs-video-wrap' );
		return shell ? shell.querySelector( '.cs-video-wrapper[data-video-id]' ) : null;
	}

	function resizeWrapper( wrapper ) {
		var player = playerForWrapper( wrapper );
		if ( ! player || 'function' !== typeof player.setSize ) {
			return;
		}

		var width = wrapper.clientWidth || wrapper.getBoundingClientRect().width;
		var height = wrapper.clientHeight || wrapper.getBoundingClientRect().height;
		if ( ! width || ! height ) {
			return;
		}

		var hideControl = 400;
		if ( width / height > 16 / 9 ) {
			player.setSize( width, width / 16 * 9 + hideControl );
		} else {
			player.setSize( height / 9 * 16, height + hideControl );
		}
	}

	function resizeAll() {
		document.querySelectorAll( '.cs-video-wrapper[data-vaarta-video-uid]' ).forEach( resizeWrapper );
	}

	function ensureUid( wrapper ) {
		var uid = wrapper.getAttribute( 'data-vaarta-video-uid' );
		if ( ! uid ) {
			uidCounter += 1;
			uid = 'vaarta-video-' + uidCounter;
			wrapper.setAttribute( 'data-vaarta-video-uid', uid );
		}
		return uid;
	}

	function createPlayer( wrapper, YT ) {
		if ( playerForWrapper( wrapper ) ) {
			return playerForWrapper( wrapper );
		}

		var inner = wrapper.querySelector( '.cs-video-inner' );
		var videoId = wrapper.getAttribute( 'data-video-id' );
		if ( ! inner || ! videoId ) {
			return null;
		}

		var uid = ensureUid( wrapper );
		inner.classList.add( 'cs-video-init' );
		inner.setAttribute( 'data-uid', uid );

		var attrs = {
			videoId: videoId,
			startSeconds: parseFloat( wrapper.getAttribute( 'data-video-start' ) ) || 0,
			endSeconds: parseFloat( wrapper.getAttribute( 'data-video-end' ) ) || undefined,
			suggestedQuality: 'hd720'
		};
		attributes.set( uid, attrs );

		var player = new YT.Player( inner, {
			playerVars: {
				autoplay: 0,
				autohide: 1,
				modestbranding: 1,
				rel: 0,
				showinfo: 0,
				controls: 0,
				disablekb: 1,
				enablejsapi: 0,
				iv_load_policy: 3,
				playsinline: 1,
				loop: 1
			},
			events: {
				onReady: function () {
					if ( 'function' === typeof player.loadVideoById ) {
						player.loadVideoById( attrs );
					}
					if ( 'function' === typeof player.mute ) {
						player.mute();
					}
					resizeWrapper( wrapper );
				},
				onStateChange: function ( event ) {
					if ( 1 === event.data ) {
						shellFor( wrapper ).classList.add( 'cs-video-bg-init' );
						inner.classList.add( 'active' );
					} else if ( 0 === event.data && 'function' === typeof player.seekTo ) {
						player.seekTo( attrs.startSeconds );
					}
				}
			}
		} );
		players.set( uid, player );
		return player;
	}

	function syncPlayback( wrapper ) {
		var player = playerForWrapper( wrapper );
		if ( ! player ) {
			return;
		}

		var control = stateControl( wrapper );
		if ( ! control || control.classList.contains( 'cs-player-upause' ) ) {
			return;
		}

		if ( isInViewport( wrapper ) && control.classList.contains( 'cs-player-play' ) ) {
			control.classList.remove( 'cs-player-play' );
			control.classList.add( 'cs-player-pause' );
			if ( 'function' === typeof player.playVideo ) {
				player.playVideo();
			}
		} else if ( ! isInViewport( wrapper ) && control.classList.contains( 'cs-player-pause' ) ) {
			control.classList.remove( 'cs-player-pause' );
			control.classList.add( 'cs-player-play' );
			if ( 'function' === typeof player.pauseVideo ) {
				player.pauseVideo();
			}
		}
	}

	function processWrapper( wrapper ) {
		if ( ! isInViewport( wrapper ) ) {
			syncPlayback( wrapper );
			return Promise.resolve();
		}

		if ( playerForWrapper( wrapper ) ) {
			syncPlayback( wrapper );
			return Promise.resolve();
		}

		return ensureYoutubeApi().then( function ( YT ) {
			createPlayer( wrapper, YT );
			syncPlayback( wrapper );
		} );
	}

	function process( root ) {
		var scope = root && root.querySelectorAll ? root : document;
		var wrappers = [];
		if ( scope.matches && scope.matches( '.cs-video-wrapper[data-video-id]' ) ) {
			wrappers.push( scope );
		}
		Array.prototype.push.apply( wrappers, scope.querySelectorAll( '.cs-video-wrapper[data-video-id]' ) );
		wrappers.forEach( processWrapper );
	}

	function schedule() {
		if ( ticking ) {
			return;
		}
		ticking = true;
		window.requestAnimationFrame( function () {
			ticking = false;
			process( document );
		} );
	}

	document.addEventListener( 'click', function ( event ) {
		var state = event.target.closest( '.cs-player-state' );
		var stop = event.target.closest( '.cs-player-stop' );
		var volume = event.target.closest( '.cs-player-volume' );
		var control = state || stop || volume;
		if ( ! control ) {
			return;
		}

		var wrapper = wrapperForControl( control );
		var player = playerForWrapper( wrapper );
		if ( ! wrapper || ! player ) {
			return;
		}

		event.preventDefault();

		if ( state ) {
			state.classList.toggle( 'cs-player-pause' );
			state.classList.toggle( 'cs-player-play' );
			if ( state.classList.contains( 'cs-player-pause' ) ) {
				state.classList.remove( 'cs-player-upause' );
				if ( 'function' === typeof player.playVideo ) {
					player.playVideo();
				}
			} else {
				state.classList.add( 'cs-player-upause' );
				if ( 'function' === typeof player.pauseVideo ) {
					player.pauseVideo();
				}
			}
		} else if ( stop ) {
			var siblingState = shellFor( wrapper ).querySelector( '.cs-player-state' );
			if ( siblingState ) {
				siblingState.classList.remove( 'cs-player-pause' );
				siblingState.classList.add( 'cs-player-play', 'cs-player-upause' );
			}
			if ( 'function' === typeof player.pauseVideo ) {
				player.pauseVideo();
			}
		} else if ( volume ) {
			volume.classList.toggle( 'cs-player-mute' );
			volume.classList.toggle( 'cs-player-unmute' );
			if ( volume.classList.contains( 'cs-player-unmute' ) ) {
				if ( 'function' === typeof player.unMute ) {
					player.unMute();
				}
			} else if ( 'function' === typeof player.mute ) {
				player.mute();
			}
		}
	} );

	window.addEventListener( 'load', schedule );
	window.addEventListener( 'scroll', schedule, { passive: true } );
	window.addEventListener( 'resize', function () {
		schedule();
		resizeAll();
	}, { passive: true } );
	document.addEventListener( 'post-load', schedule );
	document.addEventListener( 'vaarta:posts-added', schedule );
	document.addEventListener( 'vaarta:next-post-added', schedule );

	api.init = process;
	api.refresh = schedule;
	api.resize = resizeAll;
	api.getPlayer = playerForWrapper;

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () { process( document ); }, { once: true } );
	} else {
		process( document );
	}
} )();
