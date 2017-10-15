<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.facebook.com/vermadarsh
 * @since             1.0.0
 * @package           Wp_Contributers
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Contributers
 * Plugin URI:        https://github.com/vermadarsh/wp-contributers
 * Description:       This plugin adds a method to add another authors to the posts.
 * Version:           1.0.0
 * Author:            Adarsh Verma
 * Author URI:        https://www.facebook.com/vermadarsh
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-contributers
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
//Plugin Version
define( 'WPC_PLUGIN_NAME_VERSION', '1.0.0' );
//Plugin Text Domain
if ( ! defined( 'WPC_TEXT_DOMAIN' ) ) {
	define( 'WPC_TEXT_DOMAIN', 'wp-contributers' );
}
//Plugin URL
if ( ! defined( 'WPC_PLUGIN_URL' ) ) {
	define( 'WPC_PLUGIN_URL', plugin_dir_url(__FILE__) );
}
//Plugin Path
if ( ! defined( 'WPC_PLUGIN_PATH' ) ) {
	define( 'WPC_PLUGIN_PATH', plugin_dir_path(__FILE__) );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_contributers() {

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-wp-contributers.php';
	$plugin = new Wp_Contributers();
	$plugin->run();

}

/**
 * Check plugin requirement or any other thing when plugins load
 */
add_action('plugins_loaded', 'wpc_plugin_init');
function wpc_plugin_init() {
	run_wp_contributers();
}