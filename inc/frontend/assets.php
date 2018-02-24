<?php

/**
 * Enqueue scripts and styles.
 */
function benjamin_scripts() {

    if(is_admin())
        return;

    $default = get_stylesheet_directory_uri() . '/assets/css/benjamin.min.css';
    $theme = get_theme_mod('color_scheme_setting', $default);
    
    if( !$theme = filter_var( apply_filters('bootswatches_filter_css_uri', $theme), FILTER_VALIDATE_URL ) )
        $theme = $default;

    // the following scripts and styles are minified, however unminified version
    // are included with this theme.

	wp_enqueue_script(
        'benjamin', get_stylesheet_directory_uri() . '/assets/js/uswds-min.js',
         null, null, true
    );

    wp_enqueue_style( 'benjamin', $theme );

     // comment script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'benjamin_scripts' );
