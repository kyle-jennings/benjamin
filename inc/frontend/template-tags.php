<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Benjamin
 */

 function get_hero_meta(){

     $post = get_queried_object();
     $id = $post->ID;
     $aid = $post->post_author;

     $m = get_the_time('m');
     $d = get_the_date('F j');
     $y = get_the_time('Y');

     $month_url = get_month_link($y, $m);
     $year_url = get_year_link($y);
     $date = '';
     $date .= '<a class="entry-date published" href="'.$month_url.'">'.$d.'</a>, ';
     $date .= '<a class="entry-date published" href="'.$year_url.'">'.$y.'</a>';


     $author = '<span class="author vcard">';
         $author .= '<a class="url fn n"
             href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">';
             $author .= get_the_author_meta('display_name', $aid);
         $author .= '</a>';
     $author .= '</span>';

     return '<span class="posted-on">' . $date . '</span>
         <span class="byline"> - ' . $author . '</span>';
 }


function uswds_posted_on() {
    echo get_uswds_posted_on();
}

function get_uswds_posted_on(){
    global $post;

    $id = get_the_ID();

    $m = get_the_time('m');
    $d = get_the_date('F j');
    $y = get_the_time('Y');

    $month_url = get_month_link($y, $m);
    $year_url = get_year_link($y);
    $date = '';
    $date .= '<a class="entry-date published" href="'.$month_url.'">'.$d.'</a>, ';
    $date .= '<a class="entry-date published" href="'.$year_url.'">'.$y.'</a>';



    $author = '<span class="author vcard">';
        $author .= '<a class="url fn n"
            href="' . get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) . '">';
            $author .= ' - ' .get_the_author();
        $author .= '</a>';
    $author .= '</span>';

    return '<span class="posted-on">' . $date . '</span>
        <span class="byline"> ' . $author . '</span>'; // WPCS: XSS OK.
}




if ( ! function_exists( 'uswds_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function uswds_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'uswds' ) );
		if ( $categories_list && uswds_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'uswds' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'uswds' ) );
		if ( $tags_list ) {
            echo "<br>";
			printf( ' <span class="tags-links">' . esc_html__( 'Tagged %1$s', 'uswds' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo "<br>";
		echo ' <span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'uswds' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'uswds' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<br><span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function uswds_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'uswds_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'uswds_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so uswds_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so uswds_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in uswds_categorized_blog.
 */
function uswds_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'uswds_categories' );
}
add_action( 'edit_category', 'uswds_category_transient_flusher' );
add_action( 'save_post',     'uswds_category_transient_flusher' );
