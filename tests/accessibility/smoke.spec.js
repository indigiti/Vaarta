const { test, expect } = require( '@playwright/test' );
const AxeBuilder = require( '@axe-core/playwright' ).default;

const routes = ( process.env.VAARTA_A11Y_PATHS || '/' )
	.split( ',' )
	.map( ( item ) => item.trim() )
	.filter( Boolean );

for ( const route of routes ) {
	test( `axe smoke: ${ route }`, async ( { page } ) => {
		await page.goto( route, { waitUntil: 'networkidle' } );

		const results = await new AxeBuilder( { page } )
			.withTags( [ 'wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa' ] )
			.analyze();

		const serious = results.violations.filter(
			( violation ) => [ 'serious', 'critical' ].includes( violation.impact )
		);

		expect(
			serious,
			serious
				.map( ( violation ) => `${ violation.id }: ${ violation.help }` )
				.join( '\n' )
		).toEqual( [] );
	} );
}

test( 'search overlay keyboard flow', async ( { page } ) => {
	await page.goto( '/', { waitUntil: 'networkidle' } );

	const trigger = page.locator( '.vaarta-search-overlay__trigger' ).first();
	await expect( trigger ).toBeVisible();
	await trigger.focus();
	await page.keyboard.press( 'Enter' );

	const dialog = page.locator( '.vaarta-search-overlay__dialog' ).first();
	await expect( dialog ).toBeVisible();
	await expect( page.locator( '.vaarta-search-overlay__input' ).first() ).toBeFocused();

	await page.keyboard.press( 'Escape' );
	await expect( dialog ).toBeHidden();
	await expect( trigger ).toBeFocused();
} );
