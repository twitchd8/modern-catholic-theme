<?php
/**
 * Central parish settings and block bindings.
 *
 * @package Modern_Catholic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Name of the option used to store parish settings.
 */
const MODERN_CATHOLIC_PARISH_SETTINGS_OPTION = 'modern_catholic_parish_settings';

/**
 * Return the default parish settings.
 *
 * Defaults intentionally contain placeholders rather than invented parish data.
 *
 * @return string[]
 */
function modern_catholic_get_parish_settings_defaults() {
	return array(
		'weekend_masses'      => "Saturday: [time]\nSunday: [times]",
		'weekday_masses'      => 'Monday–Friday: [times]',
		'reconciliation'      => "[day and time]\nor by appointment",
		'parish_address'      => '',
		'office_address'      => '',
		'parish_phone'        => '',
		'parish_email'        => '',
	);
}

/**
 * Return all saved parish settings merged with safe defaults.
 *
 * @return string[]
 */
function modern_catholic_get_parish_settings() {
	$saved = get_option( MODERN_CATHOLIC_PARISH_SETTINGS_OPTION, array() );

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	return array_merge( modern_catholic_get_parish_settings_defaults(), $saved );
}

/**
 * Return one parish setting.
 *
 * When a separate office address is not supplied, the parish address is used.
 *
 * @param string $key Setting key.
 * @return string
 */
function modern_catholic_get_parish_setting( $key ) {
	$settings = modern_catholic_get_parish_settings();

	if ( ! array_key_exists( $key, $settings ) ) {
		return '';
	}

	if ( 'office_address' === $key && '' === trim( $settings[ $key ] ) ) {
		return $settings['parish_address'];
	}

	return $settings[ $key ];
}

/**
 * Sanitize the complete parish settings option.
 *
 * @param mixed $input Submitted option value.
 * @return string[]
 */
function modern_catholic_sanitize_parish_settings( $input ) {
	$defaults = modern_catholic_get_parish_settings_defaults();
	$input    = is_array( $input ) ? $input : array();
	$clean    = array();

	foreach ( array( 'weekend_masses', 'weekday_masses', 'reconciliation', 'parish_address', 'office_address' ) as $key ) {
		$clean[ $key ] = sanitize_textarea_field( $input[ $key ] ?? $defaults[ $key ] );
	}

	$clean['parish_phone'] = sanitize_text_field( $input['parish_phone'] ?? '' );

	$submitted_email = sanitize_text_field( $input['parish_email'] ?? '' );
	$clean_email     = sanitize_email( $submitted_email );

	if ( '' !== $submitted_email && '' === $clean_email ) {
		$existing = modern_catholic_get_parish_settings();
		$clean_email = $existing['parish_email'];

		add_settings_error(
			MODERN_CATHOLIC_PARISH_SETTINGS_OPTION,
			'modern_catholic_invalid_parish_email',
			__( 'The parish email address was not valid, so the previous email address was kept.', 'modern-catholic' ),
			'error'
		);
	}

	$clean['parish_email'] = $clean_email;

	return $clean;
}

/**
 * Register the parish settings, sections, and fields.
 *
 * @return void
 */
function modern_catholic_register_parish_settings() {
	register_setting(
		'modern_catholic_parish_settings_group',
		MODERN_CATHOLIC_PARISH_SETTINGS_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'modern_catholic_sanitize_parish_settings',
			'default'           => modern_catholic_get_parish_settings_defaults(),
		)
	);

	add_settings_section(
		'modern_catholic_mass_times_section',
		__( 'Mass and Reconciliation Times', 'modern-catholic' ),
		'modern_catholic_render_mass_times_section',
		'modern-catholic-settings'
	);

	add_settings_section(
		'modern_catholic_contact_section',
		__( 'Parish Contact Details', 'modern-catholic' ),
		'modern_catholic_render_contact_section',
		'modern-catholic-settings'
	);

	$fields = array(
		'weekend_masses' => array(
			'label'       => __( 'Weekend Masses', 'modern-catholic' ),
			'section'     => 'modern_catholic_mass_times_section',
			'type'        => 'textarea',
			'rows'        => 4,
			'description' => __( 'Enter one Mass time per line or format the schedule as parishioners should read it.', 'modern-catholic' ),
		),
		'weekday_masses' => array(
			'label'       => __( 'Weekday Masses', 'modern-catholic' ),
			'section'     => 'modern_catholic_mass_times_section',
			'type'        => 'textarea',
			'rows'        => 4,
			'description' => __( 'Include every regular weekday schedule that should appear on the site.', 'modern-catholic' ),
		),
		'reconciliation' => array(
			'label'       => __( 'Reconciliation Times', 'modern-catholic' ),
			'section'     => 'modern_catholic_mass_times_section',
			'type'        => 'textarea',
			'rows'        => 4,
			'description' => __( 'Include scheduled times and any appointment guidance.', 'modern-catholic' ),
		),
		'parish_address' => array(
			'label'       => __( 'Parish Address', 'modern-catholic' ),
			'section'     => 'modern_catholic_contact_section',
			'type'        => 'textarea',
			'rows'        => 3,
			'description' => __( 'The main worship-site or parish address.', 'modern-catholic' ),
		),
		'office_address' => array(
			'label'       => __( 'Office Address', 'modern-catholic' ),
			'section'     => 'modern_catholic_contact_section',
			'type'        => 'textarea',
			'rows'        => 3,
			'description' => __( 'Leave blank when the parish office uses the main parish address.', 'modern-catholic' ),
		),
		'parish_phone' => array(
			'label'       => __( 'Parish Phone Number', 'modern-catholic' ),
			'section'     => 'modern_catholic_contact_section',
			'type'        => 'tel',
			'description' => __( 'Enter the public telephone number in the format parishioners should see.', 'modern-catholic' ),
		),
		'parish_email' => array(
			'label'       => __( 'Parish Email Address', 'modern-catholic' ),
			'section'     => 'modern_catholic_contact_section',
			'type'        => 'email',
			'description' => __( 'Enter one public parish email address.', 'modern-catholic' ),
		),
	);

	foreach ( $fields as $key => $field ) {
		add_settings_field(
			'modern_catholic_' . $key,
			$field['label'],
			'modern_catholic_render_parish_setting_field',
			'modern-catholic-settings',
			$field['section'],
			array_merge(
				$field,
				array(
					'key'       => $key,
					'label_for' => 'modern-catholic-' . $key,
				)
			)
		);
	}
}
add_action( 'admin_init', 'modern_catholic_register_parish_settings' );

/**
 * Render the Mass Times settings section description.
 *
 * @return void
 */
function modern_catholic_render_mass_times_section() {
	echo '<p>' . esc_html__( 'Update these schedules once. Every Modern Catholic block bound to these settings will use the saved values.', 'modern-catholic' ) . '</p>';
}

/**
 * Render the contact settings section description.
 *
 * @return void
 */
function modern_catholic_render_contact_section() {
	echo '<p>' . esc_html__( 'Store the parish’s public contact information here for consistent reuse across theme sections.', 'modern-catholic' ) . '</p>';
}

/**
 * Render one settings field.
 *
 * @param array $args Field configuration.
 * @return void
 */
function modern_catholic_render_parish_setting_field( $args ) {
	$settings    = modern_catholic_get_parish_settings();
	$key         = $args['key'];
	$field_id    = 'modern-catholic-' . $key;
	$field_name  = MODERN_CATHOLIC_PARISH_SETTINGS_OPTION . '[' . $key . ']';
	$value       = $settings[ $key ];
	$description = $args['description'] ?? '';

	if ( 'textarea' === $args['type'] ) {
		printf(
			'<textarea id="%1$s" name="%2$s" rows="%3$d" class="large-text">%4$s</textarea>',
			esc_attr( $field_id ),
			esc_attr( $field_name ),
			(int) $args['rows'],
			esc_textarea( $value )
		);
	} else {
		printf(
			'<input id="%1$s" name="%2$s" type="%3$s" value="%4$s" class="regular-text">',
			esc_attr( $field_id ),
			esc_attr( $field_name ),
			esc_attr( $args['type'] ),
			esc_attr( $value )
		);
	}

	if ( '' !== $description ) {
		printf( '<p class="description">%s</p>', esc_html( $description ) );
	}
}

/**
 * Add the theme settings screen under Appearance in the admin sidebar.
 *
 * @return void
 */
function modern_catholic_add_parish_settings_page() {
	add_theme_page(
		__( 'Modern Catholic Settings', 'modern-catholic' ),
		__( 'Modern Catholic', 'modern-catholic' ),
		'edit_theme_options',
		'modern-catholic-settings',
		'modern_catholic_render_parish_settings_page'
	);
}
add_action( 'admin_menu', 'modern_catholic_add_parish_settings_page' );

/**
 * Render the theme settings page.
 *
 * @return void
 */
function modern_catholic_render_parish_settings_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Modern Catholic Settings', 'modern-catholic' ); ?></h1>
		<p><?php esc_html_e( 'Manage parish information that should remain consistent everywhere the theme displays it.', 'modern-catholic' ); ?></p>
		<p class="description"><?php esc_html_e( 'Mass Times are already connected to these settings. Contact values are stored centrally and ready for bound contact sections.', 'modern-catholic' ); ?></p>
		<?php settings_errors(); ?>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'modern_catholic_parish_settings_group' );
			do_settings_sections( 'modern-catholic-settings' );
			submit_button( __( 'Save Parish Settings', 'modern-catholic' ) );
			?>
		</form>
	</div>
	<?php
}

/**
 * Return a parish setting to a bound block.
 *
 * @param array    $source_args    Binding arguments.
 * @param WP_Block $block_instance Bound block instance.
 * @param string   $attribute_name Bound attribute name.
 * @return string|null
 */
function modern_catholic_get_parish_setting_binding_value( $source_args, $block_instance, $attribute_name ) {
	unset( $block_instance );

	if ( 'content' !== $attribute_name || empty( $source_args['key'] ) ) {
		return null;
	}

	$defaults = modern_catholic_get_parish_settings_defaults();
	$key      = sanitize_key( $source_args['key'] );

	if ( ! array_key_exists( $key, $defaults ) ) {
		return null;
	}

	return nl2br( esc_html( modern_catholic_get_parish_setting( $key ) ) );
}

/**
 * Register the parish settings Block Bindings source.
 *
 * @return void
 */
function modern_catholic_register_parish_settings_binding_source() {
	register_block_bindings_source(
		'modern-catholic/parish-setting',
		array(
			'label'              => __( 'Modern Catholic Parish Setting', 'modern-catholic' ),
			'get_value_callback' => 'modern_catholic_get_parish_setting_binding_value',
		)
	);
}
add_action( 'init', 'modern_catholic_register_parish_settings_binding_source' );
