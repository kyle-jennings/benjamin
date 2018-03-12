<?php
/**
 * This file contains the function which produce html videos, and also has some
 * helper functions
 */


function benjamin_get_the_video_markup( $url = null ) {
    if( !$url )
        return;

    $settings  = '';
    $output    = '';
    $video     = '';
    $atts      = '';
    $filetypes = array( '.mp4', '.mov', '.wmv', '.avi', '.mpg', '.ogv', '.3gp', '.3g2' );
    $type      = benjamin_get_video_type( $url );

    if ( in_array( substr( $url, -4 ), $filetypes, true ) ) {

        $video .= '<video class="video" ' . esc_attr( $atts ) . ' 
        src="' . esc_attr( $url ) . '" type="video/' . esc_attr( $type ) . '" 
        controls="controls" >';
        $video .= '</video>';

    } elseif ( wp_oembed_get( $url ) ) {
        $video .= wp_oembed_get( $url );
    }

    $output .= '<div class="video-screen">';
    $output .= $video;
    $output .= '</div>';


    return $output;
}


function benjamin_the_video_markup( $url ) {
    echo benjamin_get_the_video_markup( $url ); //WPCS: xss ok.
}


function benjamin_get_youtube_id( $url ) {
    preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match );
    return isset( $match[1] ) ? $match[1] : '';
}


function benjamin_get_video_type( $url ) {

    $filetypes = array( '.mp4', '.mov', '.wmv', '.avi', '.mpg', '.ogv', '.3gp', '.3g2');
    $type      = null;
    if ( in_array( substr( $url, -4 ), $filetypes, true ) ) {
        $type = 'uploaded';
    } elseif ( preg_match( '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $url ) ) {
        $type = 'youtube';
    } elseif ( preg_match( '#^https?://(.+\.)?vimeo\.com/.*#', $url ) ) {
        $type = 'vimeo';
    }

    return $type;
}
