<?php
/**
 * Title: Split Promo
 * Slug: vaarta/promo-split
 * Categories: vaarta, vaarta-promo
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"wide","className":"is-style-vaarta-dark-card","style":{"spacing":{"padding":{"top":"48px","right":"48px","bottom":"48px","left":"48px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide is-style-vaarta-dark-card">
	<!-- wp:columns {"verticalAlignment":"center"} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"65%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:65%">
			<!-- wp:paragraph {"fontSize":"xs"} -->
			<p class="has-xs-font-size"><?php echo esc_html__( 'VAARTA EDITORIAL', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2} -->
			<h2 class="wp-block-heading"><?php echo esc_html__( 'Build a stronger relationship with your readers.', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"verticalAlignment":"center","width":"35%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:35%">
			<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"canvas","textColor":"ink"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-ink-color has-canvas-background-color has-text-color has-background wp-element-button"><?php echo esc_html__( 'Learn more', 'vaarta' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
