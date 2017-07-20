<?php
function benjamin_get_sticky_sidenav($id = 0){
    if($id == 0)
        return false;

    $anchors = benjamin_sticky_sidenav_anchors($id);

    $output = '';

    $output .= '<aside class="sidenav sticky usa-width-one-third">';
        $output .= '<ul class="usa-sidenav-list">';
        foreach($anchors as $anchor):
            $label = str_replace(array('-','_'),' ', $anchor);
            $output .= '<li>';
                $output .= '<a href="#'.esc_attr($anchor).'">'.$label.'</a>';
            $output .= '</li>';
        endforeach;
        $output .= '</ul>';
    $output .= '</aside>';

    return $output;
}

function benjamin_sticky_sidenav($id = 0){
    if($id == 0)
        return false;

    echo benjamin_get_sticky_sidenav($id); // WPCS: xss ok.
}


function benjamin_sticky_sidenav_anchors($id) {
    $post_content = get_post($id);
    $content = $post_content->post_content;

    $pattern = '(id="([a-zA-z0-9\-]+)"+)';
    preg_match_all($pattern, $content, $matches);

    if( 2 == count($matches) > 1  )
        return $matches[1];
    else
        return false;


}
