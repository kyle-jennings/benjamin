<?php

uswds_template_settings();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


<a class="usa-skipnav" href="#primary">
    <?php esc_html_e( 'Skip to main content', 'uswds' ); ?>
</a>


<div class="usa-overlay"></div>

<main id="main-content" role="main">

<?php
    $order = json_decode(get_theme_mod('header_order_setting'));

    $order = $order ? $order : uswds_default_header_order();

    foreach($order as $component):
        switch($component->name):
            case 'banner':
                get_template_part('components/section', 'banner');
                break;
            case 'navbar':
                get_template_part('components/navbars/navbar');
                break;
            case 'hero':
                 get_template_part( 'components/section', 'hero' );
                break;
        endswitch;
    endforeach;
