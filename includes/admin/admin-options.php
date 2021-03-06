<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// add_action( 'genesis_theme_settings_metaboxes', 'bfg_remove_theme_settings_metaboxes' );
/**
 * Remove some or all of the options metaboxes in Dashboard > Genesis > Theme Settings.
 *
 * See: http://genesissnippets.com/remove-unused-theme-settings-metaboxes/
 *
 * @since 2.0.0
 */
function bfg_remove_theme_settings_metaboxes( $_genesis_theme_settings_pagehook ) {

	// remove_meta_box( 'genesis-theme-settings-version', $_genesis_theme_settings_pagehook, 'main' );			// Information
	remove_meta_box( 'genesis-theme-settings-feeds', $_genesis_theme_settings_pagehook, 'main' );			// Custom Feeds
	// remove_meta_box( 'genesis-theme-settings-layout', $_genesis_theme_settings_pagehook, 'main' );			// Default Layout
	remove_meta_box( 'genesis-theme-settings-header', $_genesis_theme_settings_pagehook, 'main' );			// Header
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );				// Navigation
	remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );		// Breadcrumbs
	// remove_meta_box( 'genesis-theme-settings-comments', $_genesis_theme_settings_pagehook, 'main' );		// Comments and Trackbacks
	// remove_meta_box( 'genesis-theme-settings-posts', $_genesis_theme_settings_pagehook, 'main' );			// Content Archives
	// remove_meta_box( 'genesis-theme-settings-blogpage', $_genesis_theme_settings_pagehook, 'main' );		// Blog Page Template
	// remove_meta_box( 'genesis-theme-settings-scripts', $_genesis_theme_settings_pagehook, 'main' );			// Header and Footer Scripts

}

add_filter( 'genesis_theme_settings_defaults', 'bfg_theme_settings_defaults' );
/**
 * Set default values for custom theme options.
 *
 * @since 2.3.0
 */
function bfg_theme_settings_defaults( $defaults ) {

	$defaults['bfg_production_on']         = false;
	$defaults['bfg_assets_version']        = null;
	$defaults['content_archive']           = 'excerpts';
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_size']                = 'thumbnail';
	$defaults['trackbacks_posts']          = 0;

	return $defaults;

}

add_action( 'genesis_settings_sanitizer_init', 'bfg_settings_sanitizer' );
/**
 * Set filters for custom theme options.
 *
 * @since 2.3.0
 */
function bfg_settings_sanitizer() {

	genesis_add_option_filter(
		'one_zero',
		GENESIS_SETTINGS_FIELD,
		array(
			'bfg_production_on',
		)
	);

	genesis_add_option_filter(
		'absint',
		GENESIS_SETTINGS_FIELD,
		array(
			'bfg_assets_version',
		)
	);

}

add_action( 'genesis_theme_settings_metaboxes', 'bfg_theme_settings_metaboxes' );
/**
 * Add meta boxes for custom theme options.
 *
 * @since 2.3.0
 */
function bfg_theme_settings_metaboxes( $pagehook ) {

	add_meta_box(
		'bfg-environment-settings',
		'Environment',
		'bfg_environment_settings_box',
		$pagehook,
		'main',
		'high'
	);

}

/**
 * Render the 'Environment' meta box.
 *
 * @since 2.3.0
 */
function bfg_environment_settings_box() {

	?>
	<p>
		<label>
			<input type="checkbox" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[bfg_production_on]" value="1" <?php checked( genesis_get_option('bfg_production_on'), 1 ); ?> >
		<?php _e( 'Use Production Assets?', 'bfg' ); ?></label>
	</p>

	<p>
		<label>
			<?php _e( 'Assets Version Number:', 'bfg' ); ?><br>
			<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[bfg_assets_version]" value="<?php echo esc_attr( genesis_get_option('bfg_assets_version') ); ?>" class="regular-text" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[bfg_assets_version]">
		</label>
	</p>

	<p>
		<span class="description">
			Add or change the value here to force users' browsers to re-download the theme CSS/JS.
		</span>
	</p>
	<?php

}
