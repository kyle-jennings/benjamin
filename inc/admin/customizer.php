<?php

$files = array(
    'customizer-fields/sortable.php',
    'customizer-fields/activate-layout-settings.php',
    'customizer-fields/activated-sortable.php',
    'customizer-fields/color-scheme.php',
    'customizer-fields/menu-dropdown.php',
    'customizer/identity.php',
    'customizer/header.php',
    'customizer/footer.php',
    'customizer/frontpage.php',
    'customizer/template-settings.php',
    'customizer/widgetized.php',
);

foreach($files as $file)
    require_once $file;




/**
 * Remove some default settings from the customizer
 * @param  object $wp_customize
 */
function uswds_remove_default($wp_customize){
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    $wp_customize->remove_section('background_image');
    $wp_customize->remove_section('custom_css');
}
add_action('customize_register', 'uswds_remove_default');
