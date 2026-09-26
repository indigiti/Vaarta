<?php
/**
 * The template part for displaying site search.
 *
 * @package Vaarta
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_header_background', '#ffffff' ),
	get_theme_mod( 'color_header_background_dark', '#1b1c1f' )
);

$search_placeholder = get_theme_mod( 'misc_search_placeholder', esc_html__( 'Enter keyword', 'caards' ) );
?>

<div id="vaarta-site-search" class="cs-search cs-search-<?php echo esc_attr( csco_get_header_search_type() ); ?>" aria-hidden="true" <?php echo wp_kses( $scheme, 'csco' ); ?>>

	<?php if ( 'two' === csco_get_header_search_type() ) { ?>
		<div class="cs-container">
	<?php } ?>

	<div class="cs-search__wrapper">
		<form role="search" method="get" class="cs-search__nav-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="cs-search__group">
				<input data-swpparentel=".cs-header .cs-search-live-result" required class="cs-search__input" data-swplive="true" type="search" value="<?php the_search_query(); ?>" name="s" placeholder="<?php echo esc_attr( $search_placeholder ); ?>" aria-label="<?php echo esc_attr( $search_placeholder ); ?>">

				<button class="cs-search__submit" type="submit" aria-label="<?php esc_attr_e( 'Search', 'caards' ); ?>">
					<i class="cs-icon cs-icon-search" aria-hidden="true"></i>
				</button>

				<button class="cs-search__close" type="button" aria-label="<?php esc_attr_e( 'Close search', 'caards' ); ?>">
					<span aria-hidden="true"></span>
				</button>
			</div>
		</form>

		<div class="cs-search-live-container" aria-live="polite" aria-atomic="false">
			<div class="cs-search-live-result"></div>
		</div>

	</div>

	<?php if ( 'two' === csco_get_header_search_type() ) { ?>
		</div>
	<?php } ?>

</div>
