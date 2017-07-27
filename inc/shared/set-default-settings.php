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



function benjamin_set_default_menu($args) {


    // see wp-includes/nav-menu-template.php for available arguments
    extract( $args );

    $link_arr = array(
        home_url() => 'Home',
        wp_login_url() => 'Login'
    );

    if( is_user_logged_in() ) {

        $link_arr = array(
            home_url() => 'Home',
            admin_url() => 'Admin',
            admin_url( 'nav-menus.php' ) => 'Add a Menu',
            admin_url( 'customize.php' ) => 'Customize your Site',
            wp_logout_url( home_url() ) => 'Logout'
        );

    }

    $links = array();
    foreach($link_arr as $url => $label)
        $links[] = $link_before . '<a href="' . $url . '">' . $before . $label . $after . '</a>' . $link_after;

    // We have a list
    if ( FALSE !== stripos( $items_wrap, '<ul' )
        || FALSE !== stripos( $items_wrap, '<ol' )
    ){
        foreach($links as &$link)
            $link = "<li>$link</li>";
    }

    $output = sprintf( $items_wrap, $menu_id, $menu_class, implode('', $links) );
    if ( ! empty ( $container ) ) {
        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
    }

    if ( $echo ) {
        echo $output; // WPCS: xss ok;
    }

    return $output;

}



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
