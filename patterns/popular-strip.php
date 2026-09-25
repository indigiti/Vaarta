<?php
/**
 * Title: Popular Stories
 * Slug: vaarta/popular-strip
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"wide","className":"vaarta-shell vaarta-popular-strip","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide vaarta-shell vaarta-popular-strip">
	<!-- wp:group {"className":"vaarta-popular-strip__header","layout":{"type":"flex","justifyContent":"space-between"}} -->
	<div class="wp-block-group vaarta-popular-strip__header">
		<!-- wp:heading {"level":2,"fontSize":"sm"} -->
		<h2 class="wp-block-heading has-sm-font-size"><?php echo esc_html__( 'Popular', 'vaarta' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->
	<!-- wp:vaarta/editorial-grid {"layout":"grid","cardStyle":"minimal","postsToShow":4,"orderBy":"views","showExcerpt":false,"showAuthor":false,"showDate":true,"showReadingTime":true,"showViews":true} /-->
</div>
<!-- /wp:group -->
