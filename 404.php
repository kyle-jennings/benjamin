<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'uswds' ); ?></p>

		<?php
			get_search_form();

			the_widget( 'WP_Widget_Recent_Posts' );

			// Only show the widget if site has multiple categories.
			if ( uswds_categorized_blog() ) :
		?>

		<div class="widget widget_categories">
			<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'uswds' ); ?></h2>
			<ul>
			<?php
				wp_list_categories( array(
					'orderby'    => 'count',
					'order'      => 'DESC',
					'show_count' => 1,
					'title_li'   => '',
					'number'     => 10,
				) );
			?>
			</ul>
		</div><!-- .widget -->

		<?php
			endif;

			/* translators: %1$s: smiley */
			$archive_content = '<p>' .
            sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'uswds' ), convert_smilies( ':)' ) ) . '</p>';
			the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

			the_widget( 'WP_Widget_Tag_Cloud' );
		?>
  </div>

  <?php
  if($sidebar_position == 'left'):
      uswds_get_sidebar($template, $sidebar_position);
  endif;
  ?>
</section>

<?php
get_footer();
