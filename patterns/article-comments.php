<?php
/**
 * Title: Article Comments
 * Slug: vaarta/article-comments
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 */
?>
<!-- wp:comments {"className":"vaarta-comments"} -->
<div class="wp-block-comments vaarta-comments">
	<!-- wp:comments-title {"showPostTitle":false} /-->

	<!-- wp:comment-template -->
	<!-- wp:columns {"className":"vaarta-comment"} -->
	<div class="wp-block-columns vaarta-comment">
		<!-- wp:column {"width":"48px"} -->
		<div class="wp-block-column" style="flex-basis:48px">
			<!-- wp:avatar {"size":48,"style":{"border":{"radius":"24px"}}} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:comment-author-name {"fontSize":"sm"} /-->
			<!-- wp:group {"className":"vaarta-comment__meta","layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="wp-block-group vaarta-comment__meta">
				<!-- wp:comment-date {"fontSize":"xs"} /-->
				<!-- wp:comment-edit-link {"fontSize":"xs"} /-->
			</div>
			<!-- /wp:group -->
			<!-- wp:comment-content /-->
			<!-- wp:comment-reply-link {"fontSize":"xs"} /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	<!-- /wp:comment-template -->

	<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:comments-pagination-previous /-->
		<!-- wp:comments-pagination-numbers /-->
		<!-- wp:comments-pagination-next /-->
	<!-- /wp:comments-pagination -->

	<!-- wp:post-comments-form /-->
</div>
<!-- /wp:comments -->
