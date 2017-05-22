<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
  </div>

  <?php
  if($sidebar_position == 'right'):
      uswds_get_sidebar($template, $sidebar_position);
  endif;
  ?>

</section>

<?php
get_footer();
