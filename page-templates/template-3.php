<?php
/*
Template Name: Template Page 3

This is a copy of the standard "page" template, but exists to allow some
deviations to standard pages

*/

get_header();

/**
 * Get all the settings needed for the the template layout
 *
 * Returns:
 * $template
 * $main_width
 * $hide_content
 * $sidebar_position
 */
extract( benjamin_template_settings() );

if ( ! $hide_content ) :
	?>

<section id="primary" class="usa-grid usa-section">

	<?php
	if ( $sidebar_position === 'left' ) {
		benjamin_get_sidebar( $template, $sidebar_position, $sidebar_size );
	}
	?>
	<div class="main-content <?php echo esc_attr( $main_width ); ?>">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/singles/content', 'page' );

		endwhile; // End of the loop.
		?>
	</div>
	<?php
	if ( $sidebar_position === 'right' ) {
		benjamin_get_sidebar( $template, $sidebar_position, $sidebar_size );
	}
	?>

</section>

	<?php
endif;


get_footer();
