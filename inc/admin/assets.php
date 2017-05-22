<?php

/**
 * Enqueue scripts and styles.
 */
function uswds_admin_assets() {

    wp_enqueue_style( 'admin-style',
        get_template_directory_uri() . '/inc/admin/assets/css/admin.css' );
    wp_enqueue_script( 'admin-scripts',
        get_template_directory_uri() . '/inc/admin/assets/js/_admin.js', null, '20170215', true  );
}
add_action( 'admin_enqueue_scripts', 'uswds_admin_assets' );
