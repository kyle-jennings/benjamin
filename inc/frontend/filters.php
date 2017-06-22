<?php
function archive_link_wpse_183665($link) {

    $find = array(
        '</a>',
        '</li>'
    );

    $replace = array(
        '',
        '</a></li>'
    );

    $link = str_replace($find, $replace, $link);
    return $link;
}
add_filter( 'get_archives_link', 'archive_link_wpse_183665' );



/**
 * [$output description]
 * @var string
 */
add_filter('wpcf7_form_response_output', function($output, $class, $content, $cf7) {
    $output = '';

    $output .= '<div class="usa-alert wpcf7-response-output wpcf7-display-none">';
        $output .= $content;
    $output .= '</div>';

    return $output;
}, 10, 4);
