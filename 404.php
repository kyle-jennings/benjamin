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

$main_width = uswds_get_main_width($sidebar_position);
$main_width .= ' ' . uswds_get_width_visibility($template, $sidebar_position);

if( !uswds_hide_layout_part('page-content', $template) ):
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

            echo '<br>';
            echo '<br>';
            echo '<br>';

			the_widget( 'USWDS_Widget_Pages', array('title'=>'Pages') );

		?>
  </div>

  <?php
  if($sidebar_position == 'right'):
      uswds_get_sidebar($template, $sidebar_position);
  endif;
  ?>
</section>

<?php
endif;
get_footer();
