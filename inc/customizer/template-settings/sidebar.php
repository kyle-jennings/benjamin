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
    'input_attrs' => array(
      'data-toggled-by' => $name . '_settings_active',
    )
);


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
        'none' => __('No sidebar', 'benjamin'),
        'left' => __('Left', 'benjamin'),
        'right' => __('Right', 'benjamin'),
    ),
    'input_attrs' => array(
      'data-toggled-by' => $name . '_settings_active',
    )
);

$wp_customize->add_control($name . '_sidebar_position_control', $sidebar_pos_args);



/**
 * Sidebar Size
 */
$wp_customize->add_setting( $name . '_sidebar_size_setting', array(
    'default' => 'BENJAMIN_ONE_THIRD',
    'sanitize_callback' => 'benjamin_sidebar_width_sanitize',
    )
);

$wp_customize->add_control( $name . '_sidebar_size_control', array(
        'label'   => 'Sizebar Size',
        'section' => $name . '_settings_section',
        'settings' => $name . '_sidebar_size_setting',
        'type' => 'select',
        'choices' => array(
            'BENJAMIN_ONE_THIRD' => __('Wide', 'benjamin'),
            'BENJAMIN_ONE_FOURTH' => __('Narrow', 'benjamin'),
        ),
        'input_attrs' => array(
            'data-toggled-by' => $name . '_sidebar_position_setting',
        )
    )
);

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
        'always-visible' => __('Always visible', 'benjamin'),
        'hidden-medium-up' => __('Hide on medium screens and larger', 'benjamin'),
        'hidden-large-up' => __('Hide on desktop', 'benjamin'),
        'visible-medium-up' => __('Visible on medium screens and larger', 'benjamin'),
        'visible-large-up' => __('Visible on desktop', 'benjamin'),
    ),
    'input_attrs' => array(
      'data-toggled-by' => $name . '_sidebar_position_setting',
    )
);

$wp_customize->add_control($name . '_sidebar_visibility_control', $sidebar_visibility_args);
