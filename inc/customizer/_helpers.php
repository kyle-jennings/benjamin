<?php

/**
 * produces a customizer section
 */
function benjamin_customize_section( &$wp_customize, $args = array() ) {

    extract(shortcode_atts(
        array(
            'section' => null,
            'title' => null,
            'description' => null,
        ),
        $args
    ));


    // the section's args, add the panel arg if the template is NOT the archive
    $section_args = array(
        'title' => sprintf( '%s ', $title),
        'description' => sprintf( '%s ', $description ),
    );

    // Add the section for the templates settings
    $wp_customize->add_section(
        $section,
        $section_args
    );

}


/**
 * produces a "label" - this is simply to group like controls together
 */
function benjamin_customizer_label(&$wp_customize, $args = array() ) {

    extract(shortcode_atts(
        array(
            'section' => null,
            'setting_id' => null,
            'label' => null,
            'control_id' => null,
        ),
        $args
    ));

    if( !$section || !$setting_id || !$label || !$control_id )
        return;

    // $wp_customize->add_setting(
    //     $setting_id, array(
    //         'default' => 'none',
    //         'sanitize_callback' => 'wp_filter_nohtml_kses',
    //     )
    // );


    $args = array(
        'label' => sprintf( '%s ', $label ),
        'type' => 'label',
        'section' => $section,
        'settings' => $setting_id,
        'priority' => 1,
    );

    $wp_customize->add_control(
        new Benjamin_Label_Custom_Control(
            $wp_customize,
            $control_id,
            $args
        )
    );

}