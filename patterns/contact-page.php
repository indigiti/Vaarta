<?php
/**
 * Title: Contact Page
 * Slug: vaarta/contact-page
 * Categories: vaarta, vaarta-editorial
 * Inserter: yes
 */
?>
<!-- wp:group {"align":"wide","className":"vaarta-shell vaarta-page-pattern vaarta-page-pattern--contact","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide vaarta-shell vaarta-page-pattern vaarta-page-pattern--contact">
	<!-- wp:columns {"verticalAlignment":"top","style":{"spacing":{"blockGap":{"left":"64px"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-top">
		<!-- wp:column {"verticalAlignment":"top","width":"38%"} -->
		<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:38%">
			<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
			<h2 class="wp-block-heading has-2-xl-font-size"><?php echo esc_html__( 'Let’s talk.', 'vaarta' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php echo esc_html__( 'Questions, pitches, partnerships, corrections and ideas are welcome.', 'vaarta' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:social-links {"className":"is-style-vaarta-pills"} -->
			<ul class="wp-block-social-links is-style-vaarta-pills"></ul>
			<!-- /wp:social-links -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"verticalAlignment":"top","width":"62%"} -->
		<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:62%">
			<!-- wp:vaarta/contact-form /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
