<?php

// cleans strings from machine safe to human readable
function benjamin_clean_string( $string ) {
    $find = array( '-', '_' );
    $replace = ' ';
    $string = str_replace( $find, $replace, $string );
    $string = ucwords( $string );
    return $string;
}


/**
* Set the content width in pixels, based on the theme's design and stylesheet.
*
* Priority 0 to make it available to lower priority callbacks.
*
* @global int $content_width
*/
function benjamin_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'benjamin_content_width', 640 );
}
add_action( 'after_setup_theme', 'benjamin_content_width', 0 );


function benjamin_get_post_format_value( $post_id = null, $format = null, $default = null ) {
    
    if ( ! $post_id || ! $format ) {
        return null;
    }

    $value = get_post_meta( $post_id, '_post_format_value', true );
    $value = isset( $value[ $format ] ) ? $value[ $format ] : null;

    return $value;
}


function benjamin_use_post_format_content( $post = null, $format = 'standard', $exclude ) {
    
    $include = json_decode( BENJAMIN_POST_FORMATS );
    if ( !in_array( $format, $include, true ) ) {
        return false;
    }

    return benjamin_get_post_format_value( $post->ID, $format, null );
}