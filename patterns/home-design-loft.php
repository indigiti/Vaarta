<?php
/**
 * Title: Homepage — Design Loft
 * Slug: vaarta/home-design-loft
 * Categories: vaarta, featured
 * Inserter: yes
 *
 * @package Vaarta
 */
?>
<!-- wp:group {"tagName":"main","className":"vaarta-home vaarta-home--design-loft","layout":{"type":"default"}} -->
<main class="wp-block-group vaarta-home vaarta-home--design-loft">
	<!-- wp:group {"className":"vaarta-shell vaarta-home-intro","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-intro">
		<!-- wp:paragraph {"className":"vaarta-eyebrow","fontSize":"xs"} -->
		<p class="vaarta-eyebrow has-xs-font-size"><?php echo esc_html__( 'Architecture · Interiors · Design', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"className":"vaarta-home-intro__title","fontSize":"3xl"} -->
		<h1 class="wp-block-heading vaarta-home-intro__title has-3-xl-font-size"><?php echo esc_html__( 'Ideas for better spaces and thoughtful design.', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-home-section--lead","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-home-section--lead">
		<!-- wp:pattern {"slug":"vaarta/query-featured-grid"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section">
		<!-- wp:group {"className":"vaarta-module-panel vaarta-module-panel--dark","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-module-panel vaarta-module-panel--dark">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Featured Design', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"dark","postsToShow":6,"orderBy":"views","showExcerpt":false,"showAuthor":false,"showDate":true,"showReadingTime":true,"showViews":true,"showComments":false} /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-home-section--latest","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-home-section--latest">
		<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Latest Stories', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:pattern {"slug":"vaarta/query-horizontal-list"} /-->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
