<?php
/** 
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Benjamin
 */

$link = get_post_meta($post->ID, '_post_format_link', true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry cf'); ?>>
    <header class="entry-header">
        <h3 class="entry-title">
    <?php
        $pre = '';
        $pre .= benjamin_post_format_icon( get_post_format());

        if(isset( $link['url']) && isset($link['text'])) {
            $pre .= '<a class="link-offsite" href="'.esc_url($link['url']).'" target="_blank" rel="follow">';// WPCS: xss ok.
                $pre .= esc_html($link['text']); // WPCS: xss ok.
            $pre .= '</a>';
                // $pre .= '<span class="dashicons dashicons-external"></span>';
        }else {
            $pre .= the_title(
                '<a href="'
                . esc_url( get_permalink() ) . '" rel="bookmark">',
                '</a>'
            );
        }
        
        echo $pre; // WPCS: xss ok.
    ?>
        </h3>
    </header><!-- .entry-header -->
    <div class="grid">
        <?php

            if( get_post_meta($post->ID, '_post_format_' . get_post_format(), true) 
                && in_array(get_post_format(), json_decode(POST_FORMATS)) ) 
            {
                benjamin_post_format_markup($post,  get_post_format() );
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
