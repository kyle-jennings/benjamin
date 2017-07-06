<?php
/**
 * Register widget areas programitically
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */


function benjamin_widgets_init() {
    $templates = benjamin_the_template_list(true);
    $sidebars = wp_get_sidebars_widgets();
    foreach($templates as $name => $label){
        $sidebar_size = '';

        $widgets = isset($sidebars[$name]) ? $sidebars[$name] : array();
        $count = count($widgets);
        $pos = get_theme_mod($name . '_sidebar_position_setting', 'none');
        $horizontals = array(
            'widgetized-widget-area-1',
            'widgetized-widget-area-2',
            'widgetized-widget-area-3',
            'frontpage-widget-area-1',
            'frontpage-widget-area-2',
            'frontpage-widget-area-3',
            'footer-widgets-1',
            'footer-widgets-2',
        );

        // $sidebar_size = benjamin_determine_widget_width_rules($pos, $name);
        // determine whether or not to apply withs to the widgets
        if ( in_array($name, $horizontals) ){
            $sidebar_size = 'full';
        }

        // figure out which width rules to use
        if($sidebar_size == 'full')
            $width = benjamin_calculate_widget_width($count);
        else
            $width = '';

        register_sidebar( array(
    		'name'          => ucfirst($label),
    		'id'            => (string)$name,
    		'description'   => esc_html__( 'Add widgets here.', 'benjamin' ),
    		'before_widget' => '<div id="%1$s" class="widget '.$width.'">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h3 class="widget-title">',
    		'after_title'   => '</h3>',
    	) );
    }


}
add_action( 'init', 'benjamin_widgets_init' );


function benjamin_calculate_widget_width($count){


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
