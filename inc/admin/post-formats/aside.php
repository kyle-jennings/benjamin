<?php

class PostFormatAside extends PostFormat {

    // reigster the metabox
    public static function register_meta_box()
    {

        foreach(self::$screens as $screen){
            add_meta_box(
                'post_formats_aside',
                __('Aside', 'benjamin'),
                array('PostFormatAside', 'meta_box_html'),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_html($post)
    {

        wp_nonce_field('post_format_aside_nonce', 'post_format_aside_nonce');
        $asideBody = get_post_meta($post->ID, '_post_format_aside_body', true);
    ?>
        <p>
            <label>
                <?php esc_attr_e('Aside Body', 'benjamin'); ?><br />
                <textarea name="post_format_aside_body"><?php echo esc_attr($asideBody); ?></textarea>
            </label>
        </p>
        <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);

        $nonce = isset( $_POST[ 'post_format_aside_nonce'] ) 
            ? wp_verify_nonce( $_POST['post_format_aside_nonce'], 'post_format_aside_nonce')  // WPCS: xss ok.
            : false;

        $is_valid_nonce = $nonce ? 'true' : 'false';

        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }


        if(isset($_POST['post_format_aside_body'])){
            update_post_meta($post_id, '_post_format_aside_body', sanitize_text_field( wp_unslash($_POST['post_format_aside_body'])) );  // WPCS: xss ok.
        }
    }

}
