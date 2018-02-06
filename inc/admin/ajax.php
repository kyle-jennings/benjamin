<?php

function benjamin_ajax_calculate_widget_width() {

    
    if( !isset($_POST['data']))
        wp_die();

    echo benjamin_calculate_widget_width($_POST['data']);

    wp_die();
}

add_action('wp_ajax_benjamin_calculate_widget_width' ,'benjamin_ajax_calculate_widget_width');
add_action('wp_ajax_nopriv_benjamin_calculate_widget_width' ,'benjamin_ajax_calculate_widget_width');