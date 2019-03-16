<?php



function benjamin_widgetized_settings($wp_customize) {

    $section = 'widgetized_content_section';
    $template = benjamin_get_template_info('widgetized');

    $section_args = array(
        'section' => $section,
        'title' => __('Widgetized Page', 'benjamin'),
        'description' => $template['description'],
    );


    benjamin_customize_section( $wp_customize, $section_args );


    $wp_customize->add_setting( 'widgetized_sortables_setting', array(
        'default'        => '[{"name":"page-content","label":"Page Content"}]',
        'sanitize_callback' => 'benjamin_widgetized_sortable_sanitize',
    ) );

    $description = __('The page content is sortable, and optional.  Simply drag the 
        available components from the "available" box over to "active".  Once a widget 
        area has been dragged to "active" you\'ll need to add some ', 'benjamin');
    $description .= '<a href="' . esc_attr("javascript:wp.customize.control( 'navbar_brand_control' ).focus();") . 
        '" data-panel="widgets">';
    $description .= __('widgets', 'benjamin') . '</a>';

    $wp_customize->add_control( new Benjamin_Sortable_Control( $wp_customize,
       'widgetized_sortables_control', array(
           'label'   => __('Sortable Page Content', 'benjamin'),
           /* translators: use the $description variable above - states that the content is sortable via drag and drop */
           'description' => sprintf( __('%s ', 'benjamin'), $description ),
           'section' => $section,
           'settings' => 'widgetized_sortables_setting',
           'optional' => true,
           'choices' => array(
                   'widget-area-1' => __('Widget Area 1', 'benjamin'),
                   'widget-area-2' => __('Widget Area 2', 'benjamin'),
                   'widget-area-3' => __('Widget Area 3', 'benjamin'),
                   'page-content' => __('Page Content', 'benjamin'),
               )
           )
       )
    );

}
add_action('customize_register', 'benjamin_widgetized_settings');
