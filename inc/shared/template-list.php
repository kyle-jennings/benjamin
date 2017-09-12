<?php

/**
 * The file contains the functions which gather all available templates.
 *
 * This tempalte list is used to populate the customizer settings and widgets ares
 *
 * @package Benjamin
 */

function benjamin_the_template_list($use_widget_areas = false) {


    $desc_warning = '<p>The layout settings and widgets on this template are not available
    unless the template is activated in the customizer.</p>';


    $templates = array(
        'archive' => array(
            'label' => 'Feed (default)',
            'description' => __('<p>This is your default (home) page, but not your frontpage.
            These settings are the default settings used on every page unless the other
            templates\' settings been activated.</p>',
            'benjamin'),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'the home (the archive/feed) page')
        ),

        'frontpage' => array(
            'label' => 'Front Page',
            /* translators: 1: site url. */
            /* translators: 2: warning about activating the widget areas. */
            'description' => sprintf( __('<p>The frontpage is the located at %1$s
            and the content area is made of 4 sortable areas. You can also set
            the content in the page header.</p> %2$s ',
            'benjamin'), site_url(), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'the frontpage' )
        ),

        'single' => array(
            'label' => 'Single Post',
            /* translators:  warning about activating the widget areas. */
            'description' => sprintf( __('<p>The "single post" is what you see when viewing
            a single blog post, or single custom post type.</p> %s.', 'benjamin'), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'single posts' )
        ),

        'page' => array(
            'label' => 'Single Page',
            /* translators:  warning about activating the widget areas. */
            'description' => sprintf( __('<p>The "single page" is what you see when viewing
            a page.</p> %s.', 'benjamin'), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'single pages' )
        ),

        'widgetized' => array(
            'label' => 'Widgetized Page',
            /* translators:  warning about activating the widget areas. */
            'description' =>  sprintf(__('<p>This is a special page template,
            the content area is made of 4 sortable areas.</p> %s ', 'benjamin'), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'the widgetizted page')
        ),
        'template-1' => array(
            'label' => 'Page Template 1',
            /* translators:  warning about activating the widget areas. */
            'description' => sprintf(__('<p>This is just an extra page template, use this
            if you want to style an individual page differently then your
            standard pages.</p> %s', 'benjamin'), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'page template 1')
        ),
        'template-2' => array(
            'label' => 'Page Template 2',
            /* translators:  warning about activating the widget areas. */
            'description' => sprintf(__('<p>This is just an extra page template, use this
            if you want to style an individual page differently then your
            standard pages.</p> %s', 'benjamin'), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'page template 2')
        ),
        'template-3' => array(
            'label' => 'Page Template 3',
            /* translators:  warning about activating the widget areas. */
            'description' => sprintf(__('<p>This is just an extra page template, use this
            if you want to style an individual page differently then your
            standard pages.</p> %s', 'benjamin'), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'page template 3')
        ),
        'template-4' => array(
            'label' => 'Page Template 4',
            /* translators:  warning about activating the widget areas. */
            'description' => sprintf(__('<p>This is just an extra page template, use this
            if you want to style an individual page differently then your
            standard pages.</p> %s', 'benjamin'), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'page template 4')
        ),
        '_404' => array(
            'label' => '404 Page',
            /* translators:  warning about activating the widget areas. */
            'description' => sprintf(__('<p>This page is what user\'s see when they attempt
            to view an invalid page URL. Both the page and header content are
            configurable.</p> %s ', 'benjamin'), $desc_warning),
            /* translators: the page template name. */
            'widget_description' => sprintf( __('These widgets appear on %s
            in the sidebar located on the right or left of the page.', 'benjamin'), 'the 404 page')
        ),
    );

    $cpts = benjamin_get_cpts();

    $templates = $templates + $cpts;

    $widget_areas = array(
        'banner-widget-area-1' => array(
            'label' => 'Banner Widget Area 1',
            'widget_description' => __('The banner is made up widget areas and are
            optionally used.  The banner is expandable only if widgets have been set.', 'benjamin')
        ),
        'banner-widget-area-2' => array(
            'label' => 'Banner Widget Area 2',
            'widget_description' => __('The banner is made up widget areas and are
            optionally used.  The banner is expandable only if widgets have been set.', 'benjamin')
        ),
        'frontpage-widget-area-1' => array(
            'label' => 'Frontpage Widget Area 1',
            'widget_description' => __('The frontpage content is made up of sortable,
            horizontal widget areas.  This is one of those areas and is
            optionally used.', 'benjamin')
        ),
        'frontpage-widget-area-2' => array(
            'label' => 'Frontpage Widget Area 2',
            'widget_description' => __('The frontpage content is made up of sortable,
            horizontal widget areas.  This is one of those areas and is
            optionally used.', 'benjamin')
        ),
        'frontpage-widget-area-3' => array(
            'label' => 'Frontpage Widget Area 3',
            'widget_description' => __('The frontpage content is made up of sortable,
            horizontal widget areas.  This is one of those areas and is
            optionally used.', 'benjamin')
        ),
        'widgetized-widget-area-1' => array(
            'label' => 'Widgetized Page Area 1',
            'widget_description' => __('The Widgetized page content is made up of
            sortable, horizontal widget areas.  This is one of those areas and
            is optionally used.', 'benjamin')
        ),
        'widgetized-widget-area-2' => array(
            'label' => 'Widgetized Page Area 2',
            'widget_description' => __('The Widgetized page content is made up of
            sortable, horizontal widget areas.  This is one of those areas and
            is optionally used.', 'benjamin')
        ),
        'widgetized-widget-area-3' => array(
            'label' => 'Widgetized Page Area 3',
            'widget_description' => __('The Widgetized page is full sortable, horizontal
            widget areas.  This is one of those areas and is optionally used.',
            'benjamin')
        ),
        'footer-widget-area-1' => array(
            'label' => 'Footer Widget Area 1',
            'widget_description' => __('The footer area is sortable and contains two
            optional widget areas.  To use these widgets, remember to setup the
            footer in the customizer.', 'benjamin')
        ),
        'footer-widget-area-2' => array(
            'label' => 'Footer Widget Area 2',
            'widget_description' => __('The footer area is sortable and contains two
            optional widget areas.  To use these widgets, remember to setup the
            footer in the customizer.', 'benjamin')
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
            /* translators: custom post type label. */
            'description' => sprintf( __('A single instance of a %s.', 'benjamin'), $obj->label)
        );
        if($obj->has_archive){

            $new[$cpt.'-feed'] = array(
                'label' => $obj->label . ' Feed',
                /* translators: custom post type label. */
                'description' => sprintf( __('The feed for your %s.', 'benjamin'), $obj->label)
            );
        }
    }


    return $new;
}
