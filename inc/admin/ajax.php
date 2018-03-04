<?php

function benjamin_ajax_calculate_widget_width() {

    if( !isset($_POST['data']))
        wp_die();

    echo benjamin_calculate_widget_width( wp_unslash(absint($_POST['data'])) ); // WPCS: xss ok.

    wp_die();
}

add_action('wp_ajax_benjamin_calculate_widget_width' ,'benjamin_ajax_calculate_widget_width');
add_action('wp_ajax_nopriv_benjamin_calculate_widget_width' ,'benjamin_ajax_calculate_widget_width');


function benjamin_postformat_shortcode() {
    if( !isset($_POST['pfpSTR']) || empty($_POST['pfpSTR']) )
        return;

    $str = sanitize_text_field( wp_unslash($_POST['pfpSTR']) );
    echo do_shortcode($str); // WPCS: xss ok.

    exit();

}
add_action('wp_ajax_benjamin_postformat_shortcode', 'benjamin_postformat_shortcode');



function benjamin_postformat_oembed( $url = null, $type = null ) {

    if( (!$url || !$type) && ( isset($_POST['pfpType']) && isset($_POST['pfpURL']) ) ) {
        
        $type = sanitize_text_field(wp_unslash($_POST['pfpType']) );
        $url = esc_url_raw(wp_unslash( $_POST['pfpURL']));
    } else {
        $type = sanitize_text_field(wp_unslash( $type ) );
        $url = esc_url_raw( wp_unslash( $url ) ); 
    }


    $func = 'benjamin_postformat_get_the_' . strtolower($type) . '_markup';

    echo call_user_func($func, $url); // WPCS: xss ok.

    exit();
}
add_action('wp_ajax_benjamin_postformat_oembed', 'benjamin_postformat_oembed');
