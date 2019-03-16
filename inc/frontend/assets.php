<?php

/**
 * Enqueue scripts and styles.
 */
function benjamin_scripts() {

    if(is_admin())
        return;

    $default = BENJAMIN_FRONTEND_ASSETS_DIR .'css/benjamin.min.css';

    $uri = get_theme_mod('color_scheme_setting', $default);
    
    if( !$uri = filter_var( apply_filters('bootswatches_filter_css_uri', $uri), FILTER_VALIDATE_URL ) )
        $uri = $default;

    // the following scripts and styles are minified, however unminified version
    // are included with this theme.

	wp_enqueue_script(
        'benjamin', BENJAMIN_FRONTEND_ASSETS_DIR .'js/uswds-min.js',
         null, null, true
    );
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_style( 'benjamin', $uri, 'dashicons' );

     // comment script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'benjamin_scripts' );
