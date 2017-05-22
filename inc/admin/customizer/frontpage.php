<?php


function uswds_frontpage_settings($wp_customize) {


    // Dropdown pages control
     $wp_customize->add_setting( 'frontpage_hero_callout_setting', array(
         'default'        => '1',
         'sanitize_callback' => 'frontpage_setting_sanitization',
     ) );
     $wp_customize->add_control( 'frontpage_hero_callout_control', array(
         'label'   => 'Callout Button',
         'section' => 'frontpage_section',
         'settings'=> 'frontpage_hero_callout_setting',
         'type'    => 'dropdown-pages',
         'priority' => 1
     ) );


     $wp_customize->add_setting( 'frontpage_section_setting', array(
         'default'        => '',
         'sanitize_callback' => 'frontpage_setting_sanitization',
     ) );

     $wp_customize->add_control( new Activated_Sortable_Custom_Control( $wp_customize,
        'frontpage_section_control', array(
            'label'   => 'Sortable Sections',
            'section' => 'frontpage_section',
            'settings'=> 'frontpage_section_setting',
            'priority' => 2,
            'choices' => array(
                    'widget-area-1' => 'Widget Area 1',
                    'widget-area-2' => 'Widget Area 2',
                    'widget-area-3' => 'Widget Area 3',
                    'page-content' => 'Page Content'
                )
            )
        )
    );

}
add_action('customize_register', 'uswds_frontpage_settings');


function frontpage_setting_sanitization($val) {
    return $val;
}
