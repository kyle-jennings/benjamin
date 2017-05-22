<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
    	<?php
    	while ( have_posts() ) : the_post();

    		get_template_part( 'template-parts/content', 'page' );


    	endwhile; // End of the loop.
    	?>
    </div>
    <?php
    if($sidebar_position == 'right'):
        uswds_get_sidebar($template, $sidebar_position);
    endif;
    ?>

</section>

<?php
get_footer();
