<?php
/**
 * Title: Top on the Week
 * Slug: vaarta/top-week
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"wide","className":"vaarta-shell","style":{"spacing":{"margin":{"top":"64px","bottom":"64px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide vaarta-shell">
	<!-- wp:heading {"level":2,"fontSize":"xl"} -->
	<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Top on the Week', 'vaarta' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:vaarta/editorial-grid {"layout":"list","cardStyle":"minimal","postsToShow":5,"orderBy":"trending","showViews":true,"showReadingTime":true} /-->
</div>
<!-- /wp:group -->
