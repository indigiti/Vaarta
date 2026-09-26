const { test, expect } = require( '@playwright/test' );

function isMobileProject( testInfo ) {
	return testInfo.project.name.includes( 'mobile' );
}

test( 'native micro runtime modules expose their public controllers', async ( { page } ) => {
	await page.goto( '/' );

	const modules = await page.evaluate( () => ( {
		metabar: !! window.vaartaMetabarAlignment,
		tile: !! window.vaartaTileHover,
		player: !! window.vaartaPlayerControls,
		widgetNav: !! window.vaartaWidgetNav
	} ) );

	expect( modules ).toEqual( {
		metabar: true,
		tile: true,
		player: true,
		widgetNav: true
	} );
} );

test( 'tile hover keeps the legacy inverse scheme contract', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Desktop hover behavior is exercised once.' );
	await page.setViewportSize( { width: 1280, height: 800 } );
	await page.goto( '/' );

	await page.evaluate( () => {
		const fixture = document.createElement( 'div' );
		fixture.className = 'cs-block-posts-layout-tile-hover';
		fixture.innerHTML = '<div id="vaarta-tile-fixture" class="cs-entry__outer" style="width:200px;height:120px"></div>';
		document.body.appendChild( fixture );
		window.vaartaTileHover.refresh( fixture );
	} );

	const tile = page.locator( '#vaarta-tile-fixture' );
	await expect( tile ).not.toHaveAttribute( 'data-scheme', 'inverse' );
	await tile.hover();
	await expect( tile ).toHaveAttribute( 'data-scheme', 'inverse' );
	await page.mouse.move( 1, 1 );
	await expect( tile ).not.toHaveAttribute( 'data-scheme', 'inverse' );
} );

test( 'player control hover dims only sibling controls', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Desktop hover behavior is exercised once.' );
	await page.goto( '/' );

	await page.evaluate( () => {
		const fixture = document.createElement( 'div' );
		fixture.id = 'vaarta-player-fixture';
		fixture.innerHTML = '<button id="player-one" class="cs-player-control" style="width:80px;height:40px">One</button><button id="player-two" class="cs-player-control" style="width:80px;height:40px">Two</button>';
		document.body.appendChild( fixture );
	} );

	await page.locator( '#player-one' ).hover();
	await expect.poll( () => page.locator( '#player-two' ).evaluate( ( element ) => element.style.opacity ) ).toBe( '0.5' );
	await page.mouse.move( 1, 1 );
	await expect.poll( () => page.locator( '#player-two' ).evaluate( ( element ) => element.style.opacity ) ).toBe( '1' );
} );

test( 'widget navigation preserves submenu classes with accessible state', async ( { page } ) => {
	await page.goto( '/' );

	await page.evaluate( () => {
		const fixture = document.createElement( 'div' );
		fixture.className = 'widget_nav_menu';
		fixture.id = 'vaarta-widget-fixture';
		fixture.innerHTML = '<ul><li id="widget-parent" class="menu-item menu-item-has-children"><a href="#">Parent</a><ul class="sub-menu"><li>Child</li></ul></li></ul>';
		document.body.appendChild( fixture );
		window.vaartaWidgetNav.init( fixture );
	} );

	const item = page.locator( '#widget-parent' );
	const toggle = item.locator( ':scope > .vaarta-widget-nav-toggle' );
	const submenu = item.locator( ':scope > .sub-menu' );

	await expect( toggle ).toHaveCount( 1 );
	await expect( toggle ).toHaveAttribute( 'aria-expanded', 'false' );
	await toggle.click();
	await expect( item ).toHaveClass( /menu-item-expanded/ );
	await expect( submenu ).toHaveClass( /submenu-visible/ );
	await expect( toggle ).toHaveAttribute( 'aria-expanded', 'true' );
	await toggle.click();
	await expect( item ).not.toHaveClass( /menu-item-expanded/ );
	await expect( submenu ).not.toHaveClass( /submenu-visible/ );
	await expect( toggle ).toHaveAttribute( 'aria-expanded', 'false' );
} );

test( 'metabar alignment hides only when transformed wide content overlaps', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Synthetic desktop geometry is exercised once.' );
	await page.goto( '/' );

	const result = await page.evaluate( () => {
		const primary = document.createElement( 'div' );
		primary.className = 'cs-site-primary';
		primary.innerHTML = '<div class="entry-content"><div id="wide-fixture" class="alignwide" style="transform:translateX(0px)"></div></div><div id="metabar-fixture" class="cs-entry__metabar-inner"></div>';
		document.body.appendChild( primary );

		const sidebar = primary.querySelector( '#metabar-fixture' );
		const wide = primary.querySelector( '#wide-fixture' );
		sidebar.getBoundingClientRect = () => ( { top: 100, height: 100, bottom: 200, left: 0, right: 100, width: 100 } );
		wide.getBoundingClientRect = () => ( { top: 150, height: 100, bottom: 250, left: 0, right: 100, width: 100 } );
		window.vaartaMetabarAlignment.refresh( primary );
		const overlapping = sidebar.style.opacity;

		wide.getBoundingClientRect = () => ( { top: 500, height: 100, bottom: 600, left: 0, right: 100, width: 100 } );
		window.vaartaMetabarAlignment.refresh( primary );

		return { overlapping, separated: sidebar.style.opacity };
	} );

	expect( result ).toEqual( { overlapping: '0', separated: '1' } );
} );
