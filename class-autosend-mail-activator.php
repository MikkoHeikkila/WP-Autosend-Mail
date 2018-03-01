<?php

/**
 * Fired during plugin activation
 *
 * @link       hungry.fi
 * @since      1.0.0
 *
 * @package    Autosend_Mail
 * @subpackage Autosend_Mail/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Autosend_Mail
 * @subpackage Autosend_Mail/includes
 * @author     Mikko Heikkilä <mikko.heikkila@hungry.fi>
 */

class Autosend_Mail_Activator {

	/**
	 * Create plugin database table.
	 *
	 * This table contains the emails of all recipients + ID and timestamp.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $automail_db_version;
		$automail_db_version = '1.0';

		global $wpdb;

		$table_name = $wpdb->prefix . 'autosend_mail_recipients';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				`id` INT NOT NULL AUTO_INCREMENT,
				`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`email` VARCHAR(500) NOT NULL,
				`ruid` VARCHAR(500) NOT NULL,
				`confirmed` VARCHAR(500) NOT NULL,
				PRIMARY KEY (`id`)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );

	}

}

register_activation_hook( __FILE__, array('Autosend_Mail_Activator', 'activate' ));