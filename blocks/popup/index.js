( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InnerBlocks, InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, RangeControl, SelectControl, TextControl, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/popup', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( {
				className: 'vaarta-popup-editor vaarta-popup-editor--' + attributes.size
			} );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Popup', 'vaarta' ), initialOpen: true },
						el( SelectControl, {
							label: __( 'Trigger', 'vaarta' ),
							value: attributes.trigger,
							options: [
								{ label: __( 'Button', 'vaarta' ), value: 'button' },
								{ label: __( 'After delay', 'vaarta' ), value: 'delay' },
								{ label: __( 'Scroll depth', 'vaarta' ), value: 'scroll' }
							],
							onChange: function( value ) {
								setAttributes( { trigger: value } );
							}
						} ),
						attributes.trigger === 'button' && el( TextControl, {
							label: __( 'Button label', 'vaarta' ),
							value: attributes.buttonLabel,
							onChange: function( value ) {
								setAttributes( { buttonLabel: value } );
							}
						} ),
						attributes.trigger === 'delay' && el( RangeControl, {
							label: __( 'Delay', 'vaarta' ),
							help: __( 'Milliseconds before the popup opens.', 'vaarta' ),
							value: attributes.delayMs,
							min: 1000,
							max: 30000,
							step: 1000,
							onChange: function( value ) {
								setAttributes( { delayMs: value } );
							}
						} ),
						attributes.trigger === 'scroll' && el( RangeControl, {
							label: __( 'Scroll depth', 'vaarta' ),
							value: attributes.scrollPercent,
							min: 10,
							max: 90,
							step: 5,
							onChange: function( value ) {
								setAttributes( { scrollPercent: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Only once per session', 'vaarta' ),
							checked: attributes.oncePerSession,
							onChange: function( value ) {
								setAttributes( { oncePerSession: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Popup size', 'vaarta' ),
							value: attributes.size,
							options: [
								{ label: __( 'Small', 'vaarta' ), value: 'small' },
								{ label: __( 'Medium', 'vaarta' ), value: 'medium' },
								{ label: __( 'Large', 'vaarta' ), value: 'large' }
							],
							onChange: function( value ) {
								setAttributes( { size: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( 'strong', null, __( 'Popup content', 'vaarta' ) ),
					el( InnerBlocks, {
						template: [
							[ 'core/heading', { level: 2, content: __( 'Join the conversation', 'vaarta' ) } ],
							[ 'core/paragraph', { content: __( 'Add any Gutenberg blocks to this popup.', 'vaarta' ) } ]
						]
					} )
				)
			);
		},
		save: function() {
			return el( InnerBlocks.Content );
		}
	} );
} )( window.wp );
