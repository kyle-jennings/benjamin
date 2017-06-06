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
function benjamin_set_defaults() {
    if(!get_theme_mod('archive_sidebar_position_setting'))
        set_theme_mod('archive_sidebar_position_setting', 'right');

    if(!get_theme_mod('archive_hero_size_setting'))
        set_theme_mod('archive_hero_size_setting', 'slim');

    if(!get_theme_mod('header_order_setting'))
        set_theme_mod('header_order_setting', 'banner-navbar-hero');

    if(!get_theme_mod('footer_size_setting'))
        set_theme_mod('footer_size_setting', 'slim');
}
add_action('after_switch_theme', 'benjamin_set_defaults');
