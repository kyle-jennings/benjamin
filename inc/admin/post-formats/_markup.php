<?php


function benjamin_postformat_get_the_video_markup($url = null) {
    if(!$url)
        return;

    $settings = '';
    $filetypes = array( '.mp4', '.mov', '.wmv', '.avi', '.mpg', '.ogv', '.3gp', '.3g2',);

    $output = '';
    $video = '';
    $atts = '';

    if( in_array( substr( $url, -4 ), $filetypes )  ){

        $video .= '<video class="video" '.esc_attr($atts).' src="'.esc_attr($url).'" type="video/'.esc_attr($type).'" controls="controls">';
        $video .= '</video>';

    }elseif( wp_oembed_get($url) ) {

        $video .= wp_oembed_get($url);

    }

    $output .= '<div class="video-screen">';
        $output .= $video;
    $output .= '</div>';


    return $output;
}


function benjamin_postformat_get_the_audio_markup($url = null) {
    if(!$url)
        return;

    $settings = '';

    $output = '';
    $audio = '';

    $filetypes = array( '.mp3', '.m4a', '.ogg', '.wav');

    if( in_array( substr( $url, -4 ), $filetypes ) ) {

        $audio .= '<div class="audio-player js--audio-player">';
            $audio .= '<canvas class="audio-player__visualizer" ></canvas>';
            $audio .= '<audio class="audio-player__player" src="'.$url.'" controls="controls"></audio>';
        $audio .= '</div>';

    }elseif( wp_oembed_get($url) ) {

        $audio .= wp_oembed_get($url);

    }

    $output .= $audio;



    return $output;
}



function benjamin_postformat_get_the_image_markup($url = null) {
    if(!$url)
        return;

    $settings = '';

    $output = '';
    $image = '';

    $filetypes = array( '.jpg', '.jpeg', '.png', '.gif', '.ico');

    if( in_array( substr( $url, -4 ), $filetypes ) ) {

        $image .= '<img src="'.$url.'" />';

    }elseif( wp_oembed_get($url) ) {

        $image .= wp_oembed_get($url);

    }

    $output .= $image;



    return $output;
}
