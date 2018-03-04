<?php

class PostFormatLink extends PostFormat {


    // register the metabox
    public static function register_meta_box()
    {
        foreach(self::$screens as $screen){
            add_meta_box(
                'post_formats_link',
                __('Link', 'benjamin'),
                array('PostFormatLink', 'meta_box_html'),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_html($post)
    {
        wp_nonce_field('post_format_link_nonce', 'post_format_link_nonce');
        $linkURL = get_post_meta($post->ID, '_post_format_link_url', true);
        $linkText = get_post_meta($post->ID, '_post_format_link_text', true);
        ?>
        <div class="link-box">
            <p>
                <label>
                    <?php echo __('Link Text', 'benjamin'); // WPCS: xss ok. ?>
                    <input type="text" value="<?php echo esc_attr($linkText); ?>" name="post_format_link_text" />
                </label>
            </p>
            <p>
                <label>
                    <?php echo __('Link URL', 'benjamin'); // WPCS: xss ok. ?>
                    <input type="text" value="<?php echo esc_attr($linkURL); ?>" name="post_format_link_url" />
                </label>
            </p>
            <a class="pfp-js-remove-link" href="#">Remove Link</a>
        </div>
        <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        
        $nonce = isset( $_POST[ 'post_format_link_nonce'] ) 
            ? wp_verify_nonce( $_POST['post_format_link_nonce'], 'post_format_link_nonce')  // WPCS: xss ok.
            : false;
        $is_valid_nonce = $nonce ? 'true' : 'false';


        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }

        if(isset($_POST['post_format_link_url'])){
            update_post_meta($post_id, '_post_format_link_url', sanitize_text_field( wp_unslash( $_POST['post_format_link_url'])) );
        }else {
            delete_post_meta($post_id, '_post_format_link_url');
        }

        if(isset($_POST['post_format_link_text'])){
            update_post_meta($post_id, '_post_format_link_text', sanitize_text_field( wp_unslash( $_POST['post_format_link_text'])) );
        }else {
            delete_post_meta($post_id, '_post_format_link_text');
        }
    }


}
