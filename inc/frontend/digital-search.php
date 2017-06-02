<?php

function uswds_digital_search() {
    $id = get_current_blog_id();
    $search = get_blog_option($id, 'sites-select-search');
    $search_status = $search['sites-select-search-status'];
    $search_id = $search['sites-select-search-id'];
    $search_url = $search['sites-select-search-url'];

    // if the search engine was set tp digital Search
    // and the search account was
    $use_search = ( $search_status == 'digitalgov'
                    && !empty($search_id)
                    && function_exists('sites_dashboard_select_search_install')
                )
                ? true : false ;

    // if using digital search, we have either a boutique search url,
    // or the standard url at search.usa.gov
    $spec_action = !empty($search_url)
        ?  $search_url . '/search'
        : 'http://search.usa.gov/search';

    // if using D search, we used the special url, otherwise we use the default WP url
    $action = $use_search ? $spec_action : home_url( '/' );

    // D search requires a hidden field
    $hidden = $use_search
        ? '<input id="affiliate" name="affiliate" type="hidden" value="'.$search_id.'" />'
        : '';

    // D search uses it's own name for the input field, WP uses "s"
    $name = $use_search ? 'query' : 's';

    // package up these args
    $args = array(
        'use_search' => $user_search,
        'action' => $action,
        'hidden' => $hidden,
        'name' => $name
    );

    return $args;
}
