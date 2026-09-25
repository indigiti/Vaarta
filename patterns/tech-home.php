<?php
/**
 * Title: Tech Home
 * Slug: vaarta/tech-home
 * Categories: vaarta, featured
 * Inserter: yes
 */
?>
<!-- wp:group {"tagName":"main","layout":{"type":"default"}} -->
<main class="wp-block-group">
	<!-- wp:group {"className":"vaarta-shell vaarta-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group vaarta-shell vaarta-hero">
		<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"muted"} -->
		<p class="has-text-align-center has-muted-color has-text-color has-sm-font-size"><?php echo esc_html__( 'Independent technology journalism', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center","level":1,"className":"vaarta-hero__title","fontSize":"2xl"} -->
		<h1 class="wp-block-heading has-text-align-center vaarta-hero__title has-2-xl-font-size"><?php echo esc_html__( 'Ideas shaping tomorrow.', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:navigation {"className":"vaarta-chip-row","overlayMenu":"never","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} /-->
	</div>
	<!-- /wp:group -->
	<!-- wp:pattern {"slug":"vaarta/archive-grid"} /-->
</main>
<!-- /wp:group -->
