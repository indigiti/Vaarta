<?php
/**
 * Title: Homepage — Foundr Startup
 * Slug: vaarta/home-foundr
 * Categories: vaarta, featured
 * Inserter: yes
 *
 * @package Vaarta
 */

$strategies_category      = get_category_by_slug( 'strategies' );
$entrepreneurship_category = get_category_by_slug( 'entrepreneurship' );
$strategies_id             = $strategies_category ? (int) $strategies_category->term_id : 0;
$entrepreneurship_id       = $entrepreneurship_category ? (int) $entrepreneurship_category->term_id : 0;
?>
<!-- wp:group {"tagName":"main","className":"vaarta-home vaarta-home--foundr","layout":{"type":"default"}} -->
<main class="wp-block-group vaarta-home vaarta-home--foundr">
	<!-- wp:group {"className":"vaarta-shell vaarta-home-intro","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-intro">
		<!-- wp:paragraph {"className":"vaarta-eyebrow","fontSize":"xs"} -->
		<p class="vaarta-eyebrow has-xs-font-size"><?php echo esc_html__( 'Ideas · Growth · Entrepreneurship', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"className":"vaarta-home-intro__title","fontSize":"3xl"} -->
		<h1 class="wp-block-heading vaarta-home-intro__title has-3-xl-font-size"><?php echo esc_html__( 'The Startup Toolkit for Aspiring Entrepreneurs', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-home-section--lead","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-home-section--lead">
		<!-- wp:pattern {"slug":"vaarta/query-featured-grid"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-category-module","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-category-module">
		<!-- wp:group {"className":"vaarta-section-heading vaarta-section-heading--with-deck","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-section-heading vaarta-section-heading--with-deck">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Strategies', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Actionable insights and tactics for scaling a startup.', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:query {"query":{"perPage":4,"postType":"post","order":"desc","orderBy":"date","inherit":false,"taxQuery":{"category":[<?php echo esc_attr( $strategies_id ); ?>]}},"className":"vaarta-query-module vaarta-query-module--category"} -->
		<div class="wp-block-query vaarta-query-module vaarta-query-module--category">
			<!-- wp:post-template {"className":"vaarta-query-cards vaarta-query-cards--category","layout":{"type":"default"}} -->
				<!-- wp:group {"tagName":"article","className":"vaarta-query-card vaarta-query-card--category","layout":{"type":"default"}} -->
				<article class="wp-block-group vaarta-query-card vaarta-query-card--category">
					<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","className":"vaarta-query-card__media"} /-->
					<!-- wp:post-terms {"term":"category","fontSize":"xs"} /-->
					<!-- wp:post-title {"isLink":true,"level":2} /-->
					<!-- wp:post-excerpt {"moreText":"","excerptLength":18,"className":"vaarta-query-card__excerpt"} /-->
					<!-- wp:vaarta/story-meta {"showAuthor":true,"showDate":true,"showReadingTime":true,"showViews":true} /-->
				</article>
				<!-- /wp:group -->
			<!-- /wp:post-template -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section">
		<!-- wp:group {"className":"vaarta-module-panel vaarta-module-panel--dark","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-module-panel vaarta-module-panel--dark">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Top on the Week', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"dark","postsToShow":5,"orderBy":"trending","showExcerpt":false,"showAuthor":true,"showDate":true,"showReadingTime":true,"showViews":true,"showComments":false} /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-category-module","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-category-module">
		<!-- wp:group {"className":"vaarta-section-heading","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-section-heading">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Entrepreneurship', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		<!-- wp:query {"query":{"perPage":4,"postType":"post","order":"desc","orderBy":"date","inherit":false,"taxQuery":{"category":[<?php echo esc_attr( $entrepreneurship_id ); ?>]}},"className":"vaarta-query-module vaarta-query-module--category"} -->
		<div class="wp-block-query vaarta-query-module vaarta-query-module--category">
			<!-- wp:post-template {"className":"vaarta-query-cards vaarta-query-cards--category","layout":{"type":"default"}} -->
				<!-- wp:group {"tagName":"article","className":"vaarta-query-card vaarta-query-card--category","layout":{"type":"default"}} -->
				<article class="wp-block-group vaarta-query-card vaarta-query-card--category">
					<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","className":"vaarta-query-card__media"} /-->
					<!-- wp:post-terms {"term":"category","fontSize":"xs"} /-->
					<!-- wp:post-title {"isLink":true,"level":2} /-->
					<!-- wp:post-excerpt {"moreText":"","excerptLength":18,"className":"vaarta-query-card__excerpt"} /-->
					<!-- wp:vaarta/story-meta {"showAuthor":true,"showDate":true,"showReadingTime":true,"showViews":true} /-->
				</article>
				<!-- /wp:group -->
			<!-- /wp:post-template -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-home-section--latest","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-home-section--latest">
		<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'News', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:pattern {"slug":"vaarta/query-horizontal-list"} /-->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
