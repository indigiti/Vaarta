( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InnerBlocks, RichText, useBlockProps } = wp.blockEditor;
	const { createElement: el } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/tab', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( { className: 'vaarta-tab-editor' } );

			return el(
				'section',
				blockProps,
				el( RichText, {
					tagName: 'h3',
					className: 'vaarta-tab-editor__title',
					value: attributes.title,
					placeholder: __( 'Tab title…', 'vaarta' ),
					allowedFormats: [],
					onChange: function( value ) {
						setAttributes( { title: value } );
					}
				} ),
				el( InnerBlocks )
			);
		},
		save: function() {
			return el( InnerBlocks.Content );
		}
	} );
} )( window.wp );
