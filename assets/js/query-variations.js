( function( wp ) {
	const { registerBlockVariation } = wp.blocks;
	const { __ } = wp.i18n;

	const variations = [
		{
			name: 'vaarta/latest-news',
			title: __( 'Vaarta: Latest News', 'vaarta' ),
			description: __( 'Latest stories using Vaarta editorial defaults.', 'vaarta' ),
			attributes: {
				namespace: 'vaarta/latest-news',
				query: {
					perPage: 8,
					postType: 'post',
					order: 'desc',
					orderBy: 'date',
					inherit: false
				}
			},
			scope: [ 'inserter', 'transform' ]
		},
		{
			name: 'vaarta/featured-grid',
			title: __( 'Vaarta: Featured Grid', 'vaarta' ),
			description: __( 'Editorial grid for featured stories.', 'vaarta' ),
			attributes: {
				namespace: 'vaarta/featured-grid',
				className: 'vaarta-story-grid',
				query: {
					perPage: 8,
					postType: 'post',
					order: 'desc',
					orderBy: 'date',
					inherit: false
				}
			},
			scope: [ 'inserter', 'transform' ]
		}
	];

	variations.forEach( ( variation ) => registerBlockVariation( 'core/query', variation ) );
} )( window.wp );
