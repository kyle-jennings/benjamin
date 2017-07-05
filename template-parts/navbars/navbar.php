<?php
$sticky = get_theme_mod('navbar_sticky_setting', 'no') == 'yes' ? 'sticky' : '';
?>
<header class="usa-header usa-header-basic
    <?php echo benjamin_navbar_header_class() . ' ' . $sticky ; ?>" role="banner">
    <div class="usa-nav-container">

        <div class="usa-navbar">
            <button class="usa-menu-btn">Menu</button>
            <?php benjamin_navbar_brand(); ?>
        </div>

        <nav role="navigation" class="usa-nav">
            <button class="usa-nav-close"></button>

            <?php
                $args =  array(
                    'container' => '',
                    'menu_class'     => 'usa-nav-primary usa-accordion',
                    'walker' => new BenjaminNavbarWalker()
                );

             if( has_nav_menu('primary') )
                $args['theme_location'] = 'primary';
             elseif(wp_get_nav_menu_object( 'default-menu' ))
                $args['menu'] = 'default-menu';
             else
                benjamin_set_default_menu();

             wp_nav_menu( $args );
            ?>

            <?php if(get_theme_mod('navbar_search_setting', 'none') == 'navbar' ): ?>
            <form class="usa-search usa-search-small">
                <div role="search">
                    <label class="usa-sr-only" for="search-field-small">Search small</label>
                    <input id="search-field-small" type="search" name="search">
                    <button type="submit">
                        <span class="usa-sr-only">Search</span>
                    </button>
                </div>
            </form>
            <?php endif;?>
        </nav>
    </div>

</header>
