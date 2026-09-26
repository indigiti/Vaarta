<?php
/**
 * Typography
 *
 * @package Caards
 */

?>

:root {

	/* Base Font */
	--cs-font-base-family: '<?php csco_typography( 'font_base', 'font-family', 'Manrope' ); ?>';
	--cs-font-base-size: <?php csco_typography( 'font_base', 'font-size', '1rem' ); ?>;
	--cs-font-base-weight: <?php csco_typography( 'font_base', 'font-weight', '400' ); ?>;
	--cs-font-base-style: <?php csco_typography( 'font_base', 'font-style', 'normal' ); ?>;
	--cs-font-base-letter-spacing: <?php csco_typography( 'font_base', 'letter-spacing', 'normal' ); ?>;
	--cs-font-base-line-height: <?php csco_typography( 'font_base', 'line-height', '1.5' ); ?>;

	/* Primary Font */
	--cs-font-primary-family: '<?php csco_typography( 'font_primary', 'font-family', 'Manrope' ); ?>';
	--cs-font-primary-size: <?php csco_typography( 'font_primary', 'font-size', '0.75rem' ); ?>;
	--cs-font-primary-weight: <?php csco_typography( 'font_primary', 'font-weight', '600' ); ?>;
	--cs-font-primary-style: <?php csco_typography( 'font_primary', 'font-style', 'normal' ); ?>;
	--cs-font-primary-letter-spacing: <?php csco_typography( 'font_primary', 'letter-spacing', 'normal' ); ?>;
	--cs-font-primary-text-transform: <?php csco_typography( 'font_primary', 'text-transform', 'uppercase' ); ?>;

	/* Secondary Font */
	--cs-font-secondary-family: '<?php csco_typography( 'font_secondary', 'font-family', 'Manrope' ); ?>';
	--cs-font-secondary-size: <?php csco_typography( 'font_secondary', 'font-size', '0.75rem' ); ?>;
	--cs-font-secondary-weight: <?php csco_typography( 'font_secondary', 'font-weight', '600' ); ?>;
	--cs-font-secondary-style: <?php csco_typography( 'font_secondary', 'font-style', 'normal' ); ?>;
	--cs-font-secondary-letter-spacing: <?php csco_typography( 'font_secondary', 'letter-spacing', '0px' ); ?>;
	--cs-font-secondary-text-transform: <?php csco_typography( 'font_secondary', 'text-transform', 'none' ); ?>;

	/* Post Meta Font */
	--cs-font-post-meta-family: '<?php csco_typography( 'font_post_meta', 'font-family', 'Manrope' ); ?>';
	--cs-font-post-meta-size: <?php csco_typography( 'font_post_meta', 'font-size', '0.75rem' ); ?>;
	--cs-font-post-meta-weight: <?php csco_typography( 'font_post_meta', 'font-weight', '600' ); ?>;
	--cs-font-post-meta-style: <?php csco_typography( 'font_post_meta', 'font-style', 'normal' ); ?>;
	--cs-font-post-meta-letter-spacing: <?php csco_typography( 'font_post_meta', 'letter-spacing', '0.0125rem' ); ?>;
	--cs-font-post-meta-text-transform: <?php csco_typography( 'font_post_meta', 'text-transform', 'none' ); ?>;

	/* Details Font */
	--cs-font-details-family: '<?php csco_typography( 'font_details', 'font-family', 'Manrope' ); ?>';
	--cs-font-details-size: <?php csco_typography( 'font_details', 'font-size', '0.75rem' ); ?>;
	--cs-font-details-weight: <?php csco_typography( 'font_details', 'font-weight', '600' ); ?>;
	--cs-font-details-style: <?php csco_typography( 'font_details', 'font-style', 'normal' ); ?>;
	--cs-font-details-letter-spacing: <?php csco_typography( 'font_details', 'letter-spacing', '0.0125rem' ); ?>;
	--cs-font-details-text-transform: <?php csco_typography( 'font_details', 'text-transform', 'uppercase' ); ?>;

	/* Entry Excerpt */
	--cs-font-entry-excerpt-family: '<?php csco_typography( 'font_excerpt', 'font-family', 'Manrope' ); ?>';
	--cs-font-entry-excerpt-size: <?php csco_typography( 'font_excerpt', 'font-size', '0.875rem' ); ?>;
	--cs-font-entry-excerpt-line-height: <?php csco_typography( 'font_excerpt', 'line-height', '1.75' ); ?>;
	--cs-font-entry-excerpt-letter-spacing: <?php csco_typography( 'font_excerpt', 'letter-spacing', '-0.0125rem' ); ?>;

	/* Category Font */
	--cs-font-category-family: '<?php csco_typography( 'font_category', 'font-family', 'Manrope' ); ?>';
	--cs-font-category-size: <?php csco_typography( 'font_category', 'font-size', '0.75rem' ); ?>;
	--cs-font-category-weight: <?php csco_typography( 'font_category', 'font-weight', '500' ); ?>;
	--cs-font-category-style: <?php csco_typography( 'font_category', 'font-style', 'normal' ); ?>;
	--cs-font-category-letter-spacing: <?php csco_typography( 'font_category', 'letter-spacing', '-0.025em' ); ?>;
	--cs-font-category-text-transform: <?php csco_typography( 'font_category', 'text-transform', 'uppercase' ); ?>;

	/* Category Latter */
	--cs-font-category-letter-family: '<?php csco_typography( 'font_category_letter', 'font-family', 'Manrope' ); ?>';
	--cs-font-category-letter-size: <?php csco_typography( 'font_category_letter', 'font-size', '1.125rem' ); ?>;
	--cs-font-category-letter-weight: <?php csco_typography( 'font_category_letter', 'font-weight', '600' ); ?>;
	--cs-font-category-letter-style: <?php csco_typography( 'font_category_letter', 'font-style', 'normal' ); ?>;
	--cs-font-category-letter-letter-spacing: <?php csco_typography( 'font_category_letter', 'letter-spacing', 'normal' ); ?>;
	--cs-font-category-letter-text-transform: <?php csco_typography( 'font_category_letter', 'text-transform', 'uppercase' ); ?>;

	/* Post Number Font */
	--cs-font-post-number-family: '<?php csco_typography( 'font_post_number', 'font-family', 'Manrope' ); ?>';
	--cs-font-post-number-size: <?php csco_typography( 'font_post_number', 'font-size', '1.125rem' ); ?>;
	--cs-font-post-number-weight: <?php csco_typography( 'font_post_number', 'font-weight', '600' ); ?>;
	--cs-font-post-number-style: <?php csco_typography( 'font_post_number', 'font-style', 'normal' ); ?>;
	--cs-font-post-number-letter-spacing: <?php csco_typography( 'font_post_number', 'letter-spacing', 'normal' ); ?>;
	--cs-font-post-number-text-transform: <?php csco_typography( 'font_post_number', 'text-transform', 'uppercase' ); ?>;

	/* Tags Font */
	--cs-font-tags-family: '<?php csco_typography( 'font_tag', 'font-family', 'Manrope' ); ?>';
	--cs-font-tags-size: <?php csco_typography( 'font_tag', 'font-size', '0.875rem' ); ?>;
	--cs-font-tags-weight: <?php csco_typography( 'font_tag', 'font-weight', '600' ); ?>;
	--cs-font-tags-style: <?php csco_typography( 'font_tag', 'font-style', 'normal' ); ?>;
	--cs-font-tags-letter-spacing: <?php csco_typography( 'font_tag', 'letter-spacing', '-0.025em' ); ?>;
	--cs-font-tags-text-transform: <?php csco_typography( 'font_tag', 'text-transform', 'none' ); ?>;

	/* Post Subbtitle */
	--cs-font-post-subtitle-family: '<?php csco_typography( 'font_post_subtitle', 'font-family', 'Manrope' ); ?>';
	--cs-font-post-subtitle-size: <?php csco_typography( 'font_post_subtitle', 'font-size', '1.75rem' ); ?>;
	--cs-font-post-subtitle-weight: <?php csco_typography( 'font_post_subtitle', 'font-weight', '400' ); ?>;
	--cs-font-post-subtitle-letter-spacing: <?php csco_typography( 'font_post_subtitle', 'letter-spacing', 'normal' ); ?>;
	--cs-font-post-subtitle-line-height:<?php csco_typography( 'font_post_subtitle', 'line-height', '1.25' ); ?>;

	/* Post Content */
	--cs-font-post-content-family: '<?php csco_typography( 'font_post_content', 'font-family', 'Manrope' ); ?>';
	--cs-font-post-content-size: <?php csco_typography( 'font_post_content', 'font-size', '1.125rem' ); ?>;
	--cs-font-post-content-line-height:<?php csco_typography( 'font_post_content', 'line-height', '1.65' ); ?>;
	--cs-font-post-content-letter-spacing: <?php csco_typography( 'font_post_content', 'letter-spacing', '-0.0125rem' ); ?>;

	/* Input Font */
	--cs-font-input-family: '<?php csco_typography( 'font_input', 'font-family', 'Manrope' ); ?>';
	--cs-font-input-size: <?php csco_typography( 'font_input', 'font-size', '0.75rem' ); ?>;
	--cs-font-input-weight: <?php csco_typography( 'font_input', 'font-weight', '600' ); ?>;
	--cs-font-input-line-height:<?php csco_typography( 'font_input', 'line-height', '1.625rem' ); ?>;
	--cs-font-input-style: <?php csco_typography( 'font_input', 'font-style', 'normal' ); ?>;
	--cs-font-input-letter-spacing: <?php csco_typography( 'font_input', 'letter-spacing', 'normal' ); ?>;
	--cs-font-input-text-transform: <?php csco_typography( 'font_input', 'text-transform', 'none' ); ?>;

	/* Button Font */
	--cs-font-button-family: '<?php csco_typography( 'font_button', 'font-family', 'Manrope' ); ?>';
	--cs-font-button-size: <?php csco_typography( 'font_button', 'font-size', '0.875rem' ); ?>;
	--cs-font-button-weight: <?php csco_typography( 'font_button', 'font-weight', '600' ); ?>;
	--cs-font-button-style: <?php csco_typography( 'font_button', 'font-style', 'normal' ); ?>;
	--cs-font-button-letter-spacing: <?php csco_typography( 'font_button', 'letter-spacing', 'normal' ); ?>;
	--cs-font-button-text-transform: <?php csco_typography( 'font_button', 'text-transform', 'none' ); ?>;

	/* Main Logo */
	--cs-font-main-logo-family: '<?php csco_typography( 'font_main_logo', 'font-family', 'Manrope' ); ?>';
	--cs-font-main-logo-size: <?php csco_typography( 'font_main_logo', 'font-size', '1.5rem' ); ?>;
	--cs-font-main-logo-weight: <?php csco_typography( 'font_main_logo', 'font-weight', '700' ); ?>;
	--cs-font-main-logo-style: <?php csco_typography( 'font_main_logo', 'font-style', 'normal' ); ?>;
	--cs-font-main-logo-letter-spacing: <?php csco_typography( 'font_main_logo', 'letter-spacing', '-0.075em' ); ?>;
	--cs-font-main-logo-text-transform: <?php csco_typography( 'font_main_logo', 'text-transform', 'none' ); ?>;

	/* Large Logo */
	--cs-font-large-logo-family: '<?php csco_typography( 'font_large_logo', 'font-family', 'Manrope' ); ?>';
	--cs-font-large-logo-size: <?php csco_typography( 'font_large_logo', 'font-size', '1.75rem' ); ?>;
	--cs-font-large-logo-weight: <?php csco_typography( 'font_large_logo', 'font-weight', '700' ); ?>;
	--cs-font-large-logo-style: <?php csco_typography( 'font_large_logo', 'font-style', 'normal' ); ?>;
	--cs-font-large-logo-letter-spacing: <?php csco_typography( 'font_large_logo', 'letter-spacing', '-0.075em' ); ?>;
	--cs-font-large-logo-text-transform: <?php csco_typography( 'font_large_logo', 'text-transform', 'none' ); ?>;

	/* Tagline Font */
	--cs-font-tag-line-family: '<?php csco_typography( 'font_tagline', 'font-family', 'Manrope' ); ?>';
	--cs-font-tag-line-size: <?php csco_typography( 'font_tagline', 'font-size', '0.75rem' ); ?>;
	--cs-font-tag-line-weight: <?php csco_typography( 'font_tagline', 'font-weight', '600' ); ?>;
	--cs-font-tag-line-style: <?php csco_typography( 'font_tagline', 'font-style', 'normal' ); ?>;
	--cs-font-tag-line-line-height: <?php csco_typography( 'font_tagline', 'line-height', '1.5' ); ?>;
	--cs-font-tag-line-letter-spacing: <?php csco_typography( 'font_tagline', 'letter-spacing', 'normal' ); ?>;
	--cs-font-tag-line-text-transform: <?php csco_typography( 'font_tagline', 'text-transform', 'none' ); ?>;

	/* Footer Logo */
	--cs-font-footer-logo-family: '<?php csco_typography( 'font_footer_logo', 'font-family', 'Manrope' ); ?>';
	--cs-font-footer-logo-size: <?php csco_typography( 'font_footer_logo', 'font-size', '1.5rem' ); ?>;
	--cs-font-footer-logo-weight: <?php csco_typography( 'font_footer_logo', 'font-weight', '700' ); ?>;
	--cs-font-footer-logo-style: <?php csco_typography( 'font_footer_logo', 'font-style', 'normal' ); ?>;
	--cs-font-footer-logo-letter-spacing: <?php csco_typography( 'font_footer_logo', 'letter-spacing', '-0.075em' ); ?>;
	--cs-font-footer-logo-text-transform: <?php csco_typography( 'font_footer_logo', 'text-transform', 'none' ); ?>;

	/* Headings */
	--cs-font-headings-family: '<?php csco_typography( 'font_headings', 'font-family', 'Manrope' ); ?>';
	--cs-font-headings-weight: <?php csco_typography( 'font_headings', 'font-weight', '800' ); ?>;
	--cs-font-headings-style: <?php csco_typography( 'font_headings', 'font-style', 'normal' ); ?>;
	--cs-font-headings-line-height: <?php csco_typography( 'font_headings', 'line-height', '1.14' ); ?>;
	--cs-font-headings-letter-spacing: <?php csco_typography( 'font_headings', 'letter-spacing', '-0.0125em' ); ?>;
	--cs-font-headings-text-transform: <?php csco_typography( 'font_headings', 'text-transform', 'none' ); ?>;

	/* Headings of Sidebar */
	--cs-font-headings-sidebar-family: '<?php csco_typography( 'font_headings_sidebar', 'font-family', 'Manrope' ); ?>';
	--cs-font-headings-sidebar-size: <?php csco_typography( 'font_headings_sidebar', 'font-size', '0.75rem' ); ?>;
	--cs-font-headings-sidebar-weight: <?php csco_typography( 'font_headings_sidebar', 'font-weight', '600' ); ?>;
	--cs-font-headings-sidebar-style: <?php csco_typography( 'font_headings_sidebar', 'font-style', 'normal' ); ?>;
	--cs-font-headings-sidebar-letter-spacing: <?php csco_typography( 'font_headings_sidebar', 'letter-spacing', 'normal' ); ?>;
	--cs-font-headings-sidebar-text-transform: <?php csco_typography( 'font_headings_sidebar', 'text-transform', 'uppercase' ); ?>;

	/* Section Headings */
	--cs-font-section-headings-family: '<?php csco_typography( 'section_heading_font', 'font-family', 'Manrope' ); ?>';
	--cs-font-section-headings-size: <?php csco_typography( 'section_heading_font', 'font-size', '2rem' ); ?>;
	--cs-font-section-headings-weight: <?php csco_typography( 'section_heading_font', 'font-weight', '800' ); ?>;
	--cs-font-section-headings-style: <?php csco_typography( 'section_heading_font', 'font-style', 'normal' ); ?>;
	--cs-font-section-headings-letter-spacing: <?php csco_typography( 'section_heading_font', 'letter-spacing', 'normal' ); ?>;
	--cs-font-section-headings-text-transform: <?php csco_typography( 'section_heading_font', 'text-transform', 'none' ); ?>;

	/* Menu Font --------------- */
	--cs-font-primary-menu-family: '<?php csco_typography( 'font_menu', 'font-family', 'Manrope' ); ?>';
	--cs-font-primary-menu-size: <?php csco_typography( 'font_menu', 'font-size', '0.875rem' ); ?>;
	--cs-font-primary-menu-weight: <?php csco_typography( 'font_menu', 'font-weight', '600' ); ?>;
	--cs-font-primary-menu-style: <?php csco_typography( 'font_menu', 'font-style', 'normal' ); ?>;
	--cs-font-primary-menu-letter-spacing: <?php csco_typography( 'font_menu', 'letter-spacing', '-0.0125em' ); ?>;
	--cs-font-primary-menu-text-transform: <?php csco_typography( 'font_menu', 'text-transform', 'none' ); ?>;

	/* Submenu Font */
	--cs-font-primary-submenu-family: '<?php csco_typography( 'font_submenu', 'font-family', 'Manrope' ); ?>';
	--cs-font-primary-submenu-size: <?php csco_typography( 'font_submenu', 'font-size', '0.875rem' ); ?>;
	--cs-font-primary-submenu-weight: <?php csco_typography( 'font_submenu', 'font-weight', '600' ); ?>;
	--cs-font-primary-submenu-style: <?php csco_typography( 'font_submenu', 'font-style', 'normal' ); ?>;
	--cs-font-primary-submenu-letter-spacing: <?php csco_typography( 'font_submenu', 'letter-spacing', 'normal' ); ?>;
	--cs-font-primary-submenu-text-transform: <?php csco_typography( 'font_submenu', 'text-transform', 'none' ); ?>;

	/* Used for main top level fullscreen-menu elements. */
	--cs-font-fullscreen-menu-family: '<?php csco_typography( 'font_fullscreen_menu', 'font-family', 'Manrope' ); ?>';
	--cs-font-fullscreen-menu-size: <?php csco_typography( 'font_fullscreen_menu', 'font-size', ' 2.625rem' ); ?>;
	--cs-font-fullscreen-menu-weight: <?php csco_typography( 'font_fullscreen_menu', 'font-weight', '800' ); ?>;
	--cs-font-fullscreen-menu-line-height: <?php csco_typography( 'font_fullscreen_menu', 'line-height', '1' ); ?>;
	--cs-font-fullscreen-menu-style: <?php csco_typography( 'font_fullscreen_menu', 'font-style', 'normal' ); ?>;
	--cs-font-fullscreen-menu-letter-spacing: <?php csco_typography( 'font_fullscreen_menu', 'letter-spacing', '-0.025em' ); ?>;
	--cs-font-fullscreen-menu-text-transform: <?php csco_typography( 'font_fullscreen_menu', 'text-transform', 'none' ); ?>;

	/* Submenu Font */
	--cs-font-fullscreen-submenu-family: '<?php csco_typography( 'font_fullscreen_submenu', 'font-family', 'Manrope' ); ?>';
	--cs-font-fullscreen-submenu-size: <?php csco_typography( 'font_fullscreen_submenu', 'font-size', '0.875rem' ); ?>;
	--cs-font-fullscreen-submenu-weight: <?php csco_typography( 'font_fullscreen_submenu', 'font-weight', '600' ); ?>;
	--cs-font-fullscreen-submenu-line-height: <?php csco_typography( 'font_fullscreen_submenu', 'line-height', '1.2' ); ?>;
	--cs-font-fullscreen-submenu-style: <?php csco_typography( 'font_fullscreen_submenu', 'font-style', 'normal' ); ?>;
	--cs-font-fullscreen-submenu-letter-spacing: <?php csco_typography( 'font_fullscreen_submenu', 'letter-spacing', 'normal' ); ?>;
	--cs-font-fullscreen-submenu-text-transform: <?php csco_typography( 'font_fullscreen_submenu', 'text-transform', 'none' ); ?>;

	/* Featured Menu */
	--cs-font-featured-menu-family: '<?php csco_typography( 'font_featured_menu', 'font-family', 'Manrope' ); ?>';
	--cs-font-featured-menu-size: <?php csco_typography( 'font_featured_menu', 'font-size', '1rem' ); ?>;
	--cs-font-featured-menu-weight: <?php csco_typography( 'font_featured_menu', 'font-weight', '800' ); ?>;
	--cs-font-featured-menu-style: <?php csco_typography( 'font_featured_menu', 'font-style', 'normal' ); ?>;
	--cs-font-featured-menu-letter-spacing: <?php csco_typography( 'font_featured_menu', 'letter-spacing', '-0.025em' ); ?>;
	--cs-font-featured-menu-text-transform: <?php csco_typography( 'font_featured_menu', 'text-transform', 'none' ); ?>;

	/* Featured Submenu Font */
	--cs-font-featured-submenu-family: '<?php csco_typography( 'font_featured_submenu', 'font-family', 'Manrope' ); ?>';
	--cs-font-featured-submenu-size: <?php csco_typography( 'font_featured_submenu', 'font-size', '0.875rem' ); ?>;
	--cs-font-featured-submenu-weight: <?php csco_typography( 'font_featured_submenu', 'font-weight', '600' ); ?>;
	--cs-font-featured-submenu-style: <?php csco_typography( 'font_featured_submenu', 'font-style', 'normal' ); ?>;
	--cs-font-featured-submenu-letter-spacing: <?php csco_typography( 'font_featured_submenu', 'letter-spacing', 'normal' ); ?>;
	--cs-font-featured-submenu-text-transform: <?php csco_typography( 'font_featured_submenu', 'text-transform', 'none' ); ?>;

	/* Footer Menu Font */
	--cs-font-footer-menu-family: '<?php csco_typography( 'font_footer_menu', 'font-family', 'Manrope' ); ?>';
	--cs-font-footer-menu-size: <?php csco_typography( 'font_footer_menu', 'font-size', '1.5rem' ); ?>;;
	--cs-font-footer-menu-weight: <?php csco_typography( 'font_footer_menu', 'font-weight', '800' ); ?>;
	--cs-font-footer-menu-line-height: <?php csco_typography( 'font_footer_menu', 'line-height', '1' ); ?>;
	--cs-font-footer-menu-style:<?php csco_typography( 'font_footer_menu', 'font-style', 'normal' ); ?>;
	--cs-font-footer-menu-letter-spacing: <?php csco_typography( 'font_footer_menu', 'letter-spacing', '-0.025em' ); ?>;
	--cs-font-footer-menu-text-transform:  <?php csco_typography( 'font_footer_menu', 'text-transform', 'none' ); ?>;

	/* Footer Submenu Font */
	--cs-font-footer-submenu-family: '<?php csco_typography( 'font_footer_submenu', 'font-family', 'Manrope' ); ?>';
	--cs-font-footer-submenu-size: <?php csco_typography( 'font_footer_submenu', 'font-size', '0.875rem' ); ?>;
	--cs-font-footer-submenu-weight: <?php csco_typography( 'font_footer_submenu', 'font-weight', '600' ); ?>;
	--cs-font-footer-submenu-line-height: <?php csco_typography( 'font_footer_submenu', 'line-height', '1' ); ?>;
	--cs-font-footer-submenu-style: <?php csco_typography( 'font_footer_submenu', 'font-style', 'normal' ); ?>;
	--cs-font-footer-submenu-letter-spacing: <?php csco_typography( 'font_footer_submenu', 'letter-spacing', 'normal' ); ?>;
	--cs-font-footer-submenu-text-transform: <?php csco_typography( 'font_footer_submenu', 'text-transform', 'none' ); ?>;

	/* Footer Bottom Menu Font */
	--cs-font-footer-bottom-submenu-family: '<?php csco_typography( 'font_footer_submenu', 'font-family', 'Manrope' ); ?>';
	--cs-font-footer-bottom-submenu-size: <?php csco_typography( 'font_footer_submenu', 'font-size', '0.875rem' ); ?>;
	--cs-font-footer-bottom-submenu-weight: <?php csco_typography( 'font_footer_submenu', 'font-weight', '600' ); ?>;
	--cs-font-footer-bottom-submenu-line-height: <?php csco_typography( 'font_footer_submenu', 'line-height', '1' ); ?>;
	--cs-font-footer-bottom-submenu-style: <?php csco_typography( 'font_footer_submenu', 'font-style', 'normal' ); ?>;
	--cs-font-footer-bottom-submenu-letter-spacing: <?php csco_typography( 'font_footer_submenu', 'letter-spacing', 'normal' ); ?>;
	--cs-font-footer-bottom-submenu-text-transform: <?php csco_typography( 'font_footer_submenu', 'text-transform', 'none' ); ?>;
}
