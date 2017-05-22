<?php
/*
Template Name: Widgetized Page

This template is used to display 3 rows of widgets, allowing users to have a
modular and customizable page as opposed to just showing text.

*/

get_header();


$template = uswds_template_settings('template');
$sidebar_position = get_theme_mod($template . '_sidebar_position_setting');
// examine($template .':'. $sidebar_position);
$main_width = ($sidebar_position == 'none' || !$sidebar_position)
        ? FULL_WIDTH : TWO_THIRDS;
$main_width .= ' ' . uswds_get_width_visibility($template, $sidebar_position);
?>


<section id="primary" class="usa-grid usa-section">
    <?php
        if($sidebar_position == 'left'):
            uswds_get_sidebar($template, $sidebar_position);
        endif;
    ?>

    <div class="<?php echo $main_width; ?>">
    <?php uswds_page_sortables('widgetized_section_setting') ;?>
    </div>

    <?php
        if($sidebar_position == 'right'):
          uswds_get_sidebar($template, $sidebar_position);
        endif;
    ?>

</section>

<?php
get_footer();
