<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Benjamin
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
$format = get_post_format();
$exclude = array( 'chat', 'gallery', 'aside' );

if ( ! $hide_content ) :
?>

<section id="primary" class="usa-grid usa-section">

    <?php
    if ( $sidebar_position == 'left' ) :
        benjamin_get_sidebar( $template, $sidebar_position, $sidebar_size );
    endif;
    ?>
    <div class="main-content <?php echo esc_attr( $main_width ); ?>">
        <?php
        while ( have_posts() ) :
            the_post();

            
            if ( $format && benjamin_use_post_format_content( $post, $format, $exclude )  ) {
                
                $part = ( !in_array( $format, $exclude, true ) ) ? 'post-format' : $format;
                get_template_part( 'template-parts/singles/content', $part );

            } else {
                get_template_part( 'template-parts/singles/content' );
            }

            $navigation_args = array(
                'prev_text' => '&laquo; Previous Post',
                'next_text' => 'Next Post &raquo;',
            );
    		the_post_navigation( $navigation_args );

    		// If comments are open or we have at least one comment, load up the comment template.
    		if ( comments_open() || get_comments_number() ) :
    			comments_template();
    		endif;

    	endwhile; // End of the loop.
    	?>
    </div>
    <?php
    if ( $sidebar_position === 'right' ) :
        benjamin_get_sidebar( $template, $sidebar_position, $sidebar_size );
    endif;
    ?>

</section>

<?php
endif;

get_footer();
