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

<article id="post-<?php the_ID(); ?>" <?php post_class('entry cf row'); ?> >
    <div class="post-content entry-content col-md-12">
        <?php benjamin_post_format_markup($post, get_post_format())?>
    </div>
    <div class="post-content entry-content">
    <?php


    the_content(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. */
                    __('Continue reading %s <span class="meta-nav">&rarr;</span>', 'benjamin'),
                array('span' => array('class' => array()))
            ),
            the_title('<span class="screen-reader-text">"', '"</span>', false)
        )
    );

    ?>
    </div><!-- .post-meta -->

    <footer class="entry-footer">
        <?php benjamin_entry_footer(); ?>
    </footer><!-- .entry-footer -->


</article><!-- #post-## -->
