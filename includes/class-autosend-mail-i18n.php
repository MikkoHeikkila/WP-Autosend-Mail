<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       hungry.fi
 * @since      1.0.0
 *
 * @package    Autosend_Mail
 * @subpackage Autosend_Mail/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Autosend_Mail
 * @subpackage Autosend_Mail/includes
 * @author     Mikko Heikkilä | Hungry <mikko.heikkila@hungry.fi>
 */
class Autosend_Mail_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'autosend-mail',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
