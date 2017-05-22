<?php

function uswds_create_default_nav() {
    $menu_name = 'default-menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    // If it doesn't exist, let's create it.
    if( $menu_exists )
        return false;

    $menu_id = wp_create_nav_menu($menu_name);

    // Set up default menu items
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Home', 'uswds'),
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url( '/' ),
        'menu-item-status' => 'publish')
    );

    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Login', 'uswds'),
        'menu-item-url' => wp_login_url(),
        'menu-item-status' => 'publish')
    );


}
uswds_create_default_nav();


function uswds_footer_nav() {
    $args = array(
        'container' => 'nav',
        'container_class' => 'usa-footer-nav',
        'depth'=> 0,
        'menu_class' => 'usa-unstyled-list',
        'walker' => new FooterNavbarWalker()
    );
    if( has_nav_menu('footer-top') )
        $args['theme_location'] = 'footer-top';
    else
        $args['menu'] = 'default-menu';

    wp_nav_menu( $args );
}
