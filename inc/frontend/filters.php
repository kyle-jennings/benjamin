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
