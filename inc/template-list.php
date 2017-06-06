<?php


function benjamin_the_template_list($use_widget_areas = false) {


    // not used yet
    // $advanced_templates = array(
    //     'search' => 'Search Results',
    //     'date' => 'Filtered by Date',
    //     'category' => 'Filtered by Category',
    //     'tag' => 'Filtered by Tag',
    // );

    $templates = array(
        'archive' => 'Feed (default)',
        'frontpage' => 'Front Page',
        'single' => 'Single Post',
        'page' => 'Single Page',
        'widgetized' => 'Widgetized Page',
        'template-1' => 'Page Template 1',
        'template-2' => 'Page Template 2',
        'template-3' => 'Page Template 3',
        'template-4' => 'Page Template 4',
        '404' => '404 Page',
    );
    $args = array(
       'public'   => true,
       'publicly_queryable' => true,
       '_builtin' => false
    );
    $cpts = get_post_types($args);

    $templates = $templates + $cpts;


    $widget_areas = array(
        'frontpage-widget-area-1' => 'Frontpage Widget Area 1',
        'frontpage-widget-area-2' => 'Frontpage Widget Area 2',
        'frontpage-widget-area-3' => 'Frontpage Widget Area 3',
        'widgetized-widget-area-1' => 'Widgetized Page Area 1',
        'widgetized-widget-area-2' => 'Widgetized Page Area 2',
        'widgetized-widget-area-3' => 'Widgetized Page Area 3',
        'footer-widgets-1' => 'Footer Widgets 1',
        'footer-widgets-2' => 'Footer Widgets 2',
    );

    if( $use_widget_areas == true )
        $templates = $templates + $widget_areas;

    return $templates;
}
