<?php
/**
 * Title: Category Feature
 * Slug: vaarta/category-feature
 * Categories: vaarta-editorial
 * Keywords: category, feature, section, magazine
 * Description: A reusable category section with one visual lead and a compact supporting story rail.
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"36px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e( 'Featured Category', 'caards' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:vaarta/editorial-query {"layout":"tile-type-3","postsToShow":3,"columns":3,"columnGap":28,"rowGap":28,"showCategory":true,"showAuthor":true,"showDate":true,"showExcerpt":false} /-->

	<!-- wp:vaarta/editorial-query {"layout":"horizontal-type-4","postsToShow":4,"columns":1,"offset":3,"rowGap":24,"showCategory":true,"showAuthor":true,"showDate":true,"showExcerpt":true,"excerptLength":18} /-->
</div>
<!-- /wp:group -->
