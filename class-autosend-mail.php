<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       hungry.fi
 * @since      1.0.0
 *
 * @package    Autosend_Mail
 * @subpackage Autosend_Mail/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Autosend_Mail
 * @subpackage Autosend_Mail/includes
 * @author     Mikko Heikkilä <mikko.heikkila@hungry.fi>
 */
class Autosend_Mail {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Autosend_Mail_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'AUTOSEND_MAIL_VERSION' ) ) {
			$this->version = AUTOSEND_MAIL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'autosend-mail';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Autosend_Mail_Loader. Orchestrates the hooks of the plugin.
	 * - Autosend_Mail_i18n. Defines internationalization functionality.
	 * - Autosend_Mail_Admin. Defines all hooks for the admin area.
	 * - Autosend_Mail_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-autosend-mail-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-autosend-mail-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-autosend-mail-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-autosend-mail-public.php';

		$this->loader = new Autosend_Mail_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Autosend_Mail_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Autosend_Mail_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Autosend_Mail_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Autosend_Mail_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();

		add_action('wp', 'cronstarter_activation');	
		add_action('wp', 'cron_delete_unconfirmed');

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Autosend_Mail_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

/**
* Add the admin page
**/

add_action('admin_menu', 'autosend_mail_admin_page');
 
function autosend_mail_admin_page(){
	
    add_menu_page( 'Autosend Mail Page', 'Autosend Mail', 'manage_options', 'Autosend_Mail', 'admin_index', 'dashicons-email-alt', 110 );
        
}



function admin_index(){

	require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';

}


/**
 * Add shortcode for displaying form for adding new recipients to the mailing list.
 */
function wpam_add_address(){ 

	if(isset($_POST['wpam_new_address'])){

		/************** POST DATA **************/

		$email = trim($_POST['wpam_new_address']);

		/**************** CONFIRMATION ****************/

		global $wpdb;

		$table_name = ($wpdb->prefix . 'autosend_mail_recipients');


	    //Check if email address already in table
		$emailFound = $wpdb->get_row( "SELECT * FROM $table_name WHERE email = '$email' AND confirmed = '1'" );
		if(!$emailFound){

			//New email. Send confirmation message
			sendConfirmation();

		} else {

			//Email already exists message
			return '<div id="wpam-notice"><p>Email already exists<p></div>';

		}


	}

	/**************** ORDER FORM ****************/

	$form = '<div class="row">
		<div class="col-xs-12">
			<form id="wpam_input_form" method="POST" action="#wpam-notice" role="form">
				<input type="email" name="wpam_new_address" placeholder="Email" required><br> 
				<input type="submit" name="Submit" value="Submit" id="submit">
			</form>					
		</div>
	</div>';

	return $form;


}
add_shortcode('wpam_input_form', 'wpam_add_address');

/**
 * Send the confirmation email to a new subscriber
 */
function sendConfirmation(){

	global $wpdb;

	$email = trim($_POST['wpam_new_address']);
	$table_name = ($wpdb->prefix . 'autosend_mail_recipients');

	//Generate a random Real User ID. This is used for 2 way authentication.
	$length = 16;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $ruid = '';

    for ($i = 0; $i < $length; $i++) {

        $ruid .= $characters[rand(0, $charactersLength - 1)];

    }

	if(( $wpdb->insert( $table_name, array( 'email' => $email, 'ruid' => $ruid ), array( '%s', '%s' ) )) === FALSE){

		//FAIL MESSAGE
		return '<div class="wpam-notice wpam-failure">Order failed</div>';

	} else {

		//CONFIRMATION EMAIL
		$content 	= '<h3>Confirm email</h3><br><a href="[PAGE LINK WHERE wpam_confirm SHORTCODE IS FOUND HERE]/?confirm_ruid='.$ruid.'&confirm_email='.$email.'">Confirm &raquo;</a>';
		$to 		= $email;
		$subject 	= "Confirm email";
		$body 		= $content;
		$headers 	= "MIME-Version: 1.0" . "\r\n";
		$headers 	.= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers 	.= "From: webmaster@example.com" . "\r\n" .

		mail($to,$subject,$body,$headers);
		//CONFIRMATION EMAIL END

		//SUCCESS MESSAGE HERE
		return '<div id="wpam-notice" class="wpam-notice wpam-success">A confirmation message has been sent to your email.</div>';
	}	
}

/**
 * Add shortcode for displaying form for adding new recipients to the mailing list.
 */
function wpam_confirm_address(){

	global $wpdb;

	// If RUID and email parameters found
	if ( (isset($_GET['confirm_ruid'])) && (isset($_GET['confirm_email'])) ) {

		$table_name = ($wpdb->prefix . 'autosend_mail_recipients');
	    $ruid = $_GET['confirm_ruid'];
	    $email = $_GET['confirm_email'];

    	// Check if user exists
		$user = $wpdb->get_var("SELECT * FROM $table_name WHERE ruid = '$ruid' AND email = '$email'");

		if ( $user > 0 ){

			// User exists
	    	// Confirm user by updating 'confirmed' col value to '1'
			$wpdb->update(
				$table_name, 
				array( 
					'confirmed' => '1',	// string
				), 
				array( 
					'email' => $email,
					'ruid' => $ruid
				), 
				array( 
					'%s'	// value1
				), 
				array( 
					'%s',
					'%s'
				)
			);

			return '<div id="wpam-notice"><p>Thank you!</p></div>';	

		} else {

			// Does not exist
			return '<div id="wpam-notice"><p>Confirmation link may be expired</p></div>';

		}

	} else {

		//No parameters

	}

}
add_shortcode('wpam_confirm', 'wpam_confirm_address');

/**
 * Delete unconfirmed emails from database after 12 hours
 */
function delete_unconfirmed(){

	global $HTTP_POST_VARS;
	global $wpdb;

	$table_name = ($wpdb->prefix . 'autosend_mail_recipients');

	//Get all unconfirmed users
	$rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE confirmed != '1'" );

	foreach ( $rows as $row ) {

		$id = $row->id; // User id
		$timestamp = $row->timestamp; //SQL timestamp
		$time = strtotime($timestamp); //Unix timestamp
		$curtime = time(); //Current unix timestamp

		if(($curtime-$time) > 43200) { //If over 12 hours old
			//Delete
			$wpdb->delete( $table_name, array( 'id' => $id ) );
		} else {
			//Keep
		}

	}
}
// hook send_mail onto our scheduled event:
add_action ('scheduled_delete_unconfirmed', 'delete_unconfirmed');

/**
 * Cron job for deleting unconfirmed users
 */
function cron_delete_unconfirmed() {
	if( !wp_next_scheduled( 'scheduled_delete_unconfirmed' ) ) {  
	   wp_schedule_event( time(), 'twicedaily', 'scheduled_delete_unconfirmed' );  
	}
}

/**
 * Send mail
 */
function send_mail(){

	global $HTTP_POST_VARS;
	global $wpdb;

	date_default_timezone_set('Europe/Helsinki');

	$table_name = ($wpdb->prefix . 'autosend_mail_recipients');

	$rows = $wpdb->get_results( "SELECT * FROM $table_name WHERE confirmed = '1'" );

	$mail_template = plugins_url() . '/autosend-mail/mail.php';

	foreach ( $rows as $row ) {
		
		$email 					= $row->email;
		$ruid 					= $row->ruid;
		$content 				= file_get_contents( "$mail_template" );
		$endSubscriptionLink 	= '<br><br><br><a href="[LINK WHERE wpam_remove_notification IS FOUND HERE]/?remove_email='.$email.'&remove_ruid='.$ruid.'">Click to remove this address from mailing list &raquo;</a>';
		$nextmonday = date('d.m', strtotime('next monday'));
		$nextfriday = date('d.m.Y', strtotime('next friday'));

		$to 		= $email;
		$subject 	= "Subject";
		$body 		= $content;
		$body 		.= $endSubscriptionLink;
		$headers 	= "MIME-Version: 1.0" . "\r\n";
		$headers 	.= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers 	.= "From: noreply@example.com" . "\r\n";

		mail($to,$subject,$body,$headers);

	}

}
// hook send_mail onto our scheduled event:
add_action ('wpam_scheduled_send', 'send_mail'); 

/**
 * Add shortcode for removing users from mailing list and displaying the notification
 */
function wpam_remove_address(){

	global $wpdb;

	// If RUID and email parameters found
	if ( (isset($_GET['remove_email'])) && (isset($_GET['remove_ruid'])) ) {

		$table_name = ($wpdb->prefix . 'autosend_mail_recipients');
	    $ruid = $_GET['remove_ruid'];
	    $email = $_GET['remove_email'];

    	// Check if user exists
		$user = $wpdb->get_var("SELECT * FROM $table_name WHERE ruid = '$ruid' AND email = '$email'");

		if ( $user > 0 ){
			// User exists
	    	// Remove user
			$wpdb->delete( $table_name, array( 'email' => $email, 'ruid' => $ruid ) );
			return "$email removed";
		} else {
			// Does not exist
			return 'Not found';
		}

	} else {
		//No parameters
	}

}
add_shortcode('wpam_remove_notification', 'wpam_remove_address');

/**
 * Add custom interval
 */
function cron_add_minute( $schedules ) {
	// Adds once every minute to the existing schedules.
    $schedules['everyminute'] = array(
	    'interval' => 60,
	    'display' => __( 'Once Every Minute' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_minute' );

/**
 * Cron job for sending mail
 */
function cronstarter_activation() {
	if( !wp_next_scheduled( 'wpam_scheduled_send' ) ) {  
	   wp_schedule_event( time(), 'hourly', 'wpam_scheduled_send' );  
	}
}
	