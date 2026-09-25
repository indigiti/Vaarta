( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, RangeControl, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/auto-load-posts', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( { className: 'vaarta-auto-load-editor' } );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Continuous Reading', 'vaarta' ), initialOpen: true },
						el( ToggleControl, {
							label: __( 'Enable auto-load', 'vaarta' ),
							checked: attributes.enabled,
							onChange: function( value ) {
								setAttributes( { enabled: value } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Maximum additional articles', 'vaarta' ),
							value: attributes.maxPosts,
							min: 1,
							max: 10,
							onChange: function( value ) {
								setAttributes( { maxPosts: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( 'strong', null, __( 'Auto-load Next Articles', 'vaarta' ) ),
					el(
						'p',
						null,
						attributes.enabled
							? __( 'Older stories will load as readers approach this point.', 'vaarta' )
							: __( 'Auto-load is disabled.', 'vaarta' )
					)
				)
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
