module.exports = {
	ci: {
		collect: {
			url: ( process.env.LHCI_TARGET_URLS || process.env.VAARTA_BASE_URL || 'http://localhost:8888' )
				.split( ',' )
				.map( ( url ) => url.trim() )
				.filter( Boolean ),
			numberOfRuns: 3
		},
		assert: {
			assertions: {
				'categories:performance': [ 'error', { minScore: 0.9 } ],
				'categories:accessibility': [ 'error', { minScore: 0.95 } ],
				'categories:best-practices': [ 'warn', { minScore: 0.9 } ],
				'categories:seo': [ 'warn', { minScore: 0.9 } ],
				'largest-contentful-paint': [ 'error', { maxNumericValue: 2500 } ],
				'cumulative-layout-shift': [ 'error', { maxNumericValue: 0.1 } ],
				'total-blocking-time': [ 'warn', { maxNumericValue: 200 } ],
				'first-contentful-paint': [ 'warn', { maxNumericValue: 1800 } ],
				'total-byte-weight': [ 'warn', { maxNumericValue: 1600000 } ]
			}
		},
		upload: {
			target: 'temporary-public-storage'
		}
	}
};
