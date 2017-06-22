<?php

/**
 * Get all the settings needed for the template layout
 * @return array keyed array with the settings
 */
function benjamin_template_settings() {
    $template = benjamin_template();
    $sidebar_position = get_theme_mod($template . '_sidebar_position_setting');

    $main_width = benjamin_get_main_width($sidebar_position);
    $main_width .= ' ' . benjamin_get_width_visibility($template, $sidebar_position);

    $hide_content = benjamin_hide_layout_part('page-content', $template);

    return array(
        'template' => $template,
        'main_width' => $main_width,
        'hide_content' => $hide_content,
        'sidebar_position' => $sidebar_position,
    );
}


/**
 * Get the "current" page template
 *
 * I saw "current" because unless the current page's template settings are
 * activated, then we will fall back onto the "feed" settings
 * @return str the template name
 */
function benjamin_template() {
    return benjamin_get_template();
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
    elseif( is_single() && $cpt = benjamin_which_cpt() ) :
        return $cpt;
    elseif ( is_single() && $single = benjamin_is_single() ) :
        return $single;
    elseif ( is_page() && $page = benjamin_is_page()) :
        return $page;
    elseif (is_404() && benjamin_settings_active('_404') ) :
        return '_404';
    elseif( is_post_type_archive( benjamin_get_cpts()) && $cpt = benjamin_which_cpt('feed') ) :
        return $cpt;
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
function benjamin_is_feed(){

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


function benjamin_which_cpt($feed = null) {
    $cpts = benjamin_get_cpts();
    $name = get_queried_object()->name;

    if(!$feed)
        $name = get_queried_object()->post_type;

    if($feed == 'feed')
        $feed = '-feed';

    if(in_array( $name, $cpts))
        return $name . $feed;

    return false;
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
