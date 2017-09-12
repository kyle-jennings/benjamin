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


    // create the panel for the other templates
    $wp_customize->add_panel(
        'extra_template_settings',
        array(
            'title' => 'More Templates Settings',
            'priority' => 37,
        )
    );

    $templates = benjamin_the_template_list();

    // for each template in the template list, we set up their customizer sections
    foreach($templates as $name => $args):

        // the section's args, add the panel arg if the template is NOT the archive
        $section_args = array(
            /* translators: Displays the dynamically set label */
            'title' => sprintf( __('%s Settings', 'benjamin'), ucfirst($args['label']) ),
            'priority' => 36,
            'description' => $args['description']
        );
        if( $name !== 'archive')
            $section_args['panel'] = 'extra_template_settings';


        // Add the section for the templates settings
        $wp_customize->add_section(
            $name . '_settings_section',
            $section_args
        );

        // now do the settings
        benjamin_template_settings_loop($wp_customize, $name);
    endforeach;

}
add_action('customize_register', 'benjamin_template_layout_settings');


function benjamin_template_settings_loop(&$wp_customize, $name){


    // activate the template settings
    if( $name !== 'archive'):

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


    require('template-settings/header.php');
    require('template-settings/sidebar.php');
    require('template-settings/layout.php');



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
