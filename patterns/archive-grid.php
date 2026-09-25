<?php
/**
 * Title: Editorial Archive Grid
 * Slug: vaarta/archive-grid
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 */
?>
<!-- wp:query {"className":"vaarta-archive-grid","query":{"perPage":12,"postType":"post","order":"desc","orderBy":"date","inherit":true},"layout":{"type":"default"}} -->
<div class="wp-block-query vaarta-archive-grid">
	<!-- wp:post-template {"className":"vaarta-story-grid vaarta-archive-grid__stories","layout":{"type":"default"}} -->
		<!-- wp:group {"tagName":"article","className":"vaarta-story-card vaarta-archive-card","layout":{"type":"constrained"}} -->
		<article class="wp-block-group vaarta-story-card vaarta-archive-card">
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->
			<!-- wp:post-terms {"term":"category","fontSize":"xs"} /-->
			<!-- wp:post-title {"isLink":true,"fontSize":"xl"} /-->
			<!-- wp:vaarta/story-meta {"showAuthor":true,"showDate":true,"showReadingTime":true,"showViews":true} /-->
		</article>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-pagination {"className":"vaarta-archive-pagination","layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous /-->
		<!-- wp:query-pagination-numbers /-->
		<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
