<?php


/**
 * The Amendment functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Benjamin
 */

if (version_compare($GLOBALS['wp_version'], '4.6', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
    return;
}

// Define some constants.
define('BENJAMIN_FULL_WIDTH', 'usa-width-one-whole');
define('BENJAMIN_FULL_WIDTH_MEDIUM_UP', 'usa-width-full-medium-up');
define('BENJAMIN_FULL_WIDTH_LARGE_UP', 'usa-width-full-large-up');

// wide sidebar.
define('BENJAMIN_TWO_THIRDS', 'usa-width-two-thirds');
define('BENJAMIN_ONE_THIRD', 'usa-width-one-third');

// narrow sidebar.
define('BENJAMIN_ONE_FOURTH', 'usa-width-one-fourth');
define('BENJAMIN_THREE_FOURTHS', 'usa-width-three-fourths');
define('BENJAMIN_ONE_HALF', 'usa-width-one-half');


// misc.
define('BENJAMIN_DEFAULT_TEMPLATE', 'default');

if(!defined('BENJAMIN_POST_FORMATS')) {
    define('BENJAMIN_POST_FORMATS', json_encode(
        array('audio', 'image', 'gallery', 'link', 'quote', 'status', 'video')
    ));
}

require_once get_template_directory() . '/inc/_inc.php';
