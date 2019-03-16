<?php

/**
 * The file contains the functions which gather all available templates.
 *
 * This tempalte list is used to populate the customizer settings and widgets ares
 *
 * @package Benjamin
 */

function benjamin_get_template_info($name = null)
{

    if (!$name) {
        return;
    }

    $templates = benjamin_the_template_list();
    return $templates[$name];
}


function benjamin_the_template_list($use_widget_areas = false, $add_default = false)
{


    $desc_warning =  __('The layout settings and widgets on this template are not available
    unless the template is activated in the customizer.', 'benjamin');


    $templates = array(
        'archive' => array(
            'label' => __('Feed/Archive', 'benjamin'),
            'description' => '' . __(
                'This is your feed, or archive page. This page shows your recent new, archived, filtered posts ect.',
                'benjamin'
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'the home (the archive/feed) page'
            )
        ),

        'frontpage' => array(
            'label' => __('Front Page', 'benjamin'),
            'description' => sprintf(
                /* translators: 1: site url. */
                /* translators: 2: warning about activating the widget areas. */
                __(
                    'The frontpage is the located at %1$s and the content area is made of 4 sortable areas. You can also set the content in the page header. %2$s ',
                    'benjamin'
                ),
                site_url(),
                $desc_warning
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'the frontpage'
            )
        ),

        'single' => array(
            'label' => __('Single Post', 'benjamin'),
            'description' => sprintf(
                /* translators:  warning about activating the widget areas. */
                __(
                    'The "single post" is what you see when viewing
            a single blog post, or single custom post type. %s',
                    'benjamin'
                ),
                $desc_warning
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'single posts'
            )
        ),

        'page' => array(
            'label' => __('Single Page', 'benjamin'),
            'description' => sprintf(
                /* translators:  warning about activating the widget areas. */
                __(
                    'The "single page" is what you see when viewing a page. %s.',
                    'benjamin'
                ),
                $desc_warning
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'single pages'
            )
        ),

        'widgetized' => array(
            'label' => __('Widgetized Page', 'benjamin'),
            'description' =>  sprintf(
                /* translators:  warning about activating the widget areas. */
                __(
                    'This is a special page template, the content area is made of 4 sortable areas. %s ',
                    'benjamin'
                ),
                $desc_warning
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'the widgetizted page'
            )
        ),
        'template-1' => array(
            'label' => __('Page Template 1', 'benjamin'),
            'description' => sprintf(
                /* translators:  warning about activating the widget areas. */
                __(
                    'This is just an extra page template, use this if you want to style an individual page differently then your standard pages. %s',
                    'benjamin'
                ),
                $desc_warning
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'page template 1'
            )
        ),
        'template-2' => array(
            'label' => __('Page Template 2', 'benjamin'),
            'description' => sprintf(
                /* translators:  warning about activating the widget areas. */
                __(
                    'This is just an extra page template, use this if you want to style an individual page differently then your standard pages. %s',
                    'benjamin'
                ),
                $desc_warning
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'page template 2'
            )
        ),
        'template-3' => array(
            'label' => __('Page Template 3', 'benjamin'),
            /* translators:  warning about activating the widget areas. */
            'description' => sprintf(__('This is just an extra page template, use this
            if you want to style an individual page differently then your
            standard pages. %s', 'benjamin'), $desc_warning),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'page template 3'
            )
        ),
        'template-4' => array(
            'label' => __('Page Template 4', 'benjamin'),
            'description' => sprintf(
                /* translators:  warning about activating the widget areas. */
                __(
                    'This is just an extra page template, use this if you want to style an individual page differently then your standard pages. %s',
                    'benjamin'
                ),
                $desc_warning
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'page template 4'
            )
        ),
        '_404' => array(
            'label' => __('404 Page', 'benjamin'),
            'description' => sprintf(
                /* translators:  warning about activating the widget areas. */
                __(
                    'This page is what user\'s see when they attempt to view an invalid page URL. Both the page and header content are configurable. %s ',
                    'benjamin'
                ),
                $desc_warning
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'the 404 page'
            )
        ),
    );

    $cpts = benjamin_get_cpts();

    $templates = $templates + $cpts;

    $widget_areas = array(
        'banner-widget-area' => array(
            'label' => __('Banner Widgets', 'benjamin'),
            'widget_description' => __(
                'The banner is made up widget areas and are optionally used.  The banner is expandable only if widgets have been set.',
                'benjamin'
            )
        ),

        'frontpage-widget-area-1' => array(
            'label' => __('Frontpage Widget Area 1', 'benjamin'),
            'widget_description' => __(
                'The frontpage content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.',
                'benjamin'
            )
        ),
        'frontpage-widget-area-2' => array(
            'label' => __('Frontpage Widget Area 2', 'benjamin'),
            'widget_description' => __(
                'The frontpage content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.',
                'benjamin'
            )
        ),
        'frontpage-widget-area-3' => array(
            'label' => __('Frontpage Widget Area 3', 'benjamin'),
            'widget_description' => __(
                'The frontpage content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.',
                'benjamin'
            )
        ),
        'widgetized-widget-area-1' => array(
            'label' => __('Widgetized Page Area 1', 'benjamin'),
            'widget_description' => __(
                'The Widgetized page content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.',
                'benjamin'
            )
        ),
        'widgetized-widget-area-2' => array(
            'label' => __('Widgetized Page Area 2', 'benjamin'),
            'widget_description' => __(
                'The Widgetized page content is made up of sortable, horizontal widget areas.  This is one of those areas and is optionally used.',
                'benjamin'
            )
        ),
        'widgetized-widget-area-3' => array(
            'label' => __('Widgetized Page Area 3', 'benjamin'),
            'widget_description' => __(
                'The Widgetized page is full sortable, horizontal widget areas.  This is one of those areas and is optionally used.',
                'benjamin'
            )
        ),
        'footer-widget-area-1' => array(
            'label' => __('Footer Widget Area 1', 'benjamin'),
            'widget_description' => __(
                'The footer area is sortable and contains two optional widget areas.  To use these widgets, remember to setup the footer in the customizer.',
                'benjamin'
            )
        ),
        'footer-widget-area-2' => array(
            'label' => __('Footer Widget Area 2', 'benjamin'),
            'widget_description' => __(
                'The footer area is sortable and contains two optional widget areas.  To use these widgets, remember to setup the footer in the customizer.',
                'benjamin'
            )
        ),
    );

    if ($use_widget_areas == true) {
        $templates = $templates + $widget_areas;
    }


    if ($add_default == true) {
        $templates = array(BENJAMIN_DEFAULT_TEMPLATE => array(
            'label' => __('Default Layout Settings', 'benjamin'),
            'description' => __(
                'These settings are the default settings used on every page unless the other templates\' settings been activated.',
                'benjamin'
            ),
            'widget_description' => sprintf(
                /* translators: the page template name. */
                __(
                    'These widgets appear on %s in the sidebar located on the right or left of the page.',
                    'benjamin'
                ),
                'the home (the archive/feed) page'
            )
        )) + $templates;
    }

    return $templates;
}
