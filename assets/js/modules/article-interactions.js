( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
	}

	var i18n = Object.assign(
		{
			urlLabel: 'Shareable URL',
			copyLabel: 'Copy shareable URL',
			copiedLabel: 'Shareable URL copied',
			copied: 'Shareable URL copied.',
			copyFailed: 'Copy failed. Select the URL and copy it manually.'
		},
		window.vaartaArticleI18n || {}
	);

	function normalizeShareControls() {
		document.querySelectorAll( '.cs-entry__after-share-buttons-link' ).forEach( function ( wrapper ) {
			var input = wrapper.querySelector( 'input.cs-entry__after-share-buttons-text' );
			var button = wrapper.querySelector( '.cs-entry__after-share-buttons-copy' );
			var status = wrapper.querySelector( '.cs-entry__after-share-buttons-status' );

			if ( input ) {
				input.readOnly = true;
				if ( ! input.getAttribute( 'aria-label' ) ) {
					input.setAttribute( 'aria-label', i18n.urlLabel );
				}
			}

			if ( button ) {
				button.type = 'button';
				button.setAttribute( 'aria-label', i18n.copyLabel );
			}

			if ( ! status ) {
				status = document.createElement( 'span' );
				status.className = 'screen-reader-text cs-entry__after-share-buttons-status';
				status.setAttribute( 'aria-live', 'polite' );
				wrapper.appendChild( status );
			}
		} );
	}

	function showComments( button ) {
		var targetId = button.getAttribute( 'aria-controls' ) || 'comments-hidden';
		var comments = document.getElementById( targetId );
		if ( ! comments ) {
			return;
		}

		comments.style.display = 'block';
		comments.setAttribute( 'aria-hidden', 'false' );
		button.setAttribute( 'aria-expanded', 'true' );

		var disclosure = button.closest( '.cs-entry__comments-show' );
		if ( disclosure ) {
			disclosure.remove();
		}

		comments.focus( { preventScroll: true } );
		runtime.emit( 'vaarta:comments-open', { comments: comments } );
	}

	function setCopyFeedback( wrapper, state ) {
		var button = wrapper.querySelector( '.cs-entry__after-share-buttons-copy' );
		var icon = button ? button.querySelector( '.cs-icon' ) : null;
		var status = wrapper.querySelector( '.cs-entry__after-share-buttons-status' );
		var copied = 'copied' === state;

		if ( icon ) {
			icon.classList.toggle( 'cs-icon-copy', ! copied );
			icon.classList.toggle( 'cs-icon-check', copied );
		}
		if ( status ) {
			status.textContent = copied ? i18n.copied : ( 'failed' === state ? i18n.copyFailed : '' );
		}
		if ( button ) {
			button.setAttribute( 'aria-label', copied ? i18n.copiedLabel : i18n.copyLabel );
		}
	}

	async function copyShareUrl( button ) {
		var wrapper = button.closest( '.cs-entry__after-share-buttons-link' );
		var input = wrapper ? wrapper.querySelector( 'input.cs-entry__after-share-buttons-text' ) : null;
		if ( ! wrapper || ! input ) {
			return;
		}

		var copied = false;
		try {
			if ( navigator.clipboard && window.isSecureContext ) {
				await navigator.clipboard.writeText( input.value );
				copied = true;
			}
		} catch ( error ) {
			copied = false;
		}

		if ( ! copied ) {
			input.focus();
			input.select();
		}

		setCopyFeedback( wrapper, copied ? 'copied' : 'failed' );
		runtime.emit( 'vaarta:share-copy', { copied: copied, url: input.value } );

		if ( copied ) {
			window.setTimeout( function () {
				setCopyFeedback( wrapper, 'idle' );
			}, 2000 );
		}
	}

	document.addEventListener( 'click', function ( event ) {
		var commentsButton = event.target.closest( '.cs-entry__comments-show button' );
		if ( commentsButton ) {
			event.preventDefault();
			showComments( commentsButton );
			return;
		}

		var copyButton = event.target.closest( '.cs-entry__after-share-buttons-copy' );
		if ( copyButton ) {
			event.preventDefault();
			copyShareUrl( copyButton );
		}
	} );

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', normalizeShareControls, { once: true } );
	} else {
		normalizeShareControls();
	}

	document.body.addEventListener( 'post-load', normalizeShareControls );

	window.vaartaArticleInteractions = {
		refresh: normalizeShareControls,
		showComments: showComments,
		copyShareUrl: copyShareUrl
	};
} )();