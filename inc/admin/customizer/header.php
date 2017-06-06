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
        'title'          => 'Header Settings',
        'priority'       => 30,
    ) );

    // header size

    $header_components = array(
        'navbar' => 'Navbar',
        'hero' => 'Hero',
    );

    if(benjamin_is_dot_gov())
        $header_components['banner'] = 'Banner';

    $wp_customize->add_setting( 'header_order_setting', array(
        'default' => 'banner-navbar-hero',
        'sanitize_callback' => 'benjamin_header_sortable_sanitize',
    ) );

    $wp_customize->add_control(
        new Benjamin_Sortable_Custom_Control( $wp_customize,
            'header_order_control', array(
                'label' => 'Header Order',
                'section' => 'header_settings_section',
                'settings' => 'header_order_setting',
                'type' => 'radio',
                'choices' => $header_components
            )
        )
    );


    $wp_customize->add_setting( 'navbar_search_setting', array(
        'default' => 'none',
        'sanitize_callback' => 'benjamin_navbar_search_setting_sanitize',
    ) );

    $wp_customize->add_control('navbar_search_control', array(
            'label' => 'Search Location',
            'section' => 'header_settings_section',
            'settings' => 'navbar_search_setting',
            'type' => 'select',
            'choices' => array(
                'none' => 'None',
                'navbar' => 'Navbar',
            )
        )
    );


    // $navs = array('navbar', 'secondary-navbar');
    $navs = array('navbar');
    foreach($navs as $nav):

        $wp_customize->add_setting( $nav . '_color_setting', array(
            'default' => 'light',
            'sanitize_callback' => 'benjamin_navbar_color_setting_sanitize',
        ) );

        $wp_customize->add_control($nav . '_color_control', array(
                'label' => benjamin_clean_string($nav) .' Color Scheme',
                'section' => 'header_settings_section',
                'settings' => $nav . '_color_setting',
                'type' => 'select',
                'choices' => array(
                    'light' => 'Light',
                    'dark' => 'Dark',
                )
            )
        );
    endforeach;

    $wp_customize->add_setting( 'navbar_sticky_setting', array(
        'default' => 'no',
        'sanitize_callback' => 'benjamin_navbar_sticky_sanitize',
    ) );

    $wp_customize->add_control('navbar_sticky_control', array(
            'label' => 'Navbar sticky on scroll',
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
            'label' => 'Navbar Brand Type',
            'section' => 'header_settings_section',
            'settings' => 'navbar_brand_setting',
            'type' => 'select',
            'choices' => array(
                'text' => 'Text',
                'logo' => 'Logo',
            )
        )
    );
}
add_action('customize_register', 'benjamin_header_settings');

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
