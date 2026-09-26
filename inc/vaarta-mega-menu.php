<?php
/**
 * Hardened Vaarta compatibility layer for the legacy mega-menu engine.
 *
 * The legacy renderer and CSS class contracts are intentionally retained while
 * request handling is moved behind WordPress capability, nonce, and schema
 * validation.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'CSCO_Mega_Menu' ) && ! class_exists( 'Vaarta_Mega_Menu' ) ) {
	/**
	 * Secure compatibility wrapper around the legacy mega-menu implementation.
	 */
	class Vaarta_Mega_Menu extends CSCO_Mega_Menu {
		/**
		 * Register the existing mega-menu hooks while removing public admin AJAX.
		 */
		public function __construct() {
			parent::__construct();

			// Menu-location mutation is an administrator-only operation.
			remove_action( 'wp_ajax_nopriv_csco_reload_menu', array( $this, 'admin_reload_nav_menu' ) );
		}

		/**
		 * Save the legacy mega-menu field only for an authenticated nav-menu form.
		 *
		 * WordPress also fires wp_update_nav_menu_item for WP-CLI, REST, imports and
		 * other programmatic menu updates. Those contexts do not carry the
		 * nav-menus.php nonce and must not be terminated by an admin-form check.
		 *
		 * @param int   $menu_id         Nav menu ID.
		 * @param int   $menu_item_db_id Menu item ID.
		 * @param array $menu_item_args  Menu item data.
		 */
		public function admin_save_new_fields( $menu_id, $menu_item_db_id, $menu_item_args ) {
			unset( $menu_id, $menu_item_args );

			if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX )
				|| ( defined( 'REST_REQUEST' ) && REST_REQUEST )
				|| ( defined( 'WP_CLI' ) && WP_CLI ) ) {
				return;
			}

			if ( ! is_admin() || ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}

			// If the menu item was changed programmatically from an admin request,
			// leave the existing mega-menu metadata untouched.
			if ( ! isset( $_POST['update-nav-menu-nonce'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Presence is checked before verification below.
				return;
			}

			check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

			foreach ( self::$fields as $_key => $field ) {
				unset( $field );
				$key = sprintf( 'menu-item-%s', $_key );

				if ( isset( $_POST[ $key ][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Verified above.
					$value = sanitize_text_field( wp_unslash( $_POST[ $key ][ $menu_item_db_id ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Verified above.
					update_post_meta( $menu_item_db_id, $key, $value );
				} else {
					// Unchecked checkboxes are absent from the nav-menu form payload.
					delete_post_meta( $menu_item_db_id, $key );
				}
			}
		}

		/**
		 * Refresh the menu editor after a protected theme-location change.
		 */
		public function admin_reload_nav_menu() {
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( '-1', '', array( 'response' => 403 ) );
			}

			check_ajax_referer( 'vaarta_reload_menu', 'nonce' );

			$nav_menu_selected_id = isset( $_POST['menu_id'] ) ? absint( wp_unslash( $_POST['menu_id'] ) ) : 0;
			$menu_name            = isset( $_POST['menu_name'] ) ? sanitize_text_field( wp_unslash( $_POST['menu_name'] ) ) : '';
			$menu_checked         = isset( $_POST['menu_checked'] ) ? rest_sanitize_boolean( wp_unslash( $_POST['menu_checked'] ) ) : false;

			preg_match( '/^menu-locations\[(.*?)\]/', $menu_name, $matches );
			$menu_location = isset( $matches[1] ) ? sanitize_key( $matches[1] ) : '';

			$allowed_locations = apply_filters( 'csco_mega_menu_locations', array( 'primary' ) );
			$allowed_locations = $this->support_languages( (array) $allowed_locations );

			if ( ! $nav_menu_selected_id || ! is_nav_menu( $nav_menu_selected_id ) || ! in_array( $menu_location, $allowed_locations, true ) ) {
				wp_die( '0', '', array( 'response' => 400 ) );
			}

			require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

			$menu_locations = get_nav_menu_locations();

			if ( $menu_checked ) {
				$menu_locations[ $menu_location ] = $nav_menu_selected_id;
			} elseif ( isset( $menu_locations[ $menu_location ] ) ) {
				unset( $menu_locations[ $menu_location ] );
			}

			set_theme_mod( 'nav_menu_locations', $menu_locations );

			$edit_markup = wp_get_nav_menu_to_edit( $nav_menu_selected_id );
			if ( ! is_wp_error( $edit_markup ) ) {
				echo $edit_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted WordPress core admin markup.
			}

			wp_die();
		}

		/**
		 * Return published mega-menu stories from constrained request parameters.
		 *
		 * @param WP_REST_Request $request REST request.
		 * @return WP_REST_Response|WP_Error
		 */
		public function rest_api_callback( $request ) {
			$per_page = absint( $request->get_param( 'per_page' ) );
			$per_page = min( 8, max( 1, $per_page ? $per_page : 4 ) );

			$term_id  = absint( $request->get_param( 'term' ) );
			$posts    = sanitize_text_field( (string) $request->get_param( 'posts' ) );
			$post_ids = array();

			if ( $posts ) {
				$post_ids = array_values( array_filter( array_map( 'absint', explode( '|', $posts ) ) ) );
				$post_ids = array_slice( array_unique( $post_ids ), 0, $per_page );
			}

			if ( ! $term_id && ! $post_ids ) {
				return new WP_Error(
					'vaarta_mega_menu_missing_filter',
					esc_html__( 'A valid term or post selection is required.', 'caards' ),
					array( 'status' => 400 )
				);
			}

			$post_types = array_values( array_filter( array_map( 'sanitize_key', (array) $this->post_types ) ) );
			if ( ! $post_types ) {
				$post_types = array( 'post' );
			}

			$args = array(
				'ignore_sticky_posts' => true,
				'post_type'           => $post_types,
				'post_status'         => 'publish',
				'posts_per_page'      => $per_page,
				'no_found_rows'       => true,
			);

			if ( $term_id ) {
				$term = get_term( $term_id );
				if ( ! $term || is_wp_error( $term ) || ! in_array( $term->taxonomy, (array) $this->taxonomies, true ) ) {
					return new WP_Error(
						'vaarta_mega_menu_invalid_term',
						esc_html__( 'The requested menu term is not available.', 'caards' ),
						array( 'status' => 404 )
					);
				}

				$args['tax_query'] = array(
					array(
						'taxonomy' => $term->taxonomy,
						'terms'    => $term_id,
						'field'    => 'term_id',
					),
				);
			}

			if ( $post_ids ) {
				$args['post__in'] = $post_ids;
				$args['orderby']  = 'post__in';
			}

			$query = new WP_Query( $args );
			ob_start();

			if ( $query->have_posts() ) {
				$options = array(
					'image_orientation' => get_theme_mod( 'mega_menu_image_orientation', 'landscape-16-9' ),
					'image_size'        => get_theme_mod( 'mega_menu_image_size', 'csco-thumbnail' ),
				);

				if ( function_exists( 'csco_block_normalize_meta' ) ) {
					$options = csco_block_normalize_meta( $options, 'mega_menu_post_meta' );
				}

				while ( $query->have_posts() ) {
					$query->the_post();
					?>
					<article <?php post_class( 'mega-menu-item menu-post-item' ); ?>>
						<div class="cs-entry__outer">
							<div class="cs-entry__inner cs-entry__content">
								<?php csco_get_post_meta( 'category', false, true, 'mega_menu_post_meta' ); ?>
								<?php the_title( '<h5 class="cs-entry__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h5>' ); ?>
								<?php csco_get_post_meta( array( 'author', 'date', 'comments' ), false, true, 'mega_menu_post_meta' ); ?>
							</div>

							<?php if ( has_post_thumbnail() ) { ?>
								<div class="cs-entry__inner cs-entry__overlay cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $options['image_orientation'] ); ?>" data-scheme="inverse">
									<div class="cs-overlay-background cs-overlay-transparent">
										<?php the_post_thumbnail( $options['image_size'] ); ?>
									</div>
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
								</div>
							<?php } ?>

							<?php if ( function_exists( 'csco_block_post_footer' ) ) { ?>
								<?php csco_block_post_footer( $options, null, true, null, array() ); ?>
							<?php } ?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
						</div>
					</article>
					<?php
				}
			}

			wp_reset_postdata();

			return rest_ensure_response(
				array(
					'status'  => 'success',
					'content' => ob_get_clean(),
				)
			);
		}

		/**
		 * Register the public, read-only mega-menu endpoint with a strict schema.
		 */
		public function rest_api_init() {
			register_rest_route(
				'csco/v1',
				'/menu-posts',
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'rest_api_callback' ),
					'permission_callback' => '__return_true',
					'args'                => array(
						'per_page' => array(
							'default'           => 4,
							'sanitize_callback' => 'absint',
							'validate_callback' => static function ( $value ) {
								$value = absint( $value );
								return $value >= 1 && $value <= 8;
							},
						),
						'term'     => array(
							'default'           => 0,
							'sanitize_callback' => 'absint',
						),
						'posts'    => array(
							'default'           => '',
							'sanitize_callback' => 'sanitize_text_field',
						),
					),
				)
			);
		}

		/**
		 * Output protected menu-editor reload behavior and existing admin styling.
		 */
		public function admin_enqueue_scripts() {
			global $pagenow;

			if ( 'nav-menus.php' !== $pagenow || ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}

			$nonce = wp_create_nonce( 'vaarta_reload_menu' );
			?>
			<script>
				(function($) {
					$( document ).ready( function() {
						$( '.menu-theme-locations input[type="checkbox"]' ).on( 'change', function( event ) {
							event.preventDefault();

							var cscoMenuID = parseInt( $( this ).val(), 10 ),
								cscoMenuName = $( this ).attr( 'name' ),
								cscoMenuChecked = $( this ).prop( 'checked' );

							if ( cscoMenuID > 0 ) {
								$.ajax({
									type: 'POST',
									url: ajaxurl,
									data: {
										action: 'csco_reload_menu',
										menu_id: cscoMenuID,
										menu_name: cscoMenuName,
										menu_checked: cscoMenuChecked,
										nonce: <?php echo wp_json_encode( $nonce ); ?>
									},
									beforeSend: function() {
										$( '#update-nav-menu' ).addClass( 'menu-ajax-reloading' );
									},
									success: function( result ) {
										if ( result.length > 0 && result != 0 ) {
											var resultHtml = $.parseHTML( result );
											if ( resultHtml ) {
												$.each( resultHtml, function( i, el ) {
													if ( $( el ).attr( 'id' ) === 'menu-to-edit' ) {
														$( '#menu-to-edit' ).html( $( el ).html() );
													}
												});
												$( '#menu-to-edit .menu-item' ).hideAdvancedMenuItemFields();
												if ( typeof wpNavMenu !== 'undefined' ) {
													wpNavMenu.refreshKeyboardAccessibility();
													wpNavMenu.refreshAdvancedAccessibility();
												}
											}
										}
									},
									complete: function() {
										$( '#update-nav-menu' ).removeClass( 'menu-ajax-reloading' );
									}
								});
							}
						});
					});
				})(jQuery);
			</script>
			<style type="text/css">
				#update-nav-menu.menu-ajax-reloading { position: relative; z-index: 12; }
				#update-nav-menu.menu-ajax-reloading:before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,.6); z-index: 15; }
				#menu-to-edit li.menu-item:not(.menu-item-depth-0) .field-cs-mega-menu { display: none; }
			</style>
			<?php
		}
	}
}

// Replace the legacy anonymous instance with Vaarta's hardened wrapper.
remove_action( 'init', 'csco_mega_menu_init' );

/**
 * Initialize the hardened compatibility implementation.
 */
function vaarta_mega_menu_init() {
	new Vaarta_Mega_Menu();
}
add_action( 'init', 'vaarta_mega_menu_init' );