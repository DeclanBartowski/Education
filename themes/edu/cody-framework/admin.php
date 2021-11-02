<?php
/*
Plugin Name: Cody Framework
Plugin URI: https://codyshop.ru
Description: Framework for create option page for themes
Author: Yan Alexandrov
Version: 1.1.0
*/

/*
 * Include this in head function.php
 * require_once get_template_directory() . '/cody-framework/admin.php';
 */

if ( ! defined( 'ABSPATH' ) ) exit;


function cody_framework_include( $wp_customize ) {

	global $cody_l18n;
	$cody_l18n = wp_get_theme()->get( 'TextDomain' );


	add_action( 'customize_controls_enqueue_scripts', 'cody_framework_add_files' );
	function cody_framework_add_files() {
		wp_enqueue_script( 'cf-script', get_template_directory_uri() . '/cody-framework/inc/js.js', '', '', true );
		wp_enqueue_style( 'cf-style', get_template_directory_uri() . '/cody-framework/inc/css.css', '' );
	}




	require get_template_directory() . '/cody-framework/controls/cody-input.php';
	require get_template_directory() . '/cody-framework/controls/cody-textarea.php';
	require get_template_directory() . '/cody-framework/controls/cody-wpeditor.php';
	require get_template_directory() . '/cody-framework/controls/cody-date-picker.php';
	require get_template_directory() . '/cody-framework/controls/cody-separator.php';
	require get_template_directory() . '/cody-framework/controls/cody-select-category.php';
	require get_template_directory() . '/cody-framework/controls/cody-google-font.php';
	require get_template_directory() . '/cody-framework/controls/cody-menu.php';
	require get_template_directory() . '/cody-framework/controls/cody-multi-input.php';
	require get_template_directory() . '/cody-framework/controls/cody-switch.php';
	require get_template_directory() . '/cody-framework/controls/cody-post.php';
	require get_template_directory() . '/cody-framework/controls/cody-notice.php';
	require get_template_directory() . '/cody-framework/controls/cody-tags.php';
	require get_template_directory() . '/cody-framework/controls/cody-user.php';
	require get_template_directory() . '/cody-framework/controls/cody-range-slider.php';
	require get_template_directory() . '/cody-framework/controls/cody-post-type.php';
	require get_template_directory() . '/cody-framework/controls/cody-taxonomy.php';
	require get_template_directory() . '/cody-framework/controls/cody-color.php';
	require get_template_directory() . '/cody-framework/controls/cody-color-scheme.php';
	require get_template_directory() . '/cody-framework/controls/cody-slider.php';


	require get_template_directory() . '/cody-framework/controls/cody-select.php';
	require get_template_directory() . '/cody-framework/controls/cody-radio-simple.php';
	require get_template_directory() . '/cody-framework/controls/cody-radio-text.php';
	require get_template_directory() . '/cody-framework/controls/cody-radio-image.php';
	
	require get_template_directory() . '/cody-framework/controls/cody-icons.php';
	require get_template_directory() . '/cody-framework/controls/cody-single-image.php';
	require get_template_directory() . '/cody-framework/controls/cody-multi-image.php';
	
	
	require get_template_directory() . '/cody-framework/controls/cody-google-map.php';
	
	require get_template_directory() . '/cody-framework/controls/cody-work-schedule.php';

}
add_action( 'customize_register', 'cody_framework_include' );








add_filter( 'cf_add_style', 'cf_add_style_in_head', 10, 1 );
function cf_add_style_in_head( $arr ) {
	$string = '';
	$arr = apply_filters( 'cf_add_styles', $arr );
	foreach ( $arr as $ar ) {
		if ( isset( $ar['gradient'] ) ) {
			if ( $ar['gradient']['orientation'] == 'horizontal' ) {
				$string .= $ar['selectors'] . '{ ';
				$string .= 'background: ' . $ar['gradient']['color1'] . ';';
				$string .= 'background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, ' . $ar['gradient']['color1'] . '), color-stop(100%, ' . $ar['gradient']['color2'] . '))' . $ar['gradient']['image'];
				$string .= 'background: -moz-linear-gradient(right, ' . $ar['gradient']['color1'] . '), ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
				$string .= 'background: -webkit-linear-gradient(left, ' . $ar['gradient']['color1'] . ', ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
				$string .= 'background: linear-gradient(to right, ' . $ar['gradient']['color1'] . ', ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
				$string .= '}';
			} elseif ( $ar['gradient']['orientation'] == 'vertical' ) {
				$string .= $ar['selectors'] . '{ ';
				$string .= 'background: ' . $ar['gradient']['color1'] . ';';
				$string .= 'background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, ' . $ar['gradient']['color1'] . '), color-stop(100%, ' . $ar['gradient']['color2'] . '))' . $ar['gradient']['image'];
				$string .= 'background: -moz-linear-gradient(top, ' . $ar['gradient']['color1'] . '), ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
				$string .= 'background: -webkit-linear-gradient(top, ' . $ar['gradient']['color1'] . ', ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
				$string .= 'background: linear-gradient(to bottom, ' . $ar['gradient']['color1'] . ', ' . $ar['gradient']['color2'] . ')' . $ar['gradient']['image'];
				$string .= '}';
			}
		} else {
			$string .= $ar['selectors'] . '{ ' . $ar['style'] . ': ' . $ar['val'] . $ar['measure'] . '; }
';
		}
	}
	return $string;
}



/*
 * param @arr - array of css ids and classes
 * param @val - value of css ids and classes
 */
add_action( 'wp_head', 'cf_add_head_styles', 99999 );
function cf_add_head_styles() {
	if( has_filter( 'cf_add_styles' ) ){
		$arr = '';
		echo "<style>\n";
		echo apply_filters( 'cf_add_style', $arr );
		echo "</style>\n";
	}
}



function cf_get_font( $option ) {
	if ( $option ) {
        $selectDirectory = get_template_directory_uri() . '/cody-framework/controls/cache/google-web-fonts.txt';
		$content = json_decode(file_get_contents($selectDirectory));
		$font_id = get_theme_mod( $option );
		$font = $content->items[$font_id];
		return $font;
	}
}


function cf_get_font_family( $option ) {
	if ( $option ) {
		$font = cf_get_font($option);
		return $font->family;
	}
}

function cf_get_font_url( $option ) {
	if ( $option ) {
		$font = cf_get_font($option);
		return $font->files;
	}
}