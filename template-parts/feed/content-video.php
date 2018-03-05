<?php
/** 
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Benjamin
 */

global $post;
$video = get_post_meta($post->ID, '_post_format_video', true) ;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
    <header class="entry-header">
        <?php
            $pre = '<h2 class="entry-title">';
            $pre .= benjamin_post_format_icon( get_post_format());
            $pre .= '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';

            the_title(  $pre, '</a></h2>');
        ?>
    </header><!-- .entry-header -->
    <div class="grid">

<?php

    if($video) {
        echo '<div class="usa-width-one-whole">';
            echo benjamin_get_the_video_markup($video); // WPCS: xss ok.
        echo '</div>';
    }
 ?>

        <div class="usa-width-one-fourth">

           <?php benjamin_post_thumbnail($post); ?>

            <?php
                if ( 'page' !== get_post_type() ) : ?>
                <div class="entry-meta">
                <?php 
                    echo benjamin_get_the_date(); // WPCS: xss ok.
                    echo benjamin_get_the_author(); // WPCS: xss ok.

                    echo benjamin_get_the_comment_popup(); // WPCS: xss ok.
                    echo benjamin_get_categories_links(); // WPCS: xss ok.
                    echo benjamin_get_tags_links(); // WPCS: xss ok. 
                ?>
                </div><!-- .entry-meta -->
                <?php
                endif;
            ?>
        </div>

        <div class="entry-content usa-width-three-fourths">
            <?php

                the_content( sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. */
                        __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'benjamin' ),
                        array( 'span' => array( 'class' => array() ) )
                    ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                    )
                );

            ?>
        </div><!-- .entry-content -->
    </div>

    <footer class="entry-footer">
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'benjamin' ),
                'after'  => '</div>',
            ) );
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
