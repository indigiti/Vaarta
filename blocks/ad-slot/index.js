( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, RangeControl, TextControl, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/ad-slot', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps();

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Ad Slot', 'vaarta' ), initialOpen: true },
						el( TextControl, {
							label: __( 'Slot name', 'vaarta' ),
							value: attributes.slotName,
							onChange: function( value ) {
								setAttributes( { slotName: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Reserved minimum height', 'vaarta' ),
							value: attributes.minHeight,
							min: 50,
							max: 600,
							step: 10,
							onChange: function( value ) {
								setAttributes( { minHeight: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show advertisement label', 'vaarta' ),
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
					el( ServerSideRender, {
						block: 'vaarta/ad-slot',
						attributes: attributes
					} )
				)
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
