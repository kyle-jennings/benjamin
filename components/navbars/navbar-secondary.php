<?php
$logo_tag = is_front_page() ? 'h1' : 'em';
?>
<div class="usa-nav-container">
    <nav class="site-nav-secondary cf usa-grid">
        <?php if(get_theme_mod('navbar_brand_setting') == 'secondary-navbar' ): ?>
        <div class="usa-width-one-third usa-brand-wrapper">
            <div class="usa-logo" id="logo">
                <<?php echo $logo_tag; ?> class="usa-logo-text">
                <a href="<?php echo get_site_url(); ?>" ><?php bloginfo( 'name' ); ?></a>
                </<?php echo $logo_tag; ?>>
            </div>

        </div>
        <?php endif;?>

        <div class="usa-site-nav-secondary__widgets usa-width-two-thirds">
        <?php
            $search = get_theme_mod('navbar_search_setting');
            $width = ($search == 'secondary-navbar') ? 'usa-width-one-third' : 'usa-width-one-half'
        ?>
            <div class="<?php echo $width; ?>">
                <a class="usa-button" href="/getting-started/download/" onclick="ga('send', 'event', 'Downloaded code and design files', 'Clicked Download code and design files from inside site');">
                    Download code and design files
                </a>
            </div>
            <div class="<?php echo $width; ?>">
                <a class="usa-button" href="/getting-started/download/" onclick="ga('send', 'event', 'Downloaded code and design files', 'Clicked Download code and design files from inside site');">
                    Download code and design files
                </a>
            </div>

            <?php if($search == 'secondary-navbar' ): ?>
                <form class="usa-search usa-search-small usa-width-one-third">
                    <div role="search">
                        <label class="usa-sr-only" for="search-field-small">Search small</label>
                        <input id="search-field-small" type="search" name="search">
                        <button type="submit">
                            <span class="usa-sr-only">Search</span>
                        </button>
                    </div>
                </form>
            <?php endif;?>


        </div> <!-- end widgets -->
    </nav> <!-- site-nav-secondary -->

</div> <!-- end container -->
