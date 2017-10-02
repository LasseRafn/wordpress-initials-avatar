<div class="wrap">
	<h1>User Initials Avatar Setitngs</h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'wiauia-settings' ); ?>
		<?php do_settings_sections( 'wiauia-settings' ); ?>

		<?php submit_button(); ?>
	</form>
</div>