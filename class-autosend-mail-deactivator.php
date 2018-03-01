<?php

/**
 * Fired during plugin deactivation
 *
 * @link       hungry.fi
 * @since      1.0.0
 *
 * @package    Autosend_Mail
 * @subpackage Autosend_Mail/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Autosend_Mail
 * @subpackage Autosend_Mail/includes
 * @author     Mikko Heikkilä | Hungry <mikko.heikkila@hungry.fi>
 */
class Autosend_Mail_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Get the timestamp for the next event.
		$wpam_scheduled_send_timestamp = wp_next_scheduled( 'wpam_scheduled_send' );
		wp_unschedule_event( $wpam_scheduled_send_timestamp, 'wpam_scheduled_send' );

		// Get the timestamp for the next event.
		$scheduled_delete_unconfirmed_timestamp = wp_next_scheduled( 'scheduled_delete_unconfirmed' );
		wp_unschedule_event( $scheduled_delete_unconfirmed_timestamp, 'scheduled_delete_unconfirmed' );

		// unschedule events upon plugin deactivation
		wp_clear_scheduled_hook( 'wpam_scheduled_send' );
		wp_clear_scheduled_hook( 'scheduled_delete_unconfirmed' );

	}

}

register_deactivation_hook( __FILE__, array('Autosend_Mail_Deactivator', 'deactivate' ));