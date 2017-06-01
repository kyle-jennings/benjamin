<?php

$uswds_widgets = array(
    'WP_Nav_Menu_Widget' => 'USWDS_Nav_Menu_Widget',
    'WP_Widget_Archives' => 'USWDS_Widget_Archives',
    'WP_Widget_Categories' => 'USWDS_Widget_Categories',
    'WP_Widget_Recent_Comments' => 'USWDS_Widget_Recent_Comments',
    'WP_Widget_Recent_Posts' => 'USWDS_Widget_Recent_Posts',
    'WP_Widget_Meta' => 'USWDS_Widget_Meta',
    'WP_Widget_Pages' => 'USWDS_Widget_Pages',
);

// include the widget files
foreach($uswds_widgets as $old=>$new)
    require get_template_directory() . '/inc/widgets/'.$new.'.php';


// Replaces some default widgets with ours.
// These widgets function exactly the same but have some additional options which
// simple change out the data is displayed, mostly by styling the lists / menus
function uswds_register_widgets() {
    global $uswds_widgets;

    unregister_widget( 'WP_Widget_Links' );

    foreach($uswds_widgets as $old=>$new){
        unregister_widget( $old );
        register_widget( $new );
    }
}
add_action( 'widgets_init', 'uswds_register_widgets' );
