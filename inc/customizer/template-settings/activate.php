<?php


$wp_customize->add_setting( $name . '_settings_active', array(
    'default' => 'no',
    'sanitize_callback' => 'benjamin_template_settings_active_sanitize',
) );

$activate_args = array(
    'description' => __('Overrides the default template settings to give
    this template a unique look and feel.  <br /><br /><b>If you do not activate these
    settings then the default (Feed) settings and widgets will be used.</b>', 'benjamin'),
    'label' => __('Use Template Settings', 'benjamin'),
    'section' => $name . '_settings_section',
    'settings' => $name . '_settings_active',
    'type' => 'radio',
    'choices' => array(
        'no' => __('No', 'benjamin'),
        'yes' => __('Yes', 'benjamin'),
    ),
    'priority' => 1
);

$wp_customize->add_control( $name . '_settings_active_control', $activate_args );