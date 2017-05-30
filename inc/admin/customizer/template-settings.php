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
function uswds_template_layout_settings($wp_customize) {
    $templates = array(

        'archive' => 'Feed (default)',
        'frontpage' => 'Front Page',
        'single' => 'Single Post',
        'page' => 'Single Page',
        'widgetized' => 'Widgetized Page'
    );

    // not used yet
    // $advanced_templates = array(
    //     '404' => 'Page Not Found',
    //     'search' => 'Search Results',
    //     'date' => 'Filtered by Date',
    //     'category' => 'Filtered by Category',
    //     'tag' => 'Filtered by Tag',
    //     'template_1' => 'Page Template 1',
    //     'template_2' => 'Page Template 2',
    //     'template_3' => 'Page Template 3',
    //     'template_4' => 'Page Template 4',
    // );


    foreach($templates as $name => $label):
        uswds_template_settings_loop($wp_customize, $name, $label);
    endforeach;
}
add_action('customize_register', 'uswds_template_layout_settings');

function uswds_template_settings_loop(&$wp_customize, $name, $label){
    $wp_customize->add_section( $name . '_section', array(
        'title'          => $label . ' Settings',
        'priority'       => 36,
    ) );

    // activate the template settings
    if( $name !== 'archive'):
        $wp_customize->add_setting( $name . '_settings_active', array(
            'default' => 'no',
            'sanitize_callback' => 'uswds_template_settings_active_sanitize',
        ) );

        $wp_customize->add_control(new Activate_Layout_Custom_Control( $wp_customize,
        $name . '_settings_active_control', array(
                'label' => 'Settings Active',
                'section' => $name . '_section',
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
        'sanitize_callback' => 'uswds_hero_image_sanitization',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
        $name . '_image_setting', array(
            'label'   => 'Hero Image Setting',
            'section' => $name . '_section',
            'settings'   => $name . '_image_setting',
            'priority' => 8
            )
        )
    );

    // header size
    $wp_customize->add_setting( $name . '_hero_size_setting', array(
        'default' => 'slim',
        'sanitize_callback' => 'uswds_hero_size_sanitize',
    ) );
    $wp_customize->add_control($name . '_hero_size_control', array(
            'label' => 'Hero Size',
            'section' => $name . '_section',
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
        'sanitize_callback' => 'uswds_sidebar_position_sanitize',
    ) );


    $wp_customize->add_control($name . '_sidebar_position_control', array(
            'label' => 'Sidebar Position',
            'section' => $name . '_section',
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
        'sanitize_callback' => 'uswds_sidebar_visibility_sanitize',
    ) );

    $wp_customize->add_control($name . '_sidebar_visibility_control', array(
            'label' => 'Sidebar Visibility',
            'section' => $name . '_section',
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


}




function uswds_hero_image_sanitization( $val ) {
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
    return ( $file['ext'] ? $val : null );
}


function uswds_template_settings_active_sanitize($val) {
    $valids = array(
        'no',
        'yes'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}

function uswds_hero_size_sanitize($val) {
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


function uswds_sidebar_position_sanitize($val) {
    $valids = array(
        'none',
        'left',
        'right'
    );

    if( !in_array($val, $valids) )
        return null;

    return $val;
}

function uswds_sidebar_visibility_sanitize($val) {
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
