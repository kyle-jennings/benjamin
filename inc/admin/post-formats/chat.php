<?php

class PostFormatChat extends PostFormat {

    // register the meta box
    public static function register_meta_box()
    {
        foreach(self::$screens as $screen){
            add_meta_box(
                'post_formats_chat',
                __('Chat', 'benjamin'),
                array('PostFormatChat', 'meta_box_html'),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_html($post)
    {
        wp_nonce_field('post_format_chat_nonce', 'post_format_chat_nonce');
        $chat = get_post_meta($post->ID, '_post_format_chat', true);
        // $chat = array();
        wp_localize_script('post_formats_js', 'chat', $chat);
    ?>
        <div class="chat-log cf" id="post_format_chat_log"></div>
    <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST[ 'post_format_chat_nonce' ]) && wp_verify_nonce($_POST['post_format_chat_nonce'], 'post_format_chat_nonce')) ? 'true' : 'false';

        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }

        if(isset($_POST['post_format_chat'])){

            update_post_meta($post_id, '_post_format_chat', $_POST['post_format_chat']);
        }else{
            delete_post_meta($post_id, '_post_format_chat');

        }
    }

}
