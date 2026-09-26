<?php
/**
 * Add badge fields to menu item
 *
 * @package Caards
 */

if ( ! function_exists( 'csco_primary_menu_item_args' ) ) {
	/**
	 * Filters the arguments for a single nav menu item.
	 *
	 * @param object $args  An object of wp_nav_menu() arguments.
	 * @param object $item  (WP_Post) Menu item data object.
	 * @param int    $depth Depth of menu item. Used for padding.
	 */
	function csco_primary_menu_item_args( $args, $item, $depth ) {
		$args->link_before = '';
		$args->link_after  = '';
		if ( 'primary' === $args->theme_location && 0 === $depth ) {
			$args->link_before = '<span>';
			$args->link_after  = '</span>';
		}
		return $args;
	}
	add_filter( 'nav_menu_item_args', 'csco_primary_menu_item_args', 10, 3 );
}

if ( version_compare( get_bloginfo( 'version' ), '5.4', '<' ) ) {
	return;
}

/**
 * Add badge custom fields to menu item
 *
 * @param int $id object id.
 */
function csco_menu_item_badge_fields( $id ) {

	wp_nonce_field( 'csco_menu_meta_nonce', 'csco_menu_meta_nonce_name' );
	$badge_color = get_post_meta( $id, '_csco_menu_badge_color', true );
	$badge_text  = get_post_meta( $id, '_csco_menu_badge_text', true );

	$badge_colors = array(
		'primary'   => esc_html__( 'Primary', 'caards' ),
		'secondary' => esc_html__( 'Secondary', 'caards' ),
		'dark'      => esc_html__( 'Dark', 'caards' ),
		'success'   => esc_html__( 'Success', 'caards' ),
		'info'      => esc_html__( 'Info', 'caards' ),
		'warning'   => esc_html__( 'Warning', 'caards' ),
		'danger'    => esc_html__( 'Danger', 'caards' ),
	);

	?>
	<p class="description description-thin">
		<label for="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Badge Style', 'caards' ); ?></label>
		<select class="widefat" name="csco_menu_badge_color[<?php echo esc_attr( $id ); ?>]">
			<?php
			foreach ( $badge_colors as $value => $label ) {
				?>
				<option value="<?php echo esc_attr( $value ); ?>" class="pk-badge-<?php echo esc_attr( $value ); ?>" <?php selected( $badge_color, $value ); ?>><?php echo esc_html( $label ); ?></option>
				<?php
			}
			?>
		</select>
	</p>
	<p class="description description-thin">
		<label><?php esc_html_e( 'Badge Text', 'caards' ); ?><br>
			<input type="text" class="widefat <?php echo esc_attr( $id ); ?>" name="csco_menu_badge_text[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $badge_text ); ?>">
		</label>
	</p>
	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'csco_menu_item_badge_fields' );

/**
 * Save the badge menu item meta
 *
 * @param int $menu_id menu id.
 * @param int $menu_item_db_id menu item db id.
 */
function csco_menu_item_badge_fields_update( $menu_id, $menu_item_db_id ) {

	// Check ajax.
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	// Security.
	check_admin_referer( 'csco_menu_meta_nonce', 'csco_menu_meta_nonce_name' );

	// Save badge color.
	if ( isset( $_POST['csco_menu_badge_color'][ $menu_item_db_id ] ) ) {
		$sanitized_data = sanitize_text_field( $_POST['csco_menu_badge_color'][ $menu_item_db_id ] );
		update_post_meta( $menu_item_db_id, '_csco_menu_badge_color', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_csco_menu_badge_color' );
	}

	// Save badge text.
	if ( isset( $_POST['csco_menu_badge_text'][ $menu_item_db_id ] ) ) {
		$sanitized_data = sanitize_text_field( $_POST['csco_menu_badge_text'][ $menu_item_db_id ] );
		update_post_meta( $menu_item_db_id, '_csco_menu_badge_text', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_csco_menu_badge_text' );
	}
}
add_action( 'wp_update_nav_menu_item', 'csco_menu_item_badge_fields_update', 10, 2 );

/**
 * Displays badge text on the front-end.
 *
 * @param string  $title The menu item's title.
 * @param WP_Post $item The current menu item.
 * @return string
 */
function csco_badge_menu_item( $title, $item ) {
	// Add badge code after title text.
	if ( is_object( $item ) && isset( $item->ID ) ) {

		$badge_color = get_post_meta( $item->ID, '_csco_menu_badge_color', true );
		$badge_text  = get_post_meta( $item->ID, '_csco_menu_badge_text', true );

		if ( ! empty( $badge_text ) ) {
			$badge_class = $badge_color ? $badge_color : 'primary';
			$title      .= ' <span class="pk-badge pk-badge-' . esc_attr( $badge_class ) . '">' . esc_html( $badge_text ) . '</span>';
		}
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'csco_badge_menu_item', 8, 2 );
