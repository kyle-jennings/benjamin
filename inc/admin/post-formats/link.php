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
        $quote = array();
        $quote = get_post_meta($post->ID, '_post_format_link', true);
        $text = isset($quote['text']) ? $quote['text'] : '';
        $url = isset($quote['url']) ? $quote['url'] : '';
    ?>
        <p>
            <label>
                <?php echo __('URL', 'benjamin'); // WPCS: xss ok. ?><br />
                <textarea name="post_format_link[url]"><?php echo esc_attr($url); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                <?php echo __('Text', 'benjamin'); // WPCS: xss ok. ?><br />
                <input type="text" value="<?php echo esc_attr($text); ?>" name="post_format_link[text]"
                 placeholder="<?php echo __('click here', 'benjamin'); ?>"/>
            </label>
        </p>
        <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $nonce = isset( $_POST[ 'post_format_link_nonce'] ) 
            ? wp_verify_nonce( sanitize_key(wp_unslash($_POST['post_format_link_nonce'])), 'post_format_link_nonce')  // WPCS: xss ok.
            : false;
        $is_valid_nonce = $nonce ? 'true' : 'false';


        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }

        if(isset($_POST['post_format_link'])){
            $val = benjamin_sanitize_text_or_array_field($_POST['post_format_link']);
            update_post_meta($post_id, '_post_format_link', $val );
        }
    }


}
