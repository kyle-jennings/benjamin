<?php


// If we are not in the archive, display the layout settings
if( $name !== 'archive'):
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
    );

    if($name != 'archive')
        $args['active_callback'] = $active_callback;
    $wp_customize->add_control(
        new Benjamin_Label_Custom_Control(
            $wp_customize,
            $name . '_other_settings_label_control',
            $args
        )
    );
endif;

// If we are not in the archive, display the layout settings
if( $name !== 'archive'):

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
            'banner' => 'Hide Banner',
            'navbar' => 'Hide Navbar',
            'page-content' => 'Hide Page Content and Sidebar',
            'footer' => 'Hide Footer'
        ),
    );

    if( $name !== 'archive')
        $layout_args['active_callback'] = $active_callback;

    $wp_customize->add_control(
        new Benjamin_Checkbox_Group_Control(
            $wp_customize,
            $name.'_page_layout_control',
            $layout_args
        )
    );

endif;
