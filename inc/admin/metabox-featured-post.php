<?php



function benjamin_featured_post_metabox_markup($post) {
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
    $featured_post = get_option('featured-post--'.$post->post_type, null);
    $checked = ($post->ID === $featured_post) ? 'checked' : '';

?>

    <p>
        Marks this post as the "featured post" in the
        <b><?php echo $post->post_type; ?></b> feed.
    </p>
    <label for="featured-post--<?php echo $post->post_type; ?>">Feature this post?</label>
    <input name="featured-post--<?php echo $post->post_type; ?>" type="checkbox" value="true" <?php echo $checked; ?>>

<?php
}



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



function benjamin_save_featured_post($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    if($post->post_type == 'revision')
        return $post_id;

    $meta_box_text_value = "";
    $meta_box_dropdown_value = "";
    $meta_box_checkbox_value = "";

    if(isset($_POST['featured-post--'.$post->post_type]))
        update_option('featured-post--'.$post->post_type, $post_id);
    elseif(!isset($_POST['featured-post--'.$post->post_type]) && $post_id == get_option('featured-post--'.$post->post_type, true))
        delete_option('featured-post--'.$post->post_type);

}

add_action("save_post", "benjamin_save_featured_post", 10, 3);
