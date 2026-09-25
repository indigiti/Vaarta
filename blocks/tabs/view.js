import { getElement, store } from '@wordpress/interactivity';

function activateButton( button ) {
	const root = button.closest( '.vaarta-tabs' );
	if ( ! root ) {
		return;
	}

	const index = Number.parseInt( button.dataset.vaartaTabIndex || '0', 10 );
	const buttons = root.querySelectorAll( '[role="tab"]' );
	const panels = root.querySelectorAll( '[role="tabpanel"]' );

	buttons.forEach( ( item, itemIndex ) => {
		const active = itemIndex === index;
		item.setAttribute( 'aria-selected', active ? 'true' : 'false' );
		item.setAttribute( 'tabindex', active ? '0' : '-1' );
	} );

	panels.forEach( ( panel, panelIndex ) => {
		panel.hidden = panelIndex !== index;
	} );
}

store( 'vaarta/tabs', {
	actions: {
		activate() {
			const { ref } = getElement();
			activateButton( ref );
		}
	}
} );
