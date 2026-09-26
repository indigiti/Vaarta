<?php
/**
 * Title: Latest Stories Grid
 * Slug: vaarta/latest-stories
 * Categories: vaarta-editorial
 * Keywords: latest, posts, grid, stories, archive
 * Description: A reusable latest-stories grid for landing pages and archive-style compositions.
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"32px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:heading {"level":2} -->
	<h2 class="wp-block-heading"><?php esc_html_e( 'Latest Stories', 'caards' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:vaarta/editorial-query {"layout":"standard-type-1","postsToShow":9,"columns":3,"columnGap":40,"rowGap":48,"showCategory":true,"showAuthor":true,"showDate":true,"showExcerpt":true,"excerptLength":22} /-->
</div>
<!-- /wp:group -->
