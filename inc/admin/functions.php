<?php


/**
 * Recursive sanitation for text or array
 *
 * @author https://wordpress.stackexchange.com/a/255861/19536
 * @param $val (array|string)
 * @since  0.1
 * @return mixed
 */
function benjamin_sanitize_text_or_array_field( $val ) {
    
    if ( is_string( $val ) ) {
        $val = sanitize_text_field( wp_unslash( $val ) );
    } elseif ( is_array( $val ) ) {
        foreach ( $val as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = benjamin_sanitize_text_or_array_field( $value );
            } else {
                $value = sanitize_text_field( wp_unslash( $value ) );
            }
        }
    }

    return $val;
}



function benjamin_franklin_advert() {
    $plugin = 'franklin/franklin.php';

    if( is_plugin_active($plugin) ||
        !current_user_can( 'install_plugins' ) || 
        !current_user_can( 'update_plugins' ) )  
    {
        return;
    }
    
    $plugin_dir = WP_PLUGIN_DIR . '/franklin/franklin.php';
    $img = get_template_directory_uri() . '/assets/admin/img/banner-772x250.jpg';

    if(!is_readable($plugin_dir)) {
        $btn_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=franklin'), 'install-plugin_franklin');
        $btn_text = 'Install Now';
    } else {

        $btn_url = admin_url('plugins.php?action=activate&plugin=' . $plugin . '&plugin_status=all&paged=1&s');
        $btn_url = wp_nonce_url($btn_url, 'activate-plugin_' . $plugin);
        $btn_text = 'Activate';
    }
    
    
    ?>
    <div class="franklin-notice">
        <div class="franklin-notice__inner">
            <h3 class="franklin-notice__title">
                <?php echo __('Install Franklin', 'benjamin'); ?>
            </h3>
            <p>
                <?php echo __('Please in Benjamin\'s companion plugin to add additonal features like:', 'benjamin'); ?>
            </p>
            <ul class="franklin-notice__features">
                <li><?php echo __('UI Components shortcodes', 'benjamin'); ?></li>
                <li><?php echo __('Post Formats', 'benjamin'); ?></li>
                <li><?php echo __('Access to Digital Search', 'benjamin'); ?></li>
                <li><?php echo __('And more!', 'benjamin'); ?></li>
            </ul>
            
            <p>
                <a href="https://wordpress.org/plugins/franklin/" target="_blank"><?php echo __('Click here', 'benjamin'); ?></a> 
                <?php echo __(' to learn more, or install and activate now.','benjamin'); ?>
            </p>

            <a class="button button-primary franklin-notice__button js--install-activate-franklin" href="<?php echo esc_url($btn_url)?>">
                <?php echo sprintf(
                        __('%s', 'benjamin'),
                        $btn_text  
                    )
                ?>
            </a>
        </div>
    </div>
    <?php
}

add_action( 'admin_notices', 'benjamin_franklin_advert' );
