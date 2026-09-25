( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, TextControl, TextareaControl, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/contact-form', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps( { className: 'vaarta-contact-form-editor' } );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Contact Form', 'vaarta' ), initialOpen: true },
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
						el( ToggleControl, {
							label: __( 'Show subject field', 'vaarta' ),
							checked: attributes.showSubject,
							onChange: function( value ) {
								setAttributes( { showSubject: value } );
							}
						} )
					)
				),
				el(
					'section',
					blockProps,
					el( 'h3', null, attributes.heading ),
					el( 'p', null, attributes.description ),
					el(
						'div',
						{ className: 'vaarta-contact-form-editor__preview' },
						el( 'span', null, __( 'Name', 'vaarta' ) ),
						el( 'span', null, __( 'Email', 'vaarta' ) ),
						attributes.showSubject && el( 'span', null, __( 'Subject', 'vaarta' ) ),
						el( 'span', null, __( 'Message', 'vaarta' ) ),
						el( 'strong', null, attributes.buttonLabel )
					)
				)
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
