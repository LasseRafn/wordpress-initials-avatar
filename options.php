<div class="wrap">
	<h1><?php _e( 'User Initials Avatar Setitngs', 'wiauia' ); ?></h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'wiauia-settings' ); ?>
		<?php do_settings_sections( 'wiauia-settings' ); ?>


		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Font color', 'wiauia' ); ?></th>
				<td><input type="text" name="color" data-default="#222222" value="<?php echo esc_attr( get_option( 'color', '#222222' ) ); ?>" class="my-color-field"/></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Background color', 'wiauia' ); ?></th>
				<td><input type="text" name="background" data-default="#dddddd" value="<?php echo esc_attr( get_option( 'background', '#dddddd' ) ); ?>" class="my-color-field"/></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Length', 'wiauia' ); ?></th>
				<td>
					<select name="length">
						<option <?php selected( esc_attr( get_option( 'length', 2 ) ) == 1 ); ?> value="1"><?php echo sprintf( translate( '%s letter', 'wiauia' ), 1 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'length', 2 ) ) == 2 ); ?> value="2"><?php echo sprintf( translate( '%s letters', 'wiauia' ), 2 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'length', 2 ) ) == 3 ); ?> value="3"><?php echo sprintf( translate( '%s letters', 'wiauia' ), 3 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'length', 2 ) ) == 4 ); ?> value="4"><?php echo sprintf( translate( '%s letters', 'wiauia' ), 4 ); ?></option>
					</select>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Rounded image?', 'wiauia' ); ?></th>
				<td>
					<select name="rounded">
						<option <?php selected( esc_attr( get_option( 'rounded', 'false' ) ) == 'false' ); ?> value="false"><?php echo translate( 'No - Square avatar', 'wiauia' ); ?></option>
						<option <?php selected( esc_attr( get_option( 'rounded', 'false' ) ) == 'true' ); ?> value="true"><?php echo translate( 'Yes - Rounded avatar', 'wiauia' ); ?></option>
					</select>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Uppercase letters?', 'wiauia' ); ?></th>
				<td>
					<select name="uppercase">
						<option <?php selected( esc_attr( get_option( 'uppercase', 'true' ) ) == 'true' ); ?> value="true"><?php echo translate( 'Yes', 'wiauia' ); ?></option>
						<option <?php selected( esc_attr( get_option( 'uppercase', 'true' ) ) == 'false' ); ?> value="false"><?php echo translate( 'No - Do not modify lettercase', 'wiauia' ); ?></option>
					</select>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>
</div>
