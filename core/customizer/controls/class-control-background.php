<?php
/**
 * Customizer Background
 *
 * @package Caards
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CSCO_Customize_Background_Control' ) ) {
	/**
	 * Class Customize Background
	 */
	class CSCO_Customize_Background_Control extends WP_Customize_Control {

		/**
		 * The field type.
		 *
		 * @var string
		 */
		public $type = 'group-background';

		/**
		 * Constructor.
		 *
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param string               $id      Control ID.
		 * @param array                $args    The args.
		 */
		public function __construct( $manager, $id, $args = array() ) {

			parent::__construct( $manager, $id, $args );

			// Init choices.
			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}
		}

		/**
		 * Render the control's content.
		 */
		protected function render_content() {}

		/**
		 * Sets the $sanitize_callback
		 *
		 * @access protected
		 */
		protected function sanitize_callback() {

			// If a custom sanitize_callback has been defined,
			// then we don't need to proceed any further.
			if ( ! empty( $this->sanitize_callback ) ) {
				return;
			}
			$this->sanitize_callback = array( $this, 'sanitize' );
		}

		/**
		 * The sanitize method that will be used as a falback
		 *
		 * @param string|array $value The control's value.
		 */
		public function sanitize( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			return array(
				'background-color'      => ( isset( $value['background-color'] ) ) ? sanitize_text_field( $value['background-color'] ) : '',
				'background-image'      => ( isset( $value['background-image'] ) ) ? esc_url_raw( $value['background-image'] ) : '',
				'background-repeat'     => ( isset( $value['background-repeat'] ) ) ? sanitize_text_field( $value['background-repeat'] ) : '',
				'background-position'   => ( isset( $value['background-position'] ) ) ? sanitize_text_field( $value['background-position'] ) : '',
				'background-size'       => ( isset( $value['background-size'] ) ) ? sanitize_text_field( $value['background-size'] ) : '',
				'background-attachment' => ( isset( $value['background-attachment'] ) ) ? sanitize_text_field( $value['background-attachment'] ) : '',
			);
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @see WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();

			// Value.
			$this->json['value'] = $this->value();

			// The link.
			$this->json['link'] = $this->get_link();

			// Choices.
			$this->json['choices'] = $this->choices;

			// The ID.
			$this->json['id'] = $this->id;
		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
			<label>
				<span class="customize-control-title">{{{ data.label }}}</span>
				<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			</label>
			<div class="background-wrapper">

				<!-- background-color -->
				<div class="background-color">
					<h4><?php esc_html_e( 'Background Color', 'caards' ); ?></h4>
					<input type="text" data-default-color="{{ data.choices['background-color'] }}" class="csco-color-control" data-alpha="true" value="{{ data.value['background-color'] }}" />
				</div>

				<!-- background-image -->
				<div class="background-image">
					<h4><?php esc_html_e( 'Background Image', 'caards' ); ?></h4>
					<div class="attachment-media-view background-image-upload">
						<# if ( data.value['background-image'] ) { #>
							<div class="thumbnail thumbnail-image"><img src="{{ data.value['background-image'] }}"/></div>
						<# } else { #>
							<div class="placeholder"><?php esc_html_e( 'No File Selected', 'caards' ); ?></div>
						<# } #>
						<div class="actions">
							<button class="button background-image-upload-remove-button<# if ( ! data.value['background-image'] ) { #> hidden <# } #>"><?php esc_html_e( 'Remove', 'caards' ); ?></button>
							<button type="button" class="button background-image-upload-button"><?php esc_html_e( 'Select File', 'caards' ); ?></button>
						</div>
					</div>
				</div>

				<!-- background-repeat -->
				<div class="background-repeat">
					<h4><?php esc_html_e( 'Background Repeat', 'caards' ); ?></h4>
					<select {{{ data.inputAttrs }}}>
						<option value="no-repeat"<# if ( 'no-repeat' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_html_e( 'No Repeat', 'caards' ); ?></option>
						<option value="repeat"<# if ( 'repeat' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_html_e( 'Repeat All', 'caards' ); ?></option>
						<option value="repeat-x"<# if ( 'repeat-x' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_html_e( 'Repeat Horizontally', 'caards' ); ?></option>
						<option value="repeat-y"<# if ( 'repeat-y' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_html_e( 'Repeat Vertically', 'caards' ); ?></option>
					</select>
				</div>

				<!-- background-position -->
				<div class="background-position">
					<h4><?php esc_html_e( 'Background Position', 'caards' ); ?></h4>
					<select {{{ data.inputAttrs }}}>
						<option value="left top"<# if ( 'left top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Left Top', 'caards' ); ?></option>
						<option value="left center"<# if ( 'left center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Left Center', 'caards' ); ?></option>
						<option value="left bottom"<# if ( 'left bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Left Bottom', 'caards' ); ?></option>
						<option value="right top"<# if ( 'right top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Right Top', 'caards' ); ?></option>
						<option value="right center"<# if ( 'right center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Right Center', 'caards' ); ?></option>
						<option value="right bottom"<# if ( 'right bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Right Bottom', 'caards' ); ?></option>
						<option value="center top"<# if ( 'center top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Center Top', 'caards' ); ?></option>
						<option value="center center"<# if ( 'center center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Center Center', 'caards' ); ?></option>
						<option value="center bottom"<# if ( 'center bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_html_e( 'Center Bottom', 'caards' ); ?></option>
					</select>
				</div>

				<!-- background-size -->
				<div class="background-size">
					<h4><?php esc_html_e( 'Background Size', 'caards' ); ?></h4>
					<div class="buttonset">
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="cover" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}cover" <# if ( 'cover' === data.value['background-size'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'cover' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}cover"><?php esc_html_e( 'Cover', 'caards' ); ?></label>
						</input>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="contain" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}contain" <# if ( 'contain' === data.value['background-size'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'contain' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}contain"><?php esc_html_e( 'Contain', 'caards' ); ?></label>
						</input>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="auto" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}auto" <# if ( 'auto' === data.value['background-size'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'auto' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}auto"><?php esc_html_e( 'Auto', 'caards' ); ?></label>
						</input>
					</div>
				</div>

				<!-- background-attachment -->
				<div class="background-attachment">
					<h4><?php esc_html_e( 'Background Attachment', 'caards' ); ?></h4>
					<div class="buttonset">
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="scroll" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}scroll" <# if ( 'scroll' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'scroll' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}scroll"><?php esc_html_e( 'Scroll', 'caards' ); ?></label>
						</input>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="fixed" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}fixed" <# if ( 'fixed' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'fixed' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}fixed"><?php esc_html_e( 'Fixed', 'caards' ); ?></label>
						</input>
					</div>
				</div>
				<input class="background-hidden-value" type="hidden" {{{ data.link }}}>
			<?php
		}
	}
}
