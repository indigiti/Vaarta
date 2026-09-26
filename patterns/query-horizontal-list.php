<?php
/**
 * Title: Query — Horizontal Story List
 * Slug: vaarta/query-horizontal-list
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 *
 * @package Vaarta
 */
?>
<!-- wp:query {"query":{"perPage":8,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"vaarta-query-module vaarta-query-module--list"} -->
<div class="wp-block-query vaarta-query-module vaarta-query-module--list">
	<!-- wp:post-template {"className":"vaarta-query-cards vaarta-query-cards--list","layout":{"type":"default"}} -->
		<!-- wp:group {"tagName":"article","className":"vaarta-query-card vaarta-query-card--horizontal","layout":{"type":"default"}} -->
		<article class="wp-block-group vaarta-query-card vaarta-query-card--horizontal">
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","className":"vaarta-query-card__media"} /-->
			<!-- wp:group {"className":"vaarta-query-card__body","layout":{"type":"default"}} -->
			<div class="wp-block-group vaarta-query-card__body">
				<!-- wp:post-terms {"term":"category","fontSize":"xs"} /-->
				<!-- wp:post-title {"isLink":true,"level":2} /-->
				<!-- wp:post-excerpt {"moreText":"","excerptLength":24,"className":"vaarta-query-card__excerpt"} /-->
				<!-- wp:vaarta/story-meta {"showAuthor":false,"showDate":true,"showReadingTime":true,"showViews":true} /-->
			</div>
			<!-- /wp:group -->
		</article>
		<!-- /wp:group -->
	<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
