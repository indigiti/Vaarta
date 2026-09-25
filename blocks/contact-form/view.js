import { getConfig, getElement, store } from '@wordpress/interactivity';

function setStatus( root, message, state = '' ) {
	const status = root.querySelector( '.vaarta-contact-form__status' );
	if ( ! status ) {
		return;
	}

	status.textContent = message;
	status.dataset.state = state;
}

store( 'vaarta/contact-form', {
	actions: {
		*submit( event ) {
			event.preventDefault();

			const { ref } = getElement();
			const form = ref.closest( 'form' ) || ref;
			const root = form.closest( '.vaarta-contact-form' );

			if ( ! root || root.dataset.submitting === 'true' ) {
				return;
			}

			if ( ! form.reportValidity() ) {
				return;
			}

			root.dataset.submitting = 'true';
			root.classList.add( 'is-submitting' );
			setStatus( root, 'Sending…', 'loading' );

			const { restUrl } = getConfig( 'vaarta/contact-form' );
			const payload = Object.fromEntries( new FormData( form ).entries() );

			try {
				const response = yield fetch( restUrl, {
					method: 'POST',
					credentials: 'same-origin',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify( payload )
				} );

				const data = yield response.json();

				if ( ! response.ok ) {
					throw new Error( data.message || 'Unable to send your message.' );
				}

				form.reset();
				setStatus( root, data.message || 'Thanks. Your message has been sent.', 'success' );
			} catch ( error ) {
				setStatus( root, error.message || 'Unable to send your message.', 'error' );
			} finally {
				root.dataset.submitting = 'false';
				root.classList.remove( 'is-submitting' );
			}
		}
	}
} );
