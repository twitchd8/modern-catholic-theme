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
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'modern_catholic_setup' );

/**
 * Enqueue the theme stylesheet on the front end.
 *
 * @return void
 */
function modern_catholic_enqueue_styles() {
	wp_enqueue_style(
		'modern-catholic-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'modern_catholic_enqueue_styles' );
