<?php
/**
 * Powerkit Filters
 *
 * @package Caards
 */

/**
 * New Share Buttons Locations
 *
 * @param array $locations List of Locations.
 */
function csco_powerkit_new_share_buttons_locations( $locations = array() ) {

	$locations['after-post'] = array(
		'shares'         => array( 'facebook', 'twitter', 'pinterest' ),
		'name'           => esc_html__( 'After Post Content', 'caards' ),
		'location'       => 'after-post',
		'mode'           => 'mixed',
		'before'         => '',
		'after'          => '',
		'display'        => true,
		'meta'           => array(
			'icons'  => true,
			'titles' => false,
			'labels' => false,
		),
		'fields'         => array(
			'display_total'   => true,
			'display_count'   => true,
			'schemes'         => array( 'default', 'bold', 'bold-bg', 'simple-light', 'bold-light' ),
			'count_locations' => array( 'inside' ),
		),
		'display_total'  => false,
		'layout'         => 'simple',
		'scheme'         => 'bold-light',
		'count_location' => 'inside',
	);

	$locations['metabar-post'] = array(
		'shares'         => array( 'facebook', 'twitter', 'pinterest' ),
		'name'           => esc_html__( 'Entry Metabar', 'caards' ),
		'location'       => 'metabar-post',
		'mode'           => 'mixed',
		'before'         => '',
		'after'          => '',
		'display'        => true,
		'meta'           => array(
			'icons'  => true,
			'titles' => false,
			'labels' => false,
		),
		// Display only the specified layouts and color schemes.
		'fields'         => array(
			'display_total'   => true,
			'display_count'   => true,
			'layouts'         => array( 'simple' ),
			'schemes'         => array( 'simple-light', 'bold-light' ),
			'count_locations' => array( 'inside' ),
		),
		'layout'         => 'simple',
		'scheme'         => 'simple-light',
		'count_location' => 'inside',
	);

	$locations['post-meta'] = array(
		'shares'         => array( 'facebook', 'twitter', 'pinterest' ),
		'name'           => esc_html__( 'Post Meta', 'caards' ),
		'location'       => 'post-meta',
		'mode'           => 'cached',
		'before'         => '',
		'after'          => '',
		'display'        => true,
		'meta'           => array(
			'icons'  => true,
			'titles' => false,
			'labels' => false,
		),
		// Display only the specified layouts and color schemes.
		'fields'         => array(
			'layouts'         => array( 'simple' ),
			'schemes'         => array( 'simple-light', 'bold-light' ),
			'count_locations' => array( 'inside' ),
		),
		'display_total'  => false,
		'layout'         => 'simple',
		'scheme'         => 'simple-light',
		'count_location' => 'inside',
	);

	return $locations;
}
add_filter( 'powerkit_share_buttons_locations', 'csco_powerkit_new_share_buttons_locations' );

/**
 * Change Share Buttons Locations
 *
 * @param array $locations List of Locations.
 */
function csco_powerkit_change_share_buttons_locations( $locations = array() ) {

	unset( $locations['before-content'] );
	unset( $locations['after-content'] );

	$locations['highlight-text'] = array(
		'shares'        => array( 'facebook', 'twitter', 'pinterest', 'mail' ),
		'name'          => '⚡ Highlight Text',
		'location'      => 'highlight-text',
		'mode'          => 'none',
		'before'        => '',
		'after'         => '',
		'meta'          => array(
			'icons'  => true,
			'titles' => false,
			'labels' => false,
		),
		'fields'        => array(
			'display_total'   => false,
			'display_count'   => false,
			'title_locations' => array(),
			'count_locations' => array(),
			'label_locations' => array(),
			'layouts'         => array( 'simple' ),
			'schemes'         => array( 'simple-light', 'bold-light' ),
		),
		'display_total' => false,
		'layout'        => 'simple',
		'scheme'        => 'simple-light',
		'attrs'         => 'data-scheme="default"',
	);

	$locations['blockquote'] = array(
		'shares'        => array( 'facebook', 'twitter' ),
		'name'          => '⭐ Blockquote',
		'location'      => 'blockquote',
		'mode'          => 'none',
		'before'        => '',
		'after'         => '',
		'meta'          => array(
			'icons'  => true,
			'titles' => false,
			'labels' => true,
		),
		'fields'        => array(
			'display_total'   => false,
			'display_count'   => false,
			'title_locations' => array(),
			'count_locations' => array(),
			'label_locations' => array(),
			'layouts'         => array( 'simple' ),
			'schemes'         => array( 'simple-light', 'bold-light' ),
		),
		'display_total' => false,
		'layout'        => 'simple',
		'scheme'        => 'simple-light',
	);

	$locations['mobile-share'] = array(
		'shares'   => array( 'facebook', 'pinterest', 'twitter', 'mail' ),
		'name'     => '📱 Mobile Share',
		'location' => 'mobile-share',
		'mode'     => 'none',
		'before'   => '',
		'after'    => '',
		'meta'     => array(
			'icons'  => true,
			'titles' => false,
			'labels' => false,
		),
		'fields'   => array(
			'display_total'   => false,
			'display_count'   => true,
			'title_locations' => array(),
			'count_locations' => array(),
			'label_locations' => array(),
			'schemes'         => array( 'default', 'simple-dark-back', 'bold-bg', 'bold' ),
			'layouts'         => array( 'horizontal', 'left-side', 'right-side', 'popup' ),
		),
		'layout'   => 'horizontal',
	);

	$locations['block-posts']['display_count'] = true;

	return $locations;
}
add_filter( 'powerkit_share_buttons_locations', 'csco_powerkit_change_share_buttons_locations', 9999 );

function csco_powerkit_share_buttons_total_output( $total_output, $class, $total_count ) {
	$total_output  = '<div class="pk-share-buttons-count pk-font-primary">' . esc_html( $total_count ) . '</div>';
	$total_output .= '<div class="pk-share-buttons-label pk-font-primary">' . esc_html__( 'Share', 'caards' ) . '</div>';

	return $total_output;
}
add_filter( 'powerkit_share_buttons_total_output', 'csco_powerkit_share_buttons_total_output', 10, 3 );

/**
 * Register Floated Share Buttons Location
 */
function csco_powerkit_widget_author_image_size() {
	return 'csco-thumbnail-uncropped';
}
add_filter( 'powerkit_widget_author_image_size', 'csco_powerkit_widget_author_image_size' );

/**
 * Change Contributors widget post author description length.
 */
function csco_powerkit_widget_contributors_description_length() {
	return 80;
}
add_filter( 'powerkit_widget_contributors_description_length', 'csco_powerkit_widget_contributors_description_length' );


/**
 * Change Default Template for featured posts
 *
 * @param array $templates The templates.
 */
function csco_powerkit_featured_posts_default( $templates = array() ) {

	$templates['list']['func']     = 'csco_powerkit_featured_default_template';
	$templates['numbered']['func'] = 'csco_powerkit_featured_default_template';
	$templates['large']['func']    = 'csco_powerkit_featured_default_template';

	$templates['tile'] = array(
		'name' => esc_html__( 'Tile', 'caards' ),
		'func' => 'csco_powerkit_featured_default_template',
	);

	return $templates;
}
add_filter( 'powerkit_featured_posts_templates', 'csco_powerkit_featured_posts_default' );

/**
 * Add new settings to Widget Posts
 *
 * @param array $settings The settings.
 */
function csco_powerkit_widget_posts_settings( $settings ) {

	$settings = array_merge(
		$settings,
		array(
			'image_orientation'  => 'square',
			'image_size'         => 'csco-smaller',
			'image_radius'       => '',
			'featured_image'     => false,
			'post_meta'          => array( 'category', 'reading_time' ),
			'post_meta_category' => true,
		)
	);

	return $settings;
}
add_filter( 'powerkit_widget_posts_settings', 'csco_powerkit_widget_posts_settings' );

/**
 * Add new field to Widget Posts
 *
 * @param object $context  The context.
 * @param array  $params   The params.
 * @param array  $instance Current settings.
 */
function csco_powerkit_widget_posts_form_after( $context, $params, $instance ) {
	$image_sizes = csco_get_list_available_image_sizes();
	?>
		<!-- Image Orientation -->
		<p>
			<label for="<?php echo esc_attr( $context->get_field_id( 'image_orientation' ) ); ?>"><?php esc_html_e( 'Image Orientation', 'caards' ); ?>:</label>
			<select name="<?php echo esc_attr( $context->get_field_name( 'image_orientation' ) ); ?>" id="<?php echo esc_attr( $context->get_field_id( 'image_orientation' ) ); ?>" class="widefat">
				<option value="original" <?php selected( $params['image_orientation'], 'original' ); ?>><?php esc_html_e( 'Original', 'caards' ); ?></option>
				<option value="landscape" <?php selected( $params['image_orientation'], 'landscape' ); ?>><?php esc_html_e( 'Landscape', 'caards' ); ?></option>
				<option value="portrait" <?php selected( $params['image_orientation'], 'portrait' ); ?>><?php esc_html_e( 'Portrait', 'caards' ); ?></option>
				<option value="square" <?php selected( $params['image_orientation'], 'square' ); ?>><?php esc_html_e( 'Square', 'caards' ); ?></option>
			</select>
		</p>

		<!-- Images Size -->
		<p>
			<label for="<?php echo esc_attr( $context->get_field_id( 'image_size' ) ); ?>"><?php esc_html_e( 'Images Size', 'caards' ); ?>:</label>
			<select name="<?php echo esc_attr( $context->get_field_name( 'image_size' ) ); ?>" id="<?php echo esc_attr( $context->get_field_id( 'image_size' ) ); ?>" class="widefat">
				<?php foreach ( $image_sizes as $key => $size ) { ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $params['image_size'], $key ); ?>><?php echo esc_html( $size ); ?></option>
				<?php } ?>
			</select>
		</p>

		<!-- Image Border Radius -->
		<p>
			<label for="<?php echo esc_attr( $context->get_field_id( 'image_radius' ) ); ?>"><?php esc_html_e( 'Image Border Radius', 'caards' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $context->get_field_id( 'image_radius' ) ); ?>" class="checkbox" name="<?php echo esc_attr( $context->get_field_name( 'image_radius' ) ); ?>" type="text" value="<?php echo esc_attr( $params['image_radius'] ); ?>" />
		</p>

		<!-- Display Featured Image -->
		<p>
			<input id="<?php echo esc_attr( $context->get_field_id( 'featured_image' ) ); ?>" class="checkbox" name="<?php echo esc_attr( $context->get_field_name( 'featured_image' ) ); ?>" type="checkbox" <?php checked( (bool) $params['featured_image'] ); ?>>
			<label for="<?php echo esc_attr( $context->get_field_id( 'featured_image' ) ); ?>"><?php esc_html_e( 'Display featured image', 'caards' ); ?></label>
		</p>
	<?php
}
add_action( 'powerkit_widget_posts_form_after', 'csco_powerkit_widget_posts_form_after', 10, 3 );

/**
 * Featured Default Template Callback
 *
 * @param  array $posts    Array of posts.
 * @param  array $params   Array of params.
 * @param  array $instance Widget instance.
 */
function csco_powerkit_featured_default_template( $posts, $params, $instance ) {

	$style = null;

	if ( $params['image_radius'] ) {
		$style = sprintf( '--cs-image-border-radius: %s;', $params['image_radius'] );
	}

	$featured_image = false;
	if ( isset( $params['featured_image'] ) && $params['featured_image'] ) {
		$featured_image = true;
	}

	if ( 'list' === $params['template'] ) {
		?>
		<article <?php post_class(); ?> style="<?php echo esc_attr( $style ); ?>">

			<div class="pk-post-outer">
				<?php if ( has_post_thumbnail() && $featured_image ) { ?>
					<div class="pk-post-inner pk-post-thumbnail cs-entry__inner cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $params['image_orientation'] ); ?>">
						<div class="cs-overlay-background cs-overlay-transparent">
							<?php the_post_thumbnail( $params['image_size'] ); ?>
						</div>

						<a class="cs-overlay-link" href="<?php echo esc_url( get_permalink() ); ?>"></a>
					</div>
				<?php } ?>

				<div class="pk-post-inner pk-post-data">
					<?php csco_get_post_meta( array( 'category', 'author', 'date', 'views', 'shares', 'reading_time', 'comments' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>

					<?php the_title( '<h5 class="cs-entry__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h5>' ); ?>
				</div>
			</div>

		</article>
		<?php

	} elseif ( 'numbered' === $params['template'] ) {
		?>
		<article <?php post_class(); ?> style="<?php echo esc_attr( $style ); ?>">

			<div class="pk-post-outer">
				<?php if ( has_post_thumbnail() && $featured_image ) { ?>
					<div class="pk-post-inner pk-post-thumbnail cs-entry__inner cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $params['image_orientation'] ); ?>">
						<div class="cs-overlay-background cs-overlay-transparent">
							<?php the_post_thumbnail( $params['image_size'] ); ?>
							<span class="pk-post-number pk-bg-primary">1</span>
						</div>

						<a class="cs-overlay-link" href="<?php echo esc_url( get_permalink() ); ?>"></a>
					</div>
				<?php } ?>

				<div class="pk-post-inner pk-post-data">
					<?php csco_get_post_meta( array( 'category' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>

					<?php the_title( '<h5 class="cs-entry__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h5>' ); ?>

					<?php csco_get_post_meta( array( 'author', 'date', 'views', 'shares', 'reading_time', 'comments' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>
				</div>
			</div>

		</article>
		<?php
	} elseif ( 'large' === $params['template'] ) {
		?>
		<article <?php post_class(); ?> style="<?php echo esc_attr( $style ); ?>">

			<div class="pk-post-outer">
				<?php if ( has_post_thumbnail() && $featured_image ) { ?>
					<div class="pk-post-inner pk-post-thumbnail cs-entry__inner cs-entry__thumbnail cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr( $params['image_orientation'] ); ?>">
						<div class="cs-overlay-background cs-overlay-transparent">
							<?php the_post_thumbnail( $params['image_size'] ); ?>
						</div>

						<?php csco_get_video_background( 'archive' ); ?>

						<?php csco_the_post_format_icon(); ?>

						<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
					</div>
				<?php } ?>
				<div class="pk-post-inner pk-post-data">
					<?php csco_get_post_meta( array( 'category' ), false, true, $params['post_meta'] ); ?>

					<?php the_title( '<h5 class="cs-entry__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h5>' ); ?>

					<?php csco_get_post_meta( array( 'author', 'date', 'views', 'shares', 'reading_time', 'comments' ), (bool) $params['post_meta_compact'], true, $params['post_meta'] ); ?>
				</div>
			</div>

		</article>
		<?php
	}
}

/**
 * Add exclude selectors of TOC
 *
 * @param string $list List selectors.
 */
function csco_powerkit_toc_exclude_selectors( $list ) {
	$list .= '|.cs-entry__title';

	return $list;
}
add_filter( 'pk_toc_exclude', 'csco_powerkit_toc_exclude_selectors' );

/**
 * Register twitter layouts
 *
 * @param array $layouts List of layouts.
 */
function csco_canvas_register_twitter_layouts( $layouts ) {
	$layouts['default'] = array(
		'name' => esc_html__( 'Default', 'caards' ),
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
			<path d="M22 5.924C21.264 6.25 20.473 6.471 19.643 6.57C20.49 6.062 21.141 5.258 21.447 4.3C20.654 4.77 19.777 5.112 18.841 5.296C18.095 4.498 17.028 4 15.848 4C13.582 4 11.745 5.837 11.745 8.103C11.745 8.425 11.781 8.738 11.851 9.038C8.441 8.868 5.418 7.234 3.394 4.751C3.041 5.358 2.838 6.063 2.838 6.815C2.838 8.239 3.562 9.495 4.663 10.23C3.99 10.208 3.358 10.023 2.803 9.716V9.768C2.803 11.756 4.218 13.415 6.096 13.791C5.752 13.886 5.389 13.936 5.016 13.936C4.751 13.936 4.494 13.91 4.243 13.862C4.765 15.492 6.281 16.679 8.076 16.712C6.672 17.812 4.902 18.469 2.98 18.469C2.648 18.469 2.32 18.449 2 18.412C3.816 19.576 5.973 20.255 8.29 20.255C15.837 20.255 19.965 14.003 19.965 8.58C19.965 8.402 19.961 8.225 19.953 8.05C20.755 7.472 21.45 6.75 22 5.926V5.924Z" />
		</svg>',
	);

	$layouts['carousel'] = array(
		'name'        => esc_html__( 'Carousel', 'caards' ),
		'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
			<path d="M22 5.924C21.264 6.25 20.473 6.471 19.643 6.57C20.49 6.062 21.141 5.258 21.447 4.3C20.654 4.77 19.777 5.112 18.841 5.296C18.095 4.498 17.028 4 15.848 4C13.582 4 11.745 5.837 11.745 8.103C11.745 8.425 11.781 8.738 11.851 9.038C8.441 8.868 5.418 7.234 3.394 4.751C3.041 5.358 2.838 6.063 2.838 6.815C2.838 8.239 3.562 9.495 4.663 10.23C3.99 10.208 3.358 10.023 2.803 9.716V9.768C2.803 11.756 4.218 13.415 6.096 13.791C5.752 13.886 5.389 13.936 5.016 13.936C4.751 13.936 4.494 13.91 4.243 13.862C4.765 15.492 6.281 16.679 8.076 16.712C6.672 17.812 4.902 18.469 2.98 18.469C2.648 18.469 2.32 18.449 2 18.412C3.816 19.576 5.973 20.255 8.29 20.255C15.837 20.255 19.965 14.003 19.965 8.58C19.965 8.402 19.961 8.225 19.953 8.05C20.755 7.472 21.45 6.75 22 5.926V5.924Z" />
		</svg>',
		'hide_fields' => array(
			'columns',
		),
		'template'    => get_template_directory() . '/template-parts/blocks/twitter-carousel.php',
	);

	return $layouts;
}
add_filter( 'canvas_block_layouts_canvas/twitter', 'csco_canvas_register_twitter_layouts' );

/**
 * Add Twitter Carousel Template
 *
 * @param array $templates The templates.
 */
function csco_carousel_register_twitter_template( $templates = array() ) {
	$templates['carousel'] = array(
		'name' => esc_html__( 'Carousel', 'caards' ),
		'func' => 'csco_powerkit_twitter_carousel_template',
	);

	return $templates;
}
add_filter( 'powerkit_twitter_templates', 'csco_carousel_register_twitter_template' );

/**
 * Twitter Carousel Callback Function Template
 *
 * @param array $tweets List of tweets.
 * @param array $params Parameters.
 */
function csco_powerkit_twitter_carousel_template( $tweets, $params ) {

	$template = isset( $params['template'] ) ? $params['template'] : 'default';

	if ( isset( $tweets['items'] ) && $tweets['items'] ) {
		$counter = 1;
		?>
		<div class="cs-twitter-carousel cs-flickity-init" data-autoplay="false" data-wraparound=true>
			<div class="cs-twitter-carousel__items">
				<?php
				foreach ( $tweets['items'] as $tweet ) {

					if ( $counter > $params['number'] ) {
						break;
					}

					$time = powerkit_relative_time( $tweet['date'] );
					$text = powerkit_twitter_convert_links( $tweet['text'] );
					?>
						<div class="cs-twitter-carousel__cell">
							<div class="pk-twitter-wrap pk-twitter-default">

								<?php
								if ( $params['header'] ) {
									?>
									<div class="pk-twitter-header">
										<div class="pk-twitter-container">

											<?php $tag = apply_filters( 'powerkit_twitter_name_tag', 'h6' ); ?>

											<div class="pk-twitter-info">
												<<?php echo esc_html( $tag ); ?> class="pk-twitter-name pk-title pk-font-heading">
													<a href="<?php echo esc_url( sprintf( 'https://twitter.com/%s/', $tweets['username'] ) ); ?>" target="_blank">
														<?php echo esc_html( $tweets['name'] ); ?>
													</a>
												</<?php echo esc_html( $tag ); ?>>

												<?php if ( $tweets['name'] !== $tweets['username'] ) { ?>
													<span class="pk-twitter-username pk-color-secondary">
														<a href="<?php echo esc_url( sprintf( 'https://twitter.com/%s/', $tweets['username'] ) ); ?>" target="_blank">
														@<?php echo wp_kses_post( $tweets['username'] ); ?>
														</a>
													</span>
												<?php } ?>
											</div>
										</div>
									</div>
									<?php
								}
								?>

								<div class="pk-tweets">
									<div class="pk-twitter-tweet">
										<div class="pk-twitter-content">
											<?php echo wp_kses_post( $text ); ?>
										</div>

										<a href="https://twitter.com/<?php echo esc_attr( $tweets['username'] ); ?>/status/<?php echo esc_attr( $tweet['tweet_id'] ); ?>" class="pk-twitter-time pk-font-secondary timestamp" target="_blank"><?php echo esc_html( $time ); ?></a>

										<div class="pk-twitter-actions">
											<ul>
												<li>
													<a onClick="window.open('https://twitter.com/intent/tweet?in_reply_to=<?php echo esc_attr( $tweet['tweet_id'] ); ?>','Twitter','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" class="tweet-reply" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo esc_attr( $tweet['tweet_id'] ); ?>">
														<i class="pk-icon pk-icon-reply"></i>
														<span class="pk-twitter-label pk-twitter-reply"><?php esc_html_e( 'Reply', 'caards' ); ?></span>
													</a>
												</li>
												<li>
													<a onClick="window.open('https://twitter.com/intent/retweet?tweet_id=<?php echo esc_attr( $tweet['tweet_id'] ); ?>','Twitter','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" class="tweet-retweet" href="https://twitter.com/intent/retweet?tweet_id=<?php echo esc_attr( $tweet['tweet_id'] ); ?>">
														<i class="pk-icon pk-icon-retweet"></i>
														<span class="pk-twitter-count"><?php echo wp_kses_post( $tweet['retweets'] ? $tweet['retweets'] : '' ); ?></span>
														<span class="pk-twitter-label pk-twitter-retweet"><?php esc_html_e( 'Retweet', 'caards' ); ?></span>
													</a>
												</li>
												<li>
													<a onClick="window.open('https://twitter.com/intent/favorite?tweet_id=<?php echo esc_attr( $tweet['tweet_id'] ); ?>','Twitter','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" class="tweet-favorite" href="https://twitter.com/intent/favorite?tweet_id=<?php echo esc_attr( $tweet['tweet_id'] ); ?>">
														<i class="pk-icon pk-icon-like"></i>
														<span class="pk-twitter-label pk-twitter-favorite"><?php esc_html_e( 'Favorite', 'caards' ); ?></span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="cs-twitter-footer">
									<div class="cs-twitter-footer__wrapper">
										<div class="cs-twitter-footer__item">
											<div class="cs-twitter-footer__inner">
												<span class="pk-twitter-username">
													<a href="<?php echo esc_url( sprintf( 'https://twitter.com/%s/', $tweets['username'] ) ); ?>" target="_blank">
														@<?php echo wp_kses_post( $tweets['username'] ); ?>
													</a>
												</span>
											</div>
											<div class="cs-twitter-footer__inner">
												<div class="pk-twitter-counters">
													<div class="counter followers">
														<span class="number"><?php echo esc_html( powerkit_abridged_number( $tweets['followers'], 0 ) ); ?></span> <?php esc_html_e( 'Followers', 'caards' ); ?>
													</div>
												</div>
											</div>
										</div>
										<div class="cs-twitter-footer__item cs-twitter-footer__item-hidden">
											<?php if ( $params['button'] ) { ?>
												<div class="cs-twitter-footer__inner">
													<span class="pk-twitter-username">
														<a href="<?php echo esc_url( sprintf( 'https://twitter.com/%s/', $tweets['username'] ) ); ?>" target="_blank">
															<?php esc_html_e( 'follow', 'caards' ); ?>
														</a>
													</span>
												</div>
											<?php } ?>

											<div class="cs-twitter-footer__inner">
												<div class="pk-twitter-counters">
													<div class="counter following">
														<span class="number"><?php echo esc_html( powerkit_abridged_number( $tweets['following'], 0 ) ); ?></span> <?php esc_html_e( 'Following', 'caards' ); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<a class="cs-overlay-link" href="<?php echo esc_url( sprintf( 'https://twitter.com/%s/', $tweets['username'] ) ); ?>" target="_blank"></a>
							</div>
						</div>
					<?php
				}
				?>
			</div>
			<div class="cs-twitter-carousel__arrows">
				<span class="cs-twitter-carousel__arrow cs-twitter-carousel__arrow-previous carousel-previous"></span>
				<span class="cs-twitter-carousel__arrow cs-twitter-carousel__arrow-next carousel-next"></span>
			</div>
		</div>
		<?php
	} else {
		?>
			<p><?php esc_html_e( 'Twitter user not found. Please check your Twitter User ID.', 'caards' ); ?></p>
		<?php
	}
}

/**
 * Register instagram layouts
 *
 * @param array $layouts List of layouts.
 */
function csco_canvas_register_instagram_layouts( $layouts ) {
	$layouts['default'] = array(
		'name' => esc_html__( 'Default', 'caards' ),
		'icon' => '
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
				<path fill="#000" d="M12 4.622c2.403 0 2.688.01 3.637.052.877.04 1.354.187 1.67.31.42.163.72.358 1.036.673.315.315.51.615.673 1.035.123.317.27.794.31 1.67.043.95.052 1.235.052 3.638s-.01 2.688-.052 3.637c-.04.877-.187 1.354-.31 1.67-.163.42-.358.72-.673 1.036-.315.315-.615.51-1.035.673-.317.123-.794.27-1.67.31-.95.043-1.234.052-3.638.052s-2.688-.01-3.637-.052c-.877-.04-1.354-.187-1.67-.31-.42-.163-.72-.358-1.036-.673-.315-.315-.51-.615-.673-1.035-.123-.317-.27-.794-.31-1.67-.043-.95-.052-1.235-.052-3.638s.01-2.688.052-3.637c.04-.877.187-1.354.31-1.67.163-.42.358-.72.673-1.036.315-.315.615-.51 1.035-.673.317-.123.794-.27 1.67-.31.95-.043 1.235-.052 3.638-.052M12 3c-2.444 0-2.75.01-3.71.054s-1.613.196-2.185.418c-.592.23-1.094.538-1.594 1.04-.5.5-.807 1-1.037 1.593-.223.572-.375 1.226-.42 2.184C3.01 9.25 3 9.555 3 12s.01 2.75.054 3.71.196 1.613.418 2.186c.23.592.538 1.094 1.038 1.594s1.002.808 1.594 1.038c.572.222 1.227.375 2.185.418.96.044 1.266.054 3.71.054s2.75-.01 3.71-.054 1.613-.196 2.186-.418c.592-.23 1.094-.538 1.594-1.038s.808-1.002 1.038-1.594c.222-.572.375-1.227.418-2.185.044-.96.054-1.266.054-3.71s-.01-2.75-.054-3.71-.196-1.613-.418-2.186c-.23-.592-.538-1.094-1.038-1.594s-1.002-.808-1.594-1.038c-.572-.222-1.227-.375-2.185-.418C14.75 3.01 14.445 3 12 3zm0 4.378c-2.552 0-4.622 2.07-4.622 4.622s2.07 4.622 4.622 4.622 4.622-2.07 4.622-4.622S14.552 7.378 12 7.378zM12 15c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3zm4.804-8.884c-.596 0-1.08.484-1.08 1.08s.484 1.08 1.08 1.08c.596 0 1.08-.484 1.08-1.08s-.483-1.08-1.08-1.08z" />
			</svg>
		',
	);

	$layouts['carousel'] = array(
		'name'        => esc_html__( 'Carousel', 'caards' ),
		'icon'        => '
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
				<path fill="#000" d="M12 4.622c2.403 0 2.688.01 3.637.052.877.04 1.354.187 1.67.31.42.163.72.358 1.036.673.315.315.51.615.673 1.035.123.317.27.794.31 1.67.043.95.052 1.235.052 3.638s-.01 2.688-.052 3.637c-.04.877-.187 1.354-.31 1.67-.163.42-.358.72-.673 1.036-.315.315-.615.51-1.035.673-.317.123-.794.27-1.67.31-.95.043-1.234.052-3.638.052s-2.688-.01-3.637-.052c-.877-.04-1.354-.187-1.67-.31-.42-.163-.72-.358-1.036-.673-.315-.315-.51-.615-.673-1.035-.123-.317-.27-.794-.31-1.67-.043-.95-.052-1.235-.052-3.638s.01-2.688.052-3.637c.04-.877.187-1.354.31-1.67.163-.42.358-.72.673-1.036.315-.315.615-.51 1.035-.673.317-.123.794-.27 1.67-.31.95-.043 1.235-.052 3.638-.052M12 3c-2.444 0-2.75.01-3.71.054s-1.613.196-2.185.418c-.592.23-1.094.538-1.594 1.04-.5.5-.807 1-1.037 1.593-.223.572-.375 1.226-.42 2.184C3.01 9.25 3 9.555 3 12s.01 2.75.054 3.71.196 1.613.418 2.186c.23.592.538 1.094 1.038 1.594s1.002.808 1.594 1.038c.572.222 1.227.375 2.185.418.96.044 1.266.054 3.71.054s2.75-.01 3.71-.054 1.613-.196 2.186-.418c.592-.23 1.094-.538 1.594-1.038s.808-1.002 1.038-1.594c.222-.572.375-1.227.418-2.185.044-.96.054-1.266.054-3.71s-.01-2.75-.054-3.71-.196-1.613-.418-2.186c-.23-.592-.538-1.094-1.038-1.594s-1.002-.808-1.594-1.038c-.572-.222-1.227-.375-2.185-.418C14.75 3.01 14.445 3 12 3zm0 4.378c-2.552 0-4.622 2.07-4.622 4.622s2.07 4.622 4.622 4.622 4.622-2.07 4.622-4.622S14.552 7.378 12 7.378zM12 15c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3zm4.804-8.884c-.596 0-1.08.484-1.08 1.08s.484 1.08 1.08 1.08c.596 0 1.08-.484 1.08-1.08s-.483-1.08-1.08-1.08z" />
			</svg>
		',
		'location'    => array(),
		'sections'    => array(),
		'hide_fields' => array(
			'columns',
		),
		'fields'      => array(),
		'template'    => get_template_directory() . '/template-parts/blocks/instagram-carousel.php',
	);

	$layouts['carousel-full'] = array(
		'name'        => esc_html__( 'Diagonal Carousel', 'caards' ),
		'icon'        => '
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
				<path fill="#000" d="M12 4.622c2.403 0 2.688.01 3.637.052.877.04 1.354.187 1.67.31.42.163.72.358 1.036.673.315.315.51.615.673 1.035.123.317.27.794.31 1.67.043.95.052 1.235.052 3.638s-.01 2.688-.052 3.637c-.04.877-.187 1.354-.31 1.67-.163.42-.358.72-.673 1.036-.315.315-.615.51-1.035.673-.317.123-.794.27-1.67.31-.95.043-1.234.052-3.638.052s-2.688-.01-3.637-.052c-.877-.04-1.354-.187-1.67-.31-.42-.163-.72-.358-1.036-.673-.315-.315-.51-.615-.673-1.035-.123-.317-.27-.794-.31-1.67-.043-.95-.052-1.235-.052-3.638s.01-2.688.052-3.637c.04-.877.187-1.354.31-1.67.163-.42.358-.72.673-1.036.315-.315.615-.51 1.035-.673.317-.123.794-.27 1.67-.31.95-.043 1.235-.052 3.638-.052M12 3c-2.444 0-2.75.01-3.71.054s-1.613.196-2.185.418c-.592.23-1.094.538-1.594 1.04-.5.5-.807 1-1.037 1.593-.223.572-.375 1.226-.42 2.184C3.01 9.25 3 9.555 3 12s.01 2.75.054 3.71.196 1.613.418 2.186c.23.592.538 1.094 1.038 1.594s1.002.808 1.594 1.038c.572.222 1.227.375 2.185.418.96.044 1.266.054 3.71.054s2.75-.01 3.71-.054 1.613-.196 2.186-.418c.592-.23 1.094-.538 1.594-1.038s.808-1.002 1.038-1.594c.222-.572.375-1.227.418-2.185.044-.96.054-1.266.054-3.71s-.01-2.75-.054-3.71-.196-1.613-.418-2.186c-.23-.592-.538-1.094-1.038-1.594s-1.002-.808-1.594-1.038c-.572-.222-1.227-.375-2.185-.418C14.75 3.01 14.445 3 12 3zm0 4.378c-2.552 0-4.622 2.07-4.622 4.622s2.07 4.622 4.622 4.622 4.622-2.07 4.622-4.622S14.552 7.378 12 7.378zM12 15c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3zm4.804-8.884c-.596 0-1.08.484-1.08 1.08s.484 1.08 1.08 1.08c.596 0 1.08-.484 1.08-1.08s-.483-1.08-1.08-1.08z" />
			</svg>
		',
		'location'    => array(),
		'sections'    => array(),
		'hide_fields' => array(
			'columns',
		),
		'fields'      => array(
			array(
				'key'        => 'card_min_height',
				'label'      => esc_html__( 'Card Min Height', 'caards' ),
				'type'       => 'dimension',
				'section'    => 'general',
				'responsive' => true,
				'default'    => '480px',
				'output'     => array(
					array(
						'element'  => '$',
						'property' => '--cs-card-min-height',
						'suffix'   => '!important',
					),
				),
			),
		),
		'template'    => get_template_directory() . '/template-parts/blocks/instagram-carousel.php',
	);

	return $layouts;
}
add_filter( 'canvas_block_layouts_canvas/instagram', 'csco_canvas_register_instagram_layouts' );

/**
 * Add Instagram Carousel Template
 *
 * @param array $templates The templates.
 */
function csco_carousel_register_instagram_template( $templates = array() ) {
	$templates['carousel'] = array(
		'name' => esc_html__( 'Carousel', 'caards' ),
		'func' => 'csco_powerkit_instagram_carousel_template',
	);

	$templates['carousel-full'] = array(
		'name' => esc_html__( 'Diagonal Carousel', 'caards' ),
		'func' => 'csco_powerkit_instagram_diagonal_carousel_template',
	);

	return $templates;
}
add_filter( 'powerkit_instagram_templates', 'csco_carousel_register_instagram_template' );

/**
 * Instagram Carousel Callback Function Template
 *
 * @param array $feed      The instagram feed.
 * @param array $instagram The instagram items.
 * @param array $params    The user parameters.
 */
function csco_powerkit_instagram_carousel_template( $feed, $instagram, $params ) {

	$instagram = array_merge(  $instagram, $instagram );
	if ( is_array( $instagram ) && $instagram ) {
		$total_count = count( $instagram ) - 1;
		?>

		<div class="pk-instagram-items-carousel">

			<?php foreach ( $instagram as $key => $item ) { ?>

				<?php
				if ( 1 === $key % 3 ) {
					$count_class = 'second';
				} elseif ( 2 === $key % 3 ) {
					$count_class = 'third';
				} else {
					$count_class = 'first';
				}
				?>

				<?php if ( 0 === $key ) { ?>
					<div class="pk-instagram-cell">
				<?php } ?>

					<div class="pk-instagram-item <?php echo esc_attr( $count_class ); ?>">
						<a class="pk-instagram-link" href="<?php echo esc_url( $item['user_link'] ); ?>" target="<?php echo esc_attr( $params['target'] ); ?>">
							<img src="<?php echo esc_attr( $item['user_image'] ); ?>" class="<?php echo esc_attr( $item['class'] ); ?>" alt="<?php echo esc_html( $item['description'] ); ?>" srcset="<?php echo esc_attr( $item['srcset'] ); ?>" sizes="<?php echo esc_attr( $item['sizes'] ); ?>">

							<?php if ( is_int( $item['likes'] ) || is_int( $item['comments'] ) ) { ?>
								<span class="pk-instagram-data">
									<span class="pk-instagram-meta">
										<?php if ( is_int( $item['likes'] ) ) { ?>
											<span class="pk-meta pk-meta-likes"><i class="pk-icon pk-icon-like"></i> <?php echo esc_attr( powerkit_abridged_number( $item['likes'] ) ); ?></span>
										<?php } ?>

										<?php if ( is_int( $item['comments'] ) ) { ?>
											<span class="pk-meta pk-meta-comments"><i class="pk-icon pk-icon-comment"></i> <?php echo esc_attr( powerkit_abridged_number( $item['comments'] ) ); ?></span>
										<?php } ?>
									</span>
								</span>
							<?php } ?>
						</a>
					</div>

				<?php if ( 2 === $key % 3 && $total_count > $key ) { ?>
					</div>
					<div class="pk-instagram-cell">
				<?php } elseif ( $total_count === $key ) { ?>
					</div>
				<?php } ?>

			<?php } ?>
		</div>

		<div class="cs-instagram-footer">
			<div class="cs-instagram-footer__wrapper">
				<div class="cs-instagram-footer__item">
					<div class="cs-instagram-footer__inner">
						<span class="pk-instagram-username">
							<a href="<?php echo esc_url( sprintf( 'https://www.instagram.com/%s/', $feed['username'] ) ); ?>" target="<?php echo esc_attr( $params['target'] ); ?>">
								@<?php echo wp_kses( $feed['username'], 'csco' ); ?></a>
						</span>
					</div>
					<div class="cs-instagram-footer__inner">
						<?php if ( is_int( $feed['followers'] ) ) { ?>
							<div class="pk-instagram-counters">
								<div class="counter followers">
									<span class="number"><?php echo esc_html( powerkit_abridged_number( $feed['followers'], 0 ) ); ?></span> <?php esc_html_e( 'Followers', 'caards' ); ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="cs-instagram-footer__item cs-instagram-footer__item-hidden">
					<div class="cs-instagram-footer__inner">
						<?php if ( $params['button'] ) { ?>
							<span class="pk-instagram-username">
								<a href="<?php echo esc_url( sprintf( 'https://www.instagram.com/%s/', $feed['username'] ) ); ?>" target="<?php echo esc_attr( $params['target'] ); ?>"><?php echo wp_kses( apply_filters( 'powerkit_instagram_follow', esc_html__( 'follow', 'caards' ) ), 'csco' ); ?></a>
							</span>
						<?php } ?>
					</div>
					<div class="cs-instagram-footer__inner">
						<?php if ( is_int( $feed['following'] ) ) { ?>
							<div class="pk-instagram-counters">
								<div class="counter following">
									<span class="number"><?php echo esc_html( powerkit_abridged_number( $feed['following'], 0 ) ); ?></span> <?php esc_html_e( 'Following', 'caards' ); ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<a class="cs-overlay-link" href="<?php echo esc_url( sprintf( 'https://www.instagram.com/%s/', $feed['username'] ) ); ?>" target="<?php echo esc_attr( $params['target'] ); ?>"></a>

		<?php
	}
}

/**
 * Instagram Diagonal Carousel Callback Function Template
 *
 * @param array $feed      The instagram feed.
 * @param array $instagram The instagram items.
 * @param array $params    The user parameters.
 */
function csco_powerkit_instagram_diagonal_carousel_template( $feed, $instagram, $params ) {

	$instagram = array_merge( $instagram, $instagram );
	if ( is_array( $instagram ) && $instagram ) {
		$total_count = count( $instagram ) - 1;
		?>

		<div class="pk-instagram-template-carousel-full-wrapper" data-scheme="inverse">
			<div class="pk-instagram-items-carousel-full">

				<?php foreach ( $instagram as $key => $item ) { ?>

					<?php
					if ( 1 === $key % 4 ) {
						$count_class = 'second';
					} elseif ( 2 === $key % 4 ) {
						$count_class = 'third';
					} elseif ( 3 === $key % 4 ) {
						$count_class = 'fourth';
					} else {
						$count_class = 'first';
					}
					?>

					<?php if ( 0 === $key ) { ?>
						<div class="pk-instagram-cell">
					<?php } ?>

					<div class="pk-instagram-item <?php echo esc_attr( $count_class ); ?>">
						<a class="pk-instagram-link" href="<?php echo esc_url( $item['user_link'] ); ?>" target="<?php echo esc_attr( $params['target'] ); ?>">
							<img src="<?php echo esc_attr( $item['user_image'] ); ?>" class="<?php echo esc_attr( $item['class'] ); ?>" alt="<?php echo esc_html( $item['description'] ); ?>" srcset="<?php echo esc_attr( $item['srcset'] ); ?>" sizes="<?php echo esc_attr( $item['sizes'] ); ?>">

							<?php if ( is_int( $item['likes'] ) || is_int( $item['comments'] ) ) { ?>
								<span class="pk-instagram-data">
										<span class="pk-instagram-meta">
											<?php if ( is_int( $item['likes'] ) ) { ?>
												<span class="pk-meta pk-meta-likes"><i class="pk-icon pk-icon-like"></i> <?php echo esc_attr( powerkit_abridged_number( $item['likes'] ) ); ?></span>
											<?php } ?>

											<?php if ( is_int( $item['comments'] ) ) { ?>
												<span class="pk-meta pk-meta-comments"><i class="pk-icon pk-icon-comment"></i> <?php echo esc_attr( powerkit_abridged_number( $item['comments'] ) ); ?></span>
											<?php } ?>
										</span>
									</span>
							<?php } ?>
						</a>
					</div>

					<?php if ( 3 === $key % 4 && $total_count > $key ) { ?>
						</div>
						<div class="pk-instagram-cell">
					<?php } elseif ( $total_count === $key ) { ?>
						</div>
					<?php } ?>

				<?php } ?>
			</div>

			<?php if ( $params['header'] ) { ?>
				<div class="pk-instagram-header"><?php esc_html_e( 'Follow Us on Instagram', 'caards' ); ?></div>
			<?php } ?>

			<div class="cs-instagram-footer">
				<div class="cs-instagram-footer__wrapper">
					<div class="cs-instagram-footer__item">
						<div class="cs-instagram-footer__inner">
							<span class="pk-instagram-username">
								<a href="<?php echo esc_url( sprintf( 'https://www.instagram.com/%s/', $feed['username'] ) ); ?>" target="<?php echo esc_attr( $params['target'] ); ?>">
									@<?php echo wp_kses( $feed['username'], 'csco' ); ?></a>
							</span>
						</div>
						<div class="cs-instagram-footer__inner">
							<?php if ( is_int( $feed['followers'] ) ) { ?>
								<div class="pk-instagram-counters">
									<div class="counter followers">
										<span class="number"><?php echo esc_html( powerkit_abridged_number( $feed['followers'], 0 ) ); ?></span> <?php esc_html_e( 'Followers', 'caards' ); ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="cs-instagram-footer__item cs-instagram-footer__item-hidden">
						<div class="cs-instagram-footer__inner">
							<?php if ( $params['button'] ) { ?>
								<span class="pk-instagram-username">
									<a href="<?php echo esc_url( sprintf( 'https://www.instagram.com/%s/', $feed['username'] ) ); ?>" target="<?php echo esc_attr( $params['target'] ); ?>"><?php echo wp_kses( apply_filters( 'powerkit_instagram_follow', esc_html__( 'follow', 'caards' ) ), 'csco' ); ?></a>
								</span>
							<?php } ?>
						</div>
						<div class="cs-instagram-footer__inner">
							<?php if ( is_int( $feed['following'] ) ) { ?>
								<div class="pk-instagram-counters">
									<div class="counter following">
										<span class="number"><?php echo esc_html( powerkit_abridged_number( $feed['following'], 0 ) ); ?></span> <?php esc_html_e( 'Following', 'caards' ); ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

			<a class="cs-overlay-link" href="<?php echo esc_url( sprintf( 'https://www.instagram.com/%s/', $feed['username'] ) ); ?>" target="<?php echo esc_attr( $params['target'] ); ?>"></a>
		</div>

		<?php
	}
}

/**
 * Change settings of opt-in-form
 *
 * @param array $blocks All registered blocks.
 */
function csco_change_settings_opt_in_form( $blocks ) {

	foreach ( $blocks as $key => $block ) {

		if ( 'canvas/opt-in-form' === $block['name'] ) {
			csco_smart_array_push( $blocks[ $key ]['fields'], array(
				'key'     => 'colorBasicInputBG',
				'label'   => esc_html__( 'Input Background', 'caards' ),
				'section' => 'general',
				'type'    => 'color',
				'output'  => array(
					array(
						'element'  => '$',
						'property' => '--cs-color-input',
						'suffix'   => '!important',
					),
				),
			), false, true );
			csco_smart_array_push( $blocks[ $key ]['fields'], array(
				'key'     => 'colorBasicInput',
				'label'   => esc_html__( 'Input Color', 'caards' ),
				'section' => 'general',
				'type'    => 'color',
				'output'  => array(
					array(
						'element'  => '$',
						'property' => '--cs-color-primary',
						'suffix'   => '!important',
					),
				),
			), false, true );
			csco_smart_array_push( $blocks[ $key ]['fields'], array(
				'key'     => 'colorBasicButtonBG',
				'label'   => esc_html__( 'Button Background', 'caards' ),
				'section' => 'general',
				'type'    => 'color',
				'output'  => array(
					array(
						'element'  => '$',
						'property' => '--cs-color-button',
						'suffix'   => '!important',
					),
				),
			), false, true );
			csco_smart_array_push( $blocks[ $key ]['fields'], array(
				'key'     => 'colorBasicButton',
				'label'   => esc_html__( 'Button Color', 'caards' ),
				'section' => 'general',
				'type'    => 'color',
				'output'  => array(
					array(
						'element'  => '$',
						'property' => '--cs-color-button-contrast',
						'suffix'   => '!important',
					),
				),
			), false, true );
			csco_smart_array_push( $blocks[ $key ]['fields'], array(
				'key'     => 'colorBasicButtonBGHover',
				'label'   => esc_html__( 'Button Background Hover', 'caards' ),
				'section' => 'general',
				'type'    => 'color',
				'output'  => array(
					array(
						'element'  => '$',
						'property' => '--cs-color-button-hover',
						'suffix'   => '!important',
					),
				),
			), false, true );
			csco_smart_array_push( $blocks[ $key ]['fields'], array(
				'key'     => 'colorBasicButtonHover',
				'label'   => esc_html__( 'Button Color Hover', 'caards' ),
				'section' => 'general',
				'type'    => 'color',
				'output'  => array(
					array(
						'element'  => '$',
						'property' => '--cs-color-button-hover-contrast',
						'suffix'   => '!important',
					),
				),
			), false, true );
		}
	}

	return $blocks;
}
add_filter( 'canvas_register_block_type', 'csco_change_settings_opt_in_form', 999 );

/**
 * Exclude Inline Posts posts from related posts block
 *
 * @param array $args Array of WP_Query args.
 */
function csco_related_posts_args( $args ) {
	global $powerkit_inline_posts;
	if ( ! $powerkit_inline_posts ) {
		return $args;
	}
	$post__not_in         = $args['post__not_in'];
	$post__not_in         = array_unique( array_merge( $post__not_in, $powerkit_inline_posts ) );
	$args['post__not_in'] = $post__not_in;
	return $args;
}

/**
 * Filter Register Templates
 *
 * @param array $templates List of Templates.
 */
function csco_powerkit_social_links_templates( $templates = array() ) {

	if ( isset( $templates['nav']['public'] ) ) {
		$templates['nav']['public'] = true;
	}

	return $templates;
}
add_filter( 'powerkit_social_links_templates', 'csco_powerkit_social_links_templates' );

/**
 * Change locations of featured categories
 *
 * @param array $locations List of locations.
 */
function csco_powerkit_featured_categories_locations( $locations = array() ) {

	$locations['vertical-list-alt'] = array(
		'name'     => esc_html__( 'Vertical List Alt', 'caards' ),
		'icon'     => '<svg width="52" height="44" xmlns="http://www.w3.org/2000/svg"><g transform="translate(1 1)" fill="none" fill-rule="evenodd"><rect stroke="#2D2D2D" stroke-width="1.5" width="50" height="42" rx="3"/><g transform="translate(5 5)"><rect stroke="#2D2D2D" stroke-width="1.5" width="40" height="8" rx="1"/><path fill="#2D2D2D" d="M34 2h4v4h-4z"/></g><g transform="translate(5 17)"><rect stroke="#2D2D2D" stroke-width="1.5" width="40" height="8" rx="1"/><path fill="#2D2D2D" d="M34 2h4v4h-4z"/></g><g transform="translate(5 29)"><rect stroke="#2D2D2D" stroke-width="1.5" width="40" height="8" rx="1"/><path fill="#2D2D2D" d="M34 2h4v4h-4z"/></g></g></svg>',
		'location' => array(),
		'template' => POWERKIT_PATH . '/modules/featured-categories/public/block/vertical-list.php',
		'sections' => array(),
		'fields'   => array(),
	);

	return $locations;
}
add_filter( 'powerkit_featured_categories_locations', 'csco_powerkit_featured_categories_locations' );
