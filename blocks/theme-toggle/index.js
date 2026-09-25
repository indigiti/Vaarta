( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/theme-toggle', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( { className: 'vaarta-theme-toggle-editor' } );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Theme Toggle', 'vaarta' ), initialOpen: true },
						el( ToggleControl, {
							label: __( 'Show text label', 'vaarta' ),
							checked: attributes.showLabel,
							onChange: function( value ) {
								setAttributes( { showLabel: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el(
						'button',
						{ className: 'vaarta-theme-toggle__button', type: 'button' },
						el( 'span', { 'aria-hidden': 'true' }, '◐' ),
						attributes.showLabel && el( 'span', null, __( 'Appearance', 'vaarta' ) )
					)
				)
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
