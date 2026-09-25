<?php
/**
 * Title: Homepage — Datacrunch Marketing
 * Slug: vaarta/home-datacrunch
 * Categories: vaarta, featured
 * Inserter: yes
 */
?>
<!-- wp:group {"tagName":"main","layout":{"type":"default"}} -->
<main class="wp-block-group">
	<!-- wp:pattern {"slug":"vaarta/popular-strip"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group vaarta-shell vaarta-hero">
		<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"muted"} -->
		<p class="has-text-align-center has-muted-color has-text-color has-sm-font-size"><?php echo esc_html__( 'Marketing · Social · Advertising', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"2xl"} -->
		<h1 class="wp-block-heading has-text-align-center has-2-xl-font-size"><?php echo esc_html__( 'Digital Marketing Breakthroughs: Unveiling Tomorrow’s Strategies!', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell">
		<!-- wp:vaarta/editorial-grid {"layout":"bento","cardStyle":"standard","postsToShow":7,"showExcerpt":true,"showReadingTime":true,"showViews":true,"priorityFirst":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-section","style":{"spacing":{"margin":{"top":"72px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-section">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Digital Marketing Secrets', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"textColor":"muted"} -->
		<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Expert insights and strategies for stronger digital performance.', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"standard","postsToShow":6,"showExcerpt":false,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-section","style":{"spacing":{"margin":{"top":"72px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-section">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Advertising', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"compact","categorySlug":"advertising","postsToShow":5,"showReadingTime":true} /-->
	</div>
	<!-- /wp:group -->
	<!-- wp:group {"className":"vaarta-shell vaarta-section","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-section">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Featured Posts', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"minimal","postsToShow":5,"orderBy":"views","showExcerpt":false,"showAuthor":true,"showDate":true,"showReadingTime":false,"showViews":false} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/social-feed"} /-->

	<!-- wp:pattern {"slug":"vaarta/top-week"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-section","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-section">
		<!-- wp:vaarta/category-cards {"heading":"Explore Marketing Topics","categorySlugs":["advertising","branding","insights"],"maxCategories":5,"showImage":true,"layout":"grid"} /-->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
