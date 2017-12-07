<?php

global $wpdb;

/************** POST DATA **************/

//$email = trim($_POST['wpam_new_address']);
$email = 'mikko.heikkila@hungry.fi';



/**************** WPDB ****************/

//$table_name = ($wpdb->prefix . 'autosend_mail_recipients');
$table_name = 'wp_autosend_mail_recipients';

//echo $table_name;

$wpdb->insert( 
	$table_name,
	array( 
		'email' => '$email'
	), 
	array( 
		'%s'
	) 
);



?>