( function( wp ) {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { CheckboxControl, PanelBody, SelectControl, TextControl, ToggleControl } = wp.components;
	const { useEntityProp } = wp.coreData;
	const { useSelect } = wp.data;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'vaarta/contributors', {
		edit: function( props ) {
			const { attributes, context, setAttributes } = props;
			const postType = context.postType || 'post';
			const blockProps = useBlockProps( { className: 'vaarta-contributors-editor' } );
			const metaTuple = useEntityProp( 'postType', postType, 'meta', context.postId );
			const meta = metaTuple[ 0 ] || {};
			const setMeta = metaTuple[ 1 ];
			const selected = Array.isArray( meta._vaarta_contributors ) ? meta._vaarta_contributors : [];

			const users = useSelect( function( select ) {
				return select( 'core' ).getUsers( {
					per_page: 100,
					who: 'authors'
				} );
			}, [] );

			function toggleUser( userId, checked ) {
				const next = checked
					? Array.from( new Set( selected.concat( [ userId ] ) ) )
					: selected.filter( function( id ) {
						return id !== userId;
					} );

				setMeta( Object.assign( {}, meta, {
					_vaarta_contributors: next
				} ) );
			}

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Display', 'vaarta' ), initialOpen: true },
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
								{ label: __( 'Compact', 'vaarta' ), value: 'compact' },
								{ label: __( 'Profiles', 'vaarta' ), value: 'profiles' }
							],
							onChange: function( value ) {
								setAttributes( { layout: value } );
							}
						} ),
						el( ToggleControl, {
							label: __( 'Show biographies', 'vaarta' ),
							checked: attributes.showBio,
							onChange: function( value ) {
								setAttributes( { showBio: value } );
							}
						} )
					),
					el(
						PanelBody,
						{ title: __( 'Select contributors', 'vaarta' ), initialOpen: true },
						! users && el( 'p', null, __( 'Loading authors…', 'vaarta' ) ),
						( users || [] ).map( function( user ) {
							return el( CheckboxControl, {
								key: user.id,
								label: user.name,
								checked: selected.includes( user.id ),
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
					el( 'strong', null, attributes.heading || __( 'Contributors', 'vaarta' ) ),
					selected.length
						? el(
							'ul',
							null,
							selected.map( function( userId ) {
								const user = ( users || [] ).find( function( item ) {
									return item.id === userId;
								} );
								return el( 'li', { key: userId }, user ? user.name : '#' + userId );
							} )
						)
						: el( 'p', null, __( 'Select contributors in the block settings.', 'vaarta' ) )
				)
			);
		},
		save: function() {
			return null;
		}
	} );
} )( window.wp );
