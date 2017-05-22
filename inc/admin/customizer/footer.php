<?php


/**
 * The footer settings
 *
 * Settings include, the footer "size" (how many footer sections), and the
 * content type (widgets or menu), and if menu is selected then the menu.
 *
 * The content and menu options will probably be removed in the future in lieu
 * of creating a new footer nav widget
 * @param  object $wp_customize
 */
function uswds_footer_settings($wp_customize) {

    $wp_customize->add_section( 'footer_settings_section', array(
        'title'          => 'Footer Settings',
        'priority'       => 38,
    ) );

    // footer size
    $wp_customize->add_setting( 'footer_size_setting', array(
        'default' => '',
        'sanitize_callback' => 'footer_setting_sanitization',
    ) );
    $wp_customize->add_control('footer_size_control', array(
            'label' => 'Footer Size',
            'section' => 'footer_settings_section',
            'settings' => 'footer_size_setting',
            'type' => 'radio',
            'choices' => array(
                'slim' => 'Slim',
                'medium' => 'Medium',
                'big' => 'Big',
            )
        )
    );

    $wp_customize->add_setting( 'footer_top_content_setting', array(
        'default' => '',
        'sanitize_callback' => 'footer_setting_sanitization',
    ) );
    $wp_customize->add_control('footer_top_content_control', array(
            'label' => 'Footer Top Content',
            'section' => 'footer_settings_section',
            'settings' => 'footer_top_content_setting',
            'type' => 'radio',
            'choices' => array(
                'widgets' => 'Widgets',
                'menu' => 'Menu',
            )
        )
    );


    $wp_customize->add_setting( 'footer_menu_setting', array(
        'default' => '',
        'sanitize_callback' => 'footer_setting_sanitization',
        )
    );

    $wp_customize->add_control( new Menu_Dropdown_Custom_Control(
        $wp_customize, 'footer_menu_control', array(
            'label'   => 'Footer Menu Dropdown Setting',
            'section' => 'footer_settings_section',
            'settings'   => 'footer_menu_setting',
            )
        )
    );

}
add_action('customize_register', 'uswds_footer_settings');



function footer_setting_sanitization($val) {
    return $val;
}
