<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package benjamin
 */

function benjamin_get_feed_entry_title( $post = null ) {
    
    if ( !$post ) {
        global $post;
    }

    $post_format = get_post_format();
    $link        = null;
    $title       = '';
    
    if ( $post_format === 'link' ) {

        $link = benjamin_get_post_format_value( $post->ID, 'link', null );
    }

    $title .= benjamin_post_format_icon( $post_format );

    if ( isset( $link['url'] ) && isset( $link['text'] ) ) {
        $title .= '<a class="link-offsite" href="' . esc_url( $link['url'] ) . '" target="_blank" rel="follow">';// WPCS: xss ok.
        $title .= esc_html( $link['text'] ); // WPCS: xss ok.
        $title .= '</a>';
    } else {
        $title .= the_title(
            '<a href="'
            . esc_url( get_permalink() ) . '" rel="bookmark">',
            '</a>'
        );
    }

    return $title;
}


function benjamin_feed_entry_title( $post = null ) {

    if ( !$post ) {
        global $post;
    }

    echo benjamin_get_feed_entry_title( $post ); // WPCS: xss ok.
}


/**
 * Gets the entry header info (meta of author and post date )
 *
 * this is used outside the loop, hence being a different function
 * @return string html
 */
 function benjamin_get_hero_meta( $post_id = null ) {

     if ( !$post_id ) {
        $post = get_queried_object();
     } else {
        $post = get_post( $post_id );
     }

     $output = '';
     $output .= benjamin_get_the_date( $post );
     $output .= benjamin_get_the_author( $post );
     $output .= benjamin_get_the_comment_count_link( $post );

     return $output;
 }


/**
 * Gets the entry header info (meta of author and post date )
 *
 * this is used inside the loop, hence being a different function than the previous one
 * @return string html
 */
function benjamin_get_entry_header() {

    $output = '';
    $output .= benjamin_get_the_date();
    $output .= benjamin_get_the_author();

    // Hide category and tag text for pages.
    if ( 'page' !== get_post_type() ) {

        $output .= benjamin_get_the_comment_popup();
    }

    return $output;
}

// echos the above
function benjamin_entry_header() {
    echo benjamin_get_entry_header(); //WPCS: xss ok.
}


/**
 * Gets the author name and link
 * @param  wp_post $post the post object
 * @return string
 */
function benjamin_get_the_author( $post = null ) {
    
    if ( !$post )
        global $post;

    $aid = get_the_author_meta( 'ID', $post->post_author );

    $author = '';
    $author .= '<i class="dashicons dashicons-admin-users" aria-hidden="true" title="Author name"></i>';
    $author .= '<span class="author vcard">';
    if ( function_exists( 'coauthors_posts_links' ) ) {
        $author .= coauthors_posts_links( null, null, null, null, false );
    } else {
        $author .= '<a class="url fn n"
            href="' . get_author_posts_url( $aid ) . '">';
        $author .= get_the_author_meta( 'display_name', $aid );
        $author .= '</a>';
    }
    $author .= '</span>';


    $output = '<span class="post-meta__field entry-meta__field byline"> ' . $author . '</span>'; // WPCS: XSS OK.

    return $output;
}


/**
 * Gets the posted date
 *
 * Used in the loop
 * @return string markup with links to date archives
 */
function benjamin_get_the_date( $post = null ) {
    if ( !$post )
        global $post;

    $date_str = get_the_date( get_option('date_format'), $post );
    $m = get_the_time( 'm', $post );
    $y = get_the_time( 'Y', $post );
    $url  = get_month_link($y, $m);
    $date = '';
    $date .= '<i class="dashicons dashicons-calendar-alt" aria-hidden="true" title="Date Published"></i>';
    $date .= '<a class="post-date entry-date published" href="' . esc_url( $url ) . '">' . $date_str . '</a>';

    $output = '<span class="post-meta__field entry-meta__field posted-on">' . $date . '</span>';

    return $output;
}


/**
 * Gets the number of comments and links to the comments 
 */
function benjamin_get_the_comment_count_link( $post = null ) {
    if ( !$post )
        global $post;

    if ( !comments_open( $post->ID ))
        return '';

    $output = '';
    $comments = '';
    $count = wp_count_comments( $post->ID );

    $count = $count->approved;
    $comments_i = $count > 1 ? 'dashicons-format-chat' : 'dashicons-admin-comments' ;

    $text = '';
    switch ( $count ) :
        case 0:
            $text = __( 'Leave a Comment', 'benjamin' );
            break;
        case 1:
            $text = __( '1 comment', 'benjamin' );
            break;
        default:
            // translators: number of comments
            $text = sprintf( __( '%s comments', 'benjamin' ), $count );
            break;
    endswitch;



    $comments = '<i class="dashicons ' . $comments_i . '" title="Number of Comments"></i>';
    $comments .= '<a href="#comments">' . $text . '</a>';


    $output = '<span class="post-meta__field entry-meta__field"> ' . $comments . '</span>'; // WPCS: XSS OK.

    return $output;
}


/**
 * The markup for the comment form
 */
function benjamin_get_the_comment_popup($anchor = null) {

    global $post;


    if ( !comments_open( $post->ID ) )
        return '';

    $output = '';
    $comments = '';
    $count = wp_count_comments( $post->ID );
    $count = $count->approved;
    $comments_i = $count > 1 ? 'dashicons-format-chat' : 'dashicons-admin-comments' ;

    // comment link
    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {



            $comments .= '<i class="dashicons ' . $comments_i . '"></i>';
            ob_start();
            /* translators: %s: post title */
            comments_popup_link(
                wp_kses( __( 'Leave a Comment', 'benjamin' ),
                    array( 'span' => array( 'class' => array() ) )
                ),
                wp_kses( __( '1 comment', 'benjamin' ),
                    array( 'span' => array( 'class' => array() ) )
                ),
                wp_kses( __( '% comments', 'benjamin' ),
                    array( 'span' => array( 'class' => array() ) )
                ),
                null,
                ''
            );
            $content = ob_get_contents();
            ob_end_clean();
            $comments .= $content;


        $output = '<span class="post-meta__field entry-meta__field"> ' . $comments . '</span>'; // WPCS: XSS OK.
    }

    return $output;
}


/**
 * gets the markup for the list of category links
 * @param  wp_post $post the post object
 * @return string
 */
function benjamin_get_categories_links( $post = null ) {
    if ( !$post )
        global $post;
    $output = '';

    if ( $categories_list = benjamin_get_the_category_list( $post->ID ) ) {
        $output .= sprintf( '<span class="post-meta__field entry-meta__field">
            <i class="dashicons dashicons-category" title="Categories"></i>' .
             esc_html( '%s' ) . '</span>', $categories_list );
    }

    return $output;
}



/**
 * gets the markup for the list of tag links
 * @param  wp_post $post the post object
 * @return string
 */
function benjamin_get_tags_links() {

    $output = '';
    // tags
    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'benjamin' ) );
    if ( $tags_list ) {
        $output .= sprintf( '<span class="post-meta__field entry-meta__field">
            <i class="dashicons dashicons-tag" title="Tags"></i>' .
             esc_html( '%s' ) . '</span>', $tags_list );
    }

    return $output;
}



/**
 * gets the markup for the post/entry footer
 * @param  wp_post $post the post object
 * @return string
 */
function benjamin_get_entry_footer( $post = null ) {
    if(!$post)
        global $post;

    $output = '';

    $output .= '<footer class="entry-footer post-meta">';
        $output .= wp_link_pages( array(
            'before' => '<nav aria-label="Page navigation"><ul class="pagination">',
            'after'  => '</ul></nav>',
            'echo' => false
        ) );
        
        if ( 'page' !== get_post_type() ) :
        $output .= '<div class="post-meta entry-meta">';
            $output .= benjamin_get_categories_links();
            $output .= benjamin_get_tags_links();
        $output .= '</div>';
        endif;

        $output .= '<div class="post-meta entry-meta">';
            $output .= benjamin_get_the_edit_post_link();
        $output .= '</div>';
    $output .= '</footer>';

    return $output;
}


/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function benjamin_entry_footer( $post = null ) {

    echo benjamin_get_entry_footer( $post ); //WPCS. xss ok.

}

/**
 * Displays the "edit post" link under a post when logged in
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function benjamin_get_the_edit_post_link( $post_id = null ) {

    $output = '';
    // Edit link
    ob_start();
    edit_post_link(
        sprintf(
            /* translators: %s: Name of current post */
            esc_html__( 'Edit %s', 'benjamin' ),
            the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ),
        '<div class="post-meta__field entry-meta__field"> <i class="dashicons dashicons-edit"></i>',
        '</div>',
        $post_id
    );
    $contents = ob_get_contents();
    ob_end_clean();
    $output .= $contents;

    return $output;
}


function benjamin_the_edit_post_link( $post_id = null ) {
    echo benjamin_get_the_edit_post_link( $post_id ); //WPCS. xss ok.
}


/**
 * Gets tht html list of category links
 * @param  int $id post id
 * @return string     html list of links
 */
function benjamin_get_the_category_list( $id = null ) {
    $post = get_post( $id );
    $post_type = $post->post_type;

    $is_cat = ( $post_type =='post' ) ? true : false;

    $terms = $is_cat ? get_the_category( $id ) : benjamin_get_custom_tax_terms( $id, $post_type );
    $output = '';
    $count = 0;

    foreach( $terms as $term ) :
        if ( $term->term_id == 1 && ( $term->slug == 'uncategorized' ) || ( $term->name == 'Uncategorized' ) )
            continue;

        $url = $is_cat ? get_category_link( $term->term_id ) : get_term_link( $term->term_id );
        $output .= '<a href="' . $url . '">' . $term->name . '</a>, ';
        $count ++;
    endforeach;

    if ( $count == 0 )
        return false;
    $output = rtrim( $output, ', ' );

    return $output;
}



/**
 * Gets the array of taxonmy terms (does not include categories)
 * @param  int $id        post id
 * @param  string $post_type the post type
 * @return array            array of terms
 */
function benjamin_get_custom_tax_terms( $id = null, $post_type = null ) {
    if ( !$id )
        return;

    if ( !$post_type ) {
        $post = get_post( $id );
        $post_type = $post->post_type;
    }

    if ( !$post_type)
        return;


    $terms = array();
    $taxonomy_names = get_object_taxonomies( $post_type );
    foreach ( $taxonomy_names as $tax )
        $terms += wp_get_post_terms( $id, $tax );


    // examine(wp_get_post_terms($id, 'topics'));
    return $terms;
}


/**
 * returns the featured image markup
 * @param  wp_post $post [description]
 * @return [type]       [description]
 */
function benjamin_get_post_thumbnail( $post = null ) {
    if ( !$post )
        global $post;

    $output = '';
    if ( has_post_thumbnail() ) :

        $output .= '<figure class="post-featured-image entry-featured-image">';
            $output .= '<a href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">';
                $output .= get_the_post_thumbnail( $post, 'thumbnail' );
            $output .= '</a>';
        $output .= '</figure>';
    endif;

    return $output;
}

/**
 * displays the featured image markup
 * @param  wp_post $post [description]
 * @return [type]       [description]
 */
function benjamin_post_thumbnail( $post = null ) {
    echo benjamin_get_post_thumbnail( $post ); //WPCS. xss ok.
}




/**
 * the icon displayed before the title for post formats
 */
function benjamin_get_post_format_icon( $format = null ) {

    $icon = null;

    switch( $format ) :
        case 'gallery':
            $icon = 'dashicons-format-gallery';
            break;
        case 'image':
            $icon = 'dashicons-camera';
            break;
        case 'video':
            $icon = 'dashicons-video-alt3';
            break;
        case 'audio':
            $icon = 'dashicons-format-audio';
            break;
        case 'link':
            $icon = 'dashicons-admin-links';
            break;
        case 'aside':
            $icon = 'dashicons-format-aside';
            break;
        case 'chat':
            $icon = 'dashicons-format-chat';
            break;
        case 'quote':
            $icon = 'dashicons-format-quote';
            break;
        case 'status':
            $icon = 'dashicons-format-status';
            break;
        default:
            $icon = '';
            break;
    endswitch;

    if ( is_sticky() ) {
        $icon = 'dashicons-sticky';
    }

    if ( !$icon ) {
        return '';
    }

    $output = '<i class="dashicons ' . $icon . '"></i>';

    return $output;
}

function benjamin_post_format_icon( $format = null ) {
    echo benjamin_get_post_format_icon( $format ); // WPCS: xss ok.
}