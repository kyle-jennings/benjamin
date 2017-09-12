<?php


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
