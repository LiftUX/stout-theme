<?php
/**
 * Child theme version.
 *
 * @since   1.0.0
 * @package Primer
 *
 * @var string
 */
define( 'PRIMER_CHILD_VERSION', '1.1.4' );

/**
 * Move some elements around.
 *
 * @action template_redirect
 * @since  1.0.0
 */
function stout_move_elements() {

	remove_action( 'primer_header', 'primer_add_hero', 7 );
	remove_action( 'primer_after_header', 'primer_add_primary_navigation', 11 );
	remove_action( 'primer_after_header', 'primer_add_page_title', 12 );
	remove_action( 'primer_before_header_wrapper', 'primer_video_header', 5 );

	add_action( 'primer_after_header', 'primer_add_hero', 7 );
	add_action( 'primer_header', 'primer_add_primary_navigation', 11 );
	add_action( 'primer_hero', 'primer_video_header', 3 );

	if ( ! is_front_page() || ! is_active_sidebar( 'hero' ) ) {

		add_action( 'primer_hero', 'primer_add_page_title', 12 );

	}

}
add_action( 'template_redirect', 'stout_move_elements' );

/**
 * Set hero image target element.
 *
 * @filter primer_hero_image_selector
 * @since  1.0.0
 *
 * @return string
 */
function stout_hero_image_selector() {

	return '.hero';

}
add_filter( 'primer_hero_image_selector', 'stout_hero_image_selector' );

/**
 * Set custom logo args.
 *
 * @filter primer_custom_logo_args
 * @since  1.0.0
 *
 * @param  array $args Argument array.
 *
 * @return array
 */
function stout_custom_logo_args( $args ) {

	$args['width']  = 248;
	$args['height'] = 100;

	return $args;

}
add_filter( 'primer_custom_logo_args', 'stout_custom_logo_args' );

/**
 * Set fonts.
 *
 * @filter primer_fonts
 * @since  1.0.0
 *
 * @param  array $fonts Font array.
 *
 * @return array
 */
function stout_fonts( $fonts ) {

	$fonts[] = 'Lato';
	$fonts[] = 'Oswald';

	return $fonts;

}
add_filter( 'primer_fonts', 'stout_fonts' );

/**
 * Set font types.
 *
 * @filter primer_font_types
 * @since  1.0.0
 *
 * @param  array $font_types Font type array.
 *
 * @return array
 */
function stout_font_types( $font_types ) {

	$overrides = array(
		'site_title_font' => array(
			'default' => 'Oswald',
		),
		'navigation_font' => array(
			'default' => 'Oswald',
		),
		'heading_font'    => array(
			'default' => 'Oswald',
		),
		'primary_font'    => array(
			'default' => 'Lato',
		),
		'secondary_font'  => array(
			'default' => 'Lato',
		),
	);

	return primer_array_replace_recursive( $font_types, $overrides );

}
add_filter( 'primer_font_types', 'stout_font_types' );

/**
 * Set colors.
 *
 * @filter primer_colors
 * @since  1.0.0
 *
 * @param  array $colors Color array.
 *
 * @return array
 */
function stout_colors( $colors ) {

	unset(
		$colors['content_background_color'],
		$colors['footer_widget_content_background_color']
	);

	// @codingStandardsIgnoreStart
	$overrides = array(
		/**
		 * Text colors
		 */
		'header_textcolor'                 => array(
			'default' => '#e3ad31',
		),
		'tagline_text_color'               => array(
			'default' => '#686868',
		),
		'hero_text_color'                  => array(
			'default' => '#ffffff',
		),
		'menu_text_color'                  => array(
			'default' => '#686868',
		),
		'heading_text_color'               => array(
			'default' => '#353535',
		),
		'primary_text_color'               => array(
			'default' => '#252525',
		),
		'secondary_text_color'             => array(
			'default' => '#686868',
		),
		'footer_widget_heading_text_color' => array(
			'default' => '#ffffff',
		),
		'footer_widget_text_color'         => array(
			'default' => '#ffffff',
		),
		'footer_menu_text_color'           => array(
			'default'  => '#252525',
			'css'      => array(
				'.footer-menu ul li a,
				.footer-menu ul li a:visited'              => array(
					'color' => '%1$s',
				),
				'.site-info-wrapper .social-menu a,
				.site-info-wrapper .social-menu a:visited' => array(
					'background-color' => '%1$s',
				),
			),
			'rgba_css' => array(
				'.footer-menu ul li a:hover,
				.footer-menu ul li a:visited:hover' => array(
					'color' => 'rgba(%1$s, 0.8)',
				),
			),
		),
		'footer_text_color'                => array(
			'default' => '#686868',
		),
		/**
		 * Link / Button colors
		 */
		'link_color'                       => array(
			'default' => '#e3ad31',
		),
		'button_color'                     => array(
			'default' => '#e3ad31',
		),
		'button_text_color'                => array(
			'default' => '#ffffff',
		),
		/**
		 * Background colors
		 */
		'background_color'                 => array(
			'default' => '#ffffff',
		),
		'hero_background_color'            => array(
			'default' => '#252525',
		),
		'menu_background_color'            => array(
			'default' => '#ffffff',
			'css'     => array(
				'.site-header-wrapper' => array(
					'background-color' => '%1$s',
				),
			),
		),
		'footer_widget_background_color'   => array(
			'default' => '#4e4e4e',
		),
		'footer_background_color'          => array(
			'default' => '#ffffff',
		),
	);
	// @codingStandardsIgnoreEnd

	return primer_array_replace_recursive( $colors, $overrides );

}
add_filter( 'primer_colors', 'stout_colors' );

/**
 * Set color schemes.
 *
 * @filter primer_color_schemes
 * @since  1.0.0
 *
 * @param  array $color_schemes Color scheme array.
 *
 * @return array
 */
function stout_color_schemes( $color_schemes ) {

	unset( $color_schemes['canary'] );

	$overrides = array(
		'blush'     => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['blush']['base'],
				'link_color'       => $color_schemes['blush']['base'],
				'button_color'     => $color_schemes['blush']['base'],
			),
		),
		'bronze'    => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['bronze']['base'],
				'link_color'       => $color_schemes['bronze']['base'],
				'button_color'     => $color_schemes['bronze']['base'],
			),
		),
		'cool'      => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['cool']['base'],
				'link_color'       => $color_schemes['cool']['base'],
				'button_color'     => $color_schemes['cool']['base'],
			),
		),
		'dark'      => array(
			'colors' => array(
				// Text.
				'tagline_text_color'               => '#999999',
				'menu_text_color'                  => '#ffffff',
				'heading_text_color'               => '#ffffff',
				'primary_text_color'               => '#e5e5e5',
				'secondary_text_color'             => '#c1c1c1',
				'footer_widget_heading_text_color' => '#ffffff',
				'footer_widget_text_color'         => '#ffffff',
				'footer_menu_text_color'           => '#ffffff',
				// Backgrounds.
				'background_color'                 => '#222222',
				'hero_background_color'            => '#282828',
				'menu_background_color'            => '#333333',
				'footer_widget_background_color'   => '#282828',
				'footer_background_color'          => '#222222',
			),
		),
		'iguana'    => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['iguana']['base'],
				'link_color'       => $color_schemes['iguana']['base'],
				'button_color'     => $color_schemes['iguana']['base'],
			),
		),
		'muted'     => array(
			'colors' => array(
				// Text.
				'header_textcolor'               => '#5a6175',
				'menu_text_color'                => '#5a6175',
				'heading_text_color'             => '#4f5875',
				'primary_text_color'             => '#4f5875',
				'secondary_text_color'           => '#888c99',
				'footer_menu_text_color'         => $color_schemes['muted']['base'],
				'footer_text_color'              => '#4f5875',
				// Links & Buttons.
				'link_color'                     => $color_schemes['muted']['base'],
				'button_color'                   => $color_schemes['muted']['base'],
				// Backgrounds.
				'background_color'               => '#ffffff',
				'hero_background_color'          => '#5a6175',
				'menu_background_color'          => '#ffffff',
				'footer_widget_background_color' => '#b6b9c5',
				'footer_background_color'        => '#ffffff',
			),
		),
		'plum'      => array(
			'colors' => array(
				'header_textcolor'               => $color_schemes['plum']['base'],
				'link_color'                     => $color_schemes['plum']['base'],
				'button_color'                   => $color_schemes['plum']['base'],
				'footer_widget_background_color' => '#191919',
			),
		),
		'rose'      => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['rose']['base'],
				'link_color'       => $color_schemes['rose']['base'],
				'button_color'     => $color_schemes['rose']['base'],
			),
		),
		'tangerine' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['tangerine']['base'],
				'link_color'       => $color_schemes['tangerine']['base'],
				'button_color'     => $color_schemes['tangerine']['base'],
			),
		),
		'turquoise' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['turquoise']['base'],
				'link_color'       => $color_schemes['turquoise']['base'],
				'button_color'     => $color_schemes['turquoise']['base'],
			),
		),
	);

	return primer_array_replace_recursive( $color_schemes, $overrides );

}
add_filter( 'primer_color_schemes', 'stout_color_schemes' );

/**
 * Enqueue stout hero scripts.
 *
 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @since 1.1.0
 */
function stout_hero_scripts() {

	if ( function_exists( 'primer_is_amp' ) && primer_is_amp() ) {
		return;
	}

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'stout-hero', get_stylesheet_directory_uri() . "/assets/js/stout-hero{$suffix}.js", array( 'jquery' ), PRIMER_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'stout_hero_scripts' );
