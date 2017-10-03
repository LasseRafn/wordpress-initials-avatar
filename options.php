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
				<th scope="row"><?php _e( 'Image size', 'wiauia' ); ?></th>
				<td>
					<select name="size">
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 16 ); ?> value="16"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 16, 16 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 24 ); ?> value="24"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 24, 24 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 32 ); ?> value="32"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 32, 32 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 48 ); ?> value="48"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 48, 48 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 64 ); ?> value="64"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 64, 64 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 96 ); ?> value="96"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 96, 96 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 128 ); ?> value="128"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 128, 128 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 192 ); ?> value="192"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 192, 192 ); ?></option>
						<option <?php selected( esc_attr( get_option( 'size', 64 ) ) == 256 ); ?> value="256"><?php echo sprintf( translate( '%sx%s pixels', 'wiauia' ), 256, 256 ); ?></option>
					</select>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>
</div>