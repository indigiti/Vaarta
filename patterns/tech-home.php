<?php
/**
 * Title: Tech Home
 * Slug: vaarta/tech-home
 * Categories: vaarta, featured
 * Inserter: yes
 *
 * @package Vaarta
 */

$future_tech_category = get_category_by_slug( 'future-tech' );
$gear_category        = get_category_by_slug( 'gear' );
$future_tech_id       = $future_tech_category ? (int) $future_tech_category->term_id : 0;
$gear_id              = $gear_category ? (int) $gear_category->term_id : 0;
?>
<!-- wp:group {"tagName":"main","className":"vaarta-home vaarta-home--tech","layout":{"type":"default"}} -->
<main class="wp-block-group vaarta-home vaarta-home--tech">
	<!-- wp:pattern {"slug":"vaarta/popular-strip"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group vaarta-shell vaarta-hero">
		<!-- wp:paragraph {"align":"center","className":"vaarta-eyebrow","fontSize":"xs"} -->
		<p class="has-text-align-center vaarta-eyebrow has-xs-font-size"><?php echo esc_html__( 'Independent technology journalism', 'vaarta' ); ?></p>
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
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Future Tech', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php echo esc_html__( 'The ideas, systems and breakthroughs changing what comes next.', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:query {"query":{"perPage":4,"postType":"post","order":"desc","orderBy":"date","inherit":false,"taxQuery":{"category":[<?php echo esc_attr( $future_tech_id ); ?>]}},"className":"vaarta-query-module vaarta-query-module--category"} -->
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

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-category-module","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-category-module">
		<!-- wp:group {"className":"vaarta-section-heading vaarta-section-heading--with-deck","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-section-heading vaarta-section-heading--with-deck">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Gear', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Devices, tools and hardware worth understanding.', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:query {"query":{"perPage":4,"postType":"post","order":"desc","orderBy":"date","inherit":false,"taxQuery":{"category":[<?php echo esc_attr( $gear_id ); ?>]}},"className":"vaarta-query-module vaarta-query-module--category"} -->
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

	<!-- wp:pattern {"slug":"vaarta/social-feed"} /-->
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
