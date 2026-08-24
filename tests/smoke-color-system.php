<?php
/**
 * Destructive-but-restoring ATS-WP-DEV color-system smoke test.
 *
 * Run only with explicit approval. The script backs up the exact Global Styles
 * row, changes only post_content, and restores that exact content in finally.
 */

define( 'WP_ADMIN', true );
define( 'WP_USE_THEMES', true );
require dirname( __DIR__, 4 ) . '/wp-load.php';

// Preview this theme inside the smoke process without activating it on the site.
add_filter( 'pre_option_stylesheet', static fn() => 'modern-catholic-theme' );
add_filter( 'pre_option_template', static fn() => 'modern-catholic-theme' );
WP_Theme_JSON_Resolver::clean_cached_data();

if ( ! function_exists( 'modern_catholic_get_curated_style_palettes' ) ) {
	require dirname( __DIR__ ) . '/functions.php';
}

global $wpdb, $submenu;

$failures = array();
$checks   = array();
$skipped  = array();
$expect   = static function ( $condition, $message ) use ( &$failures, &$checks ) {
	$checks[] = $message;
	if ( ! $condition ) {
		$failures[] = $message;
	}
};

$expect( 'modern-catholic-theme' === get_stylesheet(), 'Modern Catholic is the active theme' );

$variations = WP_Theme_JSON_Resolver::get_style_variations();
$expect( 13 === count( $variations ) + 1, 'Sanctuary plus 12 selectable variations are registered' );

$administrators = get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ids' ) );
if ( $administrators ) {
	wp_set_current_user( $administrators[0] );
}
do_action( 'admin_menu' );
$theme_submenus = $submenu['modern-catholic-settings'] ?? array();
$labels         = array_column( $theme_submenus, 0 );
$expect( in_array( 'MC Theme Settings', $labels, true ), 'MC Theme Settings submenu is registered' );
$expect( in_array( 'Color & Style Guide', $labels, true ), 'Color & Style Guide submenu is registered' );
$expect( 13 === count( modern_catholic_get_curated_style_palettes() ), 'The admin guide exposes all 13 curated palettes' );

$active_plugins = get_option( 'active_plugins', array() );
$plugins        = array(
	'Alerts'           => 'modern-catholic-plugin-parish-alerts/parish-alerts.php',
	'Bulletins'        => 'modern-catholic-plugin-parish-bulletins/parish-bulletins.php',
	'Events'           => 'modern-catholic-plugin-parish-events/modern-catholic-parish-events.php',
	'Homilies'         => 'modern-catholic-plugin-parish-homilies/parishpress-homilies.php',
	"Today's Readings" => 'modern-catholic-plugin-todays-readings/usccb-todays-readings.php',
);
foreach ( $plugins as $label => $plugin ) {
	if ( in_array( $plugin, $active_plugins, true ) ) {
		$expect( true, $label . ' is active on ATS-WP-DEV' );
	} else {
		$skipped[] = $label . ' runtime view is skipped because the plugin is inactive on ATS-WP-DEV';
	}
}

$post_id = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();
$expect( 0 < $post_id, 'A saved Global Styles record exists for exact backup and restoration' );

if ( 0 < $post_id ) {
	$row           = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", $post_id ), ARRAY_A );
	$original_hash = hash( 'sha256', serialize( $row ) );
	$backup_path   = get_theme_file_path( 'tests/.global-styles-backup-' . $post_id . '.json' );
	$backup_json   = wp_json_encode( $row, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
	$backup_hash   = hash( 'sha256', $backup_json );
	if ( false === file_put_contents( $backup_path, $backup_json ) ) {
		throw new RuntimeException( 'Could not write the exact Global Styles backup before mutation.' );
	}
	$expect( hash_file( 'sha256', $backup_path ) === $backup_hash, 'The exact Global Styles backup was written and verified before mutation' );

	try {
		$user_styles = json_decode( $row['post_content'], true );
		$settings    = wp_get_global_settings();
		$palette     = $settings['color']['palette']['theme'] ?? array();
		$found       = false;

		foreach ( $palette as &$color ) {
			if ( 'primary' === ( $color['slug'] ?? '' ) ) {
				$color['color'] = '#00ff66';
				$found          = true;
			}
		}
		unset( $color );
		$expect( $found, 'The editable Primary preset is present in merged Global Styles' );

		$user_styles['settings']['color']['palette']['theme'] = $palette;
		$updated = $wpdb->update(
			$wpdb->posts,
			array( 'post_content' => wp_json_encode( $user_styles, JSON_UNESCAPED_SLASHES ) ),
			array( 'ID' => $post_id ),
			array( '%s' ),
			array( '%d' )
		);
		$expect( false !== $updated, 'Temporary conspicuous Primary color was saved' );
		clean_post_cache( $post_id );
		WP_Theme_JSON_Resolver::clean_cached_data();

		$stylesheet = wp_get_global_stylesheet();
		$expect( str_contains( strtolower( $stylesheet ), '#00ff66' ), 'Front-end Global Styles emit the temporary Primary color' );
		$expect( str_contains( file_get_contents( get_theme_file_path( 'style.css' ) ), '--mc-color-primary:' ), 'Theme exposes Primary through the public MC alias' );

		$css_contracts = array(
			'Alerts'           => WP_PLUGIN_DIR . '/modern-catholic-plugin-parish-alerts/assets/public.css',
			'Bulletins'        => WP_PLUGIN_DIR . '/modern-catholic-plugin-parish-bulletins/assets/public.css',
			'Events'           => WP_PLUGIN_DIR . '/modern-catholic-plugin-parish-events/assets/css/frontend.css',
			'Homilies'         => WP_PLUGIN_DIR . '/modern-catholic-plugin-parish-homilies/assets/css/frontend.css',
			"Today's Readings" => WP_PLUGIN_DIR . '/modern-catholic-plugin-todays-readings/blocks/todays-readings/style.css',
		);
		foreach ( $css_contracts as $label => $file ) {
			$expect( str_contains( file_get_contents( $file ), '--mc-color-' ), $label . ' consumes the runtime MC contract' );
		}

		$urls = array(
			'Home and Alerts' => home_url( '/' ),
			'Bulletins'       => get_post_type_archive_link( 'mc_bulletin' ),
			'Events'          => get_post_type_archive_link( 'mc_event' ),
			'Homilies'        => get_post_type_archive_link( 'mc_homily' ),
		);
		foreach ( array_filter( $urls ) as $label => $url ) {
			$response = wp_remote_get( $url, array( 'timeout' => 15 ) );
			$expect( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ), $label . ' public view responds successfully' );
		}

		if ( in_array( $plugins["Today's Readings"], $active_plugins, true ) ) {
			$reading_markup = do_blocks( '<!-- wp:usccb-todays-readings/todays-readings /-->' );
			$expect( str_contains( $reading_markup, 'wp-block-usccb-todays-readings-todays-readings' ), "Today's Readings block renders under the temporary palette" );
		}
	} finally {
		$wpdb->update(
			$wpdb->posts,
			array( 'post_content' => $row['post_content'] ),
			array( 'ID' => $post_id ),
			array( '%s' ),
			array( '%d' )
		);
		clean_post_cache( $post_id );
		WP_Theme_JSON_Resolver::clean_cached_data();
		$restored = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", $post_id ), ARRAY_A );
		$expect( hash( 'sha256', serialize( $restored ) ) === $original_hash, 'The exact original Global Styles database row was restored' );
		if ( is_file( $backup_path ) ) {
			unlink( $backup_path );
		}
	}
}

echo wp_json_encode(
	array(
		'passed'      => count( $checks ) - count( $failures ),
		'total'       => count( $checks ),
		'failures'    => $failures,
		'skipped'     => $skipped,
		'backup_sha256' => $backup_hash ?? null,
		'backup_removed_after_restore' => isset( $backup_path ) && ! is_file( $backup_path ),
	),
	JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
);
echo PHP_EOL;

exit( empty( $failures ) ? 0 : 1 );
