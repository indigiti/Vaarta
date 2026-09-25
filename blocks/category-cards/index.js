( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { CheckboxControl, PanelBody, RangeControl, SelectControl, TextControl, ToggleControl } = wp.components;
	const { useSelect } = wp.data;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/category-cards', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps();

			const categories = useSelect( function( select ) {
				return select( 'core' ).getEntityRecords( 'taxonomy', 'category', {
					per_page: 100,
					hide_empty: false,
					orderby: 'name',
					order: 'asc'
				} );
			}, [] );

			function toggleCategory( slug, checked ) {
				const selected = attributes.categorySlugs || [];
				const next = checked
					? Array.from( new Set( selected.concat( [ slug ] ) ) )
					: selected.filter( function( item ) {
						return item !== slug;
					} );

				setAttributes( { categorySlugs: next } );
			}

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Category Cards', 'vaarta' ), initialOpen: true },
						el( TextControl, {
							label: __( 'Heading', 'vaarta' ),
							value: attributes.heading,
							onChange: function( value ) {
								setAttributes( { heading: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Layout', 'vaarta' ),
							value: attributes.layout,
							options: [
								{ label: __( 'Grid', 'vaarta' ), value: 'grid' },
								{ label: __( 'Strip', 'vaarta' ), value: 'strip' }
							],
							onChange: function( value ) {
								setAttributes( { layout: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Maximum categories', 'vaarta' ),
							value: attributes.maxCategories,
							min: 2,
							max: 12,
							onChange: function( value ) {
								setAttributes( { maxCategories: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show category image', 'vaarta' ),
							help: __( 'Uses the latest featured image from each category.', 'vaarta' ),
							checked: attributes.showImage,
							onChange: function( value ) {
								setAttributes( { showImage: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show post count', 'vaarta' ),
							checked: attributes.showCount,
							onChange: function( value ) {
								setAttributes( { showCount: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show description', 'vaarta' ),
							checked: attributes.showDescription,
							onChange: function( value ) {
								setAttributes( { showDescription: value } );
							}
						} )
					),
					el(
						PanelBody,
						{ title: __( 'Choose categories', 'vaarta' ), initialOpen: false },
						el(
							'p',
							null,
							__( 'Leave all unchecked to show the most-used categories automatically.', 'vaarta' )
						),
						( categories || [] ).map( function( category ) {
							return el( CheckboxControl, {
								key: category.id,
								label: category.name,
								checked: ( attributes.categorySlugs || [] ).includes( category.slug ),
								onChange: function( checked ) {
									toggleCategory( category.slug, checked );
								}
							} );
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'vaarta/category-cards',
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
