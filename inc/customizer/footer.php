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

function benjamin_footer_settings($wp_customize)
{
    $return_label = __('Return to top', 'benjamin');
    $footer_label = __('Footer menu', 'benjamin');

    $default_json = '[';
    $default_json .= '{"name":"return-to-top","label":"' . $return_label . '"},';
    $default_json .= '{"name":"footer-menu","label":"' . $footer_label . '"}';
    $default_json .= ']';


    $choices = array(
        'return-to-top' => __('Return to Top', 'benjamin'),
        'footer-menu' => __('Footer Menu', 'benjamin'),
        'widget-area-1' => __('Widget Area 1', 'benjamin'),
        'widget-area-2' => __('Widget Area 2', 'benjamin'),
    );

    $wp_customize->add_section('footer_settings_section', array(
        'title'          => __('Footer Settings', 'benjamin'),
        'priority'       => 38,
    ));

    $wp_customize->add_setting('footer_sortables_setting', array(
        'default'        => $default_json,
        'sanitize_callback' => 'benjamin_footer_sortable_sanitize',
    ));


    $description = __('The page content is sortable, and optional.  Simply drag the
    available components from the "available" box over to active.  This setting
    does not depend on the "Settings Active" setting above.', 'benjamin');

    $wp_customize->add_control(
        new Benjamin_Sortable_Control(
            $wp_customize,
            'footer_sortables_control',
            array(
               'description' => sprintf('%s', $description),
               'label'   => __('Sortable Footer Parts', 'benjamin'),
               'section' => 'footer_settings_section',
               'settings'=> 'footer_sortables_setting',
               'priority' => 1,
               'optional' => true,
               'choices' => $choices
            )
        )
    );
}

add_action('customize_register', 'benjamin_footer_settings');
