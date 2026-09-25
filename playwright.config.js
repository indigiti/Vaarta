const { defineConfig } = require( '@playwright/test' );

module.exports = defineConfig( {
	testDir: './tests/visual',
	timeout: 30_000,
	expect: {
		timeout: 8_000,
		toHaveScreenshot: {
			animations: 'disabled',
			caret: 'hide',
			scale: 'css',
			maxDiffPixelRatio: 0.015
		}
	},
	use: {
		baseURL: process.env.VAARTA_BASE_URL || 'http://localhost:8888',
		locale: 'en-US',
		timezoneId: 'Asia/Kolkata',
		reducedMotion: 'reduce'
	},
	reporter: [ [ 'list' ], [ 'html', { open: 'never' } ] ]
} );
