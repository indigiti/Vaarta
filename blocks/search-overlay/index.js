( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, RangeControl, TextControl, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/search-overlay', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( { className: 'vaarta-search-overlay-editor' } );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Search Overlay', 'vaarta' ), initialOpen: true },
						el( TextControl, {
							label: __( 'Button label', 'vaarta' ),
							value: attributes.buttonLabel,
							onChange: function( value ) {
								setAttributes( { buttonLabel: value } );
							}
						} ),
						el( TextControl, {
							label: __( 'Input placeholder', 'vaarta' ),
							value: attributes.placeholder,
							onChange: function( value ) {
								setAttributes( { placeholder: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Results limit', 'vaarta' ),
							value: attributes.resultsLimit,
							min: 3,
							max: 10,
							onChange: function( value ) {
								setAttributes( { resultsLimit: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show button text', 'vaarta' ),
							checked: attributes.showButtonLabel,
							onChange: function( value ) {
								setAttributes( { showButtonLabel: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el(
						'button',
						{ type: 'button', className: 'vaarta-search-overlay__trigger' },
						el( 'span', { 'aria-hidden': 'true' }, '⌕' ),
						attributes.showButtonLabel && el( 'span', null, attributes.buttonLabel )
					)
				)
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
