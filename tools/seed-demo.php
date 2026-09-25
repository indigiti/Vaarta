<?php
/**
 * Seed deterministic demo content for visual-regression testing.
 *
 * Run inside WordPress:
 * wp eval-file wp-content/themes/vaarta/tools/seed-demo.php
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! current_user_can( 'manage_options' ) && defined( 'WP_CLI' ) && WP_CLI ) {
	// WP-CLI does not always have an authenticated user. Continue in CLI only.
} elseif ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'Administrator capability required.', 'vaarta' ) );
}

$seed_key = '_vaarta_demo_seed';

$existing = get_posts(
	array(
		'post_type'      => 'post',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'meta_key'       => $seed_key,
		'meta_value'     => '1',
		'fields'         => 'ids',
	)
);

foreach ( $existing as $post_id ) {
	wp_delete_post( $post_id, true );
}

$categories = array(
	'artificial-intelligence' => 'Artificial Intelligence',
	'business-tech'           => 'Business & Tech',
	'connectivity'            => 'Connectivity',
	'cybersecurity'           => 'Cybersecurity',
	'future-tech'             => 'Future Tech',
	'gear'                    => 'Gear',
	'science'                 => 'Science',
	'robotics'                => 'Robotics',
	'computers'               => 'Computers',
	'wearables'               => 'Wearables',
	'advertising'             => 'Advertising',
	'inspiration'             => 'Inspiration',
	'templates'               => 'Templates',
	'branding'                => 'Branding',
	'entrepreneurship'        => 'Entrepreneurship',
	'insights'                => 'Insights',
);

$category_ids = array();

foreach ( $categories as $slug => $name ) {
	$term = term_exists( $slug, 'category' );

	if ( ! $term ) {
		$term = wp_insert_term(
			$name,
			'category',
			array( 'slug' => $slug )
		);
	}

	if ( ! is_wp_error( $term ) ) {
		$category_ids[ $slug ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
	}
}

$stories = array(
	array( 'AI Systems Are Moving From Assistants to Collaborators', 'future-tech', 3200 ),
	array( 'A Practical Guide to Safer Personal Cybersecurity', 'cybersecurity', 2450 ),
	array( 'The Next Wave of Wearable Computing', 'wearables', 1880 ),
	array( 'Why Robotics Is Becoming Everyday Infrastructure', 'robotics', 1640 ),
	array( 'What Comes After Today’s Smartphone', 'gear', 1510 ),
	array( 'Quantum Research Is Entering a More Useful Era', 'science', 1430 ),
	array( 'How Connected Devices Are Reshaping the Home', 'connectivity', 1290 ),
	array( 'The New Economics of AI Infrastructure', 'business-tech', 1180 ),
	array( 'A Better Way to Think About Product Analytics', 'insights', 1060 ),
	array( 'Design Systems That Scale Across Products', 'inspiration', 970 ),
	array( 'How Startups Can Build Stronger Feedback Loops', 'entrepreneurship', 920 ),
	array( 'Advertising Without Sacrificing User Trust', 'advertising', 860 ),
	array( 'The Return of Expressive Interface Design', 'inspiration', 790 ),
	array( 'Useful Templates for Faster Creative Work', 'templates', 720 ),
	array( 'Brand Systems for Products That Keep Evolving', 'branding', 680 ),
	array( 'Affordable Hardware for Better Everyday Workflows', 'computers', 640 ),
	array( 'What Modern Founders Should Measure First', 'entrepreneurship', 590 ),
	array( 'The Most Interesting Ideas in Applied Science', 'science', 540 ),
	array( 'Small Devices With Surprisingly Big Ambitions', 'gear', 500 ),
	array( 'A Clearer Framework for Marketing Experiments', 'advertising', 460 ),
);

function vaarta_seed_demo_image( int $index, int $post_id ): int {
	if ( ! function_exists( 'imagecreatetruecolor' ) ) {
		return 0;
	}

	$width  = 1200;
	$height = 800;
	$image  = imagecreatetruecolor( $width, $height );

	$palettes = array(
		array( '#E9ECFF', '#555EEA', '#171821' ),
		array( '#F8E8DF', '#D56A4C', '#2B211C' ),
		array( '#E7EFE4', '#748D6C', '#1F2B20' ),
		array( '#F0E8FA', '#8155C7', '#241B31' ),
		array( '#E8F1F5', '#4B7F98', '#14252D' ),
	);

	$palette = $palettes[ $index % count( $palettes ) ];

	$hex_to_rgb = static function ( string $hex ): array {
		$hex = ltrim( $hex, '#' );
		return array(
			hexdec( substr( $hex, 0, 2 ) ),
			hexdec( substr( $hex, 2, 2 ) ),
			hexdec( substr( $hex, 4, 2 ) ),
		);
	};

	list( $r1, $g1, $b1 ) = $hex_to_rgb( $palette[0] );
	list( $r2, $g2, $b2 ) = $hex_to_rgb( $palette[1] );
	list( $r3, $g3, $b3 ) = $hex_to_rgb( $palette[2] );

	$background = imagecolorallocate( $image, $r1, $g1, $b1 );
	$accent     = imagecolorallocate( $image, $r2, $g2, $b2 );
	$ink        = imagecolorallocate( $image, $r3, $g3, $b3 );

	imagefilledrectangle( $image, 0, 0, $width, $height, $background );
	imagefilledellipse( $image, 250 + ( $index % 4 ) * 120, 240, 430, 430, $accent );
	imagefilledrectangle( $image, 560, 120 + ( $index % 3 ) * 70, 1080, 610, $ink );
	imagefilledrectangle( $image, 620, 180 + ( $index % 3 ) * 70, 1020, 550, $background );

	$temp = wp_tempnam( 'vaarta-demo-' . $index . '.png' );

	if ( ! $temp || ! imagepng( $image, $temp, 7 ) ) {
		imagedestroy( $image );
		return 0;
	}

	imagedestroy( $image );

	$upload = wp_upload_bits(
		'vaarta-demo-' . $index . '.png',
		null,
		file_get_contents( $temp )
	);

	@unlink( $temp );

	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => 'image/png',
			'post_title'     => 'Vaarta Demo Image ' . ( $index + 1 ),
			'post_status'    => 'inherit',
		),
		$upload['file'],
		$post_id
	);

	if ( is_wp_error( $attachment_id ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';

	$metadata = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
	wp_update_attachment_metadata( $attachment_id, $metadata );
	update_post_meta( $attachment_id, $seed_key, '1' );

	return (int) $attachment_id;
}

$base_time = strtotime( '2026-09-01 10:00:00' );

foreach ( $stories as $index => $story ) {
	list( $title, $category_slug, $views ) = $story;

	$body = sprintf(
		'<p>%1$s</p><p>%2$s</p><h2>%3$s</h2><p>%4$s</p>',
		esc_html__( 'This seeded article exists to provide consistent content density for Vaarta visual regression testing.', 'vaarta' ),
		esc_html__( 'It deliberately uses repeatable paragraph lengths so card excerpts, article measures and responsive layouts can be compared reliably.', 'vaarta' ),
		esc_html__( 'A useful editorial subheading', 'vaarta' ),
		esc_html__( 'Replace this fixture content with real editorial material on production sites. The visual system should remain stable as content changes.', 'vaarta' )
	);

	$post_id = wp_insert_post(
		array(
			'post_title'    => $title,
			'post_excerpt'  => __( 'A concise editorial summary designed to test card density, metadata rhythm and responsive line breaks.', 'vaarta' ),
			'post_content'  => $body,
			'post_status'   => 'publish',
			'post_type'     => 'post',
			'post_date'     => gmdate( 'Y-m-d H:i:s', $base_time - ( $index * DAY_IN_SECONDS ) ),
			'post_category' => isset( $category_ids[ $category_slug ] ) ? array( $category_ids[ $category_slug ] ) : array(),
			'meta_input'    => array(
				$seed_key             => '1',
				VAARTA_VIEWS_META_KEY => $views,
			),
		)
	);

	if ( is_wp_error( $post_id ) ) {
		continue;
	}

	$image_id = vaarta_seed_demo_image( $index, $post_id );

	if ( $image_id ) {
		set_post_thumbnail( $post_id, $image_id );
	}
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::success( 'Vaarta demo content seeded.' );
}
