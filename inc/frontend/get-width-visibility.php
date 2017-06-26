<?php

function benjamin_get_width_visibility($template, $sidebar_pos = 'none') {
    $sidebar_vis = get_theme_mod($template . '_sidebar_visibility_setting');
    $visibility = null;
    if($sidebar_vis == 'hidden-medium-up') {
        $visibility = 'usa-width-full-medium-up';
    }elseif($sidebar_vis == 'hidden-large-up') {
        $visibility = 'usa-width-full-large-up';
    }elseif($sidebar_vis == 'visible-large-up') {
        $visibility = 'usa-width-full-medium-only';
    }

    return $visibility;
}



function benjamin_get_main_width($sidebar_position) {
    $sidebar_width = get_theme_mod('sidebar_size_setting');

    $sidebar_width = $sidebar_width ? constant($sidebar_width) : BENJAMIN_ONE_THIRD;
    $width = ($sidebar_width == BENJAMIN_ONE_THIRD) ? BENJAMIN_TWO_THIRDS : BENJAMIN_THREE_FOURTHS;

    return $width;
}
