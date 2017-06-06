<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
    	<?php
    	while ( have_posts() ) : the_post();

    		get_template_part( 'template-parts/content', get_post_format() );

            $navigation_args = array(
                'prev_text' => '&laquo; Previous Post',
                'next_text' => 'Next Post &raquo;',
            );
    		the_post_navigation($navigation_args);

    		// If comments are open or we have at least one comment, load up the comment template.
    		if ( comments_open() || get_comments_number() ) :
    			comments_template();
    		endif;

    	endwhile; // End of the loop.
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
