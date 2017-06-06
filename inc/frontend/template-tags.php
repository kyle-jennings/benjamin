<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Benjamin
 */

 function benjamin_get_hero_meta(){

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
     if ( function_exists( 'coauthors_posts_links' ) ) {
         $author .= coauthors_posts_links(null, null, null, null, false);
     } else {
         $author .= '<a class="url fn n"
             href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">';
             $author .= get_the_author_meta('display_name', $aid);
         $author .= '</a>';
     }

     $author .= '</span>';

     return '<span class="posted-on">' . $date . '</span>
         <span class="byline"> - ' . $author . '</span>';
 }


function benjamin_posted_on() {
    echo benjamin_get_posted_on();
}

function benjamin_get_posted_on(){
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
    if ( function_exists( 'coauthors_posts_links' ) ) {
        $author .= coauthors_posts_links(null, null, null, null, false);
    } else {
        $author .= '<a class="url fn n"
            href="' . get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) . '">';
            $author .= ' - ' .get_the_author();
        $author .= '</a>';
    }
    $author .= '</span>';

    $output = '';
    $output .= '<span class="posted-on">' . $date . '</span>';
    $output .= '<span class="byline"> - ' . $author . '</span>'; // WPCS: XSS OK.

    return $output;
}




if ( ! function_exists( 'benjamin_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function benjamin_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'page' !== get_post_type() ) {


		/* translators: used between list items, there is a space after the comma */
		if ( $categories_list = benjamin_get_the_category_list() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'benjamin' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'benjamin' ) );
		if ( $tags_list ) {
            echo "<br>";
			printf( ' <span class="tags-links">' . esc_html__( 'Tagged %1$s', 'benjamin' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo "<br>";
		echo ' <span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'benjamin' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'benjamin' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<br><span class="edit-link">',
		'</span>'
	);
}
endif;


function benjamin_get_the_category_list($id = null) {
    // esc_html__( ', ', 'benjamin' )
    $cats = get_the_category($id);
    $output = '';
    $count = 0;
    foreach($cats as $cat):
        if($cat->term_id == 1 && ($cat->slug == 'uncategorized') || ($cat->name == 'Uncategorized'))
            continue;
        $output .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a>, ';
        $count ++;
    endforeach;
    if($count == 0)
        return false;
    $output = rtrim($output, ', ');

    return $output;
}
