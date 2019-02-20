<?php

/**
 * Plugin Name:       iPages Flipbook (PRO)
 * Plugin URI:        http://avirtum.com
 * Description:       iPages Flipbook PDF Viewer is a lightweight and rich-feature plugin helps you create great interactive digital HTML5 flipbooks. It provides an easy way for you to convert static PDF documents or image sets into the online magazine, interactive catalogs, media brochures or booklets in seconds.
 * Version:           1.1.5
 * Author:            Avirtum
 * Author URI:        http://avirtum.com/
 * License:           GPLv3
 * Text Domain:       ipages_flipbook
 * Domain Path:       /languages
 */



// If this file is called directly, abort.
if(!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('IPGS_PLUGIN_NAME', 'ipages_flipbook');
define('IPGS_PLUGIN_VERSION', '1.1.5');
define('IPGS_DB_VERSION', '1.0.0');
define('IPGS_SHORTCODE_NAME', 'ipages');

/**
 * The code that runs during plugin activation
 */
function ipages_activate() {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/activator.php' );
	$activator = new iPages_Activator();
	$activator->activate();
}
register_activation_hook( __FILE__, 'ipages_activate' );

/**
 * The code that runs during plugin deactivation
 */
function ipages_deactivate() {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/deactivator.php' );
	$deactivator = new iPages_Deactivator();
	$deactivator->deactivate();
}
register_deactivation_hook( __FILE__, 'ipages_deactivate' );

/**
 * The code that runs after plugins loaded
 */
function ipages_check_db() {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/activator.php' );
	
	$activator = new iPages_Activator();
	$activator->check_db();
}
add_action('plugins_loaded', 'ipages_check_db');


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
require_once( plugin_dir_path( __FILE__ ) . 'includes/plugin.php' );


function ipages_run() {
	$pluginBasename = plugin_basename(__FILE__);
	
	$plugin = new iPages($pluginBasename);
	$plugin->run();
}
add_action('init', 'ipages_run');

