<?php
/**
 * Theme setup and assets.
 *
 * @package Modern_Catholic
 */

/**
 * Make the front-end stylesheet available in the Site Editor.
 *
 * @return void
 */
function modern_catholic_setup() {
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'style.css', 'assets/css/mega-menu.css' ) );
}
add_action( 'after_setup_theme', 'modern_catholic_setup' );

/**
 * Register optional presentation styles for theme template parts.
 *
 * @return void
 */
function modern_catholic_register_block_styles() {
	$theme = wp_get_theme();

	wp_enqueue_block_style(
		'core/navigation-submenu',
		array(
			'handle' => 'modern-catholic-mega-menu',
			'src'    => get_theme_file_uri( 'assets/css/mega-menu.css' ),
			'path'   => get_theme_file_path( 'assets/css/mega-menu.css' ),
			'ver'    => $theme->get( 'Version' ),
		)
	);

	register_block_style(
		'core/template-part',
		array(
			'name'  => 'modern-catholic-stacked-header',
			'label' => __( 'Stacked (No Overlay)', 'modern-catholic' ),
		)
	);

	register_block_style(
		'core/navigation-submenu',
		array(
			'name'  => 'modern-catholic-mega-menu-2',
			'label' => __( 'Mega Menu — 2 Columns', 'modern-catholic' ),
		)
	);

	register_block_style(
		'core/navigation-submenu',
		array(
			'name'  => 'modern-catholic-mega-menu-3',
			'label' => __( 'Mega Menu — 3 Columns', 'modern-catholic' ),
		)
	);
}
add_action( 'init', 'modern_catholic_register_block_styles' );

/**
 * Enqueue the theme stylesheet on the front end.
 *
 * @return void
 */
function modern_catholic_enqueue_styles() {
	$theme = wp_get_theme();

	wp_enqueue_style(
		'modern-catholic-style',
		get_stylesheet_uri(),
		array(),
		$theme->get( 'Version' )
	);

	if ( is_front_page() ) {
		wp_enqueue_script(
			'modern-catholic-front-page-header',
			get_theme_file_uri( 'assets/js/front-page-header.js' ),
			array(),
			$theme->get( 'Version' ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'modern_catholic_enqueue_styles' );

/**
 * Identify Single Posts that can use a featured-image header treatment.
 *
 * @param string[] $classes Existing body classes.
 * @return string[]
 */
function modern_catholic_featured_header_body_class( $classes ) {
	if ( is_singular( 'post' ) && has_post_thumbnail() ) {
		$classes[] = 'modern-catholic-has-featured-image';
	}

	return $classes;
}
add_filter( 'body_class', 'modern_catholic_featured_header_body_class' );

require_once get_theme_file_path( 'inc/parish-settings.php' );
