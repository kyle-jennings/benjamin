<?php

function benjamin_404_settings($wp_customize) {

    $wp_customize->add_setting( '404_page_content_setting', array(
        'default'  => 'default',
        'sanitize_callback' => 'benjamin_404_content_sanitize',
    ) );

    $wp_customize->add_control( '404_page_content_control', array(
            'label'   => 'Page Content',
            'section' => '404_settings_section',
            'settings'=> '404_page_content_setting',
            'priority' => 1,
            'type' => 'select',
            'choices' => array(
                'default' => 'Default',
                'page' => 'Select a Page',
            )
        )
    );

    $wp_customize->add_setting( '404_page_select_setting', array(
        'default'        => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( '404_page_select_control', array(
        'label'   => 'Select a Page',
        'section' => '404_settings_section',
        'settings'=> '404_page_select_setting',
        'type'    => 'dropdown-pages',
        'priority' => 1
    ) );


}

add_action('customize_register', 'benjamin_404_settings');


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
