<?php
/**
 * Register widget areas programitically
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */


function benjamin_widgets_init() {
    $templates = benjamin_the_template_list(true);
    $sidebars = wp_get_sidebars_widgets();
    foreach($templates as $name => $args){
        $sidebar_size = '';

        $widgets = isset($sidebars[$name]) ? $sidebars[$name] : array();
        $count = count($widgets);
        $pos = get_theme_mod($name . '_sidebar_position_setting', 'none');
        $horizontals = array(
            'banner-widget-area-1',
            'banner-widget-area-2',
            'widgetized-widget-area-1',
            'widgetized-widget-area-2',
            'widgetized-widget-area-3',
            'frontpage-widget-area-1',
            'frontpage-widget-area-2',
            'frontpage-widget-area-3',
            'footer-widget-area-1',
            'footer-widget-area-2',
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

        $description = isset($args['widget_description']) ? $args['widget_description'] : '';
        register_sidebar( array(
    		'name'          => ucfirst($args['label']),
    		'id'            => (string) $name,
            /* translators: sidebar description. */
    		'description'   => sprintf(  '%s', $description ),
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
function benjamin_hide_inactive_templates_on_widget_screen(){
    $screen = get_current_screen();

    if($screen->id !== 'widgets')
        return;

    $horizontals = array(
        'widgetized-widget-area-1',
        'widgetized-widget-area-2',
        'widgetized-widget-area-3',
        'frontpage-widget-area-1',
        'frontpage-widget-area-2',
        'frontpage-widget-area-3',
        'footer-widget-area-1',
        'footer-widget-area-2',
    );

    $templates = benjamin_the_template_list(true);

    foreach($templates as $name => $args){
        if( $name == 'archive' || get_theme_mod($name.'_settings_active') == 'yes' )
            continue;

        $skip_horz = array('banner-widget-area-1','banner-widget-area-2');
        foreach($horizontals as $area){

            $setting = strtok($area, '-');
            $sortables = get_theme_mod($setting . '_sortables_setting', null);

            $target = ltrim(ltrim($area, $setting), '-');
            if(strpos($sortables, $target) )
                $skip_horz[] = $area;

        }

        if(in_array($name, $skip_horz ))
            continue;

        unregister_sidebar((string) $name);
    }

}
add_action('sidebar_admin_setup', 'benjamin_hide_inactive_templates_on_widget_screen');
