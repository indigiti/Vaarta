<?php
/**
 * Continuous-reading / auto-load article support.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Find the next older published post for continuous reading.
 *
 * @param int $post_id Current post ID.
 * @return WP_Post|null
 */
function vaarta_get_next_reading_post( int $post_id ): ?WP_Post {
	$current = get_post( $post_id );

	if ( ! $current || 'post' !== $current->post_type ) {
		return null;
	}

	$posts = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 1,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'post__not_in'        => array( $post_id ),
			'ignore_sticky_posts' => true,
			'date_query'          => array(
				array(
					'before'    => $current->post_date,
					'inclusive' => false,
					'column'    => 'post_date',
				),
			),
		)
	);

	return $posts ? $posts[0] : null;
}

/**
 * Render one article fragment for the continuous-reading stream.
 *
 * @param WP_Post $post Post object.
 * @return string
 */
function vaarta_render_autoload_article( WP_Post $post ): string {
	global $post as $global_post;

	$previous_global = $global_post;
	$global_post     = $post;
	setup_postdata( $post );

	ob_start();
	?>
	<article
		class="vaarta-autoloaded-article"
		data-vaarta-article-url="<?php echo esc_url( get_permalink( $post ) ); ?>"
		data-vaarta-article-title="<?php echo esc_attr( get_the_title( $post ) ); ?>"
	>
		<header class="vaarta-autoloaded-article__header">
			<div class="vaarta-autoloaded-article__terms"><?php the_category( ' · ' ); ?></div>
			<h2 class="vaarta-autoloaded-article__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<div class="vaarta-autoloaded-article__meta">
				<span><?php the_author(); ?></span>
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<span>
					<?php
					printf(
						/* translators: %d: reading time in minutes. */
						esc_html__( '%d min read', 'vaarta' ),
						vaarta_get_reading_time( get_the_ID() )
					);
					?>
				</span>
				<span>
					<?php
					printf(
						/* translators: %s: formatted view count. */
						esc_html__( '%s views', 'vaarta' ),
						esc_html( number_format_i18n( vaarta_get_post_views( get_the_ID() ) ) )
					);
					?>
				</span>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="vaarta-autoloaded-article__image">
				<?php the_post_thumbnail( 'full', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
			</figure>
		<?php endif; ?>

		<div class="vaarta-autoloaded-article__content">
			<?php echo apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>

		<footer class="vaarta-autoloaded-article__footer">
			<?php
			echo do_blocks(
				'<!-- wp:vaarta/social-share {"styleVariant":"light"} /-->' .
				'<!-- wp:vaarta/author-box /-->' .
				'<!-- wp:vaarta/related-posts {"postsToShow":3,"layout":"grid"} /-->'
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</footer>
	</article>
	<?php
	$html = (string) ob_get_clean();

	wp_reset_postdata();
	$global_post = $previous_global;

	if ( $previous_global instanceof WP_Post ) {
		setup_postdata( $previous_global );
	}

	return $html;
}

/**
 * Register continuous-reading REST endpoint.
 */
function vaarta_register_autoload_route(): void {
	register_rest_route(
		'vaarta/v1',
		'/next-post',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => '__return_true',
			'args'                => array(
				'post' => array(
					'type'              => 'integer',
					'required'          => true,
					'sanitize_callback' => 'absint',
				),
			),
			'callback'            => 'vaarta_rest_next_post',
		)
	);
}
add_action( 'rest_api_init', 'vaarta_register_autoload_route' );

/**
 * REST response for the next continuous-reading article.
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response
 */
function vaarta_rest_next_post( WP_REST_Request $request ): WP_REST_Response {
	$current_id = absint( $request->get_param( 'post' ) );
	$next       = vaarta_get_next_reading_post( $current_id );

	if ( ! $next ) {
		return rest_ensure_response(
			array(
				'done' => true,
			)
		);
	}

	return rest_ensure_response(
		array(
			'done'  => false,
			'id'    => $next->ID,
			'url'   => get_permalink( $next ),
			'title' => get_the_title( $next ),
			'html'  => vaarta_render_autoload_article( $next ),
		)
	);
}
