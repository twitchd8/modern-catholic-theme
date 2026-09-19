<?php
/**
 * Read-only color and style guide for theme administrators.
 *
 * @package Modern_Catholic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the approved description for every curated variation.
 *
 * @return string[]
 */
function modern_catholic_get_style_descriptions() {
	return array(
		'Sanctuary'             => __( 'Warm burgundy, moss, and gold drawn from parish interiors; welcoming and traditional.', 'modern-catholic' ),
		'Marian Blue'           => __( 'Clear Marian blue with devotional burgundy and gold; calm, familiar, and reverent.', 'modern-catholic' ),
		'Cloister Green'        => __( 'Muted monastic green with earthen brown and gold; quiet and grounded.', 'modern-catholic' ),
		'Advent Violet'         => __( 'Liturgical violet with rose and gold; contemplative and seasonal.', 'modern-catholic' ),
		'Cathedral Navy'        => __( 'Architectural navy, restrained wine, and antique gold. Formal without feeling cold.', 'modern-catholic' ),
		'Franciscan Earth'      => __( 'Warm umber, muted sage, and ochre. Humble, natural, and welcoming.', 'modern-catholic' ),
		'Stained Glass Teal'    => __( 'Deep teal, plum, and amber. Richly colored while remaining readable and calm.', 'modern-catholic' ),
		'Paschal Gold'          => __( 'Resurrection gold with Marian blue and a restrained burgundy accent. Luminous rather than metallic.', 'modern-catholic' ),
		'Pentecost Red'         => __( 'Clear ecclesial red, ember orange, and warm gold. Energetic without becoming harsh.', 'modern-catholic' ),
		'Ordinary Time Green'   => __( 'A fresher sacramental green with walnut and muted gold. More vivid than Cloister Green.', 'modern-catholic' ),
		'Roman Gold'            => __( 'Antique gold, ecclesial wine, and patinated blue. Classical and ceremonial without looking ornate.', 'modern-catholic' ),
		'Sacred Heart Crimson'  => __( 'Devotional crimson, evergreen, and reliquary gold. Richer and clearer than the muted Sanctuary default.', 'modern-catholic' ),
		'Monastic Charcoal'     => __( 'Soft charcoal, weathered stone-brown, and bronze. Quiet, disciplined, highly legible, and especially suited to Gothic architecture or black-and-white photography.', 'modern-catholic' ),
	);
}

/**
 * Load the six editable colors for each bundled style.
 *
 * @return array<string, array<string, string>>
 */
function modern_catholic_get_curated_style_palettes() {
	$files = array( 'Sanctuary' => get_theme_file_path( 'theme.json' ) );

	foreach ( glob( get_theme_file_path( 'styles/*.json' ) ) ?: array() as $file ) {
		$data = json_decode( file_get_contents( $file ), true );
		if ( is_array( $data ) && ! empty( $data['title'] ) ) {
			$files[ $data['title'] ] = $file;
		}
	}

	$palettes = array();
	$roles    = array( 'canvas', 'surface', 'foreground', 'primary', 'secondary', 'accent' );

	foreach ( $files as $title => $file ) {
		$data = json_decode( file_get_contents( $file ), true );
		foreach ( $data['settings']['color']['palette'] ?? array() as $color ) {
			if ( in_array( $color['slug'] ?? '', $roles, true ) ) {
				$palettes[ $title ][ $color['slug'] ] = $color['color'];
			}
		}
	}

	return $palettes;
}

/**
 * Register the read-only guide below the theme settings screen.
 *
 * @return void
 */
function modern_catholic_add_color_style_guide_page() {
	add_submenu_page(
		'modern-catholic-settings',
		__( 'Color & Style Guide', 'modern-catholic' ),
		__( 'Color & Style Guide', 'modern-catholic' ),
		'edit_theme_options',
		'modern-catholic-color-style-guide',
		'modern_catholic_render_color_style_guide_page'
	);
}
add_action( 'admin_menu', 'modern_catholic_add_color_style_guide_page', 11 );

/**
 * Render the color and style guide.
 *
 * @return void
 */
function modern_catholic_render_color_style_guide_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$descriptions = modern_catholic_get_style_descriptions();
	$palettes     = modern_catholic_get_curated_style_palettes();
	?>
	<div class="wrap modern-catholic-style-guide">
		<h1><?php esc_html_e( 'Color & Style Guide', 'modern-catholic' ); ?></h1>
		<p><?php esc_html_e( 'Modern Catholic uses six editable Theme colors. The theme and compatible plugins derive their supporting tones from these foundation colors.', 'modern-catholic' ); ?></p>
		<p><?php esc_html_e( 'Open Sans is bundled locally as the default font. The system font remains available under Styles → Typography.', 'modern-catholic' ); ?></p>
		<h2><?php esc_html_e( 'Edit parish brand colors', 'modern-catholic' ); ?></h2>
		<ol>
			<li><?php esc_html_e( 'Open Appearance → Editor → Styles → Colors → Palette.', 'modern-catholic' ); ?></li>
			<li><?php esc_html_e( 'Edit the six Theme colors: Canvas, Surface, Foreground, Primary, Secondary, and Accent.', 'modern-catholic' ); ?></li>
			<li><?php esc_html_e( 'Save the Styles changes. Supporting tones, plugin colors, gradients, and contrast text update from those roles.', 'modern-catholic' ); ?></li>
		</ol>
		<p><strong><?php esc_html_e( 'Before previewing another bundled variation:', 'modern-catholic' ); ?></strong> <?php esc_html_e( 'reset any saved Theme palette colors in Global Styles. Saved administrator colors intentionally override variation defaults.', 'modern-catholic' ); ?></p>

		<h2><?php esc_html_e( 'Semantic roles', 'modern-catholic' ); ?></h2>
		<p><?php esc_html_e( 'Canvas is the page backdrop; Surface contains content; Foreground is readable text; Primary is the dominant parish brand; Secondary supports it; Accent is reserved for emphasis and focus. Muted text, borders, softer and stronger brand tones, image scrims, and status colors are automatic.', 'modern-catholic' ); ?></p>
		<p><?php esc_html_e( 'Automatic contrast applies to solid brand and status backgrounds in supporting browsers. Photography always uses the On Image color with a scrim. Duotones are curated per variation because WordPress does not bind duotone filters to CSS variables.', 'modern-catholic' ); ?></p>

		<h2><?php esc_html_e( 'Raised information panels', 'modern-catholic' ); ?></h2>
		<p><?php esc_html_e( 'Select a Group or Column block and choose Raised Panel in its Styles controls, or add a class in Advanced → Additional CSS class(es). Use mc-card (or mc-card-accent1) for an Accent strip, mc-card-accent2 for Secondary, and mc-card-accent3 for Primary. Panel surfaces, borders, shadows, and strips follow the active palette; a background color selected directly on the block remains in control.', 'modern-catholic' ); ?></p>

		<h2><?php esc_html_e( 'Curated variations', 'modern-catholic' ); ?></h2>
		<div class="modern-catholic-style-guide__grid">
			<?php foreach ( $descriptions as $title => $description ) : ?>
				<section class="modern-catholic-style-guide__card">
					<h3><?php echo esc_html( $title ); ?></h3>
					<p><?php echo esc_html( $description ); ?></p>
					<div class="modern-catholic-style-guide__swatches" aria-label="<?php echo esc_attr( sprintf( __( '%s palette', 'modern-catholic' ), $title ) ); ?>">
						<?php foreach ( $palettes[ $title ] ?? array() as $role => $color ) : ?>
							<div><span style="background-color:<?php echo esc_attr( $color ); ?>"></span><small><?php echo esc_html( ucwords( str_replace( '-', ' ', $role ) ) ); ?><br><code><?php echo esc_html( $color ); ?></code></small></div>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
	<style>
		.modern-catholic-style-guide__grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(22rem,1fr));gap:1rem;max-width:90rem}.modern-catholic-style-guide__card{background:#fff;border:1px solid #c3c4c7;border-radius:.25rem;padding:1rem}.modern-catholic-style-guide__card h3{margin-top:0}.modern-catholic-style-guide__swatches{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:.75rem}.modern-catholic-style-guide__swatches div{min-width:0}.modern-catholic-style-guide__swatches span{display:block;height:3rem;border:1px solid rgb(0 0 0 / 18%);border-radius:.2rem}.modern-catholic-style-guide__swatches small{display:block;margin-top:.25rem}.modern-catholic-style-guide__swatches code{font-size:.75rem}
	</style>
	<?php
}
