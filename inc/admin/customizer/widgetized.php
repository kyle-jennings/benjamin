<?php



function uswds_widgetized_settings($wp_customize) {

    $wp_customize->add_setting( 'widgetized_section_setting', array(
        'default'        => '',
        'sanitize_callback' => 'widgetized_setting_sanitization',
    ) );

    $wp_customize->add_control( new Activated_Sortable_Custom_Control( $wp_customize,
       'widgetized_section_control', array(
           'label'   => 'Sortable Sections',
           'section' => 'widgetized_section',
           'settings'=> 'widgetized_section_setting',
           'priority' => 1,
           'choices' => array(
                   'widget-area-1' => 'Widget Area 1',
                   'widget-area-2' => 'Widget Area 2',
                   'widget-area-3' => 'Widget Area 3',
                   'page-content' => 'Page Content'
               )
           )
       )
   );

}
add_action('customize_register', 'uswds_widgetized_settings');

function widgetized_setting_sanitization($val) {
    return $val;
}
