<?php

/**
 * Our Modified widgets, these replace the default widgets with near identical ones.
 *
 * The only real differences are that these widgets have additonal options.
 * @package Benjamin
 */


$benjamin_widgets = array(
    'WP_Nav_Menu_Widget' => 'Benjamin_Nav_Menu_Widget',
    'WP_Widget_Archives' => 'Benjamin_Widget_Archives',
    'WP_Widget_Categories' => 'Benjamin_Widget_Categories',
    'WP_Widget_Meta' => 'Benjamin_Widget_Meta',
    'WP_Widget_Pages' => 'Benjamin_Widget_Pages',
    'WP_Widget_Recent_Comments' => 'Benjamin_Widget_Recent_Comments',
    'WP_Widget_Recent_Posts' => 'Benjamin_Widget_Recent_Posts',
);

// include the widget files
foreach($benjamin_widgets as $old=>$new)
    require get_template_directory() . '/inc/widgets/'.$new.'.php';


// Replaces some default widgets with ours.
// These widgets function exactly the same but have some additional options which
// simple change out the data is displayed, mostly by styling the lists / menus
function benjamin_register_widgets() {
    global $benjamin_widgets;

    foreach($benjamin_widgets as $old=>$new){
        unregister_widget( $old );
        register_widget( $new );
    }
}
add_action( 'widgets_init', 'benjamin_register_widgets' );
