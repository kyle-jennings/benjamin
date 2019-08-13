<?php
/*
Template Name: Template Page 4

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
		<h1>IC3 Quiz</h1>
		<form action="<?php echo esc_attr( admin_url('admin-post.php') ); ?>" method="POST">
			<input type="hidden" name="action" value="save_ic3_form" />

			<div>
				<p>Are you reporting on behalf of a business?</p>
				<input type="radio" name="business-report" id='business-yes' value="true">
				<label for="business-yes">Yes</label>
  			<input type="radio" name="business-report" id="business-no" value="false">
				<label for="business-no">No</label>
			</div>
			<div>
				<p>Please describe the incident in your own words.</p>
				<textarea></textarea>
			</div>

			<div>
				<p>What is your username?</p>
				<input type="text">
			</div>

			<input type="submit" value="submit" />
		</form>

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
