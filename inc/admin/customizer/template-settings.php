<?php



/**
 * Layout settings for each templates
 *
 * Settings allow configuring th hero size, the hero image,
 * and the position of the navbar.  I will soon add the ability to "activate"
 * the settings.  So if a user wants, they would only need to set the "default"
 * layout settings
 * @param  object $wp_customize
 */
function benjamin_template_layout_settings($wp_customize) {

    $templates = benjamin_the_template_list();



    foreach($templates as $name => $label):
        benjamin_template_settings_loop($wp_customize, $name, $label);
    endforeach;
}
add_action('customize_register', 'benjamin_template_layout_settings');


function benjamin_template_settings_loop(&$wp_customize, $name, $label){
    $wp_customize->add_section( $name . '_settings_section', array(
        'title'          => ucfirst($label) . ' Settings',
        'priority'       => 36,
    ) );

    // activate the template settings
    if( $name !== 'archive'):

        $wp_customize->add_setting( $name . '_settings_active', array(
            'default' => 'no',
            'sanitize_callback' => 'benjamin_template_settings_active_sanitize',
        ) );

        $wp_customize->add_control(new Benjamin_Activate_Layout_Custom_Control( $wp_customize,
        $name . '_settings_active_control', array(
                'label' => 'Settings Active',
                'section' => $name . '_settings_section',
                'settings' => $name . '_settings_active',
                'type' => 'radio',
                'choices' => array(
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'priority' => 2
            )
        ));
    endif;


    // WP_Customize_Image_Control
    $wp_customize->add_setting( $name . '_image_setting', array(
        'default'      => null,
        'sanitize_callback' => 'benjamin_hero_image_sanitization',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
        $name . '_image_setting_control', array(
            'label'   => 'Hero Image',
            'section' => $name . '_settings_section',
            'settings'   => $name . '_image_setting',
            'priority' => 8
            )
        )
    );


    // $wp_customize->add_setting($name . '_video_setting', array(
    //     'sanitize_callback' => 'absint'
    // ));
    //
    // $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize,
    // $name . '_video_control', array(
    //     'label'   => 'Hero Video',
    //     'section' => $name . '_settings_section',
    //     'settings' => $name . '_video_setting',
    //     'mime_type' => 'video'
    // )));

    // header size
    $wp_customize->add_setting( $name . '_hero_size_setting', array(
        'default' => 'slim',
        'sanitize_callback' => 'benjamin_hero_size_sanitize',
    ) );
    $wp_customize->add_control($name . '_hero_size_control', array(
            'label' => 'Hero Size',
            'section' => $name . '_settings_section',
            'settings' => $name . '_hero_size_setting',
            'type' => 'radio',
            'choices' => array(
                'slim' => 'Slim',
                'medium' => 'Medium',
                'big' => 'Big',
                'full' => 'Full Screen'
            )
        )
    );


    $wp_customize->add_setting( $name . '_sidebar_position_setting', array(
        'default' => 'none',
        'sanitize_callback' => 'benjamin_sidebar_position_sanitize',
    ) );


    $wp_customize->add_control($name . '_sidebar_position_control', array(
            'label' => 'Sidebar Position',
            'section' => $name . '_settings_section',
            'settings' => $name . '_sidebar_position_setting',
            'type' => 'radio',
            'choices' => array(
                'none' => 'No sidebar',
                'left' => 'Left',
                'right' => 'Right'
            )
        )
    );



    $wp_customize->add_setting( $name . '_sidebar_visibility_setting', array(
        'default' => 'always-visible',
        'sanitize_callback' => 'benjamin_sidebar_visibility_sanitize',
    ) );

    $wp_customize->add_control($name . '_sidebar_visibility_control', array(
            'label' => 'Sidebar Visibility',
            'section' => $name . '_settings_section',
            'settings' => $name . '_sidebar_visibility_setting',
            'type' => 'radio',
            'choices' => array(
                'always-visible' => 'Always visible',
                'hidden-medium-up' => 'Hide on medium screens and larger',
                'hidden-large-up' => 'Hide on desktop',
                'visible-medium-up' => 'Visible on medium screens and larger',
                'visible-large-up' => 'Visible on desktop',
            )
        )
    );

    if( $name !== 'archive'):

        $wp_customize->add_setting( $name.'_page_layout_setting', array(
            'default'        => '',
            'sanitize_callback' => 'benjamin_hide_layout_sanitize',
        ) );

        $wp_customize->add_control( new Benjamin_Checkbox_Group_Control( $wp_customize,
            $name.'_page_layout_control', array(
                'label'   => 'Page Layout',
                'section' => $name.'_settings_section',
                'settings'=> $name.'_page_layout_setting',
                'priority' => 6,
                'choices' => array(
                        'banner' => 'Hide Banner',
                        'navbar' => 'Hide Navbar',
                        'page-content' => 'Hide Page Content and Sidebar',
                        'footer' => 'Hide Footer'
                    )
                )
            )
        );

    endif;

}




function benjamin_hero_image_sanitization( $val ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $val, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( ($file['ext'] || $val == null) ? $val : null );
}


function benjamin_template_settings_active_sanitize($val) {
    $valids = array(
        'no',
        'yes'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}

function benjamin_hero_size_sanitize($val) {
    $valids = array(
        'slim',
        'medium',
        'big',
        'full',
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}


function benjamin_sidebar_position_sanitize($val) {
    $valids = array(
        'none',
        'left',
        'right'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}

function benjamin_sidebar_visibility_sanitize($val) {
    $valids = array(
        'always-visible',
        'hidden-medium-up',
        'hidden-large-up',
        'visible-medium-up',
        'visible-large-up',
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}


function benjamin_hide_layout_sanitize($val) {
    $valids = array(
        'banner',
        'navbar',
        'page-content',
        'footer',
    );

    $valid = true;
    $tmp_val = json_decode($val);
    foreach($tmp_val as $v){
        if( !in_array($v, $valids) )
            $valid = false;
    }

    if(!$valid)
        return null;

    return $val;
}
