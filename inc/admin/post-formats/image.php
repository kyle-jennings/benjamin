<?php

class PostFormatImage extends PostFormat {

    // register
    public static function register_meta_box()
    {
        foreach(self::$screens as $screen){
            add_meta_box(
                'post_formats_image',
                __('Image', 'benjamin'),
                array('PostFormatImage', 'meta_box_html'),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_html($post)
    {
        $url = get_post_meta($post->ID, '_post_format_image', true);
    ?>
        <div class="pfp-media-holder">
            <?php echo call_user_func('benjamin_postformat_get_the_image_markup',$url); // WPCS: xss ok. ?>
        </div>


        <a class="button pfp-js-media-library" data-media="image"
            id="post_format_image_select">
            <span class="dashicons dashicons-format-image"></span>
            Select Image
        </a>

        <span class="pfp-or-hr">or use an oembed url</span>


        <input class="post_format_value" id="post_format_image" data-media="image" name="post_format_image"  type="url"
            value="<?php echo esc_url_raw($url); ?>" />

        <a class="pfp-js-remove-media" data-media="image"
            href="#" >Remove Image</a>

        <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);

        $nonce = isset( $_POST[ 'post_format_image_nonce'] ) 
            ? wp_verify_nonce( $_POST['post_format_image_nonce'], 'post_format_image_nonce')  // WPCS: xss ok.
            : false;
        $is_valid_nonce = $nonce ? 'true' : 'false';


        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }

        if(isset($_POST['post_format_image'])){
            update_post_meta($post_id, '_post_format_image', sanitize_text_field( wp_unslash($_POST['post_format_image'])) );
        }
    }


}
