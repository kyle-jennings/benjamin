<?php

/**
 * Enqueue scripts and styles.
 */
function benjamin_admin_assets() {

    wp_enqueue_style( 'admin-style',
        get_stylesheet_directory_uri() . '/inc/admin/assets/css/benjamin-admin.min.css' );
    wp_enqueue_script( 'admin-scripts',
        get_stylesheet_directory_uri() . '/inc/admin/assets/js/_benjamin-admin-min.js', null, '20170215', true  );
}
add_action( 'admin_enqueue_scripts', 'benjamin_admin_assets' );
