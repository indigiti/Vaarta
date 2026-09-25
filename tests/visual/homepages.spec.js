const { test, expect } = require( '@playwright/test' );

const demos = [
	{ name: 'tech', path: process.env.VAARTA_TECH_PATH || '/' },
	{ name: 'firmware', path: process.env.VAARTA_FIRMWARE_PATH || '/firmware/' },
	{ name: 'datacrunch', path: process.env.VAARTA_DATACRUNCH_PATH || '/datacrunch/' },
	{ name: 'foundr', path: process.env.VAARTA_FOUNDR_PATH || '/foundr/' },
	{ name: 'artboard', path: process.env.VAARTA_ARTBOARD_PATH || '/artboard/' },
	{ name: 'design-loft', path: process.env.VAARTA_DESIGN_LOFT_PATH || '/design-loft/' }
];

const viewports = [
	{ name: 'desktop-1440', width: 1440, height: 1200 },
	{ name: 'desktop-1280', width: 1280, height: 1000 },
	{ name: 'tablet-1024', width: 1024, height: 1366 },
	{ name: 'tablet-768', width: 768, height: 1024 },
	{ name: 'mobile-430', width: 430, height: 932 },
	{ name: 'mobile-390', width: 390, height: 844 },
	{ name: 'mobile-360', width: 360, height: 800 }
];

for ( const demo of demos ) {
	for ( const viewport of viewports ) {
		test( `${ demo.name } / ${ viewport.name }`, async ( { page } ) => {
			await page.setViewportSize( {
				width: viewport.width,
				height: viewport.height
			} );

			await page.goto( demo.path, {
				waitUntil: 'networkidle'
			} );

			await page.evaluate( () => {
				document.documentElement.dataset.vaartaTheme = 'light';
				document.documentElement.style.colorScheme = 'light';
				try {
					localStorage.setItem( 'vaarta-theme', 'light' );
				} catch ( error ) {
					// Local storage can be unavailable in hardened browsers.
				}
			} );

			await expect( page ).toHaveScreenshot(
				`${ demo.name }-${ viewport.name }.png`,
				{ fullPage: true }
			);
		} );
	}
}
