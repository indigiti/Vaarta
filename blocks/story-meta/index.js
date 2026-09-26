( function ( blocks, element, components, blockEditor, serverSideRender, i18n ) {
	'use strict';

	var el = element.createElement;
	var Fragment = element.Fragment;
	var registerBlockType = blocks.registerBlockType;
	var InspectorControls = blockEditor.InspectorControls;
	var useBlockProps = blockEditor.useBlockProps;
	var PanelBody = components.PanelBody;
	var ToggleControl = components.ToggleControl;
	var CheckboxControl = components.CheckboxControl;
	var __ = i18n.__;

	var metaOptions = [
		{ value: 'category', label: __( 'Category', 'caards' ) },
		{ value: 'author', label: __( 'Author', 'caards' ) },
		{ value: 'date', label: __( 'Date', 'caards' ) },
		{ value: 'comments', label: __( 'Comments', 'caards' ) },
		{ value: 'views', label: __( 'Views', 'caards' ) },
		{ value: 'shares', label: __( 'Shares', 'caards' ) },
		{ value: 'reading_time', label: __( 'Reading time', 'caards' ) }
	];

	registerBlockType( 'vaarta/story-meta', {
		apiVersion: 3,
		title: __( 'Story Meta', 'caards' ),
		icon: 'admin-post',
		category: 'vaarta-editorial',
		description: __( 'Display story metadata using Vaarta’s existing visual system.', 'caards' ),
		attributes: {
			items: {
				type: 'array',
				default: [ 'category', 'author', 'date', 'comments', 'reading_time' ]
			},
			compact: {
				type: 'boolean',
				default: false
			},
			authorAvatar: {
				type: 'boolean',
				default: false
			}
		},
		edit: function ( props ) {
			var attributes = props.attributes;
			var selected = Array.isArray( attributes.items ) ? attributes.items : [];
			var blockProps = useBlockProps( { className: 'vaarta-story-meta-editor' } );

			function setMetaItem( item, enabled ) {
				var next = selected.filter( function ( current ) {
					return current !== item;
				} );

				if ( enabled ) {
					next.push( item );
				}

				// Preserve the canonical option order regardless of click order.
				next = metaOptions.map( function ( option ) {
					return option.value;
				} ).filter( function ( option ) {
					return next.indexOf( option ) !== -1;
				} );

				props.setAttributes( { items: next } );
			}

			var controls = metaOptions.map( function ( option ) {
				return el( CheckboxControl, {
					key: option.value,
					label: option.label,
					checked: selected.indexOf( option.value ) !== -1,
					onChange: function ( value ) {
						setMetaItem( option.value, value );
					}
				} );
			} );

			controls.push(
				el( ToggleControl, {
					key: 'compact',
					label: __( 'Compact metadata', 'caards' ),
					checked: !! attributes.compact,
					onChange: function ( value ) {
						props.setAttributes( { compact: value } );
					}
				} )
			);

			controls.push(
				el( ToggleControl, {
					key: 'author-avatar',
					label: __( 'Show author avatar', 'caards' ),
					checked: !! attributes.authorAvatar,
					disabled: selected.indexOf( 'author' ) === -1,
					onChange: function ( value ) {
						props.setAttributes( { authorAvatar: value } );
					}
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
						{
							title: __( 'Story metadata', 'caards' ),
							initialOpen: true
						},
						controls
					)
				),
				el(
					'div',
					blockProps,
					el( serverSideRender, {
						block: 'vaarta/story-meta',
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
	window.wp.serverSideRender,
	window.wp.i18n
);
