<?php


//// buttons
function uswds_button($atts, $content = null){
    extract(shortcode_atts(
        array(
            'target' => null,
            'size' => null,
            'color' => 'primary',
            'state' => null,
            'text' => null
        ),
        $atts
    ));

    $state = $state ? 'usa-button-'.$state : null;
    $color = 'usa-button-'.$color;
    $class = implode(array($size, $color, $state), ' ');

    $output = '';
    $output .= '<a class="usa-button '.$class.'" href="'.$target.'" >';
        $output .= $text;
    $output .= '</a>';

    if(!$text || !$target)
        return false;

    return $output;
}
add_shortcode('button', 'uswds_button');


function uswds_button_group($atts, $content = null){
    extract(shortcode_atts(
        array(
            'class' => null,
        ),
        $atts
    ));
    $class = ($class == 'dark') ? ' button_wrapper-dark' : '';
    return '<div class="button_wrapper'.$class.'">'. do_shortcode( $content ). '</div>';
}
add_shortcode('buttongroup', 'uswds_button_group');


// Labels
//
function uswds_label($atts, $content = null){
    extract(shortcode_atts(
        array(
            'size' => null,
            'color' => 'primary',
            'text' => null
        ),
        $atts
    ));

    $size = $size ? 'usa-label-'.$size : null;
    $color = 'usa-label-'.$color;
    $class = implode(array($size, $color, $size), ' ');

    $output = '';
    $output .= '<span class="usa-label '.$class.'" >';
        $output .= $text;
    $output .= '</span>';

    if(!$text)
        return false;

    return $output;
}
add_shortcode('label', 'uswds_label');


// Labels
//
function uswds_alert($atts, $content = null){
    extract(shortcode_atts(
        array(
            'color' => 'primary',
            'title' => null,
            'text' => null,
        ),
        $atts
    ));

    $state = $state ? 'usa-alert-'.$state : null;
    $color = 'usa-alert-'.$color;
    $class = implode(array($size, $color, $state), ' ');

    $output = '';
    $output .= '<div class="usa-alert '.$class.'">';
        $output .= '<div class="usa-alert-body">';
            $output .= '<h3 class="usa-alert-heading">'.$title.'</h3>';
            $output .= '<p class="usa-alert-text">'.$text.'</p>';
        $output .= '</div>';
    $output .= '</div>';

    if(!$text)
        return false;

    return $output;
}
add_shortcode('alert', 'uswds_alert');


// Accordions
function uswds_accordion($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'title' => null,
            'text' => null,
            'style' => null,
            'id' => null,
            'single' => null
        ),
        $atts
    ));



    $style = $style ? 'usa-alert-bordered' : 'usa-alert';

    $output = '';


    $output .= '<div class="usa-accordion-bordered">';
        $output .= '<button class="usa-accordion-button"
            aria-controls="accordion-'.$id.'"
            aria-expanded="false">';
            $output .= $title;
        $output .= '</button>';
        $output .= '<div class="usa-accordion-content" id="accordion-'.$id.'" >';
            $output .= '<p>';
            $output .= $text;
            $output .= '</p>';
        $output .= '</div>';
    $output .= '</div>';



    if(!$text || !$title)
        return false;

    return $output;

}
add_shortcode('accordion', 'uswds_accordion');


function uswds_number_accordions($content) {

    $output = preg_replace_callback('(\[accordion )', function($matches){

        static $id = 0;
        $id++;

        return '[accordion id="'.$id.'" ';
    }, $content);

    return $output;
}
add_filter( 'the_content', 'uswds_number_accordions');


function uswds_brand_block($atts, $content = null){

    extract(shortcode_atts(
        array(
            'logo' => wp_get_attachment_url(get_theme_mod('custom_logo')),
            'title' => get_bloginfo( 'name' ),
            'url' => get_site_url(),
            'size' => null
        ),
        $atts
    ));
    $size = ($size == 'slim') ? '-slim' : '';
    $output .= '<div class="usa-footer-logo">';
        $output .= '<img class="usa-footer'.$size.'-logo-img" ';
            $output .= 'src="'.$logo.'" alt="Logo image">';
        $output .= '<h3 class="usa-footer'.$size.'-logo-heading">';
            $output .= '<a href="'.$url.'">'.$title.'</a>';
        $output .= '</h3>';
    $output .= '</div>';

    if(!$logo || $logo == '' || empty($logo))
        return;

    if(!$title || $title == '' || empty($title))
        return;

    return $output;
}
add_shortcode('brand', 'uswds_brand_block');


function uswds_contact_block($atts, $content = null){

    extract(shortcode_atts(
        array(
            'facebook' => get_option( 'facebook_profile', null ),
            'twitter' => get_option( 'twitter_profile', null ),
            'youtube' => get_option( 'youtube_profile', null ),
            'instagram' => get_option( 'instagram_profile', null ),
            'phone' => get_option( 'phone_number', null ),
            'email' => get_option( 'email', null ),
            'title' => get_option( 'title', null ),
            'rss' => get_bloginfo('rss2_url', null),
            'defaults' => null
        ),
        $atts
    ));

    if($title == '' || !$title)
        return false;

    $things = array('youtube', 'facebook', 'twitter', 'instagram', 'phone', 'email', 'rss');
    foreach($things as $thing){
            $$thing = ($$thing !== none && $$thing && $defaults != 'no') ? $$thing : null;

    }

    // $youtube = ($youtube !== 'none') ? $youtube : null;
    // $facebook = ($facebook !== 'none') ? $facebook : null;
    // $twitter = ($twitter !== 'none') ? $twitter : null;
    // $instagram = ($instagram !== 'none') ? $instagram : null;
    // $phone = ($phone !== 'none') ? $phone : null;
    // $email = ($email !== 'none') ? $email : null;
    // $rss = ($rss !== 'none') ? $rss : null;


    $output = '';
    $output .= '<div class="usa-footer-contact-links">';
        if($facebook){
            $output .= '<a class="usa-link-facebook" href="https://facebook.com/'.$facebook.'">';
                $output .= '<span>Facebook</span>';
            $output .= '</a>';
        }
        if($twitter){
            $output .= '<a class="usa-link-twitter" href="https://twitter.com/'.$twitter.'">';
                $output .= '<span>Twitter</span>';
            $output .= '</a>';
        }

        if($youtube){
            $output .= '<a class="usa-link-youtube" href="https://youtube.com/'.$youtube.'">';
                $output .= '<span>YouTube</span>';
            $output .= '</a>';
        }

        if($rss){

            $output .= '<a class="usa-link-rss" href="'.$rss.'">';
                $output .= '<span>RSS</span>';
            $output .= '</a>';
        }
        $output .= '<address>';
            $output .= $title ? '<h3 class="usa-footer-contact-heading">'.$title.'</h3>' : '';
            $output .= $phone ? '<p>'.$phone.'</p>': '' ;
            $output .= $email ? '<a href="mailto:'.$email.'">'.$email.'</a>' : '' ;
        $output .= '</address>';
    $output .= '</div>';

    return $output;
}
add_shortcode('contact-block', 'uswds_contact_block');


function uswds_nav_list($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'title' => null,
            'menu' => null,
        ),
        $atts
    ));

    $items = wp_get_nav_menu_items($menu);
    if(empty($items))
        return;

    $output = '';
    $output .= '<ul class="usa-unstyled-list">';
        $output .= '<li class="usa-footer-primary-link">';
            $output .= '<h4>Topic</h4>';
        $output .= '</li>';
        foreach($items as $item)
            $output .= '<li><a href="'.$item->url.'">'.$item->title.'</a></li>';

    $output .= '</ul>';

    return $output;
}
add_shortcode('nav-list', 'uswds_nav_list');


function uswds_callout($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'title' => null,
            'subtitle' => null,
            'text' => null,
            'link' => null,
            'linktext' => null

        ),
        $atts
    ));

    if(!$title && !$text)
        return false;

    $output = '';
    $output .= '<div class="usa-hero-callout usa-section-dark">';
        $output .= '<h2>';
            $output .= '<span class="usa-hero-callout-alt">'.$title.'</span> ';
            $output .= $subtitle;
        $output .= '</h2>';
        $output .= $text ? '<p class="site-description">'.$text.'</p>' : '';
        if($link && $linktext):
        $output .= '<a class="usa-button usa-button-big usa-button-secondary"
            href="'.$link.'">';
            $output .= $linktext;
        $output .= '</a>';
        endif;
    $output .= '</div>';

    return $output;
}

add_shortcode('callout', 'uswds_callout');



function uswds_media_block($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'title' => null,
            'subtitle' => null,
            'text' => null,
            'link' => null,
            'linktext' => null,
            'logo' => null,
            'alttext' => 'no alt text provided'
        ),
        $atts
    ));

    if(!$logo)
        return false;

    if(!$text && !$title)
        return false;

    $output = '';
    $output .= '<div class="usa-graphic_list">';
        $output .= '<div class="usa-media_block">';
            $output .= '<img class="usa-media_block-img" src="'.$logo.'" alt="'.$alttext.'">';
            $output .= '<div class="usa-media_block-body">';
                $output .= $title ? '<h3>'.$title.'</h3>': $title;
                $output .= $text ? '<p>'.$text.'</p>' : $text;
            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';

    return $output;
}

add_shortcode('media-block', 'uswds_media_block');



function uswds_grid($atts, $content = null){
    return do_shortcode( $content );
    // return '<div class="usa-grid">'. do_shortcode( $content ). '</div>';
}
add_shortcode('grid', 'uswds_grid');

function uswds_column($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'width' => null,
        ),
        $atts
    ));
    if($width == null)
        return false;
    return '<div class="usa-width-'.$width.'">'. do_shortcode( $content ). '</div>';
}
add_shortcode('column', 'uswds_column');
