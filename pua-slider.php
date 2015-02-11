<?php
/**
 * @package Pua_Slider
 * @version 0.0
 */
/*
Plugin Name: Pua Slider
Plugin URI: http://wordpress.org/plugins/pua-slider/
Description: Slider layer plug in by Kanika
Author: Nicolás Vela
Version: 0.0
Author URI: http://kanika.com
*/

$slider_view_path = plugin_dir_url( __FILE__ );

class puaslider {
    public function __construct()
    {
		include('controller/config_slider.php');

    	add_shortcode( 'puaslider_sc' , array( $this, 'pua_slider_sc') );

    	add_action("admin_menu", array( $this, "pua_slider"));
    
    }
    public function pua_slider() {

		add_menu_page('slider_settings', 'PUA Slider', 'manage_options', 
		'slider_settings', 'slider_list', plugins_url().'/pua-slider/puaicon.png');
	}

    public function pua_slider_sc($atts){
    	global $slider_view_path;
    	$slides = get_option( 'pua_sliders');
		$frond_counter = 1;
		$id = $atts['id'];

		$slide_width_value = $slides[$id]['slider_width'];
		$slide_height_value = $slides[$id]['slider_height'];

		if(!$slide_width_value){
			$slide_width_value = '100';
			$slide_height_value = '3:1';
		}
		$slide_width = $slide_width_value.'%';
		$slide_height = explode(":",$slide_height_value);
		$slide_height = ($slide_height[1] * $slide_width)/ $slide_height[0].'vh';

			include('views/slider.php');
		}

	
}

$wpDribbble = new puaslider();