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
        'title'          => sprintf( __('%s Settings', 'benjamin'), ucfirst($label) ),
        'priority'       => 36,
    ) );

    // activate the template settings
    if( $name !== 'archive'):

        $wp_customize->add_setting( $name . '_settings_active', array(
            'default' => 'no',
            'sanitize_callback' => 'benjamin_template_settings_active_sanitize',
        ) );

        $activate_args = array(
            'description' => __('Overrides the default template settings to give this template a unique look and feel.', 'benjamin'),
            'label' => __('Use Template Settings', 'benjamin'),
            'section' => $name . '_settings_section',
            'settings' => $name . '_settings_active',
            'type' => 'radio',
            'choices' => array(
                'no' => 'No',
                'yes' => 'Yes',
            ),
            'priority' => 2
        );

        $wp_customize->add_control( $name . '_settings_active_control', $activate_args );

    endif;

    // the active callback will provide the toggle functionality for us
    if( $name !== 'archive') {
        $active_callback = function() use ( $wp_customize, $name ) {
            return 'yes' === $wp_customize->get_setting( $name . '_settings_active' )->value();
        };
    }

    /**
     * Label
     */
    $wp_customize->add_setting(
        $name . '_header_label', array(
            'default' => 'none',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        )
    );
    $args = array(
        'description' => __('','benjamin'),
        'label' => __('Header Settings', 'benjamin'),
        'type' => 'label',
        'section' => $name . '_settings_section',
        'settings' => $name . '_header_label',
    );
    if($name != 'archive')
        $args['active_callback'] = $active_callback;

    $wp_customize->add_control(
        new Benjamin_Label_Custom_Control(
            $wp_customize,
            $name . '_header_label_control',
            $args
        )
    );


    /**
     * Hero Image
     */
    $wp_customize->add_setting( $name . '_image_setting', array(
        'default'      => null,
        'sanitize_callback' => 'benjamin_hero_image_sanitization',
    ) );

    $hero_image_args = array(
        'description' => __('Change the header image, for best results use an image that is at least 1080px wide by 720px tall.', 'benjamin'),
        'label'   => __('Header Image', 'benjamin'),
        'section' => $name . '_settings_section',
        'settings'   => $name . '_image_setting',
    );

    if( $name !== 'archive')
        $hero_image_args['active_callback'] = $active_callback;

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            $name . '_image_setting_control',
            $hero_image_args
        )
    );


    /**
     * Hero video
     * @var array
     */
    $wp_customize->add_setting( $name . '_video_setting', array(
        'default'      => null,
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $description = __('Use an uploaded video, or a video from youtube to display
    in the header. Uploaded videos should be 8M and should be a .mp4, .mov, or .webm format.', 'benjamin');

    $hero_video_args = array(
        'description' => $description,
        'label'   => __('Header Video', 'benjamin'),
        'section' => $name . '_settings_section',
        'settings'   => $name . '_video_setting',
    );
    if( $name !== 'archive')
        $hero_video_args['active_callback'] = $active_callback;

    $wp_customize->add_control(
        new Benjamin_Video_Control(
            $wp_customize,
            $name . '_video_setting_control',
            $hero_video_args
        )
    );



    /**
     * Hero Size
     */
    $wp_customize->add_setting( $name . '_hero_position_setting', array(
        'default' => 'top',
        'sanitize_callback' => 'benjamin_hero_position_sanitize',
    ) );

    $choices = array(
        'top' => 'Top',
        'center' => 'Center',
        'bottom' => 'Bottom',
    );

    $hero_position_args = array(
        'description' => __('Because the header image size can be changed, this option will give you some more control with how the image is displayed.','benjamin'),
        'label' => __('Header Image Position', 'benjamin'),
        'section' => $name . '_settings_section',
        'settings' => $name . '_hero_position_setting',
        'type' => 'select',
        'choices' => $choices,
    );

    if( $name !== 'archive')
        $hero_position_args['active_callback'] = $active_callback;

    $wp_customize->add_control( $name . '_hero_position_control', $hero_position_args );


    /**
     * Hero Size
     */
    $wp_customize->add_setting( $name . '_hero_size_setting', array(
        'default' => 'slim',
        'sanitize_callback' => 'benjamin_hero_size_sanitize',
    ) );

    $hero_size_args = array(
        'description' => __('Changes the height of the hero banner', 'benjamin'),
        'label' => __('Header Size', 'benjamin'),
        'section' => $name . '_settings_section',
        'settings' => $name . '_hero_size_setting',
        'type' => 'select',
        'choices' => array(
            'slim' => 'Slim',
            'medium' => 'Medium',
            'big' => 'Big',
            'full' => 'Full Screen'
        ),
    );

    if( $name !== 'archive')
        $hero_size_args['active_callback'] = $active_callback;

    $wp_customize->add_control( $name . '_hero_size_control', $hero_size_args );


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
        'description' => __('','benjamin'),
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
            'description' => __('','benjamin'),
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

}




/**
 * ----------------------------------------------------------------------------
 * Sanitization settings
 * ----------------------------------------------------------------------------
 */


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


function benjamin_hero_position_sanitize($val) {
    $valids = array(
        'top',
        'center',
        'bottom'
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




function benjamin_sanitize_external_header_video( $value ) {
    return esc_url_raw( trim( $value ) );
}

function benjamin_validate_external_header_video( $validity, $value ) {
    $video = esc_url_raw( $value );
    if ( $video ) {
        if ( ! preg_match( '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $video ) ) {
            $validity->add( 'invalid_url', __( 'Please enter a valid YouTube URL.', 'benjamin' ) );
        }
    }
    return $validity;
}


function benjamin_validate_header_video( $validity, $value ) {
    $video = get_attached_file( absint( $value ) );
    if ( $video ) {
        $size = filesize( $video );
        if ( 8 < $size / pow( 1024, 2 ) ) { // Check whether the size is larger than 8MB.
            $validity->add( 'size_too_large',
                __( 'This video file is too large to use as a header video. Try a shorter video or optimize the compression settings and re-upload a file that is less than 8MB. Or, upload your video to YouTube and link it with the option below.', 'benjamin' )
            );
        }
        if ( '.mp4' !== substr( $video, -4 ) && '.mov' !== substr( $video, -4 ) ) { // Check for .mp4 or .mov format, which (assuming h.264 encoding) are the only cross-browser-supported formats.
            $validity->add( 'invalid_file_type', sprintf(
                /* translators: 1: .mp4, 2: .mov */
                __( 'Only %1$s or %2$s files may be used for header video. Please convert your video file and try again, or, upload your video to YouTube and link it with the option below.', 'benjamin' ),
                '<code>.mp4</code>',
                '<code>.mov</code>'
            ) );
        }
    }
    return $validity;
}



function benjamin_sanitize_color( $color ) {
    if ( 'blank' === $color )
        return 'blank';

    $color = sanitize_hex_color_no_hash( $color );
    if ( empty( $color ) )
        $color = '#02bfe7'; //#112e51

    return $color;
}
