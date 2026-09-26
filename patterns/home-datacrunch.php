<?php
/**
 * Title: Homepage — Datacrunch Marketing
 * Slug: vaarta/home-datacrunch
 * Categories: vaarta, featured
 * Inserter: yes
 *
 * @package Vaarta
 */

$advertising_category = get_category_by_slug( 'advertising' );
$advertising_id       = $advertising_category ? (int) $advertising_category->term_id : 0;
?>
<!-- wp:group {"tagName":"main","className":"vaarta-home vaarta-home--datacrunch","layout":{"type":"default"}} -->
<main class="wp-block-group vaarta-home vaarta-home--datacrunch">
	<!-- wp:pattern {"slug":"vaarta/popular-strip"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-intro","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-intro">
		<!-- wp:paragraph {"className":"vaarta-eyebrow","fontSize":"xs"} -->
		<p class="vaarta-eyebrow has-xs-font-size"><?php echo esc_html__( 'Marketing · Social · Advertising', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"className":"vaarta-home-intro__title","fontSize":"3xl"} -->
		<h1 class="wp-block-heading vaarta-home-intro__title has-3-xl-font-size"><?php echo esc_html__( 'Digital Marketing Breakthroughs: Unveiling Tomorrow’s Strategies!', 'vaarta' ); ?></h1>
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
		<!-- wp:group {"className":"vaarta-section-heading vaarta-section-heading--with-deck","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-section-heading vaarta-section-heading--with-deck">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Digital Marketing Secrets', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Expert insights and strategies for stronger digital performance.', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:pattern {"slug":"vaarta/query-featured-grid"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-category-module","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-category-module">
		<!-- wp:group {"className":"vaarta-section-heading","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-section-heading">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Advertising', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		<!-- wp:query {"query":{"perPage":4,"postType":"post","order":"desc","orderBy":"date","inherit":false,"taxQuery":{"category":[<?php echo esc_attr( $advertising_id ); ?>]}},"className":"vaarta-query-module vaarta-query-module--category"} -->
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
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Featured Posts', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"dark","postsToShow":5,"orderBy":"views","showExcerpt":false,"showAuthor":true,"showDate":true,"showReadingTime":false,"showViews":true,"showComments":false} /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->
	<!-- wp:pattern {"slug":"vaarta/social-feed"} /-->
	<!-- wp:pattern {"slug":"vaarta/top-week"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section">
		<!-- wp:vaarta/category-cards {"heading":"Explore Marketing Topics","categorySlugs":["advertising","branding","insights"],"maxCategories":5,"showImage":true,"layout":"grid"} /-->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
