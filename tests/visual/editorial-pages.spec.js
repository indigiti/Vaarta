const { test, expect } = require( '@playwright/test' );

const pages = [
	{ name: 'contact', path: process.env.VAARTA_CONTACT_PATH || '' },
	{ name: 'team', path: process.env.VAARTA_TEAM_PATH || '' },
	{ name: 'coming-soon', path: process.env.VAARTA_COMING_SOON_PATH || '' }
].filter( ( item ) => item.path );

const viewports = [
	{ name: 'desktop', width: 1440, height: 1100 },
	{ name: 'mobile', width: 390, height: 844 }
];

for ( const pageConfig of pages ) {
	for ( const viewport of viewports ) {
		test( `${ pageConfig.name } / ${ viewport.name }`, async ( { page } ) => {
			await page.setViewportSize( {
				width: viewport.width,
				height: viewport.height
			} );

			await page.goto( pageConfig.path, { waitUntil: 'networkidle' } );

			await expect( page ).toHaveScreenshot(
				`${ pageConfig.name }-${ viewport.name }.png`,
				{ fullPage: true }
			);
		} );
	}
}
