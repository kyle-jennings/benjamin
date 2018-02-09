<?php


/**
 * Adds values for the columns - trying to make this as dynamic as possible
 * Possible column types are: ACF value, Taxonomy (sorting), custom function
 * @param  array $columns default WP columns
 */
function benjamin_custom_column_data( $column ) {
    global $post;

    $id = get_option('featured-post--'.$post->post_type, null);

    if($post->ID == $id )
        echo '<span class="dashicons dashicons-star-filled"></span>';
}


/**
 * Merge the columns - adds X number of columns with headers
 * @param  array $columns default WP columns
 * @return array          new columns
 */
function benjamin_add_columns($columns){
    global $post_type;


    $new = array('featured' => __('Featured', 'benjamin'), 'date' => __('Date', 'benjamin') );
    array_pop($columns);

    return array_merge( $columns, $new);
}



/**
 * Set the columns to add per post type
 * two things happen here:
 * 1 - we loop through the post types array and add the columns for each
 * 2 - if an arg is provided, we return the columns for the specfied post type
 * 3 - remove all unwanted columns
 *
 * @param  string $return_columns [name of the post type]
 * @return array                 the columns for specified post type
 */
function benjamin_manage_columns( ){

    // compile list of post types to add the featured post column on
    $post_types = array('posts' => array(
        'label' => '',
        'description' => '' 
    ) );
    $post_types += benjamin_get_cpts();

    // loop through post types and call the merge column function
    foreach( $post_types as $post_type => $v){
        $post_type = ($post_type !== 'posts') ? '_'  : '';

        add_filter('manage_' . $post_type . 'posts_columns' , 'benjamin_add_columns');
    }
};
add_action('init', 'benjamin_manage_columns');
add_action('manage_posts_custom_column' , 'benjamin_custom_column_data' );