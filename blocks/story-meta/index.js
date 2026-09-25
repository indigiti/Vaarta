( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/story-meta', {
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
						{ title: __( 'Story Meta', 'vaarta' ), initialOpen: true },
						el( ToggleControl, {
							label: __( 'Show author', 'vaarta' ),
							checked: attributes.showAuthor,
							onChange: function( value ) {
								setAttributes( { showAuthor: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show date', 'vaarta' ),
							checked: attributes.showDate,
							onChange: function( value ) {
								setAttributes( { showDate: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show reading time', 'vaarta' ),
							checked: attributes.showReadingTime,
							onChange: function( value ) {
								setAttributes( { showReadingTime: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show views', 'vaarta' ),
							checked: attributes.showViews,
							onChange: function( value ) {
								setAttributes( { showViews: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'vaarta/story-meta',
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
