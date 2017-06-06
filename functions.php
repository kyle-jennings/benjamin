<?php
/**
* The Amendment functions and definitions
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package Benjamin
*/

// use this to examine objects and arrays
if(!function_exists('benjamin_examine')){

    function benjamin_examine($object, $examine_type = 'print_r', $die = 'hard'){
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

define('BENJAMIN_FULL_WIDTH' , 'usa-width-one-whole');
define('BENJAMIN_FULL_WIDTH_MEDIUM_UP' , 'usa-width-full-medium-up');
define('BENJAMIN_FULL_WIDTH_LARGE_UP' , 'usa-width-full-large-up');

// wide sidebar
define('BENJAMIN_TWO_THIRDS' , 'usa-width-two-thirds');
define('BENJAMIN_ONE_THIRD' , 'usa-width-one-third');

// narrow sidebar
define('BENJAMIN_ONE_FOURTH' , 'usa-width-one-fourth');
define('BENJAMIN_THREE_FOURTHS' , 'usa-width-three-fourths');
define('BENJAMIN_ONE_HALF' , 'usa-width-one-half');


$sidebar_width = get_theme_mod('sidebar_size_setting');

$sidebar_width = $sidebar_width ? constant($sidebar_width) : BENJAMIN_ONE_THIRD;
$main_width = ($sidebar_width == BENJAMIN_ONE_THIRD) ? BENJAMIN_TWO_THIRDS : BENJAMIN_THREE_FOURTHS;

// sidebar and main column constants
define('BENJAMIN_SIDEBAR_WIDTH', $sidebar_width);
define('BENJAMIN_MAIN_WIDTH', $main_width);



function benjamin_is_dot_gov() {
    $domain = $_SERVER['SERVER_NAME'];
    $parts = explode('.', $domain);
    $len = count($parts);
    $tld = $parts[$len-1];
    $is_dot_gov = false;

    $domains = array('gov', 'mil');

    if( in_array($tld, $domains)
        || (defined('BENJAMIN_FORCE_BANNER') && BENJAMIN_FORCE_BANNER == true)
    ){
        $is_dot_gov = true;
    }

    return $is_dot_gov;
}


function benjamin_clean_string($string){
    $find = array('-','_');
    $replace = ' ';
    $string = str_replace($find, $replace, $string);
    $string = ucwords($string);
    return $string;
}




require get_template_directory() . '/inc/template-list.php';
require get_template_directory() . '/inc/theme-support.php';
require get_template_directory() . '/inc/admin/customizer.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/jetpack.php';
require get_template_directory() . '/inc/register-sidebars.php';
require get_template_directory() . '/inc/widgets.php';



/**
* Set the content width in pixels, based on the theme's design and stylesheet.
*
* Priority 0 to make it available to lower priority callbacks.
*
* @global int $content_width
*/
function benjamin_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'benjamin_content_width', 640 );
}
add_action( 'after_setup_theme', 'benjamin_content_width', 0 );

// only load these in the admin section
if (is_admin()) {
    $files = array(
        '/inc/admin/assets.php',
        '/inc/admin/widgets.php',
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
        '/inc/frontend/filters.php',
        '/inc/frontend/footer.php',
        '/inc/frontend/excerpts.php',
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
        '/inc/frontend/navs/sidenav-walker.php',
        '/inc/frontend/navs/navlist-walker.php',
        '/inc/frontend/navs/footer-nav-walker.php',
    );
    foreach($files as $file)
        require get_template_directory() . $file;
}
