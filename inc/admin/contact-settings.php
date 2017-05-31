<?php

function uswds_register_fields() {

    add_settings_section(
      'general_settings_section',
      'Contact Information',
      'uswds_contat_information_callback',
      'general'
  );

    add_settings_field(
        'uswds_facebook_profile',
        'Facebook' ,
        'uswds_facebook_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'uswds_facebook_profile', 'uswds_facebook_sanitize' );

    add_settings_field(
        'uswds_twitter_profile',
        'Twitter',
        'uswds_twitter_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'uswds_twitter_profile', 'uswds_twitter_sanitize' );

    add_settings_field(
        'uswds_youtube_profile',
        'Youtube',
        'uswds_youtube_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'uswds_youtube_profile', 'uswds_youtube_sanitize' );


    add_settings_field(
        'uswds_title',
        'Title',
        'uswds_title_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'uswds_title', 'esc_attr' );

    add_settings_field(
        'uswds_phone_number',
        'Phone Number',
        'uswds_phone_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'uswds_phone_number', 'uswds_phone_sanitize' );

    add_settings_field(
        'uswds_email',
        'Email',
        'uswds_email_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'uswds_email', 'uswds_email_sanitize' );
}


function uswds_contat_information_callback() {
    echo '<p>Enter the angency contact information.</p>';
}


function uswds_facebook_html() {
    $value = get_option( 'uswds_facebook_profile', '' );
    echo '<input type="text" id="uswds_facebook_profile" name="uswds_facebook_profile" value="' . $value . '" />';
}


function uswds_twitter_html() {

    $value = get_option( 'uswds_twitter_profile', '' );
    echo '<input type="text" id="uswds_twitter_profile" name="uswds_twitter_profile" value="' . $value . '" />';

}


function uswds_youtube_html() {
    $value = get_option( 'uswds_youtube_profile', '' );
    echo '<input type="text" id="uswds_youtube_profile" name="uswds_youtube_profile" value="' . $value . '" />';
}

function uswds_instagram_html() {

    $value = get_option( 'instagram_profile', '' );
    echo '<input type="text" id="instagram_profile" name="instagram_profile" value="' . $value . '" />';
}

function uswds_phone_html() {

    $value = get_option( 'uswds_phone_number', '' );
    echo '<input type="text" id="uswds_phone_profile" name="uswds_phone_number" value="' . $value . '" />';
}

function uswds_email_html() {

    $value = get_option( 'uswds_email', '' );
    echo '<input type="text" id="uswds_email" name="uswds_email" value="' . $value . '" />';
}


function uswds_title_html() {

    $value = get_option( 'uswds_title', '' );
    echo '<input type="text" id="uswds_title" name="uswds_title" value="' . $value . '" />';
}


add_filter( 'admin_init' , 'uswds_register_fields' );




// sanitize functions
function uswds_social_link_sanitize($val = null, $site = null) {
    if(
        !$site
        || !$val
        || strpos($val, $site) < 0
        || filter_var($val, FILTER_VALIDATE_URL) === false
    )
        return null;

    $val = esc_url($val, array('http', 'https') );
    return $val;
}

function uswds_facebook_sanitize($val) {
    $site = 'facebook.com';
    return uswds_social_link_sanitize($val, $site);
}

function uswds_twitter_sanitize($val) {
    $site = 'twitter.com';
    return uswds_social_link_sanitize($val, $site);
}

function uswds_youtube_sanitize($val) {
    $site = 'youtube.com';
    return uswds_social_link_sanitize($val, $site);
}



function uswds_ig_sanitize($val) {
    $site = 'instagram.com';
    return uswds_social_link_sanitize($val, $site);
}


function uswds_phone_sanitize($val) {

    $val = preg_replace ('/\D/', '', $val);

    if ($val[0] == '1')
        $val = substr ($val, 1);  // remove prefix

    $invalid = strlen ($val) != 10  ||
               preg_match ('/^1/',      $val) ||  // ac start with 1
               preg_match ('/^.11/',    $val) ||  // telco services
               preg_match ('/^...1/',   $val) ||  // exchange start with 1
               preg_match ('/^....11/', $val) ||  // exchange services
               preg_match ('/^.9/',     $val);    // ac center digit 9
    if($invalid)
        return "NOPE";

    return $val;
}


function uswds_email_sanitize($val) {
    if(filter_var($val, FILTER_VALIDATE_EMAIL) === false)
        return null;

    return $val;
}
