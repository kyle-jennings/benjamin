<?php

/**
 * The file contains the functions which gather all available templates.
 *
 * This tempalte list is used to populate the customizer settings and widgets ares
 *
 * @package Benjamin
 */

function benjamin_the_template_list($use_widget_areas = false) {


    // not used yet
    // $advanced_templates = array(
    //     'search' => 'Search Results',
    //     'date' => 'Filtered by Date',
    //     'category' => 'Filtered by Category',
    //     'tag' => 'Filtered by Tag',
    // );
    $desc_warning = 'These widgets and settings are only used if activated
    in the customizer';

    $templates = array(
        'archive' => array(
            'label' => 'Feed (default)',
            'description' => __('This is your default page, and the page where your
            blog post feed is located.  If other template\'s settings
            have not been activated then this is whats used.', 'benjamin')
        ),

        'frontpage' => array(
            'label' => 'Front Page',
            'description' => __('The frontpage is the located at '.site_url().' '. $desc_warning, 'benjamin')
        ),

        'single' => array(
            'label' => 'Single Post',
            'description' => __('The "single post" is what you see when viewing
            a single blog post, or single custom post type.'.' '. $desc_warning, 'benjamin')
        ),

        'page' => array(
            'label' => 'Single Page',
            'description' => __('The "single page" is what you see when viewing
            a page.'.' '. $desc_warning, 'benjamin')
        ),

        'widgetized' => array(
            'label' => 'Widgetized Page',
            'description' =>  __('This is a special page template, the
            Widgetized page is sortable and contains 3 horizontal widget areas
            along with the sidebar.'.' '. $desc_warning, 'benjamin')
        ),
        'template-1' => array(
            'label' => 'Page Template 1',
            'description' => __('This is just an extra page template, use this
            if you want to style an individul page differently then your
            standard pages.'.' '. $desc_warning, 'benjamin')
        ),
        'template-2' => array(
            'label' => 'Page Template 2',
            'description' => __('This is just an extra page template, use this
            if you want to style an individul page differently then your
            standard pages.'.' '. $desc_warning, 'benjamin')
        ),
        'template-3' => array(
            'label' => 'Page Template 3',
            'description' => __('This is just an extra page template,
            use this if you want to style an individul page differently then
            your standard pages.'.' '. $desc_warning, 'benjamin')
        ),
        'template-4' => array(
            'label' => 'Page Template 4',
            'description' => __('This is just an extra page template, use this
            if you want to style an individul page differently then your
            standard pages.'.' '. $desc_warning, 'benjamin')
        ),
        '_404' => array(
            'label' => '404 Page',
            'description' => __('This page is what user\'s see when they attempt
            to view an invalid page URL.'.' '. $desc_warning, 'benjamin')
        ),
    );

    $cpts = benjamin_get_cpts();

    $templates = $templates + $cpts;

    $widget_areas = array(
        'banner-widget-area-1' => array(
            'label' => 'Banner Widget Area 1',
            'description' => __('The banner is made up widget areas and are optionally used.  The banner is expandable only if widgets have been set', 'benjamin')
        ),
        'banner-widget-area-2' => array(
            'label' => 'Banner Widget Area 2',
            'description' => __('The banner is made up widget areas and are optionally used.  The banner is expandable only if widgets have been set', 'benjamin')
        ),
        'frontpage-widget-area-1' => array(
            'label' => 'Frontpage Widget Area 1',
            'description' => __('The frontpage content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.', 'benjamin')
        ),
        'frontpage-widget-area-2' => array(
            'label' => 'Frontpage Widget Area 2',
            'description' => __('The frontpage content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.', 'benjamin')
        ),
        'frontpage-widget-area-3' => array(
            'label' => 'Frontpage Widget Area 3',
            'description' => __('The frontpage content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.', 'benjamin')
        ),
        'widgetized-widget-area-1' => array(
            'label' => 'Widgetized Page Area 1',
            'description' => __('The Widgetized page content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.', 'benjamin')
        ),
        'widgetized-widget-area-2' => array(
            'label' => 'Widgetized Page Area 2',
            'description' => __('The Widgetized page content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.', 'benjamin')
        ),
        'widgetized-widget-area-3' => array(
            'label' => 'Widgetized Page Area 3',
            'description' => __('The Widgetized page is full sortable, horizontal widget areas.  This is one of those areas and is optionally used.', 'benjamin')
        ),
        'footer-widget-area-1' => array(
            'label' => 'Footer Widget Area 1',
            'description' => __('The footer area is sortable and contains two optional widget areas.  To use these widgets, remember to setup the footer in the customizer.', 'benjamin')
        ),
        'footer-widget-area-2' => array(
            'label' => 'Footer Widget Area 2',
            'description' => __('The footer area is sortable and contains two optional widget areas.  To use these widgets, remember to setup the footer in the customizer.', 'benjamin')
        ),
    );

    if( $use_widget_areas == true )
        $templates = $templates + $widget_areas;

    return $templates;
}

function benjamin_get_cpts() {
    $args = array(
       'public'   => true,
       'publicly_queryable' => true,
       '_builtin' => false
    );
    return benjamin_get_cpt_template_types( get_post_types($args) );
}

function benjamin_get_cpt_template_types($cpts) {
    $new = array();
    foreach($cpts as $cpt){
        $obj = get_post_type_object($cpt);
        $new[$cpt] = array(
            'label' => $obj->label,
            'description' => __('A single instance of a '.$obj->label, 'benjamin')
        );
        if($obj->has_archive){

            $new[$cpt.'-feed'] = array(
                'label' => $obj->label . ' Feed',
                'description' => __('The feed for your '.$obj->label, 'benjamin')
            );
        }
    }


    return $new;
}
