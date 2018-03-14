<?php

class PostFormatQuote extends PostFormat {

    public static $format = 'quote';


    // the markup
    public static function meta_box_html( $post )
    {
        wp_nonce_field( 'post_format_nonce_' . self::$format, 'post_format_nonce_' . self::$format );

        $value = self::meta_box_saved_value( $post->ID, self::$format,array() );

        $author = isset( $value['author'] ) ? $value['author'] : '';
        $body = isset( $value['body'] ) ? $value['body'] : '';
    ?>
        <p>
            <label>
                <?php echo __( 'Quote', 'benjamin' ); // WPCS: xss ok. ?><br />
                <textarea name="post_format_value[<?php echo esc_attr( self::$format ); ?>][body]"><?php echo esc_attr( $body ); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                <?php echo __( 'Author', 'benjamin' ); // WPCS: xss ok. ?><br />
                <input type="text" value="<?php echo esc_attr( $author ); ?>"
                 name="post_format_value[<?php echo esc_attr( self::$format ); ?>][author]"
                 placeholder="<?php echo __( 'unknown author', 'benjamin' ); // WPCS: xss ok. ?>" />
            </label>
        </p>
        <?php
    }


}
