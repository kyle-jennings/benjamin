<?php

class PostFormatStatus extends PostFormat {


    // register the metabox
    public static function register_meta_box()
    {
        foreach(self::$screens as $screen){
            add_meta_box(
                'post_formats_status',
                __('Status', 'benjamin'),
                array('PostFormatStatus', 'meta_box_html'),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_html($post)
    {
        wp_nonce_field('post_format_status_nonce', 'post_format_status_nonce');
        $statusBody = get_post_meta($post->ID, '_post_format_status_body', true);
    ?>
        <p>
            <label>
                <?php echo __('Status', 'benjamin'); // WPCS: xss ok. ?><br />
                <textarea name="post_format_status_body"><?php echo esc_attr($statusBody); ?></textarea>
            </label>
        </p>
        <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $nonce = isset( $_POST[ 'post_format_status_nonce'] ) 
            ? wp_verify_nonce( $_POST['post_format_status_nonce'], 'post_format_status_nonce')  // WPCS: xss ok.
            : false;
        $is_valid_nonce = $nonce ? 'true' : 'false';

        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }

        if(isset($_POST['post_format_status_body'])){
            update_post_meta($post_id, '_post_format_status_body', sanitize_textarea_field($_POST['post_format_status_body']) );
        }
    }


}
