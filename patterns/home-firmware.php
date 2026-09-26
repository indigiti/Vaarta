<?php
/**
 * Title: Homepage — Firmware Gadgets
 * Slug: vaarta/home-firmware
 * Categories: vaarta, featured
 * Inserter: yes
 *
 * Firmware is composed from WordPress queries and reusable Gutenberg modules.
 * Story content is never hard-coded into this pattern.
 *
 * @package Vaarta
 */

$mobile_category    = get_category_by_slug( 'mobile' );
$computers_category = get_category_by_slug( 'computers' );
$mobile_id          = $mobile_category ? (int) $mobile_category->term_id : 0;
$computers_id       = $computers_category ? (int) $computers_category->term_id : 0;
?>
<!-- wp:group {"tagName":"main","className":"vaarta-home vaarta-home--firmware","layout":{"type":"default"}} -->
<main class="wp-block-group vaarta-home vaarta-home--firmware">
	<!-- wp:pattern {"slug":"vaarta/popular-strip"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-intro","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-intro">
		<!-- wp:paragraph {"className":"vaarta-eyebrow","fontSize":"xs"} -->
		<p class="vaarta-eyebrow has-xs-font-size"><?php echo esc_html__( 'Gadgets · Reviews · Future Tech', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"className":"vaarta-home-intro__title","fontSize":"3xl"} -->
		<h1 class="wp-block-heading vaarta-home-intro__title has-3-xl-font-size"><?php echo esc_html__( 'Discovering Your Next Favorite Gadget', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-home-section--lead","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-home-section--lead">
		<!-- wp:pattern {"slug":"vaarta/query-featured-grid"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-home-section--split","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-home-section--split">
		<!-- wp:columns {"verticalAlignment":"stretch","className":"vaarta-editorial-split","style":{"spacing":{"blockGap":{"left":"32px"}}}} -->
		<div class="wp-block-columns are-vertically-aligned-stretch vaarta-editorial-split">
			<!-- wp:column {"verticalAlignment":"stretch","width":"58%"} -->
			<div class="wp-block-column is-vertically-aligned-stretch" style="flex-basis:58%">
				<!-- wp:group {"className":"vaarta-module-panel","layout":{"type":"default"}} -->
				<div class="wp-block-group vaarta-module-panel">
					<!-- wp:group {"className":"vaarta-section-heading","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
					<div class="wp-block-group vaarta-section-heading">
						<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
						<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Most Discussed', 'vaarta' ); ?></h2>
						<!-- /wp:heading -->
					</div>
					<!-- /wp:group -->
					<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"compact","postsToShow":5,"orderBy":"comment_count","showExcerpt":false,"showAuthor":true,"showDate":true,"showReadingTime":false,"showViews":false,"showComments":true} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"stretch","width":"42%"} -->
			<div class="wp-block-column is-vertically-aligned-stretch" style="flex-basis:42%">
				<!-- wp:group {"className":"vaarta-module-panel vaarta-module-panel--dark","layout":{"type":"default"}} -->
				<div class="wp-block-group vaarta-module-panel vaarta-module-panel--dark">
					<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
					<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Top Weekly', 'vaarta' ); ?></h2>
					<!-- /wp:heading -->
					<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"dark","postsToShow":4,"orderBy":"trending","showExcerpt":false,"showAuthor":false,"showDate":false,"showReadingTime":true,"showViews":true,"showComments":false} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-category-module","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-category-module">
		<!-- wp:group {"className":"vaarta-section-heading vaarta-section-heading--with-deck","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-section-heading vaarta-section-heading--with-deck">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Mobile', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Latest news and reviews on mobile devices and smartphone technology.', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo esc_attr( $mobile_id ); ?>]}},"className":"vaarta-query-module vaarta-query-module--category"} -->
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

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-category-module","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-category-module">
		<!-- wp:group {"className":"vaarta-section-heading vaarta-section-heading--with-deck","layout":{"type":"default"}} -->
		<div class="wp-block-group vaarta-section-heading vaarta-section-heading--with-deck">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Computers', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Insights and updates on desktops, laptops, and computer hardware advancements.', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo esc_attr( $computers_id ); ?>]}},"className":"vaarta-query-module vaarta-query-module--category"} -->
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

	<!-- wp:pattern {"slug":"vaarta/newsletter-callout"} /-->

	<!-- wp:group {"className":"vaarta-shell vaarta-home-section vaarta-home-section--latest","layout":{"type":"default"}} -->
	<div class="wp-block-group vaarta-shell vaarta-home-section vaarta-home-section--latest">
		<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Latest Posts', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:pattern {"slug":"vaarta/query-horizontal-list"} /-->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->
