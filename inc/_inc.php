<?php


// these files contain functions used by both the admin section and frontend
$shared_files = array(
    'custom-post-types',
    'extras',
    'functions',
    'jetpack',
    'register-sidebars',
    'set-default-settings',
    'template-list',
    'theme-support',
    'widgets',
);

foreach($shared_files as $file)
    require dirname(__FILE__) . '/shared/' . $file . '.php'; // WPCS: xss ok.

// customizer
require dirname(__FILE__) . '/customizer/_init.php';



// only load these in the admin section
if (is_admin()) {
    $files = array(
        'ajax',
        'assets',
        'columns',
        'metabox-featured-post',
    );


    foreach($files as $file)
        require dirname(__FILE__) . '/admin/' . $file . '.php'; // WPCS: xss ok.
}


// only load these on the frontend
if( !is_admin() ){

    $files = array(
        'assets',
        'filters',
        'excerpts',
        'template-tags',
        'class-BenjaminFeaturedPost',
        'class-BenjaminHero',
        'template-parts',
        'template-settings',
        'get-sidebar',
        'sticky-sidenav',
        'page-sortables',
        'brand',
        'get-width-visibility',
        'nav-settings',
        'nav-walkers/navbar-walker',
        'nav-walkers/sidenav-walker',
        'nav-walkers/navlist-walker',
        'nav-walkers/footer-nav-walker',
    );
    foreach($files as $file)
        require dirname(__FILE__) . '/frontend/' . $file . '.php'; // WPCS: xss ok.
}
