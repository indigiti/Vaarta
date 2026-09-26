const { defineConfig, devices } = require( '@playwright/test' );

module.exports = defineConfig( {
	testDir: './tests/e2e',
	fullyParallel: false,
	forbidOnly: !! process.env.CI,
	retries: process.env.CI ? 1 : 0,
	workers: process.env.CI ? 1 : undefined,
	reporter: process.env.CI ? 'github' : 'list',
	use: {
		baseURL: process.env.WP_BASE_URL || 'http://localhost:8888',
		trace: 'retain-on-failure',
		screenshot: 'only-on-failure',
		video: 'retain-on-failure'
	},
	projects: [
		{
			name: 'chromium-desktop',
			use: {
				... devices[ 'Desktop Chrome' ],
				viewport: { width: 1440, height: 1000 }
			}
		},
		{
			name: 'chromium-mobile',
			use: {
				... devices[ 'Pixel 7' ]
			}
		}
	]
} );
