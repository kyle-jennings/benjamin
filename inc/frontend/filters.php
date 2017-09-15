<?php
function benjamin_archive_link($link) {

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
add_filter( 'get_archives_link', 'benjamin_archive_link' );
