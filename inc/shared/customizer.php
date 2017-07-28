<?php

$files = array(
    'custom-controls/label.php',
    'custom-controls/video.php',
    'custom-controls/sortable.php',
    'custom-controls/color-scheme.php',
    'custom-controls/menu-dropdown.php',
    'custom-controls/checkbox-group.php',
    'settings/identity.php',
    'settings/header.php',
    'settings/template-settings.php',
    'settings/frontpage.php',
    'settings/widgetized.php',
    'settings/footer.php',
    'settings/404.php',
);

foreach($files as $file)
    require_once 'customizer/' . $file;




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

    // this script is minified, however a non minified version is included with the
    // theme
	wp_enqueue_script(
        'custom-customize',
        get_stylesheet_directory_uri() . '/inc/admin/assets/js/_benjamin-customizer-min.js',
        null,
        '20170215',
        true
    );
}
add_action( 'customize_controls_enqueue_scripts', 'benjamin_customizer_enqueue' );
