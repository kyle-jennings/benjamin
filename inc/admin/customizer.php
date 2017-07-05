<?php

$files = array(
    'customizer-fields/label.php',
    'customizer-fields/video.php',
    'customizer-fields/sortable.php',
    'customizer-fields/color-scheme.php',
    'customizer-fields/menu-dropdown.php',
    'customizer-fields/checkbox-group.php',
    'customizer/identity.php',
    'customizer/header.php',
    'customizer/template-settings.php',
    'customizer/frontpage.php',
    'customizer/widgetized.php',
    'customizer/footer.php',
    'customizer/404.php',
);

foreach($files as $file)
    require_once $file;




/**
 * Remove some default settings from the customizer
 * @param  object $wp_customize
 */
function benjamin_customizer_settings($wp_customize){
    // placeholder for near future updates
    $wp_customize->register_control_type( 'Benjamin_Video_Control' );
}
add_action('customize_register', 'benjamin_customizer_settings', 50);


function benjamin_customizer_enqueue() {

	wp_enqueue_script(
        'custom-customize',
        get_stylesheet_directory_uri() . '/inc/admin/assets/js/_benjamin-customizer-min.js',
        null,
        '20170215',
        true
    );
}
add_action( 'customize_controls_enqueue_scripts', 'benjamin_customizer_enqueue' );
