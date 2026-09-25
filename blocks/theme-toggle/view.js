import { getElement, store } from '@wordpress/interactivity';

function getTheme() {
	const value = document.documentElement.dataset.vaartaTheme;
	return value === 'dark' ? 'dark' : 'light';
}

function syncButton( button ) {
	const isDark = getTheme() === 'dark';
	button.setAttribute( 'aria-pressed', isDark ? 'true' : 'false' );
	button.dataset.theme = isDark ? 'dark' : 'light';
}

store( 'vaarta/theme-toggle', {
	actions: {
		toggle() {
			const { ref } = getElement();
			const next = getTheme() === 'dark' ? 'light' : 'dark';

			document.documentElement.dataset.vaartaTheme = next;
			document.documentElement.style.colorScheme = next;

			try {
				localStorage.setItem( 'vaarta-theme', next );
			} catch ( error ) {
				// The preference still applies for the current page.
			}

			document.querySelectorAll( '.vaarta-theme-toggle__button' ).forEach( syncButton );
		}
	},
	callbacks: {
		sync() {
			const { ref } = getElement();
			syncButton( ref );
		}
	}
} );
