<?php


// these files contain functions used by both the admin section and frontend
$shared_files = array(
    '/inc/admin/customizer.php',
    '/inc/shared/functions.php',
    '/inc/shared/template-list.php',
    '/inc/shared/theme-support.php',
    '/inc/shared/extras.php',
    '/inc/shared/jetpack.php',
    '/inc/shared/register-sidebars.php',
    '/inc/shared/widgets.php',
    '/inc/shared/video-markup.php',
    '/inc/shared/set-default-settings.php',
);

foreach($shared_files as $file)
    require get_template_directory() . $file;
// only load these in the admin section
if (is_admin()) {
    $files = array(
        '/inc/admin/ajax.php',
        '/inc/admin/assets.php',
        '/inc/admin/metabox-featured-post.php',
        '/inc/admin/metabox-featured-video.php',
    );
    foreach($files as $file)
        require get_template_directory() . $file;
}


// only load these on the frontend
if( !is_admin() ){

    $files = array(
        '/inc/frontend/assets.php',
        '/inc/frontend/filters.php',
        '/inc/frontend/excerpts.php',
        '/inc/frontend/template-tags.php',
        '/inc/frontend/class-BenjaminFeaturedPost.php',
        '/inc/frontend/class-BenjaminHero.php',
        '/inc/frontend/template-parts.php',
        '/inc/frontend/template-settings.php',
        '/inc/frontend/get-sidebar.php',
        '/inc/frontend/sticky-sidenav.php',
        '/inc/frontend/page-sortables.php',
        '/inc/frontend/brand.php',
        '/inc/frontend/get-width-visibility.php',
        '/inc/frontend/nav-settings.php',
        '/inc/frontend/navs/navbar-walker.php',
        '/inc/frontend/navs/sidenav-walker.php',
        '/inc/frontend/navs/navlist-walker.php',
        '/inc/frontend/navs/footer-nav-walker.php',
    );
    foreach($files as $file)
        require get_template_directory() . $file;
}
