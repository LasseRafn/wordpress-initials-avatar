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

if ( is_admin() ) { // admin actions
	add_action( 'admin_init', 'register_wiauia_settings' );
	add_action( 'admin_menu', 'wiauia_settings_menu' );

	function wiauia_settings_menu() {
		add_submenu_page( 'options-general.php', __( 'User Initials Avatar Setitngs', 'wp-initials-avatar' ), 'Avatar settings', 'administrator', __FILE__, 'wiauia_settings_page' );
		add_action( 'admin_init', 'register_wiauia_settings' );
	}

	function register_wiauia_settings() {
		register_setting( 'wiauia-settings', 'color' );
		register_setting( 'wiauia-settings', 'background' );
		register_setting( 'wiauia-settings', 'length' );
		register_setting( 'wiauia-settings', 'size' );
		register_setting( 'wiauia-settings', 'uppercase' );
		register_setting( 'wiauia-settings', 'rounded' );
	}

	function wiauia_enqueue_color_picker() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'my-script-handle', plugins_url( 'settings.js', __FILE__ ), [ 'wp-color-picker' ], false, true );
	}

	add_action( 'admin_enqueue_scripts', 'wiauia_enqueue_color_picker' );

	function wiauia_settings_page() {

		require_once __DIR__ . '/options.php';
	}
}

add_filter( 'get_avatar', 'wordpress_initials_avatar', 1, 6 );

function wordpress_initials_avatar( $avatar, $id_or_email, $size, $default, $alt, $args ) {
	if ( $default !== 'initials' && $args['force_default'] ?? false ) {
		return $avatar;
	}

	$user = false;

	if ( is_numeric( $id_or_email ) ) {
		$id   = (int) $id_or_email;
		$user = get_user_by( 'id', $id );
	} elseif ( is_object( $id_or_email && ! empty( $id_or_email->user_id ) ) ) {
		$id   = (int) $id_or_email->user_id;
		$user = get_user_by( 'id', $id );
	} else {
		$user = get_user_by( 'email', $id_or_email );
	}

	$name = 'initials';

	if ( $id_or_email instanceof WP_Comment ) {
		$name = get_comment_author( $id_or_email->ID );
	}

	if ( $user && is_object( $user ) ) {
		$name = $user->display_name;
	}

	$size       = esc_attr( get_option( 'size', $size ) );
	$size2x = $size * 2;
	$background = esc_attr( get_option( 'background', 'ddd' ) );
	$color      = esc_attr( get_option( 'color', '222' ) );
	$length     = esc_attr( get_option( 'length', 2 ) );
	$fontSize   = 0.5;
	$rounded    = (string) esc_attr( get_option( 'rounded', 'false' ) );
	$uppercase  = (string) esc_attr( get_option( 'uppercase', 'true' ) );

	$color      = str_replace( '#', '', $color );
	$background = str_replace( '#', '', $background );

	$url = $args['url'];
	$url = explode( 'd=', $url );

	if ( count( $url ) >= 1 ) {
		$url = explode( '&', $url[ count( $url ) - 1 ] );

		$url2x  = str_replace( $url[0], urlencode( 'https://ui-avatars.com/api/' . urlencode( $name ) . "/{$size2x}/{$background}/{$color}/{$length}/{$fontSize}/{$rounded}/{$uppercase}" ), $args['url'] );
		$args['url'] = str_replace( $url[0], urlencode( 'https://ui-avatars.com/api/' . urlencode( $name ) . "/{$size}/{$background}/{$color}/{$length}/{$fontSize}/{$rounded}/{$uppercase}" ), $args['url'] );
	} else {
		$args['url'] = urlencode( 'https://ui-avatars.com/api/' . urlencode( $name ) . "/{$size}/{$background}/{$color}/{$length}/{$fontSize}/{$rounded}/{$uppercase}" );
		$url2x  = 'https://ui-avatars.com/api/' . urlencode( $name ) . "/{$size2x}/{$background}/{$color}/{$length}/{$fontSize}/{$rounded}/{$uppercase}";
	}

	if ( ! is_array( $args['class'] ) ) {
		$args['class'] = [ $args['class'] ];
	}

	$avatar = sprintf(
		"<img alt='%s' src='%s' srcset='%s' class='avatar %s' height='%d' width='%d' %s/>",
		esc_attr( $args['alt'] ),
		esc_url( $args['url'] ),
		esc_attr( "$url2x 2x" ),
		esc_attr( implode( ' ', $args['class'] ) ),
		(int) $args['height'],
		(int) $args['width'],
		$args['extra_attr']
	);

	return $avatar;
}