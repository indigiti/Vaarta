<?php
/**
 * Title: Homepage — Design Loft
 * Slug: vaarta/home-design-loft
 * Categories: vaarta, featured
 * Inserter: yes
 */
?>
<!-- wp:group {"tagName":"main","layout":{"type":"default"}} -->
<main class="wp-block-group">
	<!-- wp:group {"className":"vaarta-shell vaarta-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group vaarta-shell vaarta-hero">
		<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"muted"} -->
		<p class="has-text-align-center has-muted-color has-text-color has-sm-font-size"><?php echo esc_html__( 'Architecture · Interiors · Design', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"2xl"} -->
		<h1 class="wp-block-heading has-text-align-center has-2-xl-font-size"><?php echo esc_html__( 'Ideas for better spaces and thoughtful design.', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:vaarta/editorial-grid {"layout":"bento","cardStyle":"standard","postsToShow":7,"showExcerpt":false,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-section","style":{"spacing":{"margin":{"top":"72px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Featured Design', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"minimal","postsToShow":6,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-section","style":{"spacing":{"margin":{"top":"72px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Latest Stories', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"compact","postsToShow":6,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
