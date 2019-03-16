<?php


/**
 * Label
 */
$wp_customize->add_setting(
    $name . '_other_settings_label', array(
        'default' => 'none',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    )
);
$args = array(
    'label' => __('Other Settings', 'benjamin'),
    'type' => 'label',
    'section' => $name . '_settings_section',
    'settings' => $name . '_other_settings_label',
    'input_attrs' => array(
      'data-toggled-by' => $name . '_settings_active',
    )
);

$wp_customize->add_control(
    new Benjamin_Label_Custom_Control(
        $wp_customize,
        $name . '_other_settings_label_control',
        $args
    )
);


$wp_customize->add_setting( $name.'_page_layout_setting', array(
    'default'        => '',
    'sanitize_callback' => 'benjamin_hide_layout_sanitize',
) );

$layout_args = array(
    'description' => __('Hide parts of a page, great for making landing pages.' ,'benjamin'),
    'label'   => __('Page Layout', 'benjamin'),
    'section' => $name.'_settings_section',
    'settings'=> $name.'_page_layout_setting',
    'choices' => array(
        'banner' => __('Hide Banner', 'benjamin'),
        'navbar' => __('Hide Navbar', 'benjamin'),
        'page-content' => __('Hide Page Content and Sidebar', 'benjamin'),
        'footer' => __('Hide Footer', 'benjamin'),
    ),
    'input_attrs' => array(
      'data-toggled-by' => $name . '_settings_active',
    )
);

$wp_customize->add_control(
    new Benjamin_Checkbox_Group_Control(
        $wp_customize,
        $name.'_page_layout_control',
        $layout_args
    )
);
