<?php
/**
 * This file contains the function which produce html videos, and also has some
 * helper functions
 */


function benjamin_get_the_post_video_url() {
    global $post;
    $url = get_post_meta($post->ID, 'featured-video', true);

    return $url;
}


function benjamin_has_post_video() {
    global $post;

    $url = get_post_meta($post->ID, 'featured-video', true);
    if($url)
        return true;

    return false;
}


function benjamin_get_the_video_markup($url = null, $background = null) {
    if(!$url)
        return;

    $settings = '';
    $src = ($background == 'background') ? 'data-src' : 'src';
    $type = benjamin_get_video_type($url);

    $output = '';

    $atts = '';

    if($type !== 'youtube' && $type !== 'vimeo'){
        if($background == 'background')
            $atts = 'autoplay loop muted';
        else
            $atts = 'controls';

        $output .= '<div class="video-bg">';
            $output .= '<video class="video" '.esc_attr($atts).' '.$src.'="'.esc_attr($url).'" type="video/'.esc_attr($type).'">';
            $output .= '</video>';
        $output .= '</div>';
    }else {

        $id = benjamin_get_youtube_id($url);
        $poster = 'style="background: url(http://img.youtube.com/vi/'.$id.'/0.jpg) no-repeat cover;"';

        if($background == 'background')
            $settings ='autoplay=1&loop=1&autohide=1&modestbranding=0&rel=0&showinfo=0&controls=0&disablekb=1&enablejsapi=0&iv_load_policy=3&playlist='.$id;
        else
            $settings = 'controls=1';

        $url = 'https://www.youtube.com/embed/'.$id.'?'.$settings;

        $output .= '<div class="video-bg video-bg--youtube">';
            $output .= '<iframe class="video" '.$src.'="'.esc_attr($url).'" frameborder="0" height="100%" width="100%" allowfullscreen ></iframe>';
        $output .= '</div>';
    }



    return $output;
}


function benjamin_the_video_markup($url, $background = null) {
    echo benjamin_get_the_video_markup($url, $background); //WPCS: xss ok.
}


function benjamin_get_youtube_id($url) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return $match[1];
}


function benjamin_get_video_type($url) {


    $type = null;
    if('.mp4' == substr( $url, -4 ) ){
        $type = 'mp4';
    } elseif( '.mov' == substr( $url, -4 ) ) {
        $type = 'mov';
    } elseif('.webm' == substr( $url, -5 )) {
        $type = 'webm';
    } elseif ( preg_match( '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $url ) ) {
        $type = 'youtube';
    } elseif( preg_match('#^https?://(.+\.)?vimeo\.com/.*#', $url ) ) {
        $type = 'vimeo';
    }

    return $type;
}
