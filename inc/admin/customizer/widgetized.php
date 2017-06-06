<?php



function benjamin_widgetized_settings($wp_customize) {

    $wp_customize->add_setting( 'widgetized_sortables_setting', array(
        'default'        => '',
        'sanitize_callback' => 'benjamin_widgetized_sortable_sanitize',
    ) );

    $wp_customize->add_control( new Benjamin_Activated_Sortable_Custom_Control( $wp_customize,
       'widgetized_sortables_control', array(
           'label'   => 'Sortable Sections',
           'section' => 'widgetized_settings_section',
           'settings'=> 'widgetized_sortables_setting',
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
add_action('customize_register', 'benjamin_widgetized_settings');


function benjamin_widgetized_sortable_sanitize($val) {
    $valids = array(
        'widget-area-1',
        'widget-area-2',
        'widget-area-3',
        'page-content',
    );

    $valid = true;
    $tmp_val = json_decode($val);
    foreach($tmp_val as $v){
        if( !in_array($v->name, $valids) )
            $valid = false;
    }

    if(!$valid)
        return null;

    return $val;
}
