<?php

/**
 * Sets some default values when the theme is first loaded
 *
 * Sets the following values (if not previously set) when the theme is activated:
 *
 * The archive page sidebar position
 * The archive page hero sanitize_bookmark
 * The archive header order
 */
function benjamin_set_default_settings() {
    if(!get_theme_mod('archive_sidebar_position_setting'))
        set_theme_mod('archive_sidebar_position_setting', 'right');

    if(!get_theme_mod('archive_hero_size_setting'))
        set_theme_mod('archive_hero_size_setting', 'slim');

    if(!get_theme_mod('header_sortables_setting'))
        set_theme_mod('header_sortables_setting', '[{"name":"banner","label":"Banner"},{"name":"navbar","label":"Navbar"},{"name":"hero","label":"Hero"}]');

    if(!get_theme_mod('footer_sortables_setting'))
        set_theme_mod('footer_sortables_setting', '[{"name":"return-to-top","label":"Return to Top"},{"name":"footer-menu","label":"Footer Menu"}]');

}
add_action('after_switch_theme', 'benjamin_set_default_settings');



function benjamin_set_default_menu() {

    $menu_name = 'default-menu';
    $menu = wp_get_nav_menu_object($menu_name);


    if( $menu )
        return $menu->term_id;

    $id = wp_create_nav_menu($menu_name);

    // Set up default menu items
    wp_update_nav_menu_item($id, 0, array(
        'menu-item-title' =>  __('Home', 'benjamin'),
        'menu-item-classes' => 'home',
        'menu-item-url' => esc_url( home_url( '/' ) ),
        'menu-item-status' => 'publish')
    );

    wp_update_nav_menu_item($id, 0, array(
        'menu-item-title' =>  __('Login', 'benjamin'),
        'menu-item-url' => admin_url(),
        'menu-item-status' => 'publish')
    );

}
add_action('after_switch_theme', 'benjamin_set_default_menu');


function benjamin_default_header_order() {
    $arr = array(

        (object) array (
            'name' => 'navbar',
            'label' => 'Navbar'
        ),
        (object) array (
            'name' => 'hero',
            'label' => 'Hero'
        ),
    );

    $banner = (object) array(
        'name' => 'banner',
        'label' => 'Banner'
    );

    if(benjamin_is_dot_gov())
        array_unshift($arr, $banner);

    return $arr;
}
