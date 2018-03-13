<?php

class PostFormatAside extends PostFormat {

    public static $format = 'aside';


    // the markup
    public static function meta_box_html( $post )
    {

        wp_nonce_field( 'post_format_nonce_' . self::$format, 'post_format_nonce_' . self::$format );

        $value = self::meta_box_saved_value( $post->ID, self::$format, null );
    ?>
        <p>
            <label>
                <?php esc_attr_e( 'Aside Body', 'benjamin' ); ?><br />
                <textarea name="post_format_aside"><?php echo esc_attr( $value ); ?></textarea>
            </label>
        </p>
        <?php
    }


}
