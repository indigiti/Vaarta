<?php
/**
 * Vaarta-owned category presentation metadata.
 *
 * The established csco_* callbacks and csco_* term-meta keys remain available
 * for compatibility while registration, validation, permissions, and admin UI
 * behavior are owned here.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the category presentation meta schema.
 *
 * @return array<string,array<string,string>>
 */
function vaarta_get_category_meta_schema() {
	return array(
		'csco_letter_color' => array(
			'label'   => esc_html__( 'Letter Color', 'caards' ),
			'default' => '#ffffff',
		),
		'csco_gradient_start_color' => array(
			'label'   => esc_html__( 'Background Gradient Start Color', 'caards' ),
			'default' => '',
		),
		'csco_gradient_end_color' => array(
			'label'   => esc_html__( 'Background Gradient End Color', 'caards' ),
			'default' => '',
		),
	);
}

/**
 * Render fields on the Add Category screen.
 *
 * @param string $taxonomy Taxonomy slug.
 * @return void
 */
function vaarta_category_meta_add_fields( $taxonomy ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	wp_nonce_field( 'vaarta_category_options', 'vaarta_category_options_nonce' );

	foreach ( vaarta_get_category_meta_schema() as $key => $field ) {
		?>
		<div class="form-field">
			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
			<input name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $field['default'] ); ?>" class="colorpicker" id="<?php echo esc_attr( $key ); ?>" />
		</div>
		<?php
	}
}

/**
 * Render fields on the Edit Category screen.
 *
 * @param WP_Term $term     Current category.
 * @param string  $taxonomy Taxonomy slug.
 * @return void
 */
function vaarta_category_meta_edit_fields( $term, $taxonomy ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	wp_nonce_field( 'vaarta_category_options', 'vaarta_category_options_nonce' );

	foreach ( vaarta_get_category_meta_schema() as $key => $field ) {
		$value = get_term_meta( $term->term_id, $key, true );
		$value = '' !== $value ? $value : $field['default'];
		?>
		<tr class="form-field">
			<th scope="row"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
			<td>
				<input name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" class="colorpicker" id="<?php echo esc_attr( $key ); ?>" />
			</td>
		</tr>
		<?php
	}
}

/**
 * Persist category presentation metadata.
 *
 * @param int    $term_id  Category term ID.
 * @param int    $tt_id    Term-taxonomy ID retained for hook compatibility.
 * @return void
 */
function vaarta_category_meta_save( $term_id, $tt_id = 0 ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_term', $term_id ) ) {
		return;
	}

	if ( ! isset( $_POST['vaarta_category_options_nonce'] ) ) {
		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['vaarta_category_options_nonce'] ) );
	if ( ! wp_verify_nonce( $nonce, 'vaarta_category_options' ) ) {
		return;
	}

	foreach ( vaarta_get_category_meta_schema() as $key => $field ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		$value = isset( $_POST[ $key ] ) ? sanitize_hex_color( wp_unslash( $_POST[ $key ] ) ) : '';

		if ( $value ) {
			update_term_meta( $term_id, $key, $value );
		} else {
			delete_term_meta( $term_id, $key );
		}
	}
}

/**
 * Enqueue the WordPress color picker only on category edit screens.
 *
 * @param string $hook_suffix Current admin hook suffix.
 * @return void
 */
function vaarta_category_meta_enqueue_scripts( $hook_suffix ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	$screen = get_current_screen();
	if ( ! $screen || 'edit-category' !== $screen->id ) {
		return;
	}

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_add_inline_script(
		'wp-color-picker',
		'jQuery(function($){$(".colorpicker").wpColorPicker();});'
	);
}

// -----------------------------------------------------------------------------
// Legacy public API wrappers.
// -----------------------------------------------------------------------------

if ( ! function_exists( 'csco_mb_category_options_add' ) ) {
	function csco_mb_category_options_add( $taxonomy ) {
		vaarta_category_meta_add_fields( $taxonomy );
	}
}

if ( ! function_exists( 'csco_mb_category_options_edit' ) ) {
	function csco_mb_category_options_edit( $term, $taxonomy ) {
		vaarta_category_meta_edit_fields( $term, $taxonomy );
	}
}

if ( ! function_exists( 'csco_mb_category_options_save' ) ) {
	function csco_mb_category_options_save( $term_id, $tt_id = 0 ) {
		vaarta_category_meta_save( $term_id, $tt_id );
	}
}

if ( ! function_exists( 'csco_mb_category_enqueue_scripts' ) ) {
	function csco_mb_category_enqueue_scripts( $hook_suffix ) {
		vaarta_category_meta_enqueue_scripts( $hook_suffix );
	}
}

add_action( 'category_add_form_fields', 'csco_mb_category_options_add', 10, 1 );
add_action( 'category_edit_form_fields', 'csco_mb_category_options_edit', 10, 2 );
add_action( 'created_category', 'csco_mb_category_options_save', 10, 2 );
add_action( 'edited_category', 'csco_mb_category_options_save', 10, 2 );
add_action( 'admin_enqueue_scripts', 'csco_mb_category_enqueue_scripts' );
