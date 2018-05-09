<?php


// these files contain functions used by both the admin section and frontend
$shared_files = array(
    'audio-markup',
    'custom-post-types',
    'extras',
    'functions',
    'jetpack',
    'register-sidebars',
    'set-default-settings',
    'template-list',
    'theme-support',
    'video-markup',
    'widgets',
);

foreach ($shared_files as $file) {
    require get_template_directory() . '/inc/shared/' . $file . '.php'; // WPCS: xss ok.
}

// customizer
require get_template_directory() . '/inc/customizer/_init.php';



// only load these in the admin section
if (is_admin()) {
    $files = array(
        'about-page',
        'ajax',
        'assets',
        'franklin-notice',
        'functions',
        'metabox-featured-post'
    );


    foreach ($files as $file) {
        require get_template_directory() . '/inc/admin/' . $file . '.php'; // WPCS: xss ok.
    }
}


// only load these on the frontend
if (!is_admin()) {

    $files = array(
        'assets',
        'brand',
        'class-BenjaminFeaturedPost',
        'hero/BenjaminHero',
        'hero/BenjaminHeroBG',
        'hero/BenjaminHeroContent',
        'excerpts',
        'filters',
        'get-sidebar',
        'get-width-visibility',
        'nav-settings',
        'nav-walkers/footer-nav-walker',
        'nav-walkers/navbar-walker',
        'nav-walkers/navlist-walker',
        'nav-walkers/sidenav-walker',
        'page-sortables',
        'post-format-markup',
        'sticky-sidenav',
        'template-parts',
        'template-settings',
        'template-tags',
    );

    foreach ($files as $file) {
        require get_template_directory() . '/inc/frontend/' . $file . '.php'; // WPCS: xss ok.
    }
}
