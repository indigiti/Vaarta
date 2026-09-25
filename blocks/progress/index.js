( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, RangeControl, TextControl, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/progress', {
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
						{ title: __( 'Progress', 'vaarta' ), initialOpen: true },
						el( TextControl, {
							label: __( 'Label', 'vaarta' ),
							value: attributes.label,
							onChange: function( value ) {
								setAttributes( { label: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Value', 'vaarta' ),
							value: attributes.value,
							min: 0,
							max: 100,
							onChange: function( value ) {
								setAttributes( { value: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show value', 'vaarta' ),
							checked: attributes.showValue,
							onChange: function( value ) {
								setAttributes( { showValue: value } );
							}
						} )
					)
				),
				el( 'div', blockProps, el( ServerSideRender, {
					block: 'vaarta/progress',
					attributes: attributes
				} ) )
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
