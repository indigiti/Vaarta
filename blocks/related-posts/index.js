( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, RangeControl, SelectControl, TextControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/related-posts', {
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
						{ title: __( 'Related Stories', 'vaarta' ), initialOpen: true },
						el( TextControl, {
							label: __( 'Heading', 'vaarta' ),
							value: attributes.heading,
							onChange: function( value ) {
								setAttributes( { heading: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Stories to show', 'vaarta' ),
							value: attributes.postsToShow,
							min: 2,
							max: 6,
							onChange: function( value ) {
								setAttributes( { postsToShow: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Layout', 'vaarta' ),
							value: attributes.layout,
							options: [
								{ label: __( 'Grid', 'vaarta' ), value: 'grid' },
								{ label: __( 'Compact', 'vaarta' ), value: 'compact' }
							],
							onChange: function( value ) {
								setAttributes( { layout: value } );
							}
						} )
					)
				),
				el( 'div', blockProps, el( ServerSideRender, {
					block: 'vaarta/related-posts',
					attributes: attributes
				} ) )
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
