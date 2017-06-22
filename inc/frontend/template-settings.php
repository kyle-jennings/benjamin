<?php

/**
 * Get the template, or its settings
 * @param  [type] $ret [description]
 * @return [type]      [description]
 */
function benjamin_template_settings($ret = null) {

    $settings = benjamin_set_template_settings();

    // if an arg was passed in, return that single setting
    if($ret)
        return $settings[$ret];
    else
        return $settings;
}


/**
 * [benjamin_set_template_settings description]
 */
function benjamin_set_template_settings(){

    $template = benjamin_get_template();
    $date_type = is_date() ? benjamin_is_date() : null;

    $array = array(
        'template' => $template,
        'date_type' => $archive_type,
    );

    return $array;
}


/**
 * Gets the template type, there are 5 main types. Frontpage, a single post,
 * a single page, the 404 page, or a feed
 *
 * @return str template name
 */
function benjamin_get_template() {

    //	if the page is a post type
    if( is_front_page() && benjamin_settings_active('frontpage') ) :
        return 'frontpage';
    elseif ( is_single() && $single = benjamin_is_single() ):
        return $single;
    elseif ( is_page() && $page = benjamin_is_page()) :
        return $page;
    elseif (is_404() && benjamin_settings_active('_404') ) :
        return '_404';
    else :
        return benjamin_is_feed();
    endif;
}


/**
 * If the template is a single post type...
 * @return str|boolean the template name or false
 */
function benjamin_is_single(){

    if (is_embed() && benjamin_settings_active('embed') ) :
        return 'embed';
    elseif (is_attachment() && benjamin_settings_active('attachment') ) :
        return 'attachment';
    elseif (is_single() && benjamin_settings_active('single') ) :
        return 'single';
    else:
        return false;
    endif;
}


/**
 * If the tempalte is a "feed" type, determine the type
 * @return string tempalte name
 */
function benjamin_is_feed( ){
    if( is_search() && benjamin_settings_active('search'))
        return 'search';
    elseif( is_home() && benjamin_settings_active('home') ){
        return 'home';
    }elseif( is_tax() && benjamin_settings_active('taxonomy') ){
        return 'taxonomy';
    }elseif( is_category() && benjamin_settings_active('cetegory') ){
        return 'category';
    }elseif( is_tag() && benjamin_settings_active('tag') ){
        return 'tag';
    }elseif( is_author() && benjamin_settings_active('author') ){
        return 'author';
    }elseif( is_date() && benjamin_settings_active('date') ){
        return 'date';
    }else{
        return 'archive';
    }
}


/**
 * If the archive type is a "date", determine the date type
 * @return str|boolean the template name or false
 */
function benjamin_is_date(){
    if(is_day())
        return 'day';
    elseif( is_month())
        return 'month';
    else
        return 'year';
}



/**
 * If the template is a single page, determine whether or not its a custom template
 * @return str|boolean the template name or false
 */
function benjamin_is_page(){
    if ( is_page_template() && $p_template = benjamin_is_page_template() ):
        return $p_template;
    elseif (is_page() && benjamin_settings_active('page') ):
        return 'page';
    else :
        return false;
    endif;
}


/**
 * If we are on a page template, lets ensure it's a valid one
 * @return str|boolean the template name or false
 */
function benjamin_is_page_template(){

    if ( is_page_template('page-templates/widgetized.php') && benjamin_settings_active('widgetized') )
        return 'widgetized';
    if ( is_page_template('page-templates/template-1.php') && benjamin_settings_active('template-1') )
        return 'template-1';
    if ( is_page_template('page-templates/template-2.php') && benjamin_settings_active('template-2') )
        return 'template-2';
    if ( is_page_template('page-templates/template-3.php') && benjamin_settings_active('template-3') )
        return 'template-3';
    if ( is_page_template('page-templates/template-4.php') && benjamin_settings_active('template-4') )
        return 'template-4';
    else
        return false;
}


/**
 * Have the settings been activated?
 * @param  [type] $template [description]
 * @return [type]           [description]
 */
function benjamin_settings_active($template = null){
    $mods = get_theme_mods();
    $active = $mods[$template . '_settings_active'];
    return ($active == 'yes') ? true : false;
}


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
