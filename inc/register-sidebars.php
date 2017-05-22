<?php



/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function uswds_widgets_init() {
    $templates = array(
        'frontpage' => 'Front Page',
        'archive' => 'Feed',
        'single' => 'Single Post',
        'page' => 'Single Page',
        'widgetized' => 'Widgetized Page',
        'frontpage-widget-area-1' => 'Frontpage Widget Area 1',
        'frontpage-widget-area-2' => 'Frontpage Widget Area 2',
        'frontpage-widget-area-3' => 'Frontpage Widget Area 3',
        'widgetized-widget-area-1' => 'Widgetized Page Area 1',
        'widgetized-widget-area-2' => 'Widgetized Page Area 2',
        'widgetized-widget-area-3' => 'Widgetized Page Area 3',
        'footer' => 'Footer',
        'footer-below' => 'Footer Below'
    );

    $advanced_templates = array(
        '404' => 'Page Not Found',
        'search' => 'Search Results',
        'date' => 'Filtered by Date',
        'category' => 'Filtered by Category',
        'tag' => 'Filtered by Tag',
        'template_1' => 'Page Template 1',
        'template_2' => 'Page Template 2',
        'template_3' => 'Page Template 3',
        'template_4' => 'Page Template 4',
    );

    foreach($templates as $name => $label){
        $sidebar_size = '';
        $sidebars = wp_get_sidebars_widgets();
        $widgets = $sidebars[$name];
        $count = count($widgets);
        $pos = get_theme_mod($name . '_sidebar_position_setting');
        $horizontals = array(
            'footer',
            'header',
            'footer-below',
            'widgetized-widget-area-1',
            'widgetized-widget-area-2',
            'widgetized-widget-area-3',
            'frontpage-widget-area-1',
            'frontpage-widget-area-2',
            'frontpage-widget-area-3',
        );


        // $sidebar_size = uswds_determine_widget_width_rules($pos, $name);
        // determine whether or not to apply withs to the widgets
        if ( in_array($name, $horizontals) ){
            $sidebar_size = 'full';
        }





        // figure out which width rules to use
        if($sidebar_size == 'full')
            $width = uswds_calculate_widget_width($count);
        else
            $width = '';

        register_sidebar( array(
    		'name'          => $label,
    		'id'            => $name,
    		'description'   => esc_html__( 'Add widgets here.', 'uswds' ),
    		'before_widget' => '<div id="%1$s" class="widget '.$width.'">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h3 class="widget-title">',
    		'after_title'   => '</h3>',
    	) );
    }


}
add_action( 'widgets_init', 'uswds_widgets_init' );


function uswds_calculate_widget_width($count){


    switch($count):
        case 1:
            return 'usa-width-one-whole';
            break;
        case 2:
            return 'usa-width-one-half';
            break;
        case 3:
            return 'usa-width-one-third';
            break;
        case 4:
            return 'usa-width-one-fourth';
            break;
        case 5:
            return 'usa-width-one-sixth';
            break;
        case 6:
            return 'usa-width-one-sixth';
            break;
        default:
            return 'usa-width-one-twelfth';
            break;
    endswitch;

}
