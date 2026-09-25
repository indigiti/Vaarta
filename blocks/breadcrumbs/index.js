( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/breadcrumbs', {
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
						{ title: __( 'Breadcrumbs', 'vaarta' ), initialOpen: true },
						el( ToggleControl, {
							label: __( 'Show current item', 'vaarta' ),
							checked: attributes.showCurrent,
							onChange: function( value ) {
								setAttributes( { showCurrent: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show primary category', 'vaarta' ),
							checked: attributes.showCategory,
							onChange: function( value ) {
								setAttributes( { showCategory: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'vaarta/breadcrumbs',
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
