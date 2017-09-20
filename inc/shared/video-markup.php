<?php
/**
 * This file contains the function which produce html videos, and also has some
 * helper functions
 */

/**
 * Get the featured video post meta
 */
function benjamin_get_the_post_video_url() {
    global $post;
    $url = get_post_meta($post->ID, 'featured-video', true);

    return $url;
}

/**
 * Does this post have a featured video?
 * @return boolean
 */
function benjamin_has_post_video() {
    global $post;

    $url = get_post_meta($post->ID, 'featured-video', true);
    if($url)
        return true;

    return false;
}

/**
 * returns the video markup
 * @param  string $url the url of the video
 * @param  string $background is this a background video (header)?
 * @return string the markup
 */
function benjamin_get_the_video_markup($url = null, $background = null) {
    if(!$url)
        return;

    $settings = '';
    $src = ($background == 'background') ? 'data-src' : 'src';
    $type = benjamin_get_video_type($url);

    $output = '';
    $atts = '';

    // if the video type is not YT or vimeo then its a locally hosted vid.. maybe
    if($type !== 'youtube' && $type !== 'vimeo'){
        if($background == 'background')
            $atts = 'autoplay loop muted';
        else
            $atts = 'controls';

        $output .= '<div class="video-bg">';
            $output .= '<video class="video" '.esc_attr($atts).' '.$src.'="'.esc_attr($url).'" type="video/'.esc_attr($type).'">';
            $output .= '</video>';
        $output .= '</div>';
    }elseif( wp_oembed_get($url)) {

        $id = benjamin_get_youtube_id($url);
        $poster = 'style="background-image: url(http://img.youtube.com/vi/'.$id.'/0.jpg); background-repeat:no-repeat; background-size:cover;"';

        $output .= '<div class="video-bg video-bg--youtube" '.$poster.'>';
            $output .= wp_oembed_get($url);
        $output .= '</div>';
    }



    return $output;
}


/**
 * Echos the video markup
 * @param  string $url the url of the video
 * @param  string $background is this a background video (header)?
 * @return echo the markup
 */
function benjamin_the_video_markup($url, $background = null) {
    echo benjamin_get_the_video_markup($url, $background); //WPCS: xss ok.
}

/**
 * Just grabs the ID of hte youtube video - used to get hte poster
 * @param  string $url the url of the video
 * @return string      YT id
 */
function benjamin_get_youtube_id($url) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return $match[1];
}


/**
 * Identifies whether or not the video is locally uploaded (looks at the file type)
 * or if its a youtube or vimeo video
 * @param  string $url the url of the video
 * @return string      the video type
 */
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


/**
 * adds teh correct settings to oembeded stuff
 * @param  [type] $html [description]
 * @return [type]       [description]
 */
function benjamin_youtube_embed_url($html) {
    $settings ='autoplay=1&mute=1&loop=1&autohide=1&modestbranding=0&rel=0&showinfo=0&controls=0&disablekb=1&enablejsapi=0&iv_load_policy=3';
    return str_replace("?feature=oembed", "?feature=oembed&".$settings, $html);
}
add_filter('oembed_result', 'benjamin_youtube_embed_url');
