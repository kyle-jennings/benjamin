<?php


$banner_text = stripslashes( esc_html(get_theme_mod('banner_text_setting', null) ));
$banner_read_more = stripslashes( esc_html(get_theme_mod('banner_read_more_setting', null) ));

$sidebars = wp_get_sidebars_widgets();

if(isset($sidebars['banner-widget-area']) )
    $count = count( $sidebars['banner-widget-area']);
else
    $count = 0;

?>
<!-- Gov banner BEGIN -->
<div class="usa-banner">

    <div class="usa-accordion">
        <header class="usa-banner-header">
            <div class="usa-grid usa-banner-inner">

                <p><?php echo $banner_text;  //WPCS: xss ok. ?></p>
                <?php if($count > 0): ?>
                    <button class="usa-accordion-button usa-banner-button"
                    aria-expanded="false" aria-controls="gov-banner">
                        <span class="usa-banner-button-text"><?php echo $banner_read_more; //WPCS: xss ok. ?></span>
                    </button>
                <?php endif; ?>
            </div>
        </header>  <!-- end accordion header -->

        <div class="usa-banner-content usa-grid usa-accordion-content" id="gov-banner">

            <?php if( isset($sidebars['banner-widget-area']) ): ?>
                <div class="sortable-row sortable-row--banner-widget-area cf">
                    <?php dynamic_sidebar('banner-widget-area'); ?>
                </div>
            <?php endif; ?>

        </div> <!-- end accordion content -->

    </div> <!-- end accordion -->
</div>

<!-- Gov banner END -->
