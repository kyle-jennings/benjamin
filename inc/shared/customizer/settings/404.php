<?php

function benjamin_404_settings($wp_customize) {

    // Should we display a page in the header?
    $wp_customize->add_setting( '_404_header_page_content_setting', array(
        'default'        => 0,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( '_404_header_page_content_control', array(
            'description' => __('Select page content to the header, this is great when the header size is set to full and the other page parts are hidden.','benjamin'),
            'label'   => __('Use page content in header', 'benjamin'),
            'section' => '_404_settings_section',
            'settings'=> '_404_header_page_content_setting',
            'type' => 'select',
            'type'    => 'dropdown-pages',
            'priority' => 1,
         )
    );


    // What is the page content? The premade default, or a user created page?
    $wp_customize->add_setting( '_404_page_content_setting', array(
        'default'  => 'default',
        'sanitize_callback' => 'benjamin_404_content_sanitize',
    ) );

    $wp_customize->add_control( '_404_page_content_control', array(
            'description' => __('Display some default content provided by the theme or select a page to display.','benjamin'),
            'label'   => __('Page Content', 'benjamin'),
            'section' => '_404_settings_section',
            'settings'=> '_404_page_content_setting',
            'priority' => 1,
            'type' => 'select',
            'choices' => array(
                'default' => 'Default',
                'page' => 'Select a Page',
            )
        )
    );

    // if it is a user created page, then select the page
    $wp_customize->add_setting( '_404_page_select_setting', array(
        'default'        => 0,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( '_404_page_select_control', array(
            'label'   => __('Select a Page', 'benjamin'),
            'section' => '_404_settings_section',
            'settings'=> '_404_page_select_setting',
            'type'    => 'dropdown-pages',
            'priority' => 1,
            'active_callback' => function() use ( $wp_customize ) {
                  return 'page' == $wp_customize->get_setting( '_404_page_content_setting' )->value();
            },
         )
    );

}

add_action('customize_register', 'benjamin_404_settings');


/**
 * ----------------------------------------------------------------------------
 * Sanitization settings
 * ----------------------------------------------------------------------------
 */


function benjamin_404_page_select_sanitize($val) {
    $pages = get_posts(array('post_type' => 'page', 'posts_per_page' => -1, 'fields' => 'ids'));

    if( !in_array($val, $pages) && 'publish' == get_post_status( $val ) )
        return null;

    return $val;
}


function benjamin_404_content_sanitize($val) {
    $valids = array(
        'default',
        'page'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}
