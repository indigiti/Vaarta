const { test } = require( '@playwright/test' );
const path = require( 'path' );

const references = [
	{ name: 'tech', url: 'https://caards.codesupply.co/caards/' },
	{ name: 'firmware', url: 'https://caards.codesupply.co/firmware/' },
	{ name: 'datacrunch', url: 'https://caards.codesupply.co/datacrunch/' },
	{ name: 'foundr', url: 'https://caards.codesupply.co/foundr/' },
	{ name: 'artboard', url: 'https://caards.codesupply.co/artboard/' },
	{ name: 'design-loft', url: 'https://caards.codesupply.co/design-loft/' }
];

const viewports = [
	{ name: 'desktop-1440', width: 1440, height: 1200 },
	{ name: 'tablet-768', width: 768, height: 1024 },
	{ name: 'mobile-390', width: 390, height: 844 }
];

for ( const reference of references ) {
	for ( const viewport of viewports ) {
		test( `${ reference.name } reference / ${ viewport.name }`, async ( { page } ) => {
			await page.setViewportSize( {
				width: viewport.width,
				height: viewport.height
			} );

			await page.goto( reference.url, {
				waitUntil: 'networkidle'
			} );

			await page.screenshot( {
				path: path.join(
					'test-results',
					'references',
					`${ reference.name }-${ viewport.name }.png`
				),
				fullPage: true,
				animations: 'disabled'
			} );
		} );
	}
}
