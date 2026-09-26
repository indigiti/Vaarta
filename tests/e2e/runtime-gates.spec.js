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

	const gatedModules = {
		2: 'Vaarta native carousel owns legacy Webpack module 2.',
		3: 'Vaarta native article interactions owns legacy Webpack module 3.',
		4: 'Vaarta native article interactions owns legacy Webpack module 4.',
		5: 'Vaarta native metabar alignment owns legacy Webpack module 5.',
		6: 'Vaarta native fullscreen navigation owns legacy Webpack module 6.',
		7: 'Vaarta native fullscreen shell owns legacy Webpack module 7.',
		8: 'Vaarta native tile hover owns legacy Webpack module 8.',
		9: 'Vaarta native load-more owns legacy Webpack module 9.',
		11: 'Vaarta native masonry owns legacy Webpack module 11.',
		12: 'Vaarta native mega-menu owns legacy Webpack module 12.',
		13: 'Vaarta native navigation owns legacy Webpack module 13.',
		14: 'Vaarta native offcanvas owns legacy Webpack module 14.',
		15: 'Vaarta native player controls own legacy Webpack module 15.',
		16: 'Vaarta native scheme owns legacy Webpack module 16.',
		17: 'Vaarta native search owns legacy Webpack module 17.',
		20: 'Vaarta native widget navigation owns legacy Webpack module 20.'
	};

	Object.entries( gatedModules ).forEach( ( [ moduleId, marker ] ) => {
		expect( bundle ).not.toContain( `__webpack_require__(${ moduleId });` );
		expect( bundle ).toContain( marker );
	} );
} );
