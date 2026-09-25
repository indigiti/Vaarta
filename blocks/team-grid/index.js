( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { CheckboxControl, PanelBody, RangeControl, SelectControl, TextControl, TextareaControl, ToggleControl } = wp.components;
	const { useSelect } = wp.data;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'vaarta/team-grid', {
		edit: function( props ) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps();

			const users = useSelect( function( select ) {
				return select( 'core' ).getUsers( {
					per_page: 100,
					who: 'authors'
				} );
			}, [] );

			function toggleUser( userId, checked ) {
				const selected = attributes.userIds || [];
				const next = checked
					? Array.from( new Set( selected.concat( [ userId ] ) ) )
					: selected.filter( function( id ) {
						return id !== userId;
					} );

				setAttributes( { userIds: next } );
			}

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Team Grid', 'vaarta' ), initialOpen: true },
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
						el( SelectControl, {
							label: __( 'Desktop columns', 'vaarta' ),
							value: attributes.columns,
							options: [
								{ label: '2', value: 2 },
								{ label: '3', value: 3 },
								{ label: '4', value: 4 }
							],
							onChange: function( value ) {
								setAttributes( { columns: parseInt( value, 10 ) || 4 } );
							}
						} ),
						el( RangeControl, {
							label: __( 'Maximum members', 'vaarta' ),
							value: attributes.maxMembers,
							min: 2,
							max: 16,
							onChange: function( value ) {
								setAttributes( { maxMembers: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show biographies', 'vaarta' ),
							checked: attributes.showBio,
							onChange: function( value ) {
								setAttributes( { showBio: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show post counts', 'vaarta' ),
							checked: attributes.showPostCount,
							onChange: function( value ) {
								setAttributes( { showPostCount: value } );
							}
						} )
					),
					el(
						PanelBody,
						{ title: __( 'Choose team members', 'vaarta' ), initialOpen: false },
						el(
							'p',
							null,
							__( 'Leave all unchecked to show authors automatically.', 'vaarta' )
						),
						( users || [] ).map( function( user ) {
							return el( CheckboxControl, {
								key: user.id,
								label: user.name,
								checked: ( attributes.userIds || [] ).includes( user.id ),
								onChange: function( checked ) {
									toggleUser( user.id, checked );
								}
							} );
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'vaarta/team-grid',
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
