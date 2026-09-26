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

	registerBlockType( 'vaarta/story-carousel', {
		apiVersion: 3,
		title: __( 'Story Carousel', 'caards' ),
		icon: 'slides',
		category: 'vaarta-editorial',
		description: __( 'Display a story query with Vaarta’s carousel visual system.', 'caards' ),
		attributes: {
			variant: { type: 'string', default: 'wide' },
			postsToShow: { type: 'number', default: 6 },
			category: { type: 'number', default: 0 },
			orderBy: { type: 'string', default: 'date' },
			order: { type: 'string', default: 'DESC' },
			excludeCurrent: { type: 'boolean', default: true },
			columns: { type: 'number', default: 4 },
			gap: { type: 'number', default: 40 },
			autoplay: { type: 'boolean', default: true },
			pageDots: { type: 'boolean', default: true },
			wrapAround: { type: 'boolean', default: true },
			imageSize: { type: 'string', default: 'medium_large' },
			imageOrientation: { type: 'string', default: 'landscape-16-9' },
			topMeta: { type: 'string', default: 'author' },
			showCategory: { type: 'boolean', default: true },
			showAuthor: { type: 'boolean', default: true },
			showDate: { type: 'boolean', default: true },
			showExcerpt: { type: 'boolean', default: true },
			excerptLength: { type: 'number', default: 20 }
		},
		edit: function ( props ) {
			var attributes = props.attributes;
			var blockProps = useBlockProps( { className: 'vaarta-story-carousel-editor' } );
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
						{ title: __( 'Carousel', 'caards' ), initialOpen: true },
						el( SelectControl, {
							label: __( 'Variant', 'caards' ),
							value: attributes.variant,
							options: [
								{ value: 'wide', label: __( 'Carousel 1 — Wide', 'caards' ) },
								{ value: 'large', label: __( 'Carousel 2 — Large / Grouped', 'caards' ) }
							],
							onChange: function ( value ) { props.setAttributes( { variant: value } ); }
						} ),
						el( RangeControl, {
							label: __( 'Columns', 'caards' ), value: attributes.columns, min: 1, max: 6,
							onChange: function ( value ) { props.setAttributes( { columns: value || 1 } ); }
						} ),
						el( RangeControl, {
							label: __( 'Gap', 'caards' ), value: attributes.gap, min: 0, max: 120, step: 4,
							onChange: function ( value ) { props.setAttributes( { gap: value || 0 } ); }
						} ),
						el( ToggleControl, {
							label: __( 'Autoplay', 'caards' ), checked: !! attributes.autoplay,
							onChange: function ( value ) { props.setAttributes( { autoplay: value } ); }
						} ),
						el( ToggleControl, {
							label: __( 'Pagination dots', 'caards' ), checked: !! attributes.pageDots,
							onChange: function ( value ) { props.setAttributes( { pageDots: value } ); }
						} ),
						el( ToggleControl, {
							label: __( 'Wrap around', 'caards' ), checked: !! attributes.wrapAround,
							onChange: function ( value ) { props.setAttributes( { wrapAround: value } ); }
						} )
					),
					el(
						PanelBody,
						{ title: __( 'Query', 'caards' ), initialOpen: true },
						el( RangeControl, {
							label: __( 'Stories to show', 'caards' ), value: attributes.postsToShow, min: 1, max: 20,
							onChange: function ( value ) { props.setAttributes( { postsToShow: value || 1 } ); }
						} ),
						el( SelectControl, {
							label: __( 'Category', 'caards' ), value: attributes.category, options: categoryOptions,
							onChange: function ( value ) { props.setAttributes( { category: parseInt( value, 10 ) || 0 } ); }
						} ),
						el( SelectControl, {
							label: __( 'Order by', 'caards' ), value: attributes.orderBy,
							options: [
								{ value: 'date', label: __( 'Publish date', 'caards' ) },
								{ value: 'modified', label: __( 'Modified date', 'caards' ) },
								{ value: 'comment_count', label: __( 'Comment count', 'caards' ) },
								{ value: 'title', label: __( 'Title', 'caards' ) },
								{ value: 'rand', label: __( 'Random', 'caards' ) }
							],
							onChange: function ( value ) { props.setAttributes( { orderBy: value } ); }
						} ),
						el( SelectControl, {
							label: __( 'Order', 'caards' ), value: attributes.order,
							options: [
								{ value: 'DESC', label: __( 'Descending', 'caards' ) },
								{ value: 'ASC', label: __( 'Ascending', 'caards' ) }
							],
							onChange: function ( value ) { props.setAttributes( { order: value } ); }
						} ),
						el( ToggleControl, {
							label: __( 'Exclude current story', 'caards' ), checked: !! attributes.excludeCurrent,
							onChange: function ( value ) { props.setAttributes( { excludeCurrent: value } ); }
						} )
					),
					el(
						PanelBody,
						{ title: __( 'Story content', 'caards' ), initialOpen: false },
						el( SelectControl, {
							label: __( 'Image orientation', 'caards' ), value: attributes.imageOrientation,
							options: [
								{ value: 'stretch', label: __( 'Stretch', 'caards' ) },
								{ value: 'landscape', label: __( 'Landscape 4:3', 'caards' ) },
								{ value: 'landscape-3-2', label: __( 'Landscape 3:2', 'caards' ) },
								{ value: 'landscape-16-9', label: __( 'Landscape 16:9', 'caards' ) },
								{ value: 'portrait', label: __( 'Portrait 3:4', 'caards' ) },
								{ value: 'portrait-2-3', label: __( 'Portrait 2:3', 'caards' ) },
								{ value: 'square', label: __( 'Square', 'caards' ) }
							],
							onChange: function ( value ) { props.setAttributes( { imageOrientation: value } ); }
						} ),
						el( SelectControl, {
							label: __( 'Top meta', 'caards' ), value: attributes.topMeta,
							options: [
								{ value: 'none', label: __( 'None', 'caards' ) },
								{ value: 'author', label: __( 'Author', 'caards' ) },
								{ value: 'category', label: __( 'Category', 'caards' ) },
								{ value: 'count', label: __( 'Count', 'caards' ) }
							],
							onChange: function ( value ) { props.setAttributes( { topMeta: value } ); }
						} ),
						el( ToggleControl, {
							label: __( 'Show category', 'caards' ), checked: !! attributes.showCategory,
							onChange: function ( value ) { props.setAttributes( { showCategory: value } ); }
						} ),
						el( ToggleControl, {
							label: __( 'Show author', 'caards' ), checked: !! attributes.showAuthor,
							onChange: function ( value ) { props.setAttributes( { showAuthor: value } ); }
						} ),
						el( ToggleControl, {
							label: __( 'Show date', 'caards' ), checked: !! attributes.showDate,
							onChange: function ( value ) { props.setAttributes( { showDate: value } ); }
						} ),
						el( ToggleControl, {
							label: __( 'Show excerpt', 'caards' ), checked: !! attributes.showExcerpt,
							onChange: function ( value ) { props.setAttributes( { showExcerpt: value } ); }
						} ),
						el( RangeControl, {
							label: __( 'Excerpt length', 'caards' ), value: attributes.excerptLength, min: 4, max: 80,
							disabled: ! attributes.showExcerpt,
							onChange: function ( value ) { props.setAttributes( { excerptLength: value || 20 } ); }
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( serverSideRender, {
						block: 'vaarta/story-carousel',
						attributes: attributes,
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
