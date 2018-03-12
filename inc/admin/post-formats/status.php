<?php

class PostFormatStatus extends PostFormat {

    public static $format = 'status';

    /**
     * Register the metabox
     *
     * @return void.
     */
    public static function register_meta_box()
    {
        foreach ( self::$screens as $screen ) {
            add_meta_box(
                'post_formats_status',
                __( 'Status', 'benjamin' ),
                array( 'PostFormatStatus', 'meta_box_html' ),
                $screen,
                'top',
                'default'
            );
        }
    }


    /**
     * [meta_box_html description]
     *
     * @param  wp_post $post the post object.
     * @return void       everythign is echoed.
     */
    public static function meta_box_html( $post )
    {
        
        wp_nonce_field( 'post_format_nonce_' . self::$format, 'post_format_nonce_' . self::$format );

        $value = self::meta_box_saved_value( $post->ID, self::$format, null );
    ?>
        <p>
            <label>
                <?php echo __( 'Character Count', 'benjamin' ); ?> 
                <span class="js--char-count"><?php echo esc_html( strlen( $value ) ); ?></span>
                <textarea class="js--post-format-status-textarea" 
                name="post_format_value[<?php echo esc_attr( self::$format ); ?>]"
                ><?php echo esc_attr( $value ); ?></textarea>
            </label>
        </p>
        <?php
    }


}
