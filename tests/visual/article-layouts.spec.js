const { test, expect } = require( '@playwright/test' );

const articlePaths = ( process.env.VAARTA_ARTICLE_PATHS || '' )
	.split( ',' )
	.map( ( item ) => item.trim() )
	.filter( Boolean );

for ( const [ index, path ] of articlePaths.entries() ) {
	test( `article-layout-${ index + 1 }`, async ( { page } ) => {
		await page.setViewportSize( { width: 1280, height: 1000 } );
		await page.goto( path, { waitUntil: 'networkidle' } );

		await expect( page ).toHaveScreenshot(
			`article-layout-${ index + 1 }.png`,
			{ fullPage: true }
		);
	} );
}
