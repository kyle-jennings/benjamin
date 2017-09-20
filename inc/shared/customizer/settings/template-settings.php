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

    require('template-settings/header.php');
    require('template-settings/sidebar.php');
    require('template-settings/layout.php');



}
