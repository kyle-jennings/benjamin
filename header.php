<?php benjamin_template_settings(); ?>
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


<?php 
    $pf_include = json_decode( POST_FORMATS );
    benjamin_the_header( $pf_include );
?>


<div class="usa-overlay"></div>

<main id="main-content" role="main">