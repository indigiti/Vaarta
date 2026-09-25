( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, SelectControl, RangeControl, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/editorial-grid', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( { className: 'vaarta-editorial-grid-editor' } );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Editorial Grid', 'vaarta' ), initialOpen: true },
						el( SelectControl, {
							label: __( 'Layout', 'vaarta' ),
							value: attributes.layout,
							options: [
								{ label: __( 'Bento', 'vaarta' ), value: 'bento' },
								{ label: __( 'Grid', 'vaarta' ), value: 'grid' },
								{ label: __( 'List', 'vaarta' ), value: 'list' }
							],
							onChange: function( value ) {
								setAttributes( { layout: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Posts to show', 'vaarta' ),
							value: attributes.postsToShow,
							min: 1,
							max: 16,
							onChange: function( value ) {
								setAttributes( { postsToShow: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Order by', 'vaarta' ),
							value: attributes.orderBy,
							options: [
								{ label: __( 'Date', 'vaarta' ), value: 'date' },
								{ label: __( 'Modified', 'vaarta' ), value: 'modified' },
								{ label: __( 'Title', 'vaarta' ), value: 'title' },
								{ label: __( 'Random', 'vaarta' ), value: 'rand' }
							],
							onChange: function( value ) {
								setAttributes( { orderBy: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show excerpt', 'vaarta' ),
							checked: attributes.showExcerpt,
							onChange: function( value ) {
								setAttributes( { showExcerpt: value } );
							}
						} ),
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
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'vaarta/editorial-grid',
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
