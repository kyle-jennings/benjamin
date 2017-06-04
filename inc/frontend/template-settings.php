<?php

function uswds_template_settings($ret = null) {

    $settings = uswds_set_template_settings();

    // if an arg was passed in, return that single setting
    if($ret)
        return $settings[$ret];
    else
        return $settings;
}


function uswds_set_template_settings(){

    $template = uswds_get_template();
    $date_type = is_date() ? uswds_is_date() : null;

    $array = array(
        'template' => $template,
        'date_type' => $archive_type,
    );

    return $array;
}




function uswds_get_template() {

    //	if the page is a post type
    if( is_front_page() && uswds_settings_active('frontpage') ) :
        return 'frontpage';
    elseif ( is_single() && $single = uswds_is_single() ):
        return $single;
    elseif ( is_page() && $page = uswds_is_page()) :
        return $page;
    elseif (is_404() && uswds_settings_active('404') ) :
        return '404';
    else :
        return uswds_is_feed();
    endif;
}


function uswds_is_single(){

    if (is_embed() && uswds_settings_active('embed') ) :
        return 'embed';
    elseif (is_attachment() && uswds_settings_active('attachment') ) :
        return 'attachment';
    elseif (is_single() && uswds_settings_active('single') ) :
        return 'single';
    else:
        return false;
    endif;
}



function uswds_is_feed( ){
    if( is_search() && uswds_settings_active('search'))
        return 'search';
    elseif( is_home() && uswds_settings_active('home') ){
        return 'home';
    }elseif( is_tax() && uswds_settings_active('taxonomy') ){
        return 'taxonomy';
    }elseif( is_category() && uswds_settings_active('cetegory') ){
        return 'category';
    }elseif( is_tag() && uswds_settings_active('tag') ){
        return 'tag';
    }elseif( is_author() && uswds_settings_active('author') ){
        return 'author';
    }elseif( is_date() && uswds_settings_active('date') ){
        return 'date';
    }else{
        return 'archive';
    }
}


function uswds_is_date(){
    if(is_day())
        return 'day';
    elseif( is_month())
        return 'month';
    else
        return 'year';
}

function uswds_is_page(){
    if ( is_page_template() && $p_template = uswds_is_page_template() ):
        return $p_template;
    elseif (is_page() && uswds_settings_active('page') ):
        return 'page';
    else :
        return false;
    endif;
}


function uswds_is_page_template(){

    if ( is_page_template('page-templates/widgetized.php') && uswds_settings_active('widgetized') )
        return 'widgetized';
    if ( is_page_template('page-templates/template-1.php') && uswds_settings_active('template-1') )
        return 'template-1';
    if ( is_page_template('page-templates/template-2.php') && uswds_settings_active('template-2') )
        return 'template-2';
    if ( is_page_template('page-templates/template-3.php') && uswds_settings_active('template-3') )
        return 'template-3';
    if ( is_page_template('page-templates/template-4.php') && uswds_settings_active('template-4') )
        return 'template-4';
    else
        return false;
}


function uswds_settings_active($template = null){
    $mods = get_theme_mods();
    $active = $mods[$template . '_settings_active'];
    return ($active == 'yes') ? true : false;
}


function uswds_hide_layout_part( $needle, $template ) {

    $layout_settings = get_theme_mod($template.'_page_layout_setting');
    $layout_settings = json_decode($layout_settings);
    $layout_settings = $layout_settings ? $layout_settings : array();
    $result = in_array($needle, $layout_settings);

    return $result;
}


function uswds_get_main_width($sidebar_position) {
    $width = ($sidebar_position == 'none' || !$sidebar_position)
            ? USWDS_FULL_WIDTH : USWDS_MAIN_WIDTH;

    return $width;
}
