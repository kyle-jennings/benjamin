<div class="usa-footer-primary-section">
    <div class="usa-grid">
    <?php

        $args = array(
            'container' => 'nav',
            'container_class' => 'usa-footer-nav',
            'depth'=> 0,
            'menu_class' => 'usa-unstyled-list',
            'theme_location' => 'footer',
            'walker' => new BenjaminFooterNavbarWalker()
        );

        if( has_nav_menu('footer') )
            $args['theme_location'] = 'footer';
        elseif(wp_get_nav_menu_object( 'default-menu' ))
            $args['menu'] = 'default-menu';
        else
            benjamin_set_default_menu();

        wp_nav_menu( $args ); ?>
    </div>
</div>
