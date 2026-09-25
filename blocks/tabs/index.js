( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InnerBlocks, InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, SelectControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/tabs', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( {
				className: 'vaarta-tabs-editor vaarta-tabs-editor--' + attributes.styleVariant
			} );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Tabs / Pills', 'vaarta' ), initialOpen: true },
						el( SelectControl, {
							label: __( 'Style', 'vaarta' ),
							value: attributes.styleVariant,
							options: [
								{ label: __( 'Tabs', 'vaarta' ), value: 'tabs' },
								{ label: __( 'Pills', 'vaarta' ), value: 'pills' }
							],
							onChange: function( value ) {
								setAttributes( { styleVariant: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( InnerBlocks, {
						allowedBlocks: [ 'vaarta/tab' ],
						template: [
							[ 'vaarta/tab', { title: __( 'Tab 1', 'vaarta' ) } ],
							[ 'vaarta/tab', { title: __( 'Tab 2', 'vaarta' ) } ]
						],
						renderAppender: InnerBlocks.ButtonBlockAppender
					} )
				)
			);
		},
		save: function() {
			return el( InnerBlocks.Content );
		}
	} );
} )( window.wp );
