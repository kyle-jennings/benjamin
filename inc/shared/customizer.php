<?php

$files = array(
    'custom-controls/label.php',
    'custom-controls/sortable.php',
    'custom-controls/color-scheme.php',
    'custom-controls/menu-dropdown.php',
    'custom-controls/checkbox-group.php',
    'settings/_sanitizations.php',
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
 * enqueues scripts to the WordPress Customizer
 * @return [type] [description]
 */
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



/**
 * enqueues scripts to the WordPress Previewer
 * @return [type] [description]
 */
function benjamin_previewer_enqueue() {
  wp_enqueue_script(
        'custom-customize',
        get_stylesheet_directory_uri() . '/assets/js/_benjamin-previewer-min.js',
        null,
        '20170215',
        true
    );
}

add_action( 'customize_preview_init', 'benjamin_previewer_enqueue' );

/**
 * ----------------------------------------------------------------------------
 * Active Callbacks for 5.2 support ::shakes fist::
 * ----------------------------------------------------------------------------
 */


function benjamin_active_callback_filter($active, $control) {
  global $wp_customize;

  if( empty($control->input_attrs) || !isset($control->input_attrs['data-toggled-by']) )
    return $active;

  $toggled_by = $control->input_attrs['data-toggled-by'];

  if( strpos($toggled_by, '_settings_active') && $toggled_by !== 'archive_settings_active' ){
    return 'yes' === $wp_customize->get_setting( $toggled_by )->value();
  }elseif( $control->id == '_404_page_select_control' ){
    return 'page' == $wp_customize->get_setting( '_404_page_content_setting' )->value();
  }elseif( $control->id == 'frontpage_hero_callout_control' ) {
    return 'callout' === $wp_customize->get_setting( 'frontpage_hero_content_setting' )->value();
  }elseif( $control->id == 'frontpage_hero_page_control' ) {
    return $this->checkToggableSettings($active, $control, $wp_customize );
  }

  return $active;


}
add_filter( 'customize_control_active', 'benjamin_active_callback_filter', 100, 2);
