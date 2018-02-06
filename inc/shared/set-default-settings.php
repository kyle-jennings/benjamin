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



/**
 * Sets default menu items when no menu is set
 * @param  [type] $args [description]
 * @return [type]       [description]
 */
function benjamin_set_default_menu( $args = array() ) {

    // see wp-includes/nav-menu-template.php for available arguments
    extract( $args );



    $link_arr = array(
        home_url() => __('Home', 'benjamin'),
        wp_login_url() => __('Login', 'benjamin')
    );

    if( is_user_logged_in() ) {

        $link_arr = array(
            home_url() => __('Home', 'benjamin'),
            admin_url() => __('Admin', 'benjamin'),
            admin_url( 'nav-menus.php' ) => __('Add a Menu', 'benjamin'),
            admin_url( 'customize.php' ) => __('Customize your Site', 'benjamin'),
            wp_logout_url( home_url() ) => __('Logout', 'benjamin')
        );

    }

    $links = array();
    
    $link_before = isset($link_before) ? $link_before : '';
    $link_after = isset($link_after) ? $link_after : '';
    $before = isset($before) ? $before : '';
    $after = isset($after) ? $after : '';
    $items_wrap = isset($items_wrap) ? $items_wrap : '';
    $menu_id = isset($menu_id) ? $menu_id : '';
    $menu_class = isset($menu_class) ? $menu_class : '';
    $echo = isset($echo) ? $echo : false;


    $li_class = $theme_location == 'footer' ? 'usa-width-one-sixth usa-footer-primary-content' : '';
    $link_class = $theme_location == 'footer' ? 'usa-footer-primary-link' : '';

    // loop through the list of links, add some escaped markup, the before and afters, as well as the lable
    foreach($link_arr as $url => $label)
        $links[] = $link_before . '<a class="'.esc_attr($link_class).'" href="' . esc_attr($url) . '">' . $before . $label . $after . '</a>' . $link_after;

    // We have a list
    if ( FALSE !== stripos( $items_wrap, '<ul' )
        || FALSE !== stripos( $items_wrap, '<ol' )
    ){
        foreach($links as &$link)
            $link = '<li class="'.esc_attr($li_class).'">'.$link.'</li>';
    }

    $output = sprintf( $items_wrap, $menu_id, $menu_class, implode('', $links) );
    if ( ! empty ( $container ) ) {
        $output  = '<'.$container.' class="'.esc_attr($container_class).'" id="'.esc_attr($container_id).'">'.$output.'</'.$container.'>';
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
