<div class="usa-footer-primary-section">
    <div class="usa-grid">
    <?php
        $args = array(
            'container' => 'nav',
            'container_class' => 'usa-footer-nav',
            'depth'=> 0,
            'menu_class' => 'usa-unstyled-list',
            'theme_location' => 'footer',
            'walker' => new FooterNavbarWalker()
        );
        wp_nav_menu( $args ); ?>
    </div>
</div>
