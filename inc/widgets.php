<?php

require get_template_directory() . '/inc/widgets/USWDSNavMenu.php';

function uswds_register_widgets() {
    unregister_widget( 'WP_Nav_Menu_Widget' );
    register_widget( 'USWDSNavMenu' );
}
add_action( 'widgets_init', 'uswds_register_widgets' );
