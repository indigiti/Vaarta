( function ( blocks, element, components, blockEditor, data, serverSideRender, i18n ) {
	'use strict';

	var el = element.createElement;
	var Fragment = element.Fragment;
	var registerBlockType = blocks.registerBlockType;
	var InspectorControls = blockEditor.InspectorControls;
	var useBlockProps = blockEditor.useBlockProps;
	var PanelBody = components.PanelBody;
	var SelectControl = components.SelectControl;
	var RangeControl = components.RangeControl;
	var ToggleControl = components.ToggleControl;
	var useSelect = data.useSelect;
	var __ = i18n.__;

	var layoutOptions = [
		{ value: 'standard-type-1', label: __( 'Standard 1', 'caards' ) },
		{ value: 'standard-type-2', label: __( 'Standard 2', 'caards' ) },
		{ value: 'standard-type-3', label: __( 'Standard 3', 'caards' ) },
		{ value: 'standard-type-4', label: __( 'Standard 4', 'caards' ) },
		{ value: 'masonry-type-1', label: __( 'Masonry 1', 'caards' ) },
		{ value: 'horizontal-type-1', label: __( 'Horizontal 1', 'caards' ) },
		{ value: 'horizontal-type-2', label: __( 'Horizontal 2', 'caards' ) },
		{ value: 'horizontal-type-3', label: __( 'Horizontal 3', 'caards' ) },
		{ value: 'horizontal-type-4', label: __( 'Horizontal 4', 'caards' ) },
		{ value: 'horizontal-type-5', label: __( 'Horizontal 5', 'caards' ) },
		{ value: 'tile-type-1', label: __( 'Tile 1', 'caards' ) },
		{ value: 'tile-type-2', label: __( 'Tile 2', 'caards' ) },
		{ value: 'tile-type-3', label: __( 'Tile 3', 'caards' ) },
		{ value: 'tile-type-4', label: __( 'Tile 4', 'caards' ) }
	];

	var orderByOptions = [
		{ value: 'date', label: __( 'Publish date', 'caards' ) },
		{ value: 'modified', label: __( 'Modified date', 'caards' ) },
		{ value: 'comment_count', label: __( 'Comment count', 'caards' ) },
		{ value: 'title', label: __( 'Title', 'caards' ) },
		{ value: 'rand', label: __( 'Random', 'caards' ) }
	];

	var orientationOptions = [
		{ value: 'original', label: __( 'Original', 'caards' ) },
		{ value: 'landscape', label: __( 'Landscape 4:3', 'caards' ) },
		{ value: 'landscape-3-2', label: __( 'Landscape 3:2', 'caards' ) },
		{ value: 'landscape-16-9', label: __( 'Landscape 16:9', 'caards' ) },
		{ value: 'landscape-21-10', label: __( 'Landscape 21:10', 'caards' ) },
		{ value: 'portrait', label: __( 'Portrait 3:4', 'caards' ) },
		{ value: 'portrait-2-3', label: __( 'Portrait 2:3', 'caards' ) },
		{ value: 'square', label: __( 'Square', 'caards' ) }
	];

	registerBlockType( 'vaarta/editorial-query', {
		apiVersion: 3,
		title: __( 'Editorial Query', 'caards' ),
		icon: 'grid-view',
		category: 'vaarta-editorial',
		description: __( 'Query stories and render them with Vaarta editorial layouts.', 'caards' ),
		edit: function ( props ) {
			var attributes = props.attributes;
			var blockProps = useBlockProps( { className: 'vaarta-editorial-query-editor' } );

			var categories = useSelect( function ( select ) {
				return select( 'core' ).getEntityRecords( 'taxonomy', 'category', {
					per_page: 100,
					hide_empty: false,
					orderby: 'name',
					order: 'asc'
				} ) || [];
			}, [] );

			var categoryOptions = [
				{ value: 0, label: __( 'All categories', 'caards' ) }
			].concat( categories.map( function ( category ) {
				return {
					value: category.id,
					label: category.name
				};
			} ) );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{
							title: __( 'Layout', 'caards' ),
							initialOpen: true
						},
						el( SelectControl, {
							label: __( 'Editorial layout', 'caards' ),
							value: attributes.layout,
							options: layoutOptions,
							onChange: function ( value ) {
								props.setAttributes( { layout: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Columns', 'caards' ),
							value: attributes.columns,
							min: 1,
							max: 6,
							onChange: function ( value ) {
								props.setAttributes( { columns: value || 1 } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Column gap', 'caards' ),
							value: attributes.columnGap,
							min: 0,
							max: 120,
							step: 4,
							onChange: function ( value ) {
								props.setAttributes( { columnGap: value || 0 } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Row gap', 'caards' ),
							value: attributes.rowGap,
							min: 0,
							max: 120,
							step: 4,
							onChange: function ( value ) {
								props.setAttributes( { rowGap: value || 0 } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Image orientation', 'caards' ),
							value: attributes.imageOrientation,
							options: orientationOptions,
							onChange: function ( value ) {
								props.setAttributes( { imageOrientation: value } );
							}
						} )
					),
					el(
						PanelBody,
						{
							title: __( 'Query', 'caards' ),
							initialOpen: true
						},
						el( RangeControl, {
							label: __( 'Stories to show', 'caards' ),
							value: attributes.postsToShow,
							min: 1,
							max: 20,
							onChange: function ( value ) {
								props.setAttributes( { postsToShow: value || 1 } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Category', 'caards' ),
							value: attributes.category,
							options: categoryOptions,
							onChange: function ( value ) {
								props.setAttributes( { category: parseInt( value, 10 ) || 0 } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Order by', 'caards' ),
							value: attributes.orderBy,
							options: orderByOptions,
							onChange: function ( value ) {
								props.setAttributes( { orderBy: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Order', 'caards' ),
							value: attributes.order,
							options: [
								{ value: 'DESC', label: __( 'Descending', 'caards' ) },
								{ value: 'ASC', label: __( 'Ascending', 'caards' ) }
							],
							onChange: function ( value ) {
								props.setAttributes( { order: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Offset', 'caards' ),
							value: attributes.offset,
							min: 0,
							max: 100,
							onChange: function ( value ) {
								props.setAttributes( { offset: value || 0 } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Exclude current story', 'caards' ),
							checked: !! attributes.excludeCurrent,
							onChange: function ( value ) {
								props.setAttributes( { excludeCurrent: value } );
							}
						} )
					),
					el(
						PanelBody,
						{
							title: __( 'Story content', 'caards' ),
							initialOpen: false
						},
						el( ToggleControl, {
							label: __( 'Show category', 'caards' ),
							checked: !! attributes.showCategory,
							onChange: function ( value ) {
								props.setAttributes( { showCategory: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show author', 'caards' ),
							checked: !! attributes.showAuthor,
							onChange: function ( value ) {
								props.setAttributes( { showAuthor: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show date', 'caards' ),
							checked: !! attributes.showDate,
							onChange: function ( value ) {
								props.setAttributes( { showDate: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show excerpt', 'caards' ),
							checked: !! attributes.showExcerpt,
							onChange: function ( value ) {
								props.setAttributes( { showExcerpt: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Excerpt length', 'caards' ),
							value: attributes.excerptLength,
							min: 4,
							max: 80,
							disabled: ! attributes.showExcerpt,
							onChange: function ( value ) {
								props.setAttributes( { excerptLength: value || 24 } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( serverSideRender, {
						block: 'vaarta/editorial-query',
						attributes: attributes,
						httpMethod: 'POST'
					} )
				)
			);
		},
		save: function () {
			return null;
		}
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.components,
	window.wp.blockEditor,
	window.wp.data,
	window.wp.serverSideRender,
	window.wp.i18n
);
