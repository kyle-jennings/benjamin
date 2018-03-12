<?php

class PostFormatChat extends PostFormat {

    public static $format = 'chat';
    
    // register the meta box
    public static function register_meta_box()
    {
        foreach ( self::$screens as $screen ) {
            add_meta_box(
                'post_formats_chat',
                __( 'Chat', 'benjamin' ),
                array( 'PostFormatChat', 'meta_box_html' ),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_html( $post )
    {
        wp_nonce_field( 'post_format_nonce_' . self::$format, 'post_format_nonce_' . self::$format );

        $value = self::meta_box_saved_value( $post->ID, self::$format, null );

        wp_localize_script( 'post_formats_js', 'chat', $value );
    ?>
        <div class="chat-log cf" id="post_format_chat_log"></div>
    <?php
    }



}
