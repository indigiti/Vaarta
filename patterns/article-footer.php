<?php
/**
 * Title: Article Footer
 * Slug: vaarta/article-footer
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 *
 * @package Vaarta
 */
?>
<!-- wp:group {"className":"vaarta-article-footer","style":{"spacing":{"blockGap":"40px","margin":{"top":"56px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group vaarta-article-footer">
	<!-- wp:post-terms {"term":"post_tag","className":"vaarta-article-footer__tags"} /-->
	<!-- wp:vaarta/social-share {"styleVariant":"light"} /-->
	<!-- wp:vaarta/author-box /-->
	<!-- wp:vaarta/contributors {"layout":"compact","showBio":false} /-->

	<!-- wp:group {"className":"vaarta-article-navigation","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
	<div class="wp-block-group vaarta-article-navigation">
		<!-- wp:post-navigation-link {"type":"previous","showTitle":true,"linkLabel":true} /-->
		<!-- wp:post-navigation-link {"type":"next","showTitle":true,"linkLabel":true} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:vaarta/related-posts {"postsToShow":3,"layout":"grid"} /-->
	<!-- wp:pattern {"slug":"vaarta/article-comments"} /-->
</div>
<!-- /wp:group -->
