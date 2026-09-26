( function () {
	'use strict';

	var runtime = window.vaartaRuntime;
	if ( ! runtime ) {
		return;
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

	function setCopyFeedback( wrapper, copied ) {
		var button = wrapper.querySelector( '.cs-entry__after-share-buttons-copy' );
		var icon = button ? button.querySelector( '.cs-icon' ) : null;
		var status = wrapper.querySelector( '.cs-entry__after-share-buttons-status' );

		if ( icon ) {
			icon.classList.toggle( 'cs-icon-copy', ! copied );
			icon.classList.toggle( 'cs-icon-check', copied );
		}
		if ( status ) {
			status.textContent = copied ? 'Shareable URL copied.' : 'Copy failed. Select the URL and copy it manually.';
		}
		if ( button ) {
			button.setAttribute( 'aria-label', copied ? 'Shareable URL copied' : 'Copy shareable URL' );
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

		setCopyFeedback( wrapper, copied );
		runtime.emit( 'vaarta:share-copy', { copied: copied, url: input.value } );

		if ( copied ) {
			window.setTimeout( function () {
				setCopyFeedback( wrapper, false );
				var status = wrapper.querySelector( '.cs-entry__after-share-buttons-status' );
				if ( status ) {
					status.textContent = '';
				}
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

	window.vaartaArticleInteractions = {
		showComments: showComments,
		copyShareUrl: copyShareUrl
	};
} )();