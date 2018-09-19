<?php

/*
Plugin Name: WordPress Initials Avatar
Plugin URI: https://github.com/LasseRafn/wordpress-initials-avatar
Description: Replaces the default avatars with initials
Version: 0.9
Author: lasserafn
Author URI: https://github.com/LasseRafn
License: MIT
Text Domain: wp-initials-avatar
*/

if ( is_admin() ) { // admin actions
	add_action( 'admin_init', 'register_wp_ui_avatars_settings' );
	add_action( 'admin_menu', 'wp_ui_avatars_settings_menu' );

	function wp_ui_avatars_settings_menu() {
		add_submenu_page( 'options-general.php', __( 'User Initials Avatar Setitngs', 'wp-initials-avatar' ), __( 'Avatar settings', 'wp-initials-avatar' ), 'administrator', __FILE__, 'wp_ui_avatars_settings_page' );
		add_action( 'admin_init', 'register_wp_ui_avatars_settings' );
	}

	function register_wp_ui_avatars_settings() {
		register_setting( 'wiauia-settings', 'color' );
		register_setting( 'wiauia-settings', 'background' );
		register_setting( 'wiauia-settings', 'length' );
		register_setting( 'wiauia-settings', 'uppercase' );
		register_setting( 'wiauia-settings', 'rounded' );
	}

	function wp_ui_avatars_enqueue_color_picker() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'my-script-handle', plugins_url( 'settings.js', __FILE__ ), [ 'wp-color-picker' ], false, true );
	}

	add_action( 'admin_enqueue_scripts', 'wp_ui_avatars_enqueue_color_picker' );

	function wp_ui_avatars_settings_page() {

		require_once __DIR__ . '/options.php';
	}
}

add_filter( 'get_avatar_url', 'wordpress_initials_avatar', 10, 3 );

/**
 * Filters the avatar URL.
 *
 * @param string $url         The URL of the avatar.
 * @param mixed  $id_or_email The Gravatar to retrieve. Accepts a user_id, gravatar md5 hash,
 *                            user email, WP_User object, WP_Post object, or WP_Comment object.
 * @param array  $args        Arguments passed to get_avatar_data(), after processing.
 */
function wordpress_initials_avatar( $url, $id_or_email, $args ) {
	if ( $args['default'] !== 'initials' && ( $args['force_default'] || false ) || !preg_match('/gravatar.com/', $url) ) {
		return $url;
	}

	$user = false;
	$name = 'initials';

	if ( is_object( $id_or_email ) && isset( $id_or_email->comment_ID ) ) {
		$id_or_email = get_comment( $id_or_email );
	}
	// Process the user identifier.
	if ( is_numeric( $id_or_email ) ) {
		$user = get_user_by( 'id', absint( $id_or_email ) );
	} elseif ( is_string( $id_or_email ) ) {
		$user = get_user_by( 'email', $id_or_email );
	} elseif ( $id_or_email instanceof WP_User ) {
		// User Object
		$user = $id_or_email;
	} elseif ( $id_or_email instanceof WP_Post ) {
		// Post Object
		$user = get_user_by( 'id', (int) $id_or_email->post_author );
	} elseif ( $id_or_email instanceof WP_Comment ) {
		$name = get_comment_author( $id_or_email->ID );
	}

	if ( $user && is_object( $user ) ) {
		$name = $user->display_name;
	}

	$size       = $args['size'];
	$background = esc_attr( get_option( 'background', 'ddd' ) );
	$color      = esc_attr( get_option( 'color', '222' ) );
	$length     = esc_attr( get_option( 'length', 2 ) );
	$fontSize   = 0.5;
	$rounded    = (string) esc_attr( get_option( 'rounded', 'false' ) );
	$uppercase  = (string) esc_attr( get_option( 'uppercase', 'true' ) );

	$color      = str_replace( '#', '', $color );
	$background = str_replace( '#', '', $background );

	$param      = explode( 'd=', $url );

	if ( count( $param ) >= 1 ) {
		$param = explode( '&', $param[1] );
		$url   = str_replace( $param[0], urlencode( 'https://ui-avatars.com/api/' . urlencode( $name ) . "/{$size}/{$background}/{$color}/{$length}/{$fontSize}/{$rounded}/{$uppercase}" ), $url );
	} else {
		$url   = urlencode( 'https://ui-avatars.com/api/' . urlencode( $name ) . "/{$size}/{$background}/{$color}/{$length}/{$fontSize}/{$rounded}/{$uppercase}" );
	}

	return $url;

}
