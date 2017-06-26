<?php


/**
 * Hides a part of the template layout
 * @param  str $needle   page part (navbar, footer, ect)
 * @param  str  $template the "current" templat
 * @return boolean
 */
function benjamin_hide_layout_part( $needle, $template ) {

    $layout_settings = get_theme_mod($template.'_page_layout_setting');
    $layout_settings = json_decode($layout_settings);
    $layout_settings = $layout_settings ? $layout_settings : array();
    $result = in_array($needle, $layout_settings);

    return $result;
}


/**
 * Get the header parts
 *
 * - banner" (only available if the domain is a .gov or .mil)
 * - navbar
 * - hero banner
 *
 * @return markup the echo mark up
 */
function benjamin_the_header() {
    $template = benjamin_template();

    $layout_settings = get_theme_mod($template.'_page_layout_setting', '[]');
    $layout_settings = json_decode($layout_settings);

    $order = json_decode(get_theme_mod('header_order_setting'));
    $order = $order ? $order : benjamin_default_header_order();

    foreach($order as $component):
        if($layout_settings && in_array($component->name, $layout_settings))
            continue;
        switch($component->name):
            case 'banner':
                get_template_part('template-parts/section', 'banner');
                break;
            case 'navbar':
                get_template_part('template-parts/navbars/navbar');
                break;
            case 'hero':
                echo new BenjaminHero($template);
                break;
        endswitch;
    endforeach;
}



/**
 * gets the 404 settings
 * @return array keyed array with settings
 */
function benjamin_get_404_settings() {

    $content = get_theme_mod('_404_page_content_setting', 'default');
    $pid = get_theme_mod('_404_page_select_setting', null);
    $header_page = get_theme_mod('_404_header_page_content_setting');

    return array(
        'content' => $content,
        'pid' => $pid,
        'header_page' => $header_page,
    );
}
