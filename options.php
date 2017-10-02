<div class="wrap">
	<h1>User Initials Avatar Setitngs</h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'wiauia-settings' ); ?>
		<?php do_settings_sections( 'wiauia-settings' ); ?>


		<table class="form-table">
			<tr valign="top">
				<th scope="row">Some Other Option</th>
				<td><input type="text" name="use_api" value="<?php echo esc_attr( get_option('use_api') ); ?>" /></td>
			</tr>


			<tr valign="top">
				<th scope="row">Some Other Option</th>
				<td><input type="text" name="color" value="<?php echo esc_attr( get_option('color') ); ?>" /></td>
			</tr>


			<tr valign="top">
				<th scope="row">Some Other Option</th>
				<td><input type="text" name="background" value="<?php echo esc_attr( get_option('background') ); ?>" /></td>
			</tr>


			<tr valign="top">
				<th scope="row">Some Other Option</th>
				<td><input type="text" name="length" value="<?php echo esc_attr( get_option('length') ); ?>" /></td>
			</tr>


			<tr valign="top">
				<th scope="row">Some Other Option</th>
				<td><input type="text" name="size" value="<?php echo esc_attr( get_option('size') ); ?>" /></td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>
</div>