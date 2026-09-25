<?php
/**
 * Title: Homepage — Artboard Freebies
 * Slug: vaarta/home-artboard
 * Categories: vaarta, featured
 * Inserter: yes
 */
?>
<!-- wp:group {"tagName":"main","layout":{"type":"default"}} -->
<main class="wp-block-group">
	<!-- wp:group {"className":"vaarta-shell vaarta-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group vaarta-shell vaarta-hero">
		<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"muted"} -->
		<p class="has-text-align-center has-muted-color has-text-color has-sm-font-size"><?php echo esc_html__( 'Mockups · Templates · Inspiration', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"2xl"} -->
		<h1 class="wp-block-heading has-text-align-center has-2-xl-font-size"><?php echo esc_html__( 'Welcome to the Ultimate Design Resource Hub!', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:vaarta/editorial-grid {"layout":"bento","cardStyle":"overlay","postsToShow":5,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/promo-split"} /-->

	<!-- wp:group {"className":"vaarta-shell","style":{"spacing":{"margin":{"top":"72px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Inspiration', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"textColor":"muted"} -->
		<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Fresh ideas, mockups and resources for creative projects.', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"standard","categorySlug":"inspiration","postsToShow":6,"showExcerpt":true,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->
</main>
<!-- /wp:group -->
