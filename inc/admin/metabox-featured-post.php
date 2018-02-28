<?php


/**
 * The checkbox markup for marking a post as "featured"
 */
function benjamin_featured_post_metabox_markup($post) {

    $featured_post = get_option('featured-post--'.$post->post_type, null);
    $checked = ($post->ID === $featured_post) ? 'checked' : '';

    $output = '';

    $output .= '<p>';
        /* translators: marks post as "featured" */
        $output .= sprintf( __('Marks this post as the "featured post" in the <b> %s </b> feed.', 'benjamin'), esc_html($post->post_type) );
    $output .= '</p>';

    $output .= '<label for="featured-post--' . esc_attr($post->post_type) . '"> '. __('Feature this post?', 'benjamin') . ' </label>';
    $output .= '<input name="featured-post--' . esc_attr($post->post_type) . '" 
        type="checkbox" value="true" '. esc_html($checked) . ' >';

    echo $output; //WPCS: xss ok.
}


/**
 * Adds the metabox for making a post "featured"
 * @return [type] [description]
 */
function benjamin_featured_post_metabox() {
    $args = array(
       'public'   => true,
       'publicly_queryable' => true,
       '_builtin' => false
    );
    $cpts = get_post_types($args);
    array_push($cpts, 'post');

    add_meta_box(
        'featured_post',
        'Featured Post',
        'benjamin_featured_post_metabox_markup',
        $cpts,
        'side',
        'high',
        null
    );
}
add_action( 'add_meta_boxes', 'benjamin_featured_post_metabox' );



/**
 * Saves the featured post setting to the DB
 * 
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
function benjamin_save_featured_post($post_id, $post) {


    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    if($post->post_type == 'revision')
        return $post_id;


    // if the post has been stickies, remove that flag and apply our flag
    if( $post->post_type == 'post' && isset( $_POST['sticky'] ) ) {
        unset( $_POST['sticky'] );
        update_option('featured-post--'.$post->post_type, $post_id);
    } elseif( isset($_POST['featured-post--'.$post->post_type]) ) {
        update_option('featured-post--'.$post->post_type, $post_id);

    } elseif( !isset($_POST['featured-post--'.$post->post_type])
        && $post_id == get_option('featured-post--'.$post->post_type, true)
    ) {
        delete_option('featured-post--'.$post->post_type);
    }

}

add_action("save_post", "benjamin_save_featured_post", 10, 3);
