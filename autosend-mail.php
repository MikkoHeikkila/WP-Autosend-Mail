<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              hungry.fi
 * @since             1.0.0
 * @package           Autosend_Mail
 *
 * @wordpress-plugin
 * Plugin Name:       Autosend Mail
 * Plugin URI:        https://github.com/MikkoHeikkila/WP-Autosend-Mail
 * Description:       Automatically send custom mail on specified interval
 * Version:           1.0.0
 * Author:            Mikko Heikkilä
 * Author URI:        hungry.fi
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       autosend-mail
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AUTOSEND_MAIL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-autosend-mail-activator.php
 */
function activate_autosend_mail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-autosend-mail-activator.php';
	Autosend_Mail_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-autosend-mail-deactivator.php
 */
function deactivate_autosend_mail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-autosend-mail-deactivator.php';
	Autosend_Mail_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_autosend_mail' );
register_deactivation_hook( __FILE__, 'deactivate_autosend_mail' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-autosend-mail.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_autosend_mail() {

	$plugin = new Autosend_Mail();
	$plugin->run();

}
run_autosend_mail();
