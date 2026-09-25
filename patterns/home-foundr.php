<?php
/**
 * Title: Homepage — Foundr Startup
 * Slug: vaarta/home-foundr
 * Categories: vaarta, featured
 * Inserter: yes
 */
?>
<!-- wp:group {"tagName":"main","layout":{"type":"default"}} -->
<main class="wp-block-group">
	<!-- wp:group {"className":"vaarta-shell vaarta-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group vaarta-shell vaarta-hero">
		<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"muted"} -->
		<p class="has-text-align-center has-muted-color has-text-color has-sm-font-size"><?php echo esc_html__( 'Ideas · Growth · Entrepreneurship', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"2xl"} -->
		<h1 class="wp-block-heading has-text-align-center has-2-xl-font-size"><?php echo esc_html__( 'The Startup Toolkit for Aspiring Entrepreneurs', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:vaarta/editorial-grid {"layout":"bento","cardStyle":"standard","postsToShow":6,"showExcerpt":true,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell","style":{"spacing":{"margin":{"top":"72px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Strategies', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"textColor":"muted"} -->
		<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Actionable insights and tactics for scaling a startup.', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"standard","postsToShow":4,"showExcerpt":true,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell","style":{"spacing":{"margin":{"top":"72px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Top on the Week', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"minimal","postsToShow":4,"showAuthor":true,"showDate":true,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->

	<!-- wp:group {"className":"vaarta-shell","style":{"spacing":{"margin":{"top":"72px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Entrepreneurship', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"standard","postsToShow":6,"showExcerpt":true,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
