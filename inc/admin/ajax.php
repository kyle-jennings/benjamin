<?php

function benjamin_ajax_calculate_widget_width() {

    
    if( !isset($_POST['data']))
        wp_die();

    echo benjamin_calculate_widget_width( wp_unslash(absint($_POST['data'])) ); // WPCS: xss ok.

    wp_die();
}

add_action('wp_ajax_benjamin_calculate_widget_width' ,'benjamin_ajax_calculate_widget_width');
add_action('wp_ajax_nopriv_benjamin_calculate_widget_width' ,'benjamin_ajax_calculate_widget_width');