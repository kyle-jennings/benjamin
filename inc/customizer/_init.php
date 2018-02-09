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
foreach($files as $file)
  require_once  $file;



/**
 * enqueues scripts to the WordPress Customizer
 * @return [type] [description]
 */
function benjamin_customizer_enqueue() {

  // this script is minified, however a non minified version is included with the theme
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

  $toggled_by = !isset($control->input_attrs) ? $control->input_attrs['data-toggled-by'] : null;


  // toggle controls if the template has been "activated"
  if( strpos($toggled_by, '_settings_active') && $toggled_by !== DEFAULT_TEMPLATE.'_settings_active' ){
    // error_log('template');
    return 'yes' === $wp_customize->get_setting( $toggled_by )->value();
  
  // toggle the 404 header content page selection is "page" is selected
  } elseif( $control->id == '_404_header_page_content_control'){

    return 'page' == $wp_customize->get_setting( '_404_hero_content_setting' )->value();

  } elseif( $control->id == '_404_page_select_control' ){
    // error_log('404 page');
  
    return 'page' == $wp_customize->get_setting( '_404_page_content_setting' )->value();

  // toggle the frontpage header content page selection is "page" is selected  
  }elseif( $control->id == 'frontpage_hero_callout_control' ) {
    // error_log('frontpage hero');
    return 'callout' === $wp_customize->get_setting( 'frontpage_hero_content_setting' )->value();

  // something else with the frontage
  }elseif( $control->id == 'frontpage_hero_page_control' ) {
    // error_log('front page hero content');
    return 'page' == $wp_customize->get_setting( 'frontpage_hero_content_setting' )->value();
    
    // return $this->checkToggableSettings($active, $control, $wp_customize );
  }

  return $active;


}
add_filter( 'customize_control_active', 'benjamin_active_callback_filter', 100, 2);
