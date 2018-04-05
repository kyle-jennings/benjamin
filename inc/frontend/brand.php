<?php

function benjamin_get_navbar_brand()
{

    $brand = get_theme_mod('navbar_brand_setting', 'text');

    $output = '';
    if ($brand == 'logo') :
        $url = benjamin_get_custom_logo();
    
        $img = $url
            ? '<img src="' . esc_url($url) . '" alt="' . get_bloginfo('name', 'display') . '">'
            : get_bloginfo('name', 'display');

        $output .= '<div class="usa-logo" id="logo">';
            $output .= '<em class="usa-logo-text usa-logo-image">';
                $output .= '<a href="' . get_home_url() . '" >';
                    $output .= $img;
                $output .= '</a>';
            $output .= '</em>';
        $output .= '</div>';
        
        return $output;
    else :
        $output .= '<div class="usa-logo" id="logo">';
            $output .= '<em class="usa-logo-text">';
                $output .= '<a href="' . get_home_url() . '" >' . get_bloginfo('name', 'display') . '</a>';
            $output .= '</em>';
        $output .= '</div>';
        
        return $output;
    endif;
}


function benjamin_navbar_brand()
{
    echo benjamin_get_navbar_brand(); // WPCS: xss ok.
}


function benjamin_get_custom_logo($logo_id = null)
{

    $logo_id = get_theme_mod('custom_logo', null);
    if (!$logo_id) {
        return false;
    }
    
    $thumb_url_array = wp_get_attachment_image_src($logo_id, 'full', true);

    if (strpos(reset($thumb_url_array), 'wp-includes/images/media/default.png')) {
        return false;
    }

    return $thumb_url_array[0];
}
