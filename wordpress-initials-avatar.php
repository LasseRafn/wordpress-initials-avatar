<?php

/*
Plugin Name: Wordpress Initials Avatar
Plugin URI: https://github.com/LasseRafn/wordpress-initials-avatar
Description: Replaces the default avatars with initials
Version: 0.5
Author: lasserafn
Author URI: https://github.com/LasseRafn
License: MIT
*/

if ( is_admin() ){ // admin actions
	add_action( 'admin_init', 'register_wiaua_settings' );
	add_action('admin_menu', 'wiaua_settings_menu');

	function wiaua_settings_menu() {
		add_menu_page('My Cool Plugin Settings', 'Cool Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );
		add_action( 'admin_init', 'register_my_cool_plugin_settings' );
	}

	function register_wiaua_settings() {
		register_setting( 'wiaua-settings', 'use_api' );
		register_setting( 'wiaua-settings', 'color' );
		register_setting( 'wiaua-settings', 'background' );
		register_setting( 'wiaua-settings', 'length' );
		register_setting( 'wiaua-settings', 'size' );
	}

	function my_cool_plugin_settings_page() {
		require_once 'options.php';
	}
}

add_filter( 'avatar_defaults', 'add_custom_gravatar' );
if ( ! function_exists( 'add_custom_gravatar' ) ) {
	function add_custom_gravatar( $avatar_defaults )
	{
		$avatar_defaults[ 'initials' ] = 'Initials';

		return $avatar_defaults;
	}
}

add_filter( 'get_avatar', 'wordpress_initials_avatar', 1, 6 );

function wordpress_initials_avatar( $avatar, $id_or_email, $size, $default, $alt, $args )
{
	if ( $default !== 'initials' || $args['force_default'] ?? false ) {
		return $avatar;
	}

	$user = false;

	if ( is_numeric( $id_or_email ) ) {
		$id   = (int) $id_or_email;
		$user = get_user_by( 'id', $id );
	} elseif ( is_object( $id_or_email ) ) {
		if ( ! empty( $id_or_email->user_id ) ) {
			$id   = (int) $id_or_email->user_id;
			$user = get_user_by( 'id', $id );
		}
	}
	else {
		$user = get_user_by( 'email', $id_or_email );
	}

	if ( $user && is_object( $user ) ) {
		$url = $args['url'];
		$url = explode( 'd=', $url );

		if ( count( $url ) >= 1 ) {
			$url = explode( '&', $url[count( $url ) - 1] );

			$args['url'] = str_replace($url[0], urlencode('https://ui-avatars.com/api/' . urlencode($user->display_name)), $args['url']);
		}

		$url2x       = urlencode('https://ui-avatars.com/api/' . urlencode($user->display_name) . '/'.  ( $size * 2 ));

		$avatar = sprintf(
			"<img alt='%s' src='%s' srcset='%s' class='%s' height='%d' width='%d' %s/>",
			esc_attr( $args['alt'] ),
			esc_url( $args['url'] ),
			esc_attr( "$url2x 2x" ),
			esc_attr( join( ' ', $args['class'] ) ),
			(int) $args['height'],
			(int) $args['width'],
			$args['extra_attr']
		);
	}

	return $avatar;
}