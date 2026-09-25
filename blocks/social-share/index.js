( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { CheckboxControl, PanelBody, SelectControl, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	const availableNetworks = [
		{ value: 'facebook', label: 'Facebook' },
		{ value: 'x', label: 'X' },
		{ value: 'linkedin', label: 'LinkedIn' },
		{ value: 'whatsapp', label: 'WhatsApp' },
		{ value: 'email', label: __( 'Email', 'vaarta' ) }
	];

	registerBlockType( 'vaarta/social-share', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps();

			function toggleNetwork( network, checked ) {
				const current = attributes.networks || [];
				const next = checked
					? Array.from( new Set( current.concat( [ network ] ) ) )
					: current.filter( function( item ) {
						return item !== network;
					} );

				setAttributes( { networks: next } );
			}

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Social Share', 'vaarta' ), initialOpen: true },
						availableNetworks.map( function( network ) {
							return el( CheckboxControl, {
								key: network.value,
								label: network.label,
								checked: ( attributes.networks || [] ).includes( network.value ),
								onChange: function( checked ) {
									toggleNetwork( network.value, checked );
								}
							} );
						} ),
						el( ToggleControl, {
							label: __( 'Show Share label', 'vaarta' ),
							checked: attributes.showLabel,
							onChange: function( value ) {
								setAttributes( { showLabel: value } );
							}
						} ),
						el( SelectControl, {
							label: __( 'Style', 'vaarta' ),
							value: attributes.styleVariant,
							options: [
								{ label: __( 'Light', 'vaarta' ), value: 'light' },
								{ label: __( 'Bold', 'vaarta' ), value: 'bold' },
								{ label: __( 'Minimal', 'vaarta' ), value: 'minimal' }
							],
							onChange: function( value ) {
								setAttributes( { styleVariant: value } );
							}
						} )
					)
				),
				el( 'div', blockProps, el( ServerSideRender, {
					block: 'vaarta/social-share',
					attributes: attributes
				} ) )
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
