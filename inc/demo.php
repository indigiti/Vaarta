<?php
/**
 * Demo content installer shared by wp-admin and WP-CLI.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Install or refresh Vaarta's deterministic demo site.
 *
 * Only content carrying Vaarta's demo markers is replaced.
 *
 * @return array{pages: array<string,int>, blog: int}
 */
function vaarta_install_demo_site(): array {
	if ( ! current_user_can( 'manage_options' ) && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		return array( 'pages' => array(), 'blog' => 0 );
	}

	require get_theme_file_path( 'tools/seed-demo.php' );

	$demo_page_key = '_vaarta_demo_page';
	
	$pages = array(
		'tech' => array(
			'title'    => 'Tech',
			'pattern'  => 'vaarta/tech-home',
			'template' => 'page-demo',
		),
		'firmware' => array(
			'title'    => 'Firmware',
			'pattern'  => 'vaarta/home-firmware',
			'template' => 'page-demo',
		),
		'datacrunch' => array(
			'title'    => 'Datacrunch',
			'pattern'  => 'vaarta/home-datacrunch',
			'template' => 'page-demo',
		),
		'foundr' => array(
			'title'    => 'Foundr',
			'pattern'  => 'vaarta/home-foundr',
			'template' => 'page-demo',
		),
		'artboard' => array(
			'title'    => 'Artboard',
			'pattern'  => 'vaarta/home-artboard',
			'template' => 'page-demo',
		),
		'design-loft' => array(
			'title'    => 'Design Loft',
			'pattern'  => 'vaarta/home-design-loft',
			'template' => 'page-demo',
		),
		'contact' => array(
			'title'    => 'Contact',
			'content'  => '<p>Questions, pitches, partnerships, corrections and ideas are welcome. Use the form to reach the editorial team.</p>',
			'template' => 'page-contact',
		),
		'team' => array(
			'title'    => 'About Our Team',
			'content'  => '<p>Meet the editors, writers and contributors behind Vaarta.</p>',
			'template' => 'page-team',
		),
		'coming-soon' => array(
			'title'    => 'Something new is coming.',
			'content'  => '<p>We are preparing a new editorial experience. Join the list and we will let you know when it launches.</p>',
			'template' => 'page-coming-soon',
		),
	);
	
	$page_ids = array();
	
	foreach ( $pages as $slug => $config ) {
		$existing = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'meta_key'       => $demo_page_key,
				'meta_value'     => $slug,
				'fields'         => 'ids',
			)
		);
	
		$page_content = isset( $config['pattern'] )
			? sprintf(
				'<!-- wp:pattern {"slug":"%s"} /-->',
				esc_attr( $config['pattern'] )
			)
			: ( $config['content'] ?? '' );
	
		$postarr = array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $config['title'],
			'post_name'    => $slug,
			'post_content' => $page_content,
			'meta_input'   => array(
				$demo_page_key => $slug,
			),
		);
	
		if ( $existing ) {
			$postarr['ID'] = (int) $existing[0];
			$page_id       = wp_update_post( $postarr, true );
		} else {
			$page_id = wp_insert_post( $postarr, true );
		}
	
		if ( is_wp_error( $page_id ) ) {
			WP_CLI::warning(
				sprintf(
					'Could not create %1$s: %2$s',
					$config['title'],
					$page_id->get_error_message()
				)
			);
			continue;
		}
	
		update_post_meta( $page_id, '_wp_page_template', $config['template'] );
		$page_ids[ $slug ] = (int) $page_id;
	}
	
	$blog_existing = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_key'       => $demo_page_key,
			'meta_value'     => 'blog',
			'fields'         => 'ids',
		)
	);
	
	$blog_postarr = array(
		'post_type'   => 'page',
		'post_status' => 'publish',
		'post_title'  => 'Blog',
		'post_name'   => 'blog',
		'meta_input'  => array(
			$demo_page_key => 'blog',
		),
	);
	
	if ( $blog_existing ) {
		$blog_postarr['ID'] = (int) $blog_existing[0];
		$blog_id             = wp_update_post( $blog_postarr, true );
	} else {
		$blog_id = wp_insert_post( $blog_postarr, true );
	}
	
	if ( isset( $page_ids['tech'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['tech'] );
	}
	
	if ( ! is_wp_error( $blog_id ) ) {
		update_option( 'page_for_posts', (int) $blog_id );
	}
	
	flush_rewrite_rules();
	
		return array(
			'pages' => $page_ids,
			'blog'  => is_wp_error( $blog_id ) ? 0 : (int) $blog_id,
		);
	
	
}

/**
 * Register the Vaarta Setup screen under Appearance.
 */
function vaarta_register_demo_setup_page(): void {
	add_theme_page(
		__( 'Vaarta Setup', 'vaarta' ),
		__( 'Vaarta Setup', 'vaarta' ),
		'manage_options',
		'vaarta-setup',
		'vaarta_render_demo_setup_page'
	);
}
add_action( 'admin_menu', 'vaarta_register_demo_setup_page' );

/**
 * Process a protected demo import request.
 */
function vaarta_handle_demo_import(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Administrator capability required.', 'vaarta' ) );
	}

	check_admin_referer( 'vaarta_install_demo' );
	$result = vaarta_install_demo_site();

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'           => 'vaarta-setup',
				'vaarta_imported'=> count( $result['pages'] ) + ( $result['blog'] ? 1 : 0 ),
			),
			admin_url( 'themes.php' )
		)
	);
	exit;
}
add_action( 'admin_post_vaarta_install_demo', 'vaarta_handle_demo_import' );

/**
 * Render the setup screen.
 */
function vaarta_render_demo_setup_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$imported = isset( $_GET['vaarta_imported'] ) ? absint( $_GET['vaarta_imported'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Vaarta Setup', 'vaarta' ); ?></h1>
		<p><?php esc_html_e( 'Install the complete Vaarta editorial demo: seeded stories, generated demo media, categories, homepage variants, Blog, Contact, Team and Coming Soon pages.', 'vaarta' ); ?></p>
		<?php if ( $imported ) : ?>
			<div class="notice notice-success is-dismissible"><p>
				<?php echo esc_html( sprintf( __( 'Vaarta demo installed successfully. %d demo pages are ready.', 'vaarta' ), $imported ) ); ?>
			</p></div>
		<?php endif; ?>
		<div class="card">
			<h2><?php esc_html_e( 'Demo Content', 'vaarta' ); ?></h2>
			<p><?php esc_html_e( 'Safe to run again: Vaarta replaces only content marked as demo content and preserves unrelated site content.', 'vaarta' ); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="vaarta_install_demo">
				<?php wp_nonce_field( 'vaarta_install_demo' ); ?>
				<?php submit_button( __( 'Install / Refresh Vaarta Demo', 'vaarta' ), 'primary', 'submit', false ); ?>
			</form>
		</div>
	</div>
	<?php
}
