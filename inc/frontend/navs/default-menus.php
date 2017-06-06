<?php

function benjamin_create_default_nav() {
    $menu_name = 'default-menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    // If it doesn't exist, let's create it.
    if( $menu_exists )
        return false;

    $menu_id = wp_create_nav_menu($menu_name);

    // Set up default menu items
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Home', 'benjamin'),
        'menu-item-classes' => 'home',
        'menu-item-url' => esc_url( home_url( '/' ) ),
        'menu-item-status' => 'publish')
    );

    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' =>  __('Login', 'benjamin'),
        'menu-item-url' => admin_url(),
        'menu-item-status' => 'publish')
    );


}
benjamin_create_default_nav();
