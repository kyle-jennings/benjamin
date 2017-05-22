<?php

/**
 * Custom Excerpt Length
 */
function uswds_continue_reading_link() {
    global $summary_settings;
    $value = $summary_settings['read_more'] ? $summary_settings['read_more'] : '...';

    return ' <a href="'. esc_url( get_permalink() ) . '">' . $value . '</a>';
}


function uswds_excerpt_length() {
    global $summary_settings;
    $value = $summary_settings['length'] ? $summary_settings['length'] : 55;

    return $value;
}

function uswds_auto_excerpt_more( $more ) {
    return uswds_continue_reading_link();
}

function uswds_custom_excerpt_more( $output ) {
    if ( has_excerpt() && !is_attachment() ) {
        $output .= uswds_continue_reading_link();
    }
    return $output;
}


if(get_option('rss_use_excerpt', true) == true) {
    $summary_settings = get_option('summary_settings', true);

    add_filter( 'excerpt_length', 'uswds_excerpt_length' );
    add_filter( 'excerpt_more', 'uswds_auto_excerpt_more' );
    add_filter( 'get_the_excerpt', 'uswds_custom_excerpt_more' );
}
