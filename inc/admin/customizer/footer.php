<?php


/**
 * The footer settings
 *
 * Settings include, the footer "size" (how many footer sections), and the
 * content type (widgets or menu), and if menu is selected then the menu.
 *
 * The content and menu options will probably be removed in the future in lieu
 * of creating a new footer nav widget
 * @param  object $wp_customize
 */

function benjamin_footer_settings($wp_customize) {
    $choices = array(
            'return-to-top' => 'Return to Top',
            'footer-menu' => 'Footer Menu',
            'widget-area-1' => 'Widget Area 1',
            'widget-area-2' => 'Widget Area 2'
    );

    $wp_customize->add_section( 'footer_settings_section', array(
        'title'          => 'Footer Settings',
        'priority'       => 38,
    ) );

    $wp_customize->add_setting( 'footer_sortables_setting', array(
        'default'        => '',
        'sanitize_callback' => 'benjamin_footer_sortable_sanitize',
    ) );

    $wp_customize->add_control( new Benjamin_Activated_Sortable_Custom_Control( $wp_customize,
       'footer_sortables_control', array(
           'label'   => 'Sortable Sections',
           'section' => 'footer_settings_section',
           'settings'=> 'footer_sortables_setting',
           'priority' => 1,
           'choices' => $choices
           )
       )
   );


}
add_action('customize_register', 'benjamin_footer_settings');




function benjamin_footer_sortable_sanitize($val) {

    $valids = array(
            'return-to-top',
            'footer-menu',
            'widget-area-1',
            'widget-area-2',
    );

    $valid = true;
    $tmp_val = json_decode($val);
    foreach($tmp_val as $v){
        if( !in_array($v->name, $valids) ){
            // error_log($v->name)
            $valid = false;
        }
    }

    if(!$valid)
        return null;

    return $val;
}
