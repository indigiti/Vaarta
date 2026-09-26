const { test, expect } = require( '@playwright/test' );

function isMobileProject( testInfo ) {
	return testInfo.project.name.includes( 'mobile' );
}

test( 'native sticky sidebar applies and clears the legacy top offset', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Sticky sidebar geometry is exercised once in the desktop project.' );
	await page.setViewportSize( { width: 1280, height: 800 } );
	await page.goto( '/' );

	await page.evaluate( () => {
		document.body.classList.remove( 'cs-navbar-smart-enabled' );
		document.body.classList.add( 'cs-sticky-sidebar-enabled', 'cs-navbar-sticky-enabled', 'cs-stick-to-top' );
		const fixture = document.createElement( 'aside' );
		fixture.id = 'vaarta-sticky-sidebar-fixture';
		fixture.innerHTML = '<div class="cs-sidebar__inner">Sticky fixture</div>';
		document.body.appendChild( fixture );
		window.vaartaStickySidebar.refresh();
	} );

	const sidebar = page.locator( '#vaarta-sticky-sidebar-fixture .cs-sidebar__inner' );
	await expect.poll( () => sidebar.evaluate( ( element ) => element.style.top ) ).toMatch( /^\d+(?:\.\d+)?px$/ );
	const desktopTop = await sidebar.evaluate( ( element ) => parseFloat( element.style.top ) );
	expect( desktopTop ).toBeGreaterThanOrEqual( 20 );

	await page.setViewportSize( { width: 900, height: 800 } );
	await page.evaluate( () => window.vaartaStickySidebar.refresh() );
	await expect.poll( () => sidebar.evaluate( ( element ) => element.style.top ) ).toBe( '' );
} );

test( 'native video background owns player lifecycle and controls', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'Video lifecycle is exercised once with a deterministic YouTube stub.' );
	await page.goto( '/' );

	await page.evaluate( () => {
		window.__vaartaVideoCalls = { load: 0, mute: 0, unmute: 0, play: 0, pause: 0, seek: 0, resize: 0 };
		window.YT = {
			Player: function ( element, options ) {
				this.loadVideoById = () => { window.__vaartaVideoCalls.load++; };
				this.mute = () => { window.__vaartaVideoCalls.mute++; };
				this.unMute = () => { window.__vaartaVideoCalls.unmute++; };
				this.playVideo = () => { window.__vaartaVideoCalls.play++; };
				this.pauseVideo = () => { window.__vaartaVideoCalls.pause++; };
				this.seekTo = () => { window.__vaartaVideoCalls.seek++; };
				this.setSize = () => { window.__vaartaVideoCalls.resize++; };
				setTimeout( () => {
					options.events.onReady();
					options.events.onStateChange( { data: 1 } );
				}, 0 );
			}
		};

		const shell = document.createElement( 'div' );
		shell.id = 'vaarta-video-fixture';
		shell.className = 'cs-video-wrap';
		shell.style.position = 'fixed';
		shell.style.top = '20px';
		shell.style.left = '20px';
		shell.style.zIndex = '99999';
		shell.style.width = '640px';
		shell.style.height = '360px';
		shell.innerHTML = `
			<div class="cs-video-wrapper" data-video-id="demo-video" data-video-start="4" data-video-end="20" style="width:640px;height:360px">
				<div class="cs-video-inner"></div>
			</div>
			<button type="button" class="cs-player-control cs-player-state cs-player-play">State</button>
			<button type="button" class="cs-player-control cs-player-stop">Stop</button>
			<button type="button" class="cs-player-control cs-player-volume cs-player-mute">Volume</button>`;
		document.body.appendChild( shell );
		window.vaartaVideoBackground.init( shell );
	} );

	const shell = page.locator( '#vaarta-video-fixture' );
	const wrapper = shell.locator( '.cs-video-wrapper' );
	const state = shell.locator( '.cs-player-state' );
	const volume = shell.locator( '.cs-player-volume' );

	await expect( wrapper ).toHaveAttribute( 'data-vaarta-video-uid', /vaarta-video-/ );
	await expect( shell ).toHaveClass( /cs-video-bg-init/ );
	await expect( state ).toHaveClass( /cs-player-pause/ );
	await expect.poll( () => page.evaluate( () => window.__vaartaVideoCalls.load ) ).toBeGreaterThan( 0 );
	await expect.poll( () => page.evaluate( () => window.__vaartaVideoCalls.mute ) ).toBeGreaterThan( 0 );
	await expect.poll( () => page.evaluate( () => window.__vaartaVideoCalls.resize ) ).toBeGreaterThan( 0 );

	await volume.click();
	await expect( volume ).toHaveClass( /cs-player-unmute/ );
	await expect.poll( () => page.evaluate( () => window.__vaartaVideoCalls.unmute ) ).toBeGreaterThan( 0 );

	await shell.locator( '.cs-player-stop' ).click();
	await expect( state ).toHaveClass( /cs-player-play/ );
	await expect( state ).toHaveClass( /cs-player-upause/ );
	await expect.poll( () => page.evaluate( () => window.__vaartaVideoCalls.pause ) ).toBeGreaterThan( 0 );

	await state.click();
	await expect( state ).toHaveClass( /cs-player-pause/ );
	await expect( state ).not.toHaveClass( /cs-player-upause/ );
	await expect.poll( () => page.evaluate( () => window.__vaartaVideoCalls.play ) ).toBeGreaterThan( 0 );
} );
