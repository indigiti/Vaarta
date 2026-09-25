( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, SelectControl, RangeControl, ToggleControl } = wp.components;
	const { useSelect } = wp.data;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/editorial-grid', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( { className: 'vaarta-editorial-grid-editor' } );

			const categories = useSelect( function( select ) {
				return select( 'core' ).getEntityRecords( 'taxonomy', 'category', {
					per_page: 100,
					hide_empty: false
				} );
			}, [] );

			const categoryOptions = [
				{ label: __( 'All categories', 'vaarta' ), value: '' }
			].concat(
				( categories || [] ).map( function( category ) {
					return {
						label: category.name,
						value: category.slug
					};
				} )
			);

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
						el( SelectControl, {
							label: __( 'Card style', 'vaarta' ),
							value: attributes.cardStyle,
							options: [
								{ label: __( 'Standard', 'vaarta' ), value: 'standard' },
								{ label: __( 'Minimal', 'vaarta' ), value: 'minimal' },
								{ label: __( 'Overlay', 'vaarta' ), value: 'overlay' },
								{ label: __( 'Dark', 'vaarta' ), value: 'dark' },
								{ label: __( 'Compact', 'vaarta' ), value: 'compact' }
							],
							onChange: function( value ) {
								setAttributes( { cardStyle: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Category', 'vaarta' ),
							value: attributes.categorySlug || '',
							options: categoryOptions,
							onChange: function( value ) {
								setAttributes( { categorySlug: value || '', categoryId: 0 } );
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
						} ),
						el( ToggleControl, {
							label: __( 'Show reading time', 'vaarta' ),
							checked: attributes.showReadingTime,
							onChange: function( value ) {
								setAttributes( { showReadingTime: value } );
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
