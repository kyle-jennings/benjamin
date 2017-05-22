<?php


/**
 * Site Identity - these settings control some site branding
 * @param  [type] $wp_customize [description]
 * @return [type]               [description]
 */
function uswds_site_identity($wp_customize) {

    $classic = array('#0c555d', '#399099', '#ff5049', '#ffffff', '#f5f5f5', '#000000');
    $standard = array('#112e51', '#02bfe7','#e31c3d', '#ffffff', '#f1f1f1', '#d6d7d9');
    $red = array('#912b27', '#ba1b16','#02bfe7', '#ffffff', '#f1f1f1', '#d6d7d9');

    // color scheme
    $wp_customize->add_setting( 'color_scheme_setting', array(
        'default' => 'standard',
        'sanitize_callback' => 'identity_setting_sanitization',
        )
    );

    $wp_customize->add_control( new Color_Scheme_Custom_Control(
        $wp_customize, 'color_scheme_control', array(
            'label'   => 'Color Scheme',
            'section' => 'title_tagline',
            'settings' => 'color_scheme_setting',
            'type' => 'radio',
            'choices' => array(
                        'standard' => $standard,
                        'classic' => $classic,
                        'red' => $red,
                    )
            )
        )
    );


    $wp_customize->add_setting( 'sidebar_size_setting', array(
        'default' => 'ONE_THIRD',
        'sanitize_callback' => 'identity_setting_sanitization',
        )
    );

    $wp_customize->add_control( 'sidebar_size_control', array(
            'label'   => 'Sizebar Size',
            'section' => 'title_tagline',
            'settings' => 'sidebar_size_setting',
            'type' => 'select',
            'choices' => array(
                        'ONE_THIRD' => 'Wide',
                        'ONE_FOURTH' => 'Narrow',
                    ),
        )
    );

}
add_action('customize_register', 'uswds_site_identity');

function identity_setting_sanitization($val) {
    return $val;
}
