<?php

/**
 * Enqueue scripts and styles.
 */
function uswds_scripts() {

    if(is_admin())
        return;
        
    $uswds_color_scheme = get_theme_mod('color_scheme_setting');

    $uswds_color_scheme = (!$uswds_color_scheme || $uswds_color_scheme == 'standard')
        ? '' : '-'.$uswds_color_scheme;


	wp_enqueue_script( 'uswds-scripts',
        get_template_directory_uri() . '/assets/js/uswds.min.js' );
    wp_enqueue_style( 'uswds-style',
        get_template_directory_uri() . '/assets/css/site'.$uswds_color_scheme.'.css' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'uswds_scripts' );
