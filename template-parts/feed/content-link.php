<?php
/** 
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Benjamin
 */

global $post;

$link_url = get_post_meta($post->ID, '_post_format_link_url', true);
$link_text = get_post_meta($post->ID, '_post_format_link_text', true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
    <header class="entry-header">
        <?php
            $pre = '<h2 class="entry-title">';
            $pre .= benjamin_post_format_icon( get_post_format());
            $pre .= '<a href="' . get_permalink() . '" rel="bookmark">'; // WPCS: xss ok.

            the_title( $pre, '</a></h2>');
        ?>
    </header><!-- .entry-header -->
    <div class="grid">

<?php


        echo '<div class="usa-width-one-whole">';
        if($link_url && $link_text) {
                echo '<i class="fa fa-link fa-sm"></i>';
                echo '<a href="'.esc_url($link_url).'" target="_blank" rel="follow">';// WPCS: xss ok.
                    echo esc_html($link_text); // WPCS: xss ok.
                echo '</a>';
            echo '';
        }else {
            the_title(
                '<a href="'
                . esc_url( get_permalink() ) . '" rel="bookmark">',
                '</a>'
            );
        }
        echo '</div>';

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
