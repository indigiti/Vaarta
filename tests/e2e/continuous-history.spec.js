const { test, expect } = require( '@playwright/test' );

function isMobileProject( testInfo ) {
	return testInfo.project.name.includes( 'mobile' );
}

test( 'continuous reading owns title and URL synchronization', async ( { page }, testInfo ) => {
	test.skip( isMobileProject( testInfo ), 'History synchronization is exercised once in the desktop project.' );

	await page.goto( '/vaarta-test-story-1/' );
	await expect( page.locator( 'body' ) ).toHaveClass( /single-post/ );
	const originalTitle = await page.title();
	const originalUrl = page.url();

	await page.evaluate( async () => {
		if ( ! document.querySelector( '.cs-nextpost-section' ) ) {
			await window.vaartaContinuousReading.load();
		}
	} );

	const nextSection = page.locator( '.cs-nextpost-section' ).first();
	await expect( nextSection ).toHaveAttribute( 'data-title', 'Vaarta Test Story 2' );

	await page.evaluate( () => {
		const section = document.querySelector( '.cs-nextpost-section' );
		window.scrollTo( 0, section.getBoundingClientRect().top + window.scrollY + 20 );
		window.vaartaContinuousReading.syncHistory();
	} );

	await expect.poll( () => new URL( page.url() ).pathname ).toBe( '/vaarta-test-story-2/' );
	await expect.poll( () => page.title() ).toContain( 'Vaarta Test Story 2' );

	await page.evaluate( () => {
		window.scrollTo( 0, 0 );
		window.vaartaContinuousReading.syncHistory();
	} );

	await expect.poll( () => page.url() ).toBe( originalUrl );
	await expect.poll( () => page.title() ).toBe( originalTitle );
} );
