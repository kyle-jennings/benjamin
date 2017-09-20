<?php
/**
 * The markup for the featured image meta box
 */
function benjamin_featured_video_metabox_markup($post) {

    $url = get_post_meta($post->ID, 'featured-video', true);
    $video = '';

    if($url){
      $video = benjamin_get_the_video_markup($url);
    }
?>
    <div class="js--media-wrapper">
        <div class="js--placeholder">
            <?php echo $video; // WPCS: xss ok. ?>
        </div>
        <label for="featured-video">
            <a class="button js--media-library" data-filter="video">
                <span class="dashicons dashicons-video-alt3"></span>
                Set featured video
            </a>

            <a class="button js--clear-video">
                <span class="dashicons dashicons-no-alt"></span>
            </a>
        </label>
        <span class="use-url"> - or use YouTube -</span>
        <input class="js--video-url" name="featured-video"
            type="text" value="<?php echo esc_url($url); ?>">

    </div>

    <input name="save" type="submit" class="button button-primary button-large" id="publish" value="Update">
<?php
}



/**
 * Register the featured image metabox
 * @return [type] [description]
 */
function benjamin_featured_video_metabox() {
    $args = array(
       'public'   => true,
       'publicly_queryable' => true,
       '_builtin' => false
    );
    $cpts = get_post_types($args);
    array_push($cpts, 'post', 'page');
    add_meta_box(
        'featured_video',
        'Featured Video',
        'benjamin_featured_video_metabox_markup',
        $cpts,
        'side',
        'low',
        null
    );
}
add_action( 'add_meta_boxes', 'benjamin_featured_video_metabox' );



/**
 * The save function for the featured image
 * @param  [type] $post_id [description]
 * @param  [type] $post    [description]
 * @param  [type] $update  [description]
 * @return [type]          [description]
 */
function benjamin_save_featured_video($post_id, $post, $update) {

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    if($post->post_type == 'revision')
        return $post_id;


    $url = isset($_POST['featured-video']) ? esc_url_raw( wp_unslash($_POST['featured-video']) ) : null;
    if( filter_var($url, FILTER_VALIDATE_URL) ) {

        // if local - Check for .mp4 or .mov format, which
        // (assuming h.264 encoding) are the only cross-browser-supported formats.
        // if( strpos($url, home_url()) !== false && benjamin_validate_local_video($url) ) {
        //     update_post_meta($post_id, 'featured-video', $url);
        // } elseif( preg_match( '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $url ) ) {
        // }


        update_post_meta($post_id, 'featured-video', $url);
    } else{
        delete_post_meta($post_id, 'featured-video');
    }


}
add_action("save_post", "benjamin_save_featured_video", 10, 3);


/**
 * I guess this ensures the video is local, dont rememeber where this is used
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function benjamin_validate_local_video($url) {
    global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));
    $id = $attachment[0];

    $video = get_attached_file( absint( $id ) );
    $size = filesize( $video );
    if ( 8 < $size / pow( 1024, 2 ) ) { // Check whether the size is larger than 8MB.
        return false;
    }


    if('.mp4' == substr( $url, -4 ) || '.mov' == substr( $url, -4 )  || '.webm' == substr( $url, -5 ))
        return true;

    return false;
}
