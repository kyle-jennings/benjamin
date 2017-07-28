<?php


/**
 * Header Settings
 *
 * These settings include ordering the header area (banner, hero,) and the
 * navbar size
 * @param  [type] $wp_customize [description]
 * @return [type]               [description]
 */
function benjamin_header_settings($wp_customize){


    // the section
    $wp_customize->add_section( 'header_settings_section', array(
        'title'          => __('Header Settings', 'benjamin'),
        'priority'       => 30,
    ) );

    // header size
    $header_components = array(
        'navbar' => 'Navbar',
        'hero' => 'Hero',
    );

    if(benjamin_is_dot_gov())
        $header_components['banner'] = 'Banner';

    $wp_customize->add_setting( 'header_sortables_setting', array(
        'default' => '[{"name":"navbar","label":"Navbar"},{"name":"hero","label":"Hero"}]',
        'sanitize_callback' => 'benjamin_header_sortable_sanitize',
    ) );

    $description = 'The header area is made of sortable parts.  Simply drag these
    parts around to change the order they are displayed.';
    $wp_customize->add_control(
        new Benjamin_Sortable_Control( $wp_customize,
            'header_sortables_control', array(
                'description' => $description,
                'label' => __('Header Order', 'benjamin'),
                'section' => 'header_settings_section',
                'settings' => 'header_sortables_setting',
                'choices' => $header_components
            )
        )
    );


    /**
     * Label
     */
    $wp_customize->add_setting(
        'navbar_label', array(
            'default' => 'none',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        )
    );


    $wp_customize->add_control(
        new Benjamin_Label_Custom_Control(
            $wp_customize,
            'navbar_label_control',
            array(
                'label' => __('Navbar Settings', 'benjamin'),
                'type' => 'label',
                'section' => 'header_settings_section',
                'settings' => 'navbar_label',
            )
        )
    );


    $wp_customize->add_setting( 'navbar_search_setting', array(
        'default' => 'none',
        'sanitize_callback' => 'benjamin_navbar_search_setting_sanitize',
    ) );

    $wp_customize->add_control('navbar_search_control', array(
            'label' => __('Display Search in Navbar', 'benjamin'),
            'section' => 'header_settings_section',
            'settings' => 'navbar_search_setting',
            'type' => 'select',
            'choices' => array(
                'none' => 'None',
                'navbar' => 'Navbar',
            )
        )
    );




    $wp_customize->add_setting( 'navbar_color_setting', array(
        'default' => 'light',
        'sanitize_callback' => 'benjamin_navbar_color_setting_sanitize',
    ) );

    $wp_customize->add_control('navbar_color_control', array(
            'label' => __('Navbar Color Scheme', 'benjamin'),
            'section' => 'header_settings_section',
            'settings' => 'navbar_color_setting',
            'type' => 'select',
            'choices' => array(
                'light' => 'Light',
                'dark' => 'Dark',
            )
        )
    );


    $wp_customize->add_setting( 'navbar_sticky_setting', array(
        'default' => 'no',
        'sanitize_callback' => 'benjamin_navbar_sticky_sanitize',
    ) );

    $wp_customize->add_control('navbar_sticky_control', array(
            'description' => __('Stick the navbar to the top of the screen when you scroll down the page', 'benjamin'),
            'label' => __('Navbar sticky on scroll', 'benjamin'),
            'section' => 'header_settings_section',
            'settings' => 'navbar_sticky_setting',
            'type' => 'select',
            'choices' => array(
                'no' => 'No',
                'yes' => 'Yes',
            )
        )
    );

    $wp_customize->add_setting( 'navbar_brand_setting', array(
        'default' => 'text',
        'sanitize_callback' => 'benjamin_navbar_brand_sanitize',
    ) );

    $wp_customize->add_control('navbar_brand_control', array(
            'description' => 'Display your site logo, or site name in the navbar',
            'label' => __('Navbar Brand Type', 'benjamin'),
            'section' => 'header_settings_section',
            'settings' => 'navbar_brand_setting',
            'type' => 'select',
            'choices' => array(
                'text' => 'Text',
                'logo' => 'Logo',
            )
        )
    );



    /**
     * Label
     */
    $wp_customize->add_setting(
        'banner_label', array(
            'default' => 'none',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        )
    );


    $wp_customize->add_control(
        new Benjamin_Label_Custom_Control(
            $wp_customize,
            'banner_label_control',
            array(
                'label' => __('Banner Settings', 'benjamin'),
                'type' => 'label',
                'section' => 'header_settings_section',
                'settings' => 'banner_label',
            )
        )
    );


    $wp_customize->add_setting( 'banner_visibility_setting', array(
        'default' => 'hide',
        'sanitize_callback' => 'benjamin_banner_visibility_sanitize',
    ) );

    $wp_customize->add_control('banner_visibility_control', array(
            'description' => 'Display your site banner',
            'label' => __('Banner Visibility', 'benjamin'),
            'section' => 'header_settings_section',
            'settings' => 'banner_visibility_setting',
            'type' => 'select',
            'choices' => array(
                'hide' => 'Hide',
                'display' => 'Display',
            )
        )
    );


    $wp_customize->add_setting( 'banner_text_setting', array(
        'default' => '',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $wp_customize->add_control('banner_text_control', array(
            'label' => __('Banner Text', 'benjamin'),
            'section' => 'header_settings_section',
            'settings' => 'banner_text_setting',
            'type' => 'text',
        )
    );


    $wp_customize->add_setting( 'banner_read_more_setting', array(
        'default' => '',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $wp_customize->add_control('banner_read_more_control', array(
            'label' => __('Banner Read More', 'benjamin'),
            'section' => 'header_settings_section',
            'settings' => 'banner_read_more_setting',
            'type' => 'text',
        )
    );


}
add_action('customize_register', 'benjamin_header_settings');





/**
 * ----------------------------------------------------------------------------
 * Sanitization settings
 * ----------------------------------------------------------------------------
 */


function benjamin_header_sortable_sanitize($val) {
    $valids = array(
        'navbar',
        'hero',
        'banner',
    );

    $valid = true;
    $tmp_val = json_decode($val);
    foreach($tmp_val as $v){
        if( !in_array($v->name, $valids) )
            $valid = false;
    }

    if(!$valid)
        return null;

    return $val;
}


function benjamin_navbar_brand_sanitize($val) {
    $valids = array(
        'text',
        'logo'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}



function benjamin_navbar_sticky_sanitize($val) {
    $valids = array(
        'no',
        'yes'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}


function benjamin_navbar_color_setting_sanitize($val) {
    $valids = array(
        'light',
        'dark'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}


function benjamin_navbar_search_setting_sanitize($val) {
    $valids = array(
        'none',
        'navbar'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}


function benjamin_banner_visibility_sanitize($val) {
    $valids = array(
        'hide',
        'display'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}
