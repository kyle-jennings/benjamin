<?php

/**
 * Counts the widgets and returns the proper width (which each widget should use.
 *
 * @return void echos out some json.
 */
function benjamin_ajax_calculate_widget_width() {

    if ( ! isset( $_POST['data'] ) ) {
        wp_die();
    }

    echo benjamin_calculate_widget_width( wp_unslash( absint( $_POST['data'] ) ) ); // WPCS: xss ok.

    wp_die();
}

add_action( 'wp_ajax_benjamin_calculate_widget_width', 'benjamin_ajax_calculate_widget_width' );
add_action( 'wp_ajax_nopriv_benjamin_calculate_widget_width', 'benjamin_ajax_calculate_widget_width' );


/**
 * [benjamin_postformat_shortcode description]
 * @return void       echo markup.
 */
function benjamin_postformat_shortcode() {
    
    if ( ! isset( $_POST['pfpSTR']) || empty( $_POST['pfpSTR'] ) ) {
        return;
    }

    $str = sanitize_text_field( wp_unslash( $_POST['pfpSTR'] ) );
    echo do_shortcode( $str ); // WPCS: xss ok.

    exit();

}
add_action( 'wp_ajax_benjamin_postformat_shortcode', 'benjamin_postformat_shortcode' );


/**
 * Returns the OEMBED generated markup for media elements
 *
 * @param  string $url  the url of the asset (image, video ect).
 * @param  string $type the asset type (image, video ect).
 * @return void       echo markup.
 */
function benjamin_postformat_oembed( $url = null, $type = null ) {

    if ( ( ! $url || ! $type ) && ( isset( $_POST['pfpType'] ) && isset( $_POST['pfpURL'] ) ) ) {
        
        $type = sanitize_text_field( wp_unslash( $_POST['pfpType'] ) );
        $url = esc_url_raw( wp_unslash( $_POST['pfpURL'] ) );
    } else {
        $type = sanitize_text_field( wp_unslash( $type ) );
        $url = esc_url_raw( wp_unslash( $url ) );
    }


    $func = 'benjamin_postformat_get_the_' . strtolower( $type ) . '_markup';
    
    echo call_user_func( $func, $url ); // WPCS: xss ok.

    exit();
}
add_action( 'wp_ajax_benjamin_postformat_oembed', 'benjamin_postformat_oembed' );



function benjamin_dismiss_franklin_notice() {
    $result = update_option('benjamin-franklin-notice', 'dismissed');
    echo esc_html($result);
    exit();
}
add_action( 'wp_ajax_benjamin_dismiss_franklin_notice', 'benjamin_dismiss_franklin_notice' );
