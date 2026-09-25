( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, RangeControl, SelectControl, TextControl, TextareaControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/review', {
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
						{ title: __( 'Review Rating', 'vaarta' ), initialOpen: true },
						el( TextControl, {
							label: __( 'Title', 'vaarta' ),
							value: attributes.title,
							onChange: function( value ) {
								setAttributes( { title: value } );
							}
						} ),
						el( TextareaControl, {
							label: __( 'Summary', 'vaarta' ),
							value: attributes.summary,
							onChange: function( value ) {
								setAttributes( { summary: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Score', 'vaarta' ),
							help: __( 'Stored internally on a 0–100 scale.', 'vaarta' ),
							value: attributes.score,
							min: 0,
							max: 100,
							onChange: function( value ) {
								setAttributes( { score: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Display scale', 'vaarta' ),
							value: attributes.scale,
							options: [
								{ label: __( 'Percentage', 'vaarta' ), value: 'percent' },
								{ label: __( 'Points / 10', 'vaarta' ), value: 'points' },
								{ label: __( 'Stars / 5', 'vaarta' ), value: 'stars' }
							],
							onChange: function( value ) {
								setAttributes( { scale: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'vaarta/review',
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
