<div class="wrap">

    <h1>Autosend Mail</h1>

    <p>Automatically send a custom email to a list of subscribers.</p>
    <p>Edit the file <b>mail.php</b> located in the plugin folder.</p>

    <br>

    <h2>Settings</h2>

	<form method="post" action="options.php">

		<h3>Two factor authentication</h3>

		<p>This is the page where the user is taken after clicking on the confirmation link, that is sent to them after subscribing to the newsletter. This page will display the confirmation or failure notification. <b>The page must include this shortcode:</b> [wpam_confirm]</p>
		<label><b>Subscription page</b>: <?php wp_dropdown_pages( ); ?> </label>	

	<?php
		settings_fields( 'autosend_fields' );
		do_settings_sections( 'autosend_fields' );
		submit_button();
	?>
	
	</form>	

</div>