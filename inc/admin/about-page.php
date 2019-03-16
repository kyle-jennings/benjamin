<?php


/**
 * Adds a submenu item to the "appearance" menu and links to an about page
 */
function benjamin_about_theme_menu_items() {
    add_theme_page(
        'About Benjamin',
        'About Benjamin',
        'manage_options',
        'about-benjamin',
        'benjamin_about_theme_page' 
    ); 
}
add_action( 'admin_menu', 'benjamin_about_theme_menu_items' );


function benjamin_enqueue_updaatescript($hook) {

    if ($hook !== 'appearance_page_about-benjamin') {
        return;
    }

    if ( current_user_can( 'install_plugins' ) ) {
        wp_enqueue_script( 'plugin-install' );
        wp_enqueue_script( 'updates' );
    }
}
add_action('admin_enqueue_scripts', 'benjamin_enqueue_updaatescript');

/**
 * The content about the "about benjamin" page
 */
function benjamin_about_theme_page() {
    ?>
    <div class="wrap">
        <h2><?php echo esc_html__('Welcome to Benjamin', 'benjamin'); ?></h2>
        
        <?php if(!function_exists('benjamin_about_intro')) : ?>
        <p>
            <?php 
            echo esc_html__('Benjamin is a flexible and feature rich WordPess theme built with The United States Digital Services','benjamin') .
            ' <a href="https://standards.usa.gov" target="_blank">' . esc_html__('Web Design Standards','benjamin') . '</a>, ';
            echo esc_html__('by WordPress developer ', 'benjamin') . 
            '<a href="https://www.kylejennings.codes" target="_blank">' . esc_html__('Kyle Jennings', 'benjamin') . '</a>';
            ?>

        </p>
        <?php endif; ?>
        
        <?php 
            if(!function_exists('benjamin_plugin_advert')){
                echo benjamin_get_franklin_advert(); // WPCS: xss ok.
            }
        ?>

        <?php if(!function_exists('benjamin_feature_info')) : ?>
        <h2><?php echo esc_html__('Customize your site', 'benjamin'); ?></h2>
        <p><?php echo esc_html__('Use WordPress\'s Customizer to preview changes to your site\'s settings in real time. 
        Configure every part of your site\'s layout, how the homepage acts, your 404 page, your header 
        and footer, and so much more. With the Customizer, you can personalize your site and really make it yours.','benjamin');?>
        </p>
        <ul>
            <li>
                <span class="dashicons dashicons-art"></span>
                <?php echo esc_html__('Choose from 2 color schemes','benjamin'); ?>
            </li>
            <li>
                <span class="dashicons dashicons-welcome-widgets-menus"></span>
                <?php echo esc_html__('Customizable layout settings', 'benjamin'); ?>
            </li>
            <li>
                <span class="dashicons dashicons-id-alt"></span>
                <?php echo esc_html__('Template specific layout settings', 'benjamin'); ?>
            </li>
            <li>
                <span class="dashicons dashicons-layout"></span>
                <?php echo esc_html__('Sortable Pages', 'benjamin'); ?>
            </li>
            <li>
                <span class="dashicons dashicons-admin-post"></span>
                <?php echo esc_html__('Feed Featured Posts', 'benjamin'); ?>
            </li>
            <li>
                <span class="dashicons dashicons-admin-generic"></span>
                <?php echo esc_html__('Header Settings & Footer Settings', 'benjamin'); ?>
            </li>
            <li><?php echo esc_html__('And more', 'benjamin'); ?></li>
        </ul>


        <h2><?php echo esc_html__('Get Started', 'benjamin'); ?></h2>
        <a class="button button-primary button-hero load-customize hide-if-no-customize" 
            href="<?php echo esc_url(admin_url('customize.php')); ?>"><?php echo esc_html__('Customize your site', 'benjamin'); ?></a>

        <?php endif; ?>
    </div>
    <?php
}

