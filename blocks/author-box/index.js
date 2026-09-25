( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/author-box', {
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
						{ title: __( 'Author Box', 'vaarta' ), initialOpen: true },
						el( ToggleControl, {
							label: __( 'Show avatar', 'vaarta' ),
							checked: attributes.showAvatar,
							onChange: function( value ) {
								setAttributes( { showAvatar: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show biography', 'vaarta' ),
							checked: attributes.showBio,
							onChange: function( value ) {
								setAttributes( { showBio: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show author archive link', 'vaarta' ),
							checked: attributes.showArchiveLink,
							onChange: function( value ) {
								setAttributes( { showArchiveLink: value } );
							}
						} )
					)
				),
				el( 'div', blockProps, el( ServerSideRender, {
					block: 'vaarta/author-box',
					attributes: attributes
				} ) )
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
