<?php
/**
 * Register widget areas programitically
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */


/**
 * Register the widget areas, and determine the width of said area to use to 
 * size the widgets correctly
 */
function benjamin_widgets_init() {
    $templates = benjamin_the_template_list(true, true);
    $sidebars = wp_get_sidebars_widgets();
    foreach($templates as $name => $args){
        $sidebar_size = '';
        
        $widgets = isset($sidebars[$name]) ? $sidebars[$name] : array();
        $count = count($widgets);

        $horizontals = array(
            'banner-widget-area',
            'footer-widget-area-1',
            'footer-widget-area-2',
            'frontpage-widget-area-1',
            'frontpage-widget-area-2',
            'frontpage-widget-area-3',
            'widgetized-widget-area-1',
            'widgetized-widget-area-2',
            'widgetized-widget-area-3',
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
    		'name'          => sprintf( '%s ', ucfirst($args['label']) ),
    		'id'            => (string) $name,
            /* translators: sidebar description. */
    		'description'   => sprintf(  __('%s ', 'benjamin'), $description ),
    		'before_widget' => '<div id="%1$s" class="widget widget-area--' . $name . ' '. $width . '">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h3 class="widget-title">',
    		'after_title'   => '</h3>',
    	) );
    }


}
add_action( 'init', 'benjamin_widgets_init' );


/**
 * Count the number of widgets set in an a widget area, this is used to automatically
 * resize all the widgets to take up the full width of the area
 * @param  [type] $count [description]
 * @return [type]        [description]
 */
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


/**
 * Deactivate and hide the widget area if it is not "active"
 * @return [type] [description]
 */
function benjamin_hide_inactive_templates_on_widget_screen(){
    $screen = get_current_screen();

    if($screen->id !== 'widgets')
        return;

    $horizontals = array(
        'footer-widget-area-1',
        'footer-widget-area-2',
        'frontpage-widget-area-1',
        'frontpage-widget-area-2',
        'frontpage-widget-area-3',
        'widgetized-widget-area-1',
        'widgetized-widget-area-2',
        'widgetized-widget-area-3',
    );

    $templates = benjamin_the_template_list(true);

    // loop through all the templates
    foreach($templates as $name => $args){
        
        // if we are on the default template or that template's settings 
        // have been activated, then skip it.
        if( $name == DEFAULT_TEMPLATE || get_theme_mod($name.'_settings_active') == 'yes' )
            continue;

        // skip the following areas
        $skip_horz = array('banner-widget-area');
        

        // loop through the list of horizontal areas
        foreach($horizontals as $area){

            $setting = strtok($area, '-');
            $sortables = get_theme_mod($setting . '_sortables_setting', null);
            // if the area is active, then add it to the skip list
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
