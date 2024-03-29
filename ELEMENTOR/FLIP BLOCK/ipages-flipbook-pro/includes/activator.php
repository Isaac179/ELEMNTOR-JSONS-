<?php
/**
 * Fired during plugin activation and loading.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */

// If this file is called directly, abort.
if(!defined('WPINC')) {
	die;
}


if(!class_exists( 'iPages_Activator')) :

class iPages_Activator {
	public function activate() {
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		global $wpdb;
		
		$table = $wpdb->prefix . IPGS_PLUGIN_NAME;
		$sql = 'CREATE TABLE ' . $table . ' (
			id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			title text COLLATE utf8_unicode_ci DEFAULT NULL,
			active tinyint NOT NULL DEFAULT 1,
			data text COLLATE utf8_unicode_ci DEFAULT NULL,
			config text COLLATE utf8_unicode_ci DEFAULT NULL,
			author bigint(20) UNSIGNED NOT NULL DEFAULT 0,
			date datetime NOT NULL DEFAULT "0000-00-00 00:00:00",
			modified datetime NOT NULL DEFAULT "0000-00-00 00:00:00",
			UNIQUE KEY id (id)
		);';
		dbDelta($sql);
		
		update_option(IPGS_PLUGIN_NAME . '_db_version', IPGS_DB_VERSION, false);
		
		if( get_option(IPGS_PLUGIN_NAME . '_activated') == false ) {
			$this->install_data();
		}
		
		update_option(IPGS_PLUGIN_NAME . '_activated', time(), false);
	}
	
	public function install_data() {
	}
	
	public function check_db() {
		if ( get_option(IPGS_PLUGIN_NAME . '_db_version') != IPGS_DB_VERSION ) {
			$this->activate();
		}
	}
}

endif;