<?php

function uswds_register_fields() {

    add_settings_section(
      'general_settings_section',
      'Contact Information',
      'uswds_contat_information_callback',
      'general'
  );

    add_settings_field(
        'facebook_profile',
        'Facebook' ,
        'uswds_facebook_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'facebook_profile', 'esc_attr' );

    add_settings_field(
        'twitter_profile',
        'Twitter',
        'uswds_twitter_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'twitter_profile', 'esc_attr' );

    add_settings_field(
        'youtube_profile',
        'Youtube',
        'uswds_youtube_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'youtube_profile', 'esc_attr' );


    add_settings_field(
        'title',
        'Title',
        'uswds_title_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'title', 'esc_attr' );

    add_settings_field(
        'phone_number',
        'Phone Number',
        'uswds_phone_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'phone_number', 'esc_attr' );

    add_settings_field(
        'email',
        'Email',
        'uswds_email_html' ,
        'general',
        'general_settings_section'
    );
    register_setting( 'general', 'email', 'esc_attr' );
}

function uswds_contat_information_callback() {
    echo '<p>Enter the angency contact information.</p>';
}

function uswds_facebook_html() {
    $value = get_option( 'facebook_profile', '' );
    echo '<input type="text" id="facebook_profile" name="facebook_profile" value="' . $value . '" />';

}

function uswds_twitter_html() {

    $value = get_option( 'twitter_profile', '' );
    echo '<input type="text" id="twitter_profile" name="twitter_profile" value="' . $value . '" />';

}


function uswds_youtube_html() {
    $value = get_option( 'youtube_profile', '' );
    echo '<input type="text" id="youtube_profile" name="youtube_profile" value="' . $value . '" />';
}

function uswds_instagram_html() {

    $value = get_option( 'instagram_profile', '' );
    echo '<input type="text" id="instagram_profile" name="instagram_profile" value="' . $value . '" />';
}

function uswds_phone_html() {

    $value = get_option( 'phone_number', '' );
    echo '<input type="text" id="phone_profile" name="phone_number" value="' . $value . '" />';
}

function uswds_email_html() {

    $value = get_option( 'email', '' );
    echo '<input type="text" id="email" name="email" value="' . $value . '" />';
}


function uswds_title_html() {

    $value = get_option( 'title', '' );
    echo '<input type="text" id="title" name="title" value="' . $value . '" />';
}


add_filter( 'admin_init' , 'uswds_register_fields' );
