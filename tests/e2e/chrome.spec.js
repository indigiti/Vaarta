const { test, expect } = require( '@playwright/test' );

function isMobileProject( testInfo ) {
	return testInfo.project.name.includes( 'mobile' );
}

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
		fullscreenNav: !! window.vaartaFullscreenNav,
		scheme: !! window.vaartaScheme
	} ) );

	expect( runtime ).toEqual( {
		runtime: true,
		search: true,
		offcanvas: true,
		fullscreen: true,
		fullscreenNav: true,
		scheme: true
	} );
} );

test( 'search opens and closes with synchronized ARIA state', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Desktop header search is covered in the desktop project.' );

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

test( 'fullscreen menu closes with Escape', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Fullscreen desktop control is covered in the desktop project.' );

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

test( 'fullscreen navigation populates progressive submenu columns', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Fullscreen hover columns are a desktop interaction.' );

	const toggle = page.locator( '.cs-header__fullscreen-menu-toggle:visible' ).first();
	const firstColumn = page.locator( '.cs-fullscreen-menu__nav-col-first' );
	const lastColumn = page.locator( '.cs-fullscreen-menu__nav-col-last' );
	const stories = page.locator( '.cs-fullscreen-menu__nav-inner > .menu-item-has-children' ).first();

	await toggle.click();
	await expect( page.locator( '#vaarta-fullscreen-menu' ) ).toHaveAttribute( 'aria-hidden', 'false' );
	await expect( stories ).toContainText( 'Stories' );

	await stories.hover();
	await expect( firstColumn ).toHaveClass( /visible/ );
	await expect( firstColumn ).toContainText( 'News' );
	await expect( firstColumn ).toContainText( 'Culture' );

	const news = firstColumn.locator( ':scope > .sub-menu > .menu-item-has-children' ).first();
	await expect( news ).toContainText( 'News' );
	await news.hover();
	await expect( lastColumn ).toHaveClass( /visible/ );
	await expect( lastColumn ).toContainText( 'World' );
} );

test( 'scheme control changes the active color scheme', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Desktop scheme control is covered in the desktop project.' );

	const toggle = page.locator( '.cs-site-scheme-toggle:visible' ).first();
	const body = page.locator( 'body' );
	await expect( toggle ).toBeVisible();

	const before = await body.getAttribute( 'data-site-scheme' );
	await toggle.click();
	await expect.poll( () => body.getAttribute( 'data-site-scheme' ) ).not.toBe( before );

	const after = await body.getAttribute( 'data-site-scheme' );
	await expect( toggle ).toHaveAttribute( 'aria-pressed', 'dark' === after ? 'true' : 'false' );
} );

test( 'mobile off-canvas menu opens and closes with Escape', async ( { page }, testInfo ) => {
	test.skip( ! isMobileProject( testInfo ), 'Off-canvas mobile control is covered in the mobile project.' );

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
