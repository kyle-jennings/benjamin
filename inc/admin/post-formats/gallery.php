<?php

class PostFormatGallery extends PostFormat {

    // register the metabox
    public static function register_meta_box()
    {
        foreach(self::$screens as $screen){
            add_meta_box(
                'post_formats_gallery',
                __('Gallery', 'benjamin'),   // WPCS: xss ok.
                array('PostFormatGallery', 'meta_box_html'),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_html($post)
    {
        wp_nonce_field('post_format_gallery_nonce', 'post_format_gallery_nonce');
        $gallery = get_post_meta($post->ID, '_post_format_gallery', true);

    ?>
        <input class="post_format_value" type="hidden" name="post_format_gallery" value="<?php echo esc_attr($gallery); ?>" />
        <p>
            <?php echo __('Select Images to add to your gallery here.', 'benjamin'); ?>
            <input type="button" value="<?php echo __('Manage Gallery', 'benjamin'); ?>" id="post_format_gallery_add" />
            <a class="gallery_remove" href="#" ><?php echo __('Remove Gallery', 'benjamin'); ?></a>

        </p>
        <div class="pfp-shortcode-holder" id="post_format_gallery_list">
            <?php echo do_shortcode('[gallery link="none" ids="'. $gallery. '"]');?>
        </div>
        <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);

        $nonce = isset( $_POST[ 'post_format_gallery_nonce'] ) 
            ? wp_verify_nonce( $_POST['post_format_gallery_nonce'], 'post_format_gallery_nonce')  // WPCS: xss ok.
            : false;
        $is_valid_nonce = $nonce ? 'true' : 'false';

        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }


        if(isset($_POST['post_format_gallery'])){
            update_post_meta($post_id, '_post_format_gallery', sanitize_text_field( wp_unslash($_POST['post_format_gallery'])) );
        }else {
            delete_post_meta($post_id, '_post_format_gallery');
        }
    }

}
