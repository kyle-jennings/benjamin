<?php
/**
 * The front page template file
 *
 * It is used to display the front page of the website.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Benjamin
 */


get_header();

$template = uswds_template_settings('template');
$sidebar_position = get_theme_mod($template . '_sidebar_position_setting');

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
    	<?php uswds_page_sortables('frontpage_section_setting') ;?>
    </div>

    <?php
        if($sidebar_position == 'right'):
          uswds_get_sidebar($template, $sidebar_position);
        endif;
    ?>

</section>

<?php
get_footer();
