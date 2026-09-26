<?php
/**
 * Adding Custom Meta Boxes.
 *
 * @package Caards
 */

/**
 * ==================================
 * Category Options
 * ==================================
 */

/**
 * Add fields to Category
 *
 * @param string $taxonomy The taxonomy slug.
 */
function csco_mb_category_options_add( $taxonomy ) {
	wp_nonce_field( 'category_options', 'csco_mb_category_options' );
	?>
		<div class="form-field">
			<label for="csco_letter_color"><?php esc_html_e( 'Letter Color', 'caards' ); ?></label>
			<input name="csco_letter_color" value="#ffffff" class="colorpicker" id="csco_letter_color" />
		</div>
		<div class="form-field">
			<label for="csco_gradient_start_color"><?php esc_html_e( 'Background Gradient Start Color', 'caards' ); ?></label>
			<input name="csco_gradient_start_color" class="colorpicker" id="csco_gradient_start_color" />
		</div>
		<div class="form-field">
			<label for="csco_gradient_end_color"><?php esc_html_e( 'Background Gradient End Color', 'caards' ); ?></label>
			<input name="csco_gradient_end_color" class="colorpicker" id="csco_gradient_end_color" />
		</div>
		<br><br>
	<?php
}
add_action( 'category_add_form_fields', 'csco_mb_category_options_add', 10 );

/**
 * Edit fields from Category
 *
 * @param object $term     Current taxonomy term object.
 * @param string $taxonomy Current taxonomy slug.
 */
function csco_mb_category_options_edit( $term, $taxonomy ) {
	wp_nonce_field( 'category_options', 'csco_mb_category_options' );

	$color       = get_term_meta( $term->term_id, 'csco_letter_color', true );
	$start_color = get_term_meta( $term->term_id, 'csco_gradient_start_color', true );
	$end_color   = get_term_meta( $term->term_id, 'csco_gradient_end_color', true );

	$color            = ( ! empty( $color ) ) ? $color : '#ffffff';
	$background_color = ( ! empty( $background_color ) ) ? $background_color : '';
	$start_color      = ( ! empty( $start_color ) ) ? $start_color : '';
	$end_color        = ( ! empty( $end_color ) ) ? $end_color : '';
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="csco_brand_color"><?php esc_html_e( 'Letter Color', 'caards' ); ?></label></th>
		<td>
			<input name="csco_letter_color" value="<?php echo esc_attr( $color ); ?>" class="colorpicker" id="csco_letter_color" />
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="csco_gradient_start_color"><?php esc_html_e( 'Background Gradient Start Color', 'caards' ); ?></label></th>
		<td>
			<input name="csco_gradient_start_color" value="<?php echo esc_attr( $start_color ); ?>" class="colorpicker" id="csco_gradient_start_color" />
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="csco_gradient_end_color"><?php esc_html_e( 'Background Gradient End Color', 'caards' ); ?></label></th>
		<td>
			<input name="csco_gradient_end_color" value="<?php echo esc_attr( $end_color ); ?>" class="colorpicker" id="csco_gradient_end_color" />
		</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'csco_mb_category_options_edit', 10, 2 );

/**
 * Save meta box
 *
 * @param int    $term_id  ID of the term about to be edited.
 * @param string $taxonomy Taxonomy slug of the related term.
 */
function csco_mb_category_options_save( $term_id, $taxonomy ) {

	// Bail if we're doing an auto save.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// if our nonce isn't there, or we can't verify it, bail.
	if ( ! isset( $_POST['csco_mb_category_options'] ) || ! wp_verify_nonce( $_POST['csco_mb_category_options'], 'category_options' ) ) { // Input var ok; sanitization ok.
		return;
	}

	if ( isset( $_POST['csco_letter_color'] ) && ! empty( $_POST['csco_letter_color'] ) ) { // Input var ok; sanitization ok.
		update_term_meta( $term_id, 'csco_letter_color', maybe_hash_hex_color( $_POST['csco_letter_color'] ) ); // Input var ok; sanitization ok.
	} else {
		delete_term_meta( $term_id, 'csco_letter_color' );
	}
	if ( isset( $_POST['csco_gradient_start_color'] ) && ! empty( $_POST['csco_gradient_start_color'] ) ) { // Input var ok; sanitization ok.
		update_term_meta( $term_id, 'csco_gradient_start_color', maybe_hash_hex_color( $_POST['csco_gradient_start_color'] ) ); // Input var ok; sanitization ok.
	} else {
		delete_term_meta( $term_id, 'csco_gradient_start_color' );
	}
	if ( isset( $_POST['csco_gradient_end_color'] ) && ( ! empty( $_POST['csco_gradient_end_color'] ) ) ) { // Input var ok; sanitization ok.
		update_term_meta( $term_id, 'csco_gradient_end_color', maybe_hash_hex_color( $_POST['csco_gradient_end_color'] ) ); // Input var ok; sanitization ok.
	} else {
		delete_term_meta( $term_id, 'csco_gradient_end_color' );
	}
}
add_action( 'created_category', 'csco_mb_category_options_save', 10, 2 );
add_action( 'edited_category', 'csco_mb_category_options_save', 10, 2 );

/**
 * Meta box Enqunue Scripts
 *
 * @param string $page Current page.
 */
function csco_mb_category_enqueue_scripts( $page ) {
	$screen = get_current_screen();

	if ( null !== $screen && 'edit-category' !== $screen->id ) {
		return;
	}

	// Colorpicker Scripts.
	wp_enqueue_script( 'wp-color-picker' );

	// Colorpicker Styles.
	wp_enqueue_style( 'wp-color-picker' );

	// Init Colorpicker.
	ob_start();
	?>
	<script>
	jQuery( document ).ready( function( $ ) {
		$( '.colorpicker' ).wpColorPicker();
	} );
	</script>
	<?php
	wp_add_inline_script( 'wp-color-picker', str_replace( array( '<script>', '</script>' ), '', ob_get_clean() ) );

	wp_enqueue_script( 'jquery' );

}
add_action( 'admin_enqueue_scripts', 'csco_mb_category_enqueue_scripts' );
