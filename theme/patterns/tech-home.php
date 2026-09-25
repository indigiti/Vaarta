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
	<!-- wp:group {"className":"vaarta-shell vaarta-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-group vaarta-shell vaarta-hero">
		<!-- wp:paragraph {"align":"center","fontSize":"sm","textColor":"muted"} -->
		<p class="has-text-align-center has-muted-color has-text-color has-sm-font-size"><?php echo esc_html__( 'Independent technology journalism', 'vaarta' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textAlign":"center","level":1,"className":"vaarta-hero__title","fontSize":"2xl"} -->
		<h1 class="wp-block-heading has-text-align-center vaarta-hero__title has-2-xl-font-size"><?php echo esc_html__( 'Ideas shaping tomorrow.', 'vaarta' ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:navigation {"className":"vaarta-chip-row","overlayMenu":"never","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:query {"className":"vaarta-shell","query":{"perPage":8,"postType":"post","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"default"}} -->
	<div class="wp-block-query vaarta-shell">
		<!-- wp:post-template {"className":"vaarta-story-grid","layout":{"type":"default"}} -->
			<!-- wp:group {"tagName":"article","layout":{"type":"constrained"}} -->
			<article class="wp-block-group">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->
				<!-- wp:post-terms {"term":"category","fontSize":"xs"} /-->
				<!-- wp:post-title {"isLink":true,"fontSize":"xl"} /-->
				<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"}} -->
				<div class="wp-block-group">
					<!-- wp:post-date {"fontSize":"xs","textColor":"muted"} /-->
					<!-- wp:post-author-name {"isLink":true,"fontSize":"xs","textColor":"muted"} /-->
				</div>
				<!-- /wp:group -->
			</article>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</main>
<!-- /wp:group -->
