<?php


/**
 * Label
 */
$wp_customize->add_setting(
    $name . '_sidebar_label', array(
        'default' => 'none',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    )
);
$args = array(

    'label' => __('Sidebar Settings', 'benjamin'),
    'type' => 'label',
    'section' => $name . '_settings_section',
    'settings' => $name . '_sidebar_label',
);
if($name != 'archive')
    $args['active_callback'] = $active_callback;
$wp_customize->add_control(
    new Benjamin_Label_Custom_Control(
        $wp_customize,
        $name . '_sidebar_label_control',
        $args
    )
);


/**
 * Sidebar position
 */
$wp_customize->add_setting( $name . '_sidebar_position_setting', array(
    'default' => 'none',
    'sanitize_callback' => 'benjamin_sidebar_position_sanitize',
) );

$sidebar_pos_args = array(
    'description' => __('Hide or move your sidebar to change the layout of the content area.','benjamin'),
    'label' => __('Sidebar Position', 'benjamin'),
    'section' => $name . '_settings_section',
    'settings' => $name . '_sidebar_position_setting',
    'type' => 'select',
    'choices' => array(
        'none' => 'No sidebar',
        'left' => 'Left',
        'right' => 'Right'
    ),
);

if( $name !== 'archive')
    $sidebar_pos_args['active_callback'] = $active_callback;

$wp_customize->add_control($name . '_sidebar_position_control', $sidebar_pos_args);


/**
 * Sidebar Visibility
 */
$wp_customize->add_setting( $name . '_sidebar_visibility_setting', array(
    'default' => 'always-visible',
    'sanitize_callback' => 'benjamin_sidebar_visibility_sanitize',
) );
$sidebar_visibility_args = array(
    'description' => __('Hide or show the sidebar on different screen size (ie: hide on phones)', 'benjamin'),
    'label' => __('Sidebar Visibility', 'benjamin'),
    'section' => $name . '_settings_section',
    'settings' => $name . '_sidebar_visibility_setting',
    'type' => 'select',
    'choices' => array(
        'always-visible' => 'Always visible',
        'hidden-medium-up' => 'Hide on medium screens and larger',
        'hidden-large-up' => 'Hide on desktop',
        'visible-medium-up' => 'Visible on medium screens and larger',
        'visible-large-up' => 'Visible on desktop',
    ),
);

if( $name !== 'archive')
    $sidebar_visibility_args['active_callback'] = $active_callback;

$wp_customize->add_control($name . '_sidebar_visibility_control', $sidebar_visibility_args);
