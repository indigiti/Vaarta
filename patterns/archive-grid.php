<?php
/**
 * Title: Editorial Archive Grid
 * Slug: vaarta/archive-grid
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 */
?>
<!-- wp:query {"className":"vaarta-shell","query":{"perPage":8,"postType":"post","order":"desc","orderBy":"date","inherit":true},"layout":{"type":"default"}} -->
<div class="wp-block-query vaarta-shell">
	<!-- wp:post-template {"className":"vaarta-story-grid","layout":{"type":"default"}} -->
		<!-- wp:group {"tagName":"article","className":"vaarta-story-card","layout":{"type":"constrained"}} -->
		<article class="wp-block-group vaarta-story-card">
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
	<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous /-->
		<!-- wp:query-pagination-numbers /-->
		<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
