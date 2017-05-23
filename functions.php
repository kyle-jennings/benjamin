<?php
/**
* The Amendment functions and definitions
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package Benjamin
*/

// use this to examine objects and arrays
if(!function_exists('examine')){

    function examine($object, $examine_type = 'print_r', $die = 'hard'){
        if(empty($object))
            return;
        echo '<pre>';
        if($examine_type == 'var_dump')
            var_dump($object);
        else
            print_r($object);
        if($die != 'soft')
            die;
    }
}

// Define some constants

define('FULL_WIDTH' , 'usa-width-one-whole');
define('FULL_WIDTH_MEDIUM_UP' , 'usa-width-full-medium-up');
define('FULL_WIDTH_LARGE_UP' , 'usa-width-full-large-up');

// wide sidebar
define('TWO_THIRDS' , 'usa-width-two-thirds');
define('ONE_THIRD' , 'usa-width-one-third');

// narrow sidebar
define('ONE_FOURTH' , 'usa-width-one-fourth');
define('THREE_FOURTHS' , 'usa-width-three-fourths');
define('ONE_HALF' , 'usa-width-one-half');

// set the sidebar width
$sidebar_width = get_theme_mod('sidebar_size_setting');
$main_width = ($sidebar_width == ONE_THIRD) ? TWO_THIRDS : THREE_FOURTHS;
$sidebar_width = $sidebar_width ? constant($sidebar_width) : ONE_THIRD;

// sidebar and main column constants
define('SIDEBAR_WIDTH', $sidebar_width);
define('MAIN_WIDTH', $main_width);


function uswds_is_dot_gov() {
    $domain = $_SERVER['SERVER_NAME'];
    $parts = explode('.', $domain);
    $len = count($parts);
    $tld = $parts[$len-1];
    $is_dot_gov = false;

    $domains = array('gov', 'mil');

    if( in_array($tld, $domains)
        || (defined('USWDS_FORCE_BANNER') && USWDS_FORCE_BANNER == true)
    ){
        $is_dot_gov = true;
    }

    return $is_dot_gov;
}


function uswds_clean_string($string){
    $find = array('-','_');
    $replace = ' ';
    $string = str_replace($find, $replace, $string);
    $string = ucwords($string);
    return $string;
}



/**
* Assets
*/
require get_template_directory() . '/inc/theme-support.php';
require get_template_directory() . '/inc/admin/customizer.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/jetpack.php';
require get_template_directory() . '/inc/excerpts.php';

// sidebars
require get_template_directory() . '/inc/register-sidebars.php';
require get_template_directory() . '/inc/widgets.php';


/**
* Set the content width in pixels, based on the theme's design and stylesheet.
*
* Priority 0 to make it available to lower priority callbacks.
*
* @global int $content_width
*/
function uswds_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'uswds_content_width', 640 );
}
add_action( 'after_setup_theme', 'uswds_content_width', 0 );

// only load these in the admin section
if (is_admin()) {
    $files = array(
        '/inc/admin/assets.php',
        '/inc/admin/widgets.php',
        '/inc/admin/contact-settings.php',
        '/inc/admin/metabox-featured-post.php',
        '/inc/admin/set-default-settings.php',
    );
    foreach($files as $file)
        require get_template_directory() . $file;
}

// only load these on the frontend
if( !is_admin() ){

    $files = array(
        '/inc/frontend/assets.php',
        '/inc/frontend/template-tags.php',
        '/inc/frontend/class-FeaturedPost.php',
        '/inc/frontend/hero-settings.php',
        '/inc/frontend/template-settings.php',
        '/inc/frontend/get-sidebar.php',
        '/inc/frontend/sticky-sidenav.php',
        '/inc/frontend/page-sortables.php',
        '/inc/frontend/defaults.php',
        '/inc/frontend/brand.php',
        '/inc/frontend/get-width-visibility.php',
        '/inc/frontend/nav-settings.php',
        '/inc/frontend/navs/default-menus.php',
        '/inc/frontend/navs/navbar-walker.php',
        '/inc/frontend/navs/footer-nav-walker.php',
        '/inc/frontend/navs/sidenav-walker.php',
        '/inc/frontend/navs/navlist-walker.php',
    );
    foreach($files as $file)
        require get_template_directory() . $file;
}
