<?php
/*
Plugin Name: Elegant Tabs for Elementor
Plugin URI: https://infiwebs.com/elegant-tabs-elementor/
Description: Elegant Tabs add-on for Elementor Page Builder.
Version: 1.1
Author: InfiWebs
Author URI: https://www.infiwebs.com
*/

namespace ElegantTabs;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin version.
if ( ! defined( 'ELEGANT_TABS_ELEMENTOR_VERSION' ) ) {
	define( 'ELEGANT_TABS_ELEMENTOR_VERSION', '1.1' );
}
// Plugin Root File.
if ( ! defined( 'ELEGANT_TABS_ELEMENTOR_PLUGIN_FILE' ) ) {
	define( 'ELEGANT_TABS_ELEMENTOR_PLUGIN_FILE', __FILE__ );
}
// Plugin Folder Path.
if ( ! defined( 'ELEGANT_TABS_ELEMENTOR_PLUGIN_DIR' ) ) {
	define( 'ELEGANT_TABS_ELEMENTOR_PLUGIN_DIR', wp_normalize_path( plugin_dir_path( ELEGANT_TABS_ELEMENTOR_PLUGIN_FILE ) ) );
}
// Plugin Folder URL.
if ( ! defined( 'ELEGANT_TABS_ELEMENTOR_PLUGIN_URL' ) ) {
	define( 'ELEGANT_TABS_ELEMENTOR_PLUGIN_URL', plugin_dir_url( ELEGANT_TABS_ELEMENTOR_PLUGIN_FILE ) );
}

/**
 * Main Elegant_Tabs_Elementor Class.
 *
 * @since 1.0
 */
final class Elegant_Tabs_Elementor {

	/**
	 * The one, true instance of this object.
	 *
	 * @since 1.0
	 * @static
	 * @access private
	 * @var object
	 */
	private static $instance;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0
	 * @static
	 * @access public
	 */
	public static function get_instance() {

		// If an instance hasn't been created and set to $instance create an instance and set it to $instance.
		if ( null === self::$instance ) {
			self::$instance = new Elegant_Tabs_Elementor();
		}
		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		// Load plugin textdomain.
		add_action( 'plugins_loaded', array( $this, 'textdomain' ) );

		// Register elements.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elements' ), 10 );

		add_action( 'wp_enqueue_scripts', array( $this, 'et_tabs_front_styles' ) );
		add_action( 'wp_print_scripts', array( $this, 'et_tabs_front_scripts' ) );

		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'et_tabs_front_editor_scripts' ) );
	}

	/**
	 * Loads the plugin language files.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function textdomain() {

		// Set text domain.
		$domain = 'elegant-tabs';

		// Load the plugin textdomain.
		load_plugin_textdomain( $domain, false, dirname( plugin_basename( ELEGANT_TABS_ELEMENTOR_PLUGIN_FILE ) ) . '/languages/' );
	}

	/**
	 * Register Elegant Tabs.
	 *
	 * @access public
	 * @since 1.0
	 * @param object $widgets_manager Elementor Widget Manager.
	 * @return void
	 */
	public function register_elements( $widgets_manager ) {
		require_once ELEGANT_TABS_ELEMENTOR_PLUGIN_DIR . 'elegant-tabs.php';
		$widgets_manager->register_widget_type( new \ElegantTabs\Widgets\Elegant_Tabs_Widget() );
	}

	/**
	 * Enqueue styles on frontend.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function et_tabs_front_styles() {
		wp_register_style( 'iw_tab_style', ELEGANT_TABS_ELEMENTOR_PLUGIN_URL . 'assets/css/tabstyles.css' );
		wp_register_style( 'iw_tabs', ELEGANT_TABS_ELEMENTOR_PLUGIN_URL . 'assets/css/tabs.css' );

		wp_enqueue_style( 'iw_tab_style' );
		wp_enqueue_style( 'iw_tabs' );
	}

	/**
	 * Enqueue scripts on frontend.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function et_tabs_front_scripts() {
		wp_register_script( 'elegant_tabs', ELEGANT_TABS_ELEMENTOR_PLUGIN_URL . 'assets/js/eTabs.js', array( 'jquery' ), '', true );

		if ( ! is_admin() ) {
			wp_enqueue_script( 'elegant_tabs' );
		}
	}

	/**
	 * Enqueue scripts on frontend editor.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function et_tabs_front_editor_scripts() {
		wp_register_script( 'elegant_tabs', ELEGANT_TABS_ELEMENTOR_PLUGIN_URL . 'assets/js/eTabs.js', array( 'jquery' ), '', true );

		if ( ! is_admin() ) {
			wp_enqueue_script( 'elegant_tabs' );
		}
	}
}

/**
 * Instantiates the Elegant_Tabs_Elementor class.
 * Make sure the class is properly set-up.
 * The Elegant_Tabs_Elementor class is a singleton
 * so we can directly access the one true Elegant_Tabs_Elementor object using this function.
 *
 * @since 1.0
 * @return object Elegant_Tabs_Elementor
 */
function elegant_tabs() {
	return Elegant_Tabs_Elementor::get_instance();
}

// Instantiate the elegant elements.
elegant_tabs();
