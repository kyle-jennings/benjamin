<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Benjamin
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( !is_single() ) :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

    		if ( 'post' === get_post_type() ) : ?>
    		<div class="entry-meta">
    			<?php benjamin_posted_on(); ?>
    		</div><!-- .entry-meta -->
    		<?php
    		endif;

		endif;
        ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php

            if( !is_single() && get_option('rss_use_excerpt', true)  ):
                the_excerpt( sprintf(
    				/* translators: %s: Name of current post. */
    				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'benjamin' ), array( 'span' => array( 'class' => array() ) ) ),
    				the_title( '<span class="screen-reader-text">"', '"</span>', false )
    			) );

    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'benjamin' ),
    				'after'  => '</div>',
    			) );
            else:
                the_content( sprintf(
                    /* translators: %s: Name of current post. */
                    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'benjamin' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'benjamin' ),
                    'after'  => '</div>',
                ) );
            endif;
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php benjamin_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
