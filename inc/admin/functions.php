<?php


/**
 * Recursive sanitation for text or array
 *
 * @author https://wordpress.stackexchange.com/a/255861/19536
 * @param $val (array|string)
 * @since  0.1
 * @return mixed
 */
function benjamin_sanitize_text_or_array_field( $val ) {
    
    if ( is_string( $val ) ) {
        $val = sanitize_text_field( wp_unslash( $val ) );
    } elseif ( is_array( $val ) ) {
        foreach ( $val as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = benjamin_sanitize_text_or_array_field( $value );
            } else {
                $value = sanitize_text_field( wp_unslash( $value ) );
            }
        }
    }

    return $val;
}
