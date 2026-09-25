<?php
/**
 * Title: Editorial Section Header
 * Slug: vaarta/section-header
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"bottom":"28px"},"padding":{"bottom":"14px"}},"border":{"bottom":{"color":"var:preset|color|line","width":"1px"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<div class="wp-block-group alignwide" style="border-bottom-color:var(--wp--preset--color--line);border-bottom-width:1px;margin-bottom:28px;padding-bottom:14px">
	<!-- wp:heading {"level":2,"fontSize":"xl"} -->
	<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Latest Stories', 'vaarta' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"fontSize":"sm"} -->
	<p class="has-sm-font-size"><a href="#"><?php echo esc_html__( 'View all', 'vaarta' ); ?></a></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
