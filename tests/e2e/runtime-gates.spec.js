const { test, expect } = require( '@playwright/test' );

function isMobileProject( testInfo ) {
	return testInfo.project.name.includes( 'mobile' );
}

test( 'legacy bundle entry keeps migrated runtime modules gated', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Generated bundle gate is verified once in the desktop project.' );

	await page.goto( '/' );
	const source = await page.locator( 'script[src*="/assets/js/scripts.js"]' ).getAttribute( 'src' );
	expect( source ).toBeTruthy();

	const bundle = await page.evaluate( async ( scriptSource ) => {
		const response = await fetch( scriptSource, { credentials: 'same-origin' } );
		return response.text();
	}, source );

	expect( bundle ).not.toContain( '__webpack_require__(2);' );
	expect( bundle ).not.toContain( '__webpack_require__(9);' );
	expect( bundle ).not.toContain( '__webpack_require__(11);' );
	expect( bundle ).not.toContain( '__webpack_require__(13);' );
	expect( bundle ).toContain( 'Vaarta native carousel owns legacy Webpack module 2.' );
	expect( bundle ).toContain( 'Vaarta native load-more owns legacy Webpack module 9.' );
	expect( bundle ).toContain( 'Vaarta native masonry owns legacy Webpack module 11.' );
	expect( bundle ).toContain( 'Vaarta native navigation owns legacy Webpack module 13.' );
} );