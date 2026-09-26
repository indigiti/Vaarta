const { test, expect } = require( '@playwright/test' );

function isMobileProject( testInfo ) {
	return testInfo.project.name.includes( 'mobile' );
}

test( 'native mega-menu loader fetches published taxonomy stories', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Desktop mega-menu transport is exercised once.' );

	await page.goto( '/' );
	await expect( page.locator( 'body' ) ).toBeVisible();

	const runtimePresent = await page.evaluate( () => !! window.vaartaMegaMenu );
	expect( runtimePresent ).toBe( true );

	const item = page.locator( '.cs-header__nav .menu-item.cs-mega-menu-term' ).filter( { hasText: 'Mega News' } ).first();
	const posts = item.locator( '.cs-mm__posts' ).first();

	await expect( item ).toBeVisible();
	await item.hover();
	await expect( item ).toHaveClass( /loaded/ );
	await expect( posts ).toHaveClass( /loaded/ );
	await expect( posts.locator( '.mega-menu-item' ) ).toHaveCount( 3 );
	await expect( posts ).toContainText( 'Vaarta Test Story 3' );
	await expect( posts ).toContainText( 'Vaarta Test Story 1' );
} );