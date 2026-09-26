<?php
/**
 * Title: Homepage — Artboard Freebies
 * Slug: vaarta/home-artboard
 * Categories: vaarta, featured
 * Inserter: yes
 *
 * @package Vaarta
 */

$inspiration_category = get_category_by_slug( 'inspiration' );
$inspiration_id       = $inspiration_category ? (int) $inspiration_category->term_id : 0;
?>
<!-- wp:group {"tagName":"main","className":"vaarta-home vaarta-home--artboard","layout":{"type":"default"}} -->
<main class="wp-block-group vaarta-home vaarta-home--artboard">
	<!-- wp:group {"className":"vaarta-shell vaarta-home-intro","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-intro">
		<!-- wp:paragraph {"className":"vaarta-eyebrow","fontSize":"xs"} -->
		<p class="vaarta-eyebrow has-xs-font-size"><?php echo esc_html__( 'Mockups · Templates · Inspiration', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"className":"vaarta-home-intro__title","fontSize":"3xl"} -->
		<h1 class="wp-block-heading vaarta-home-intro__title has-3-xl-font-size"><?php echo esc_html__( 'Welcome to the Ultimate Design Resource Hub!', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-home-section--lead","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-home-section--lead">
		<!-- wp:pattern {"slug":"vaarta/query-featured-grid"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/promo-split"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-category-module","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-category-module">
		<!-- wp:group {"className":"vaarta-section-heading vaarta-section-heading--with-deck","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-section-heading vaarta-section-heading--with-deck">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Inspiration', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Fresh ideas, mockups and resources for creative projects.', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:query {"query":{"perPage":4,"postType":"post","order":"desc","orderBy":"date","inherit":false,"taxQuery":{"category":[<?php echo esc_attr( $inspiration_id ); ?>]}},"className":"vaarta-query-module vaarta-query-module--category"} -->
		<div class="wp-block-query vaarta-query-module vaarta-query-module--category">
			<!-- wp:post-template {"className":"vaarta-query-cards vaarta-query-cards--category","layout":{"type":"default"}} -->
				<!-- wp:group {"tagName":"article","className":"vaarta-query-card vaarta-query-card--category","layout":{"type":"default"}} -->
				<article class="wp-block-group vaarta-query-card vaarta-query-card--category">
					<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","className":"vaarta-query-card__media"} /-->
					<!-- wp:post-terms {"term":"category","fontSize":"xs"} /-->
					<!-- wp:post-title {"isLink":true,"level":2} /-->
					<!-- wp:post-excerpt {"moreText":"","excerptLength":18,"className":"vaarta-query-card__excerpt"} /-->
					<!-- wp:vaarta/story-meta {"showAuthor":false,"showDate":true,"showReadingTime":true,"showViews":true} /-->
				</article>
				<!-- /wp:group -->
			<!-- /wp:post-template -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section">
		<!-- wp:vaarta/category-cards {"heading":"Browse Resources","categorySlugs":["inspiration","templates","branding"],"maxCategories":5,"showImage":true,"layout":"grid"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->
</main>
<!-- /wp:group -->
