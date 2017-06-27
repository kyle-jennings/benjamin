<?php


function benjamin_ajax_video() {
    $url = $_POST['data'];

    benjamin_the_video_markup($url);
    wp_die();
}
add_action('wp_ajax_benjamin_video_shortcode', 'benjamin_ajax_video');
