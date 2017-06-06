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

$template = benjamin_template_settings('template');
$sidebar_position = get_theme_mod($template . '_sidebar_position_setting');
$main_width = benjamin_get_main_width($sidebar_position);
$main_width .= ' ' . benjamin_get_width_visibility($template, $sidebar_position);


if( !benjamin_hide_layout_part('page-content', $template) ):
?>


<section id="primary" class="usa-grid usa-section">
    <?php
        if($sidebar_position == 'left'):
            benjamin_get_sidebar($template, $sidebar_position);
        endif;
    ?>

    <div class="<?php echo $main_width; ?>">
    	<?php benjamin_page_sortables('frontpage_sortables_setting') ;?>
    </div>

    <?php
        if($sidebar_position == 'right'):
          benjamin_get_sidebar($template, $sidebar_position);
        endif;
    ?>

</section>

<?php
endif;

get_footer();
