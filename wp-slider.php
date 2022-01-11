<?php
/*
Plugin Name: Wp Slider
Plugin URI: https://nazmunsakib.com
Description: This is minimal plugin for worspress slider
Version: 1.0
Author: Nazmun Sakib
Author URI: https://nazmunsakib.com
License: GPLv2 or later
Text Domain: wps
Domain Path: /languages/
*/

function wps_load_text_domain(){
    load_plugin_textdomain( "wps", false, dirname(__FILE__)."/languages");
}
add_action("plugin_loaded", "wps_load_text_domain");

function wps_assets(){
    wp_enqueue_style("tynislider-css", "//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css");
    wp_enqueue_script("tynislider-js", "//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js", true);

    wp_enqueue_script("wpslider-css", plugin_dir_url(__FILE__)."/assets/js/app.js" , array("jquery"), true);
}
add_action("wp_enqueue_scripts", "wps_assets");

function wps_plugin_init(){
    add_image_size( "wp-slider", 800, 550, true );
}
add_action("init", "wps_plugin_init");

function wp_sliders($atts, $content){
    $deafult = array(
        "id" => "",
        "height" => 550,
        "width" => 800,
    );
    $content = do_shortcode($content);
    $agrs = shortcode_atts($deafult, $atts);

    $sliders = <<<EOD
<div class="wps-container" style="width:{$agrs['width']}; height:{$agrs['height']}" >
    <div class="wpsliders" id="{$agrs['id']}">
        {$content}
    </div>
</div>
EOD;
return $sliders;
}
add_shortcode("wpsliders", "wp_sliders");

function wp_slider($atts){
    $deafult = array(
        "id" => "",
        "caption" => "",
        "size" => "wp-slider",
    );
    $agrs = shortcode_atts($deafult, $atts);
    $img_src = wp_get_attachment_image_src($agrs['id'], $agrs['size']);

    $slider = <<<EOD
<div class="wp-slide">
    <img src="{$img_src['0']}" alt="{$agrs['caption']}">
</div>
EOD;
return $slider;

}
add_shortcode("wpslider", "wp_slider");