<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Benjamin
 */

get_header();

$template = benjamin_template_settings('template');
$sidebar_position = get_theme_mod($template . '_sidebar_position_setting');

$main_width = benjamin_get_main_width($sidebar_position);
$main_width .= ' ' . benjamin_get_width_visibility($template, $sidebar_position);

$content = get_theme_mod('404_page_content_setting', 'default');


if( !benjamin_hide_layout_part('page-content', $template) ):
?>

<section id="primary" class="usa-grid usa-section">
    <?php
    if($sidebar_position == 'left'):
        benjamin_get_sidebar($template, $sidebar_position);
    endif;
    ?>

  <div class="<?php echo $main_width; ?>">
        <?php

            if($content == 'page' && $pid = get_theme_mod('404_page_select_setting') ):

                $page = get_page($pid);
                echo $page->post_content;
            else :
                echo '<p>' . esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'benjamin' ) . '</p>';

                get_search_form();

                echo '<br>';
                echo '<br>';
                echo '<br>';

    			the_widget( 'Benjamin_Widget_Pages', array('title'=>'Pages') );
            endif;
		?>
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
