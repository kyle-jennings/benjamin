<?php

benjamin_template_settings();

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
    <?php esc_html_e( 'Skip to main content', 'benjamin' ); ?>
</a>


<div class="usa-overlay"></div>

<main id="main-content" role="main">

<?php
    $template = benjamin_template_settings('template');

    $layout_settings = get_theme_mod($template.'_page_layout_setting', '[]');
    $layout_settings = json_decode($layout_settings);

    $order = json_decode(get_theme_mod('header_order_setting'));
    $order = $order ? $order : benjamin_default_header_order();

    foreach($order as $component):
        if($layout_settings && in_array($component->name, $layout_settings))
            continue;
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
