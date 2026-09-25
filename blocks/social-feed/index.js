( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InnerBlocks, InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, SelectControl, TextControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/social-feed', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( {
				className: 'vaarta-social-feed-editor vaarta-social-feed-editor--' + attributes.layout
			} );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Social Feed', 'vaarta' ), initialOpen: true },
						el( TextControl, {
							label: __( 'Heading', 'vaarta' ),
							value: attributes.heading,
							onChange: function( value ) {
								setAttributes( { heading: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Network', 'vaarta' ),
							value: attributes.network,
							options: [
								{ label: 'Instagram', value: 'instagram' },
								{ label: 'X', value: 'x' },
								{ label: 'Facebook', value: 'facebook' },
								{ label: 'Pinterest', value: 'pinterest' },
								{ label: __( 'Mixed', 'vaarta' ), value: 'mixed' }
							],
							onChange: function( value ) {
								setAttributes( { network: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Layout', 'vaarta' ),
							value: attributes.layout,
							options: [
								{ label: __( 'Grid', 'vaarta' ), value: 'grid' },
								{ label: __( 'Horizontal strip', 'vaarta' ), value: 'strip' },
								{ label: __( 'List', 'vaarta' ), value: 'list' }
							],
							onChange: function( value ) {
								setAttributes( { layout: value } );
							}
						} ),
						el( TextControl, {
							label: __( 'Profile URL', 'vaarta' ),
							value: attributes.profileUrl,
							onChange: function( value ) {
								setAttributes( { profileUrl: value } );
							}
						} ),
						el( TextControl, {
							label: __( 'Profile link label', 'vaarta' ),
							value: attributes.profileLabel,
							onChange: function( value ) {
								setAttributes( { profileLabel: value } );
							}
						} )
					)
				),
				el(
					'section',
					blockProps,
					el( 'strong', null, attributes.heading || __( 'Social Feed', 'vaarta' ) ),
					el( 'p', null, __( 'Insert native Embed blocks for social posts below.', 'vaarta' ) ),
					el( InnerBlocks, {
						allowedBlocks: [ 'core/embed', 'core/image', 'core/group' ],
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
