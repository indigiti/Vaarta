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

	var layouts = [
		'standard-type-1', 'standard-type-2', 'standard-type-3', 'standard-type-4',
		'masonry-type-1',
		'horizontal-type-1', 'horizontal-type-2', 'horizontal-type-3', 'horizontal-type-4', 'horizontal-type-5',
		'tile-type-1', 'tile-type-2', 'tile-type-3', 'tile-type-4'
	].map( function ( value ) {
		var label = value.replace( /-/g, ' ' ).replace( /\b\w/g, function ( letter ) { return letter.toUpperCase(); } );
		return { value: value, label: label };
	} );

	var orientations = [
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
		attributes: {
			layout: { type: 'string', default: 'standard-type-1' },
			postsToShow: { type: 'number', default: 6 },
			category: { type: 'number', default: 0 },
			orderBy: { type: 'string', default: 'date' },
			order: { type: 'string', default: 'DESC' },
			offset: { type: 'number', default: 0 },
			excludeCurrent: { type: 'boolean', default: true },
			showCategory: { type: 'boolean', default: true },
			showAuthor: { type: 'boolean', default: true },
			showDate: { type: 'boolean', default: true },
			showExcerpt: { type: 'boolean', default: true },
			excerptLength: { type: 'number', default: 24 },
			imageSize: { type: 'string', default: 'medium_large' },
			imageOrientation: { type: 'string', default: 'landscape-16-9' },
			columns: { type: 'number', default: 1 },
			columnGap: { type: 'number', default: 40 },
			rowGap: { type: 'number', default: 40 }
		},
		edit: function ( props ) {
			var a = props.attributes;
			var set = function ( key, value ) {
				var next = {};
				next[ key ] = value;
				props.setAttributes( next );
			};
			var categories = useSelect( function ( select ) {
				return select( 'core' ).getEntityRecords( 'taxonomy', 'category', {
					per_page: 100,
					hide_empty: false,
					orderby: 'name',
					order: 'asc'
				} ) || [];
			}, [] );
			var categoryOptions = [ { value: 0, label: __( 'All categories', 'caards' ) } ].concat(
				categories.map( function ( category ) {
					return { value: category.id, label: category.name };
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
						{ title: __( 'Layout', 'caards' ), initialOpen: true },
						el( SelectControl, {
							label: __( 'Editorial layout', 'caards' ),
							value: a.layout,
							options: layouts,
							onChange: function ( value ) { set( 'layout', value ); }
						} ),
						el( RangeControl, {
							label: __( 'Columns', 'caards' ),
							value: a.columns,
							min: 1,
							max: 6,
							onChange: function ( value ) { set( 'columns', value || 1 ); }
						} ),
						el( RangeControl, {
							label: __( 'Column gap', 'caards' ),
							value: a.columnGap,
							min: 0,
							max: 120,
							step: 4,
							onChange: function ( value ) { set( 'columnGap', value || 0 ); }
						} ),
						el( RangeControl, {
							label: __( 'Row gap', 'caards' ),
							value: a.rowGap,
							min: 0,
							max: 120,
							step: 4,
							onChange: function ( value ) { set( 'rowGap', value || 0 ); }
						} ),
						el( SelectControl, {
							label: __( 'Image orientation', 'caards' ),
							value: a.imageOrientation,
							options: orientations,
							onChange: function ( value ) { set( 'imageOrientation', value ); }
						} )
					),
					el(
						PanelBody,
						{ title: __( 'Query', 'caards' ), initialOpen: true },
						el( RangeControl, {
							label: __( 'Stories to show', 'caards' ),
							value: a.postsToShow,
							min: 1,
							max: 20,
							onChange: function ( value ) { set( 'postsToShow', value || 1 ); }
						} ),
						el( SelectControl, {
							label: __( 'Category', 'caards' ),
							value: a.category,
							options: categoryOptions,
							onChange: function ( value ) { set( 'category', parseInt( value, 10 ) || 0 ); }
						} ),
						el( SelectControl, {
							label: __( 'Order by', 'caards' ),
							value: a.orderBy,
							options: [
								{ value: 'date', label: __( 'Publish date', 'caards' ) },
								{ value: 'modified', label: __( 'Modified date', 'caards' ) },
								{ value: 'comment_count', label: __( 'Comment count', 'caards' ) },
								{ value: 'title', label: __( 'Title', 'caards' ) },
								{ value: 'rand', label: __( 'Random', 'caards' ) }
							],
							onChange: function ( value ) { set( 'orderBy', value ); }
						} ),
						el( SelectControl, {
							label: __( 'Order', 'caards' ),
							value: a.order,
							options: [
								{ value: 'DESC', label: __( 'Descending', 'caards' ) },
								{ value: 'ASC', label: __( 'Ascending', 'caards' ) }
							],
							onChange: function ( value ) { set( 'order', value ); }
						} ),
						el( RangeControl, {
							label: __( 'Offset', 'caards' ),
							value: a.offset,
							min: 0,
							max: 100,
							onChange: function ( value ) { set( 'offset', value || 0 ); }
						} ),
						el( ToggleControl, {
							label: __( 'Exclude current story', 'caards' ),
							checked: !! a.excludeCurrent,
							onChange: function ( value ) { set( 'excludeCurrent', value ); }
						} )
					),
					el(
						PanelBody,
						{ title: __( 'Story content', 'caards' ), initialOpen: false },
						el( ToggleControl, {
							label: __( 'Show category', 'caards' ),
							checked: !! a.showCategory,
							onChange: function ( value ) { set( 'showCategory', value ); }
						} ),
						el( ToggleControl, {
							label: __( 'Show author', 'caards' ),
							checked: !! a.showAuthor,
							onChange: function ( value ) { set( 'showAuthor', value ); }
						} ),
						el( ToggleControl, {
							label: __( 'Show date', 'caards' ),
							checked: !! a.showDate,
							onChange: function ( value ) { set( 'showDate', value ); }
						} ),
						el( ToggleControl, {
							label: __( 'Show excerpt', 'caards' ),
							checked: !! a.showExcerpt,
							onChange: function ( value ) { set( 'showExcerpt', value ); }
						} ),
						el( RangeControl, {
							label: __( 'Excerpt length', 'caards' ),
							value: a.excerptLength,
							min: 4,
							max: 80,
							disabled: ! a.showExcerpt,
							onChange: function ( value ) { set( 'excerptLength', value || 24 ); }
						} )
					)
				),
				el(
					'div',
					useBlockProps( { className: 'vaarta-editorial-query-editor' } ),
					el( serverSideRender, {
						block: 'vaarta/editorial-query',
						attributes: a,
						httpMethod: 'POST'
					} )
				)
			);
		},
		save: function () { return null; }
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
