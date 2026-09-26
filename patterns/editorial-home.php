<?php
/**
 * Title: Editorial Homepage
 * Slug: vaarta/editorial-home
 * Categories: vaarta-home
 * Keywords: homepage, magazine, news, editorial, carousel
 * Description: A complete Vaarta homepage composition using the native story carousel and editorial query blocks.
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"32px","bottom":"64px"},"blockGap":"56px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:32px;padding-bottom:64px">
	<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":1,"fontSize":"x-large"} -->
		<h1 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Top Stories', 'caards' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:vaarta/story-carousel {"variant":"wide","postsToShow":6,"columns":4,"autoplay":true,"pageDots":true,"wrapAround":true,"showCategory":true,"showAuthor":true,"showDate":true,"showExcerpt":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e( 'Editor’s Picks', 'caards' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-query {"layout":"tile-type-1","postsToShow":4,"columns":2,"columnGap":40,"rowGap":40,"showCategory":true,"showAuthor":true,"showDate":true,"showExcerpt":false} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e( 'Latest Stories', 'caards' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-query {"layout":"standard-type-1","postsToShow":6,"columns":3,"columnGap":40,"rowGap":48,"showCategory":true,"showAuthor":true,"showDate":true,"showExcerpt":true,"excerptLength":24} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e( 'More to Explore', 'caards' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:vaarta/editorial-query {"layout":"horizontal-type-4","postsToShow":5,"columns":1,"rowGap":28,"offset":6,"showCategory":true,"showAuthor":true,"showDate":true,"showExcerpt":true,"excerptLength":18} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
