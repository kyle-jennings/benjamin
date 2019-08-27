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
define('BENJAMIN_FRONTEND_ASSETS_DIR', get_template_directory_uri() . '/assets/frontend/');

if (!defined('BENJAMIN_POST_FORMATS')) {
	define(
		'BENJAMIN_POST_FORMATS',
		wp_json_encode(
			array('audio', 'image', 'gallery', 'link', 'quote', 'status', 'video')
		)
	);
}

require_once get_template_directory() . '/inc/_inc.php';


// FENSES specific code
function save_ic3_form()
{
	//  Sanity test -- shows how to insert form in to DB
	// global $wpdb;
	// $inputName = 'hello world!';
	// $wpdb->insert(
	// 	'wp_test',
	// 	array('name' => 'hello')
	// );

	wp_redirect(site_url('/confirmation')); // <-- address of site that user should be redirected after submitting that form
	die;
}


// Need to add both actions because we want this to work for both logged-in users and visitors
add_action('admin_post_nopriv_save_ic3_form', 'save_ic3_form');
add_action('admin_post_save_ic3_form', 'save_ic3_form');
