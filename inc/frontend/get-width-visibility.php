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
