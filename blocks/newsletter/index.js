( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, SelectControl, TextControl, TextareaControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/newsletter', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( { className: 'vaarta-newsletter-editor' } );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Newsletter', 'vaarta' ), initialOpen: true },
						el( TextControl, {
							label: __( 'Heading', 'vaarta' ),
							value: attributes.heading,
							onChange: function( value ) {
								setAttributes( { heading: value } );
							}
						} ),
						el( TextareaControl, {
							label: __( 'Description', 'vaarta' ),
							value: attributes.description,
							onChange: function( value ) {
								setAttributes( { description: value } );
							}
						} ),
						el( TextControl, {
							label: __( 'Button label', 'vaarta' ),
							value: attributes.buttonLabel,
							onChange: function( value ) {
								setAttributes( { buttonLabel: value } );
							}
						} ),
						el( TextControl, {
							label: __( 'Form action URL', 'vaarta' ),
							help: __( 'Use the subscription endpoint supplied by your email provider.', 'vaarta' ),
							value: attributes.formAction,
							onChange: function( value ) {
								setAttributes( { formAction: value } );
							}
						} ),
						el( TextControl, {
							label: __( 'Email field name', 'vaarta' ),
							value: attributes.emailFieldName,
							onChange: function( value ) {
								setAttributes( { emailFieldName: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Style', 'vaarta' ),
							value: attributes.styleVariant,
							options: [
								{ label: __( 'Light', 'vaarta' ), value: 'light' },
								{ label: __( 'Dark', 'vaarta' ), value: 'dark' },
								{ label: __( 'Minimal', 'vaarta' ), value: 'minimal' }
							],
							onChange: function( value ) {
								setAttributes( { styleVariant: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'vaarta/newsletter',
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
