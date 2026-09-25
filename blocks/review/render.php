<?php
/**
 * Render Review Rating block.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title   = isset( $attributes['title'] ) ? sanitize_text_field( $attributes['title'] ) : __( 'Review', 'vaarta' );
$summary = isset( $attributes['summary'] ) ? sanitize_textarea_field( $attributes['summary'] ) : '';
$score   = isset( $attributes['score'] ) ? (float) $attributes['score'] : 80;
$scale   = isset( $attributes['scale'] ) ? sanitize_key( $attributes['scale'] ) : 'percent';

$score = max( 0, min( 100, $score ) );

if ( ! in_array( $scale, array( 'percent', 'points', 'stars' ), true ) ) {
	$scale = 'percent';
}

switch ( $scale ) {
	case 'points':
		$display_score = number_format_i18n( $score / 10, 1 ) . '/10';
		break;
	case 'stars':
		$display_score = number_format_i18n( $score / 20, 1 ) . '/5';
		break;
	default:
		$display_score = number_format_i18n( $score, 0 ) . '%';
		break;
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-review vaarta-review--' . $scale,
	)
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="vaarta-review__header">
		<div>
			<?php if ( $title ) : ?>
				<h2 class="vaarta-review__title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( $summary ) : ?>
				<p class="vaarta-review__summary"><?php echo esc_html( $summary ); ?></p>
			<?php endif; ?>
		</div>

		<div
			class="vaarta-review__score"
			role="meter"
			aria-valuemin="0"
			aria-valuemax="100"
			aria-valuenow="<?php echo esc_attr( (string) $score ); ?>"
			aria-label="<?php echo esc_attr__( 'Review score', 'vaarta' ); ?>"
		>
			<?php echo esc_html( $display_score ); ?>
		</div>
	</div>

	<div class="vaarta-review__track" aria-hidden="true">
		<span class="vaarta-review__fill" style="width:<?php echo esc_attr( (string) $score ); ?>%"></span>
	</div>

	<?php if ( 'stars' === $scale ) : ?>
		<div class="vaarta-review__stars" aria-hidden="true">
			<?php
			$filled_stars = (int) round( $score / 20 );
			echo esc_html( str_repeat( '★', $filled_stars ) . str_repeat( '☆', 5 - $filled_stars ) );
			?>
		</div>
	<?php endif; ?>
</section>
