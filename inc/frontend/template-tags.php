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
             href="' . get_author_posts_url( $aid ) . '">';
             $author .= get_the_author_meta('display_name', $aid);
         $author .= '</a>';
     }

     $author .= '</span>';

     return '<span class="posted-on">' . $date . '</span>
         <span class="byline"> - ' . $author . '</span>';
 }


function benjamin_posted_on() {
    echo benjamin_get_posted_on(); //WPCS: xss ok.
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
    $date .= '<a class="entry-date published" href="' . esc_url($month_url) . '">'.$d.'</a>, ';
    $date .= '<a class="entry-date published" href="' . esc_url($year_url) . '">'.$y.'</a>';

    $author = '<span class="author vcard">';
    if ( function_exists( 'coauthors_posts_links' ) ) {
        $author .= coauthors_posts_links(null, null, null, null, false);
    } else {
        $author .= '<a class="url fn n"
            href="' . get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) . '">';
            $author .= get_the_author();
        $author .= '</a>';
    }
    $author .= '</span>';

    $output = '';
    $output .= '<span class="posted-on">' . $date . '</span>';
    $output .= '<span class="byline"> - ' . $author . '</span>'; // WPCS: XSS OK.

    return $output;
}




/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function benjamin_entry_footer() {
    global $post;
	// Hide category and tag text for pages.
	if ( 'page' !== get_post_type() ) {

		if ( $categories_list = benjamin_get_the_category_list($post->ID) ) {
            /* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'benjamin' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'benjamin' ) );
		if ( $tags_list ) {
            echo "<br>";
            /* translators: used between list items, there is a space after the comma */
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



function benjamin_get_the_category_list($id = null) {
    $post = get_post($id);
    $post_type = $post->post_type;

    $is_cat = ($post_type =='post') ? true : false;

    $terms = $is_cat ? get_the_category($id) : benjamin_get_custom_tax_terms($id, $post_type);
    $output = '';
    $count = 0;

    foreach($terms as $term):
        if($term->term_id == 1 && ($term->slug == 'uncategorized') || ($term->name == 'Uncategorized'))
            continue;

        $url = $is_cat ? get_category_link($term->term_id) : get_term_link($term->term_id);
        $output .= '<a href="'.$url.'">'.$term->name.'</a>, ';
        $count ++;
    endforeach;

    if($count == 0)
        return false;
    $output = rtrim($output, ', ');

    return $output;
}



function benjamin_get_custom_tax_terms($id = null, $post_type = null) {
    if(!$id)
        return;

    if(!$post_type){
        $post = get_post($id);
        $post_type = $post->post_type;
    }

    if( !$post_type)
        return;


    $terms = array();
    $taxonomy_names = get_object_taxonomies( $post_type );
    foreach($taxonomy_names as $tax)
        $terms += wp_get_post_terms($id, $tax);


    // examine(wp_get_post_terms($id, 'topics'));
    return $terms;
}
