<?php
/**
 * Block Category Navigation
 *
 * @var $attributes - block attributes
 * @var $attributes - layout attributes
 *
 * @package Caards
 */
// var_dump( $attributes);
// var_dump( $attributes);
?>
<div class="<?php echo esc_attr( $attributes['className'] ); ?>">
	<div class="cs-category-navigation">
		<?php
		$attributes['maximum'] = intval( $attributes['maximum'] );

		// Get terms.
		$categories = get_terms( array(
			'slug'       => $attributes['filter_ids'] ? explode( ',', $attributes['filter_ids'] ) : '',
			'orderby'    => $attributes['orderby'],
			'order'      => $attributes['order'],
			'number'     => $attributes['maximum'] > 0 ? $attributes['maximum'] : '',
			'taxonomy'   => 'category',
			'hide_empty' => true,
		) );

		if ( $categories ) {
			?>
			<ul>
				<?php
				foreach ( $categories as $category ) {
					?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $category->term_id ) ); ?>">
							<?php echo esc_html( $category->name ); ?>
						</a>
					</li>
					<?php
				}
				?>
			</ul>
			<?php
		}
		?>
	</div>
</div>
