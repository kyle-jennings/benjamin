<?php

$files = array(
    '_helpers.php',
    '_sanitizations.php',

    'controls/label.php',
    'controls/sortable.php',
    'controls/color-scheme.php',
    'controls/menu-dropdown.php',
    'controls/checkbox-group.php',
    
    'identity.php',
    'header.php',
    'template-settings.php',
    'frontpage.php',
    'widgetized.php',
    'footer.php',
    'page-404.php',
);

// load all the settings files
foreach ($files as $file) {
    require_once $file;
}



/**
 * enqueues scripts to the WordPress Customizer
 * @return [type] [description]
 */
function benjamin_customizer_enqueue()
{

  // this script is minified, however a non minified version is included with the theme
    wp_enqueue_script(
        'custom-customize',
        get_stylesheet_directory_uri() . '/assets/admin/js/_benjamin-customizer-min.js',
        null,
        '20170215',
        true
    );
}
add_action('customize_controls_enqueue_scripts', 'benjamin_customizer_enqueue');



/**
 * enqueues scripts to the WordPress Previewer
 * @return [type] [description]
 */
function benjamin_previewer_enqueue()
{
    wp_enqueue_script(
        'custom-customize',
        get_stylesheet_directory_uri() . '/assets/frontend/js/_benjamin-previewer-min.js',
        null,
        '20170215',
        true
    );
}

add_action('customize_preview_init', 'benjamin_previewer_enqueue');



/**
 * ----------------------------------------------------------------------------
 * Active Callbacks for 5.2 support ::shakes fist::
 * ----------------------------------------------------------------------------
 */

function benjamin_active_callback_filter($active, $control)
{
    global $wp_customize;

    $toggled_by = isset($control->input_attrs['data-toggled-by']) ? $control->input_attrs['data-toggled-by'] : null;

    if (strpos($toggled_by, '_settings_active') && $toggled_by !== DEFAULT_TEMPLATE . '_settings_active') {
        return 'yes' === $wp_customize->get_setting($toggled_by)->value();
    } elseif ($control->id == '_404_header_page_content_control') {
        return 'page' == $wp_customize->get_setting('_404_hero_content_setting')->value();
    } elseif ($control->id == '_404_page_select_control') {
        return 'page' == $wp_customize->get_setting('_404_page_content_setting')->value();
    } elseif ($control->id == 'frontpage_hero_callout_control') {
        return 'callout' === $wp_customize->get_setting('frontpage_hero_content_setting')->value();
    } elseif ($control->id == 'frontpage_hero_page_control') {
        return 'page' == $wp_customize->get_setting('frontpage_hero_content_setting')->value();
    } elseif ($control->id == 'banner_read_more_control' || $control->id == 'banner_text_control') {
        return 'display' == $wp_customize->get_setting('banner_visibility_setting')->value();
    } elseif (strpos($toggled_by, '_sidebar_position_setting')) {

        $pos = strpos($toggled_by, '_sidebar_position_setting');
        $prefix = substr($toggled_by, 0, $pos);
        $pos = 'none' !== $wp_customize->get_setting($toggled_by)->value();
        $settings_active = $prefix . '_settings_active';

        if ($prefix == 'default') {
            return $pos;
        }

        $section = 'yes' === $wp_customize->get_setting($settings_active)->value();

        return $pos == $section ? true : false;
    }

    return $active;


}

add_filter('customize_control_active', 'benjamin_active_callback_filter', 100, 2);
