const { test, expect } = require( '@playwright/test' );

test.beforeEach( async ( { page } ) => {
	await page.goto( '/' );
	await expect( page.locator( 'body' ) ).toBeVisible();
	await expect( page.locator( '#content' ) ).toBeAttached();
} );

test( 'Vaarta modular runtime is present', async ( { page } ) => {
	const runtime = await page.evaluate( () => ( {
		runtime: !! window.vaartaRuntime,
		search: !! window.vaartaSearch,
		offcanvas: !! window.vaartaOffcanvas,
		fullscreen: !! window.vaartaFullscreen,
		scheme: !! window.vaartaScheme
	} ) );

	expect( runtime ).toEqual( {
		runtime: true,
		search: true,
		offcanvas: true,
		fullscreen: true,
		scheme: true
	} );
} );

test( 'search opens and closes with synchronized ARIA state', async ( { page, isMobile } ) => {
	test.skip( isMobile, 'Desktop header search is covered in the desktop project.' );

	const toggle = page.locator( '.cs-header__search-toggle:visible' ).first();
	const panel = page.locator( '#vaarta-site-search' ).first();
	const close = panel.locator( '.cs-search__close' );

	await expect( toggle ).toBeVisible();
	await toggle.click();
	await expect( panel ).toBeVisible();
	await expect( panel ).toHaveAttribute( 'aria-hidden', 'false' );
	await expect( toggle ).toHaveAttribute( 'aria-expanded', 'true' );
	await expect( panel.locator( '.cs-search__input' ) ).toBeFocused();

	await close.click();
	await expect( panel ).toBeHidden();
	await expect( panel ).toHaveAttribute( 'aria-hidden', 'true' );
	await expect( toggle ).toHaveAttribute( 'aria-expanded', 'false' );
} );

test( 'fullscreen menu closes with Escape', async ( { page, isMobile } ) => {
	test.skip( isMobile, 'Fullscreen desktop control is covered in the desktop project.' );

	const toggle = page.locator( '.cs-header__fullscreen-menu-toggle:visible' ).first();
	const panel = page.locator( '#vaarta-fullscreen-menu' );

	await expect( toggle ).toBeVisible();
	await toggle.click();
	await expect( page.locator( 'body' ) ).toHaveClass( /cs-fullscreen-menu-active/ );
	await expect( panel ).toHaveAttribute( 'aria-hidden', 'false' );

	await page.keyboard.press( 'Escape' );
	await expect( page.locator( 'body' ) ).not.toHaveClass( /cs-fullscreen-menu-active/ );
	await expect( panel ).toHaveAttribute( 'aria-hidden', 'true' );
} );

test( 'scheme control changes the active color scheme', async ( { page, isMobile } ) => {
	test.skip( isMobile, 'Desktop scheme control is covered in the desktop project.' );

	const toggle = page.locator( '.cs-site-scheme-toggle:visible' ).first();
	const body = page.locator( 'body' );
	await expect( toggle ).toBeVisible();

	const before = await body.getAttribute( 'data-site-scheme' );
	await toggle.click();
	await expect.poll( () => body.getAttribute( 'data-site-scheme' ) ).not.toBe( before );

	const after = await body.getAttribute( 'data-site-scheme' );
	await expect( toggle ).toHaveAttribute( 'aria-pressed', 'dark' === after ? 'true' : 'false' );
} );

test( 'mobile off-canvas menu opens and closes with Escape', async ( { page, isMobile } ) => {
	test.skip( ! isMobile, 'Off-canvas mobile control is covered in the mobile project.' );

	const toggle = page.locator( '.cs-header__offcanvas-toggle:visible' ).first();
	const panel = page.locator( '#vaarta-offcanvas' );

	await expect( toggle ).toBeVisible();
	await toggle.click();
	await expect( page.locator( 'body' ) ).toHaveClass( /cs-offcanvas-active/ );
	await expect( panel ).toHaveAttribute( 'aria-hidden', 'false' );

	await page.keyboard.press( 'Escape' );
	await expect( page.locator( 'body' ) ).not.toHaveClass( /cs-offcanvas-active/ );
	await expect( panel ).toHaveAttribute( 'aria-hidden', 'true' );
} );
