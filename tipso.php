<?php
/**
 * Plugin Name: Tipso
 * Plugin URI: http://tipso.object505.com
 * Description: A Lightweight Responsive Mobile Tooltip
 * Version: 1.0.0
 * Author: Bojan Petkovski
 * Author URI: http://object505.com
 * License: A short license name. Example: GPL2
 */

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
	Add Admin Settings
 **/

include_once 'tipso-admin.php';	

/**
	Register Tipso Shortcode
 **/

add_action( 'init', 'tipso_register_shortcodes' );
function tipso_register_shortcodes() {
	add_shortcode( 'tipso', 'tipso_shortcode' );
}
function tipso_shortcode( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'tip' => 'tipso',
		), $atts )
	);

	$content = do_shortcode( $content );
	
	return "<span class='tipso' data-tipso='" . esc_attr( $tip ) ."'>" . $content . "</span>";	
}
add_shortcode( 'tipso', 'tipso_shortcode' );

/**
 	Enqueue Script and Style
 **/

function tipso_enqueue() {
	wp_register_style( 'tipso-css', plugins_url('src/tipso.min.css', __FILE__) );
	wp_enqueue_style( 'tipso-css' );
	wp_register_script( 'tipso-js', plugins_url('src/tipso.min.js', __FILE__), 'jquery', null, true );
	wp_enqueue_script( 'tipso-js' );
	wp_register_script( 'calltipso-js', plugins_url('admin/callTipso.js', __FILE__), 'jquery', null, true );

	// Get Settings Page values
	$options    = get_option( 'tipso_settings' );		
	
	$speed		= $options['speed']      ? $options['speed']      : 400 ;
	$background	= $options['background'] ? $options['background'] : '#55b555' ;
	$color		= $options['color']      ? $options['color']      : '#ffffff' ;
    $position 	= $options['position']   ? $options['position']   : 'top' ;
    $width		= $options['width']      ? $options['width']      : 200 ;
    $delay		= $options['delay']      ? $options['delay']      : 200 ;

	$tipsoData = array(
	    'speed'       => $speed,
        'background'  => $background,
        'color'       => $color,
        'position'    => $position,
        'width'       => $width,
        'delay'       => $delay 
	);
	wp_localize_script( 'calltipso-js', 'tipsoData', $tipsoData );
	wp_enqueue_script( 'calltipso-js' );
	
}
add_action( 'wp_enqueue_scripts', 'tipso_enqueue' );


/**
	Add Button to tinymce Editor
 **/
function add_tipso_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'tipso_tinymce_plugin' );
		add_filter( 'mce_buttons', 'tipso_register_mce_button' );
	}
}
add_action('admin_head', 'add_tipso_mce_button');

// Declare script for new button
function tipso_tinymce_plugin( $plugin_array ) {
	$plugin_array['tipso_mce_button'] = plugins_url('admin/tipso-mce.js', __FILE__);
	return $plugin_array;
}

// Register new button in the editor
function tipso_register_mce_button( $buttons ) {
	array_push( $buttons, 'tipso_mce_button' );
	return $buttons;
}
// Add dashicons for tipso icon
function tipso_mce_style() {
	wp_enqueue_style('tipso_mce_style', plugins_url('admin/tipso-mce.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'tipso_mce_style');