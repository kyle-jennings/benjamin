<?php

class PostFormatQuote extends PostFormat {

    // register the metabox
    public static function register_meta_box()
    {
        foreach(self::$screens as $screen){
            add_meta_box(
                'post_formats_quote',
                __('Quote', 'benjamin'),
                array('PostFormatQuote', 'meta_box_html'),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_html($post)
    {
        wp_nonce_field('post_format_quote_nonce', 'post_format_quote_nonce');
        $quote = array();
        $quote = get_post_meta($post->ID, '_post_format_quote', true);
        $author = isset($quote['author']) ? $quote['author'] : '';
        $body = isset($quote['body']) ? $quote['body'] : '';
    ?>
        <p>
            <label>
                <?php echo __('Quote', 'benjamin'); // WPCS: xss ok. ?><br />
                <textarea name="post_format_quote[body]"><?php echo esc_attr($body); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                <?php echo __('Quote', 'benjamin'); // WPCS: xss ok. ?><br />
                <input type="text" value="<?php echo esc_attr($author); ?>"
                 name="post_format_quote[author]" placeholder="<?php echo __('unknown author', 'benjamin'); ?>" />
            </label>
        </p>
        <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $nonce = isset( $_POST[ 'post_format_quote_nonce'] ) 
            ? wp_verify_nonce( sanitize_key(wp_unslash($_POST['post_format_quote_nonce'])), 'post_format_quote_nonce')  // WPCS: xss ok.
            : false;
        $is_valid_nonce = $nonce ? 'true' : 'false';


        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }

        if(isset($_POST['post_format_quote'])){
            $val = benjamin_sanitize_text_or_array_field($_POST['post_format_quote']);
            update_post_meta($post_id, '_post_format_quote', $val );
        }
    }


}
