<?php
$logo_tag = is_front_page() ? 'h1' : 'em';
?>
<header class="usa-header usa-header-basic <?php echo uswds_navbar_header_class(); ?>" role="banner">
    <div class="usa-nav-container">

        <div class="usa-navbar">
            <button class="usa-menu-btn">Menu</button>
            <?php if(get_theme_mod('navbar_brand_setting') == 'navbar' ): ?>
            <div class="usa-logo" id="logo">
                <<?php echo $logo_tag; ?> class="usa-logo-text">
                    <a href="<?php echo get_site_url(); ?>" ><?php bloginfo( 'name' ); ?></a>
                </<?php echo $logo_tag; ?>>
            </div>
            <?php endif; ?>
        </div>

        <nav role="navigation" class="usa-nav">
            <button class="usa-nav-close">

            </button>


            <?php
                $args =  array(
                    'container' => '',
                    'menu_class'     => 'usa-nav-primary usa-accordion',
                    'walker' => new NavbarWalker()
                );

             if( has_nav_menu('primary') )
                 $args['theme_location'] = 'primary';
             else
                 $args['menu'] = 'default-menu';

             wp_nav_menu( $args );
            ?>

            <?php if(get_theme_mod('navbar_search_setting') == 'navbar' ): ?>
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
