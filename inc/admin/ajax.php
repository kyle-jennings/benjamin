<?php


function benjamin_ajax_video() {
    if(isset($_POST['data']))
        $url = esc_url_raw( wp_unslash( $_POST['data'] ) );
    else
        wp_die();

    benjamin_the_video_markup($url);
    wp_die();
}
add_action('wp_ajax_benjamin_video_shortcode', 'benjamin_ajax_video');
