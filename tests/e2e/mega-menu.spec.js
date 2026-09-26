const { test, expect } = require( '@playwright/test' );

function isMobileProject( testInfo ) {
	return testInfo.project.name.includes( 'mobile' );
}

test( 'native mega-menu loader exclusively fetches published taxonomy stories', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Desktop mega-menu transport is exercised once.' );

	let menuRequests = 0;
	page.on( 'request', ( request ) => {
		if ( request.url().includes( '/wp-json/csco/v1/menu-posts' ) ) {
			menuRequests++;
		}
	} );

	await page.goto( '/' );
	await expect( page.locator( 'body' ) ).toBeVisible();

	const runtime = await page.evaluate( () => ( {
		native: !! window.vaartaMegaMenu,
		nativeConfig: !! ( window.vaartaMegaMenuConfig && window.vaartaMegaMenuConfig.rest_url )
	} ) );
	expect( runtime ).toEqual( {
		native: true,
		nativeConfig: true
	} );

	const item = page.locator( '.cs-header__nav .menu-item.cs-mega-menu-term' ).filter( { hasText: 'Mega News' } ).first();
	const posts = item.locator( '.cs-mm__posts' ).first();

	await expect( item ).toBeVisible();
	await item.hover();
	await expect( item ).toHaveClass( /loaded/ );
	await expect( posts ).toHaveClass( /loaded/ );
	await expect( posts.locator( '.mega-menu-item' ) ).toHaveCount( 3 );
	await expect( posts ).toContainText( 'Vaarta Test Story 3' );
	await expect( posts ).toContainText( 'Vaarta Test Story 1' );

	// The native controller autoloads this fixture exactly once. If a second
	// frontend loader is introduced it will issue a duplicate request.
	expect( menuRequests ).toBe( 1 );
} );
