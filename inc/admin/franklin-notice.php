<?php


/**
 * Markup for the franklin notice
 */
function benjamin_get_franklin_advert($dismissable = 'not-dismissable') {

    $plugin = 'franklin/franklin.php';
    $output = '';

    if( is_plugin_active($plugin) ||
        !current_user_can( 'install_plugins' ) || 
        !current_user_can( 'update_plugins' )
        // !in_array($screen->id, array('plugins', 'dashboard'))
    ) {
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
    
    
 
    $output .= '<div class="franklin-notice">';
        
        if($dismissable == 'dismissable') {
        $output .= '<a href="#" class="notice-dismiss franklin-notice__dismiss js--dismiss-franklin-notice">';
            $output .= '<span class="screen-reader-text"> Dismiss </span>';
        $output .= '</a>';
        }

        $output .= '<div class="franklin-notice__inner">';
            $output .= '<h3 class="franklin-notice__title">';
                $output .= esc_html__('Introducing Franklin', 'benjamin'); // WPCS: xss ok.
            $output .= '</h3>';
            $output .= '<h5 class="franklin-notice__sub-title">A companion plugin to the Benjamin theme</h5>';
            $output .= '<p>';

                $output .= esc_html__('Franklin enhances the Benjamin theme with frequent updates, and adds additonal features like:', 'benjamin'); // WPCS: xss ok.
            $output .= '</p>';
            $output .= '<ul class="franklin-notice__features">';
                $output .= '<li>'. esc_html__('UI Components shortcodes', 'benjamin') .'</li>';
                $output .= '<li>'. esc_html__('Post Formats', 'benjamin') .'</li>';
                $output .= '<li>'. esc_html__('Access to Digital Search', 'benjamin') .'</li>';
                $output .= '<li>'. esc_html__('More color schemes coming soon', 'benjamin') .'</li>';
                $output .= '<li>'. esc_html__('And more!', 'benjamin') .'</li>';
            $output .= '</ul>';
            
            $output .= '<p>';
                $output .= '<a href="https://wordpress.org/plugins/franklin/" target="_blank">';
                    $output .=  esc_html__('Click here', 'benjamin');
                $output .= '</a>';
                $output .=  esc_html__(' to learn more, or install and activate now.','benjamin');
            $output .= '</p>';

            $output .= '<a class="button button-primary franklin-notice__button js--install-activate-franklin" href="' . esc_url($btn_url) .'">';
                $output .= sprintf(
                    // translators: Either "install Now or Activate. See lines 46 and 51"
                    esc_html(__('%s ', 'benjamin')),
                    esc_html($btn_text)
                );
            $output .= '</a>';

            if($dismissable == 'dismissable') {
            $output .= '<a class="button button-ghost franklin-notice__button js--dismiss-franklin-notice" href="#">';
                $output .= __('Don\'t show this again', 'benjamin');
            $output .= '</a>';
            }

        $output .= '</div>';
    $output .= '</div>';

    return $output;
}


// get the markup for the franklin advert
function benjamin_franklin_advert($dismissable = 'not-dismissable') {
    echo benjamin_get_franklin_advert($dismissable); // WPCS: xss ok.
}


/**
 * [benjamin_franklin_notice description]
 * @return [type] [description]
 */
function benjamin_franklin_notice(){
    $option = get_option('benjamin-franklin-notice', false);
    $screen = get_current_screen();

    if( $option == 'dismissed' ||
        !in_array($screen->id, array('plugins', 'dashboard'))
    ) {
        return;
    }

    benjamin_franklin_advert('dismissable');
    
}
add_action( 'admin_notices', 'benjamin_franklin_notice' );

