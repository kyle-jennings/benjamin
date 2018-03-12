<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootswatches
 */
global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry cf row' ); ?> >
    <div class="post-content entry-content col-md-12">
        <?php

        echo '<header class="post-header">';

        if ( 'page' !== get_post_type() ) :
        ?>
            <div class="post-meta entry-meta">
            <?php
                echo benjamin_get_the_date(); // WPCS: xss ok.
                echo benjamin_get_the_author(); // WPCS: xss ok.
                echo benjamin_get_the_comment_count_link(); // WPCS: xss ok.
            ?>
            </div><!-- .post-meta -->
        <?php
        endif;

        echo '</header>';

        ?>

        <div class="post-content entry-content">
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
        </div><!-- .post-meta -->


        <?php 
            echo benjamin_get_entry_footer( $post ); // WPCS: xss ok.
        ?>


    </div>
</article><!-- #post-## -->
