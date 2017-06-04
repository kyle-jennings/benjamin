<?php

// function uswds_404_settings($wp_customize) {
//
//     $wp_customize->add_setting( '404_page_layout_setting', array(
//         'default'        => '',
//         'sanitize_callback' => 'uswds_404_layout_sanitize',
//     ) );
//
//     $wp_customize->add_control( new USWDS_Checkbox_Group_Control( $wp_customize,
//         '404_page_layout_control', array(
//             'label'   => 'Page Layout',
//             'section' => '404_settings_section',
//             'settings'=> '404_page_layout_setting',
//             'priority' => 1,
//             'choices' => array(
//                     'banner' => 'Hide Banner',
//                     'navbar' => 'Hide Navbar',
//                     'page-content' => 'Hide Page Content and Sidebar',
//                     'footer' => 'Hide Footer'
//                 )
//             )
//         )
//     );
// }

// add_action('customize_register', 'uswds_404_settings');




function uswds_404_layout_sanitize($val) {
    return $val;
}
