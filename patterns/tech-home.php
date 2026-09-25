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
	<!-- wp:pattern {"slug":"vaarta/popular-strip"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group vaarta-shell vaarta-hero">
		<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"muted"} -->
		<p class="has-text-align-center has-muted-color has-text-color has-sm-font-size"><?php echo esc_html__( 'Independent technology journalism', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textAlign":"center","level":1,"className":"vaarta-hero__title","fontSize":"3xl"} -->
		<h1 class="wp-block-heading has-text-align-center vaarta-hero__title has-3-xl-font-size"><?php echo esc_html__( 'Ideas shaping tomorrow.', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"vaarta-hero__deck","textColor":"muted"} -->
		<p class="has-text-align-center vaarta-hero__deck has-muted-color has-text-color"><?php echo esc_html__( 'Technology, science and culture explained with clarity.', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:navigation {"className":"vaarta-chip-row","overlayMenu":"never","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-section vaarta-section--lead","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-section vaarta-section--lead">
		<!-- wp:vaarta/editorial-grid {"layout":"bento","postsToShow":8,"showExcerpt":true,"showAuthor":false,"showDate":false,"showReadingTime":true,"showViews":true,"priorityFirst":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-section","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-section">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Future Tech', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"textColor":"muted"} -->
		<p class="has-muted-color has-text-color"><?php echo esc_html__( 'The ideas, systems and breakthroughs changing what comes next.', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"standard","categorySlug":"future-tech","postsToShow":6,"showExcerpt":false,"showAuthor":false,"showDate":false,"showReadingTime":true,"showViews":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/social-feed"} /-->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-section","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-section">
		<!-- wp:heading {"level":2,"fontSize":"xl"} -->
		<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Latest Stories', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"compact","postsToShow":8,"showExcerpt":false,"showAuthor":true,"showDate":true,"showReadingTime":true,"showViews":true} /-->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
