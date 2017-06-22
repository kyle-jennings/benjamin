<?php

function benjamin_get_navbar_brand() {
    $logo_tag = 'em';
    $brand = get_theme_mod('navbar_brand_setting');

    $brand = $brand ? $brand : 'text';
    $output = '';
    if( $brand == 'text' ):

        $output .= '<div class="usa-logo" id="logo">';
            $output .= '<'.$logo_tag.' class="usa-logo-text">';
                $output .= '<a href="'.get_site_url().'" >'.get_bloginfo( 'name' ).'</a>';
            $output .= '</'.$logo_tag.'>';
        $output .= '</div>';
    else:

        $url = benjamin_get_custom_logo($logo_id);
        $output .= '<div class="usa-logo" id="logo">';
            $output .= '<'.$logo_tag.' class="usa-logo-text usa-logo-image">';
                $output .= '<a href="'.get_site_url().'" >';

                    $output .= $url
                        ? '<img src="'.$url.'" alt="'.get_bloginfo( 'name' ).'">'
                        : get_bloginfo( 'name' );

                $output .= '</a>';
            $output .= '</'.$logo_tag.'>';
        $output .= '</div>';
    endif;

    return $output;
}


function benjamin_navbar_brand() {
    echo benjamin_get_navbar_brand();
}


function benjamin_get_custom_logo($logo_id = null){
    $logo_id = get_theme_mod('custom_logo');
    $thumb_id = get_post_thumbnail_id($logo_id);
    $thumb_url_array = wp_get_attachment_image_src($logo_id, 'full', true);

    if( strpos(reset($thumb_url_array), 'wp-includes/images/media/default.png') )
        return false;

    return $thumb_url_array[0];
}
