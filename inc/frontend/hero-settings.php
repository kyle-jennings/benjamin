<?php


/**
 * The hero image can change depending on whether or not we are on a feed, or a
 * single page / post (in which case the default image can be overridden )
 * @param  [type] $template [description]
 * @return [type]           [description]
 */
function benjamin_hero_image($template = null) {

    $hero_image = null;

    // this is gross, clean me up
    if( (   in_array( $template, array('single','page') )
            || ( is_single() || is_page() )
        )
        && has_post_thumbnail()
    ) {
        $hero_image = get_the_post_thumbnail_url();
    } elseif ( $template == 'frontpage' ) {
        $hero_image = get_theme_mod($template . '_image_setting');
    } else {
        $post = get_queried_object();
        $post_type = is_a($post, 'WP_Post_Type') && !is_home() ? $post->name : 'post';

        $f_id = get_option('featured-post--'.$post_type, false);
        $featuredPost = new BenjaminFeaturedPost($f_id, $post_type);

        $hero_image = ($featuredPost && $featuredPost->image )
            ? $featuredPost->image : get_theme_mod($template . '_image_setting');
    }

    return $hero_image;
}


/**
 * The hero has different sizes depending on which template is displayed
 * @param  [type] $template [description]
 * @return [type]           [description]
 */
function benjamin_hero_size($template = null){

    $setting = get_theme_mod($template . '_hero_size_setting');
    $hero_size = $setting ? 'usa-hero--'.$setting : 'usa-hero--slim';

    return $hero_size;
}


/**
 * The front page displays a "callout", here is the markup
 * @return [type] [description]
 */
function benjamin_get_hero_callout(){
    $page = ($id = get_theme_mod('frontpage_hero_callout_setting')) ? $id : null;
    $description = get_bloginfo( 'description', 'display' );
    $title = get_bloginfo( 'name', 'display' );

    if(!$title || !$description){
        echo '<h1>' . $title .'</h1>';
        return false;
    }
    ?>
    <div class="usa-hero-callout usa-section-dark">
        <h1><?php echo $title; ?></h1>
        <?php
            if ( $description || is_customize_preview() ) : ?>
                <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
            <?php
            endif;
        ?>
        <?php if( !is_null($id) && $id != 0 ): ?>
            <a class="usa-button usa-button-big usa-button-secondary"
            href="<?php echo the_permalink($id) ; ?>">Learn More</a>
        <?php endif; ?>
    </div>
    <?php
}


/**
 * The Feed title will either show the author tagline, category / tag tag line
 * The date (month / year), search results, or the post type's featured post
 * @return [type] [description]
 */
function benjamin_get_feed_title() {

    if( is_author() ) {
        $auth = get_user_by('slug', get_query_var('author_name'));
        $title = '<h1>' . 'Posts by: '.$auth->nickname . '</h1>';
    } elseif( is_date() ){

        if( is_month())
            $title = 'Posted in: ' . get_the_date('F, Y');
        else
            $title = 'Posted in: ' . get_the_date('Y');
        $title = '<h1>' . $title .'</h1>';

    } elseif( is_category() ){

        ob_start();
        single_cat_title();
        $buffered_cat = ob_get_contents();
        ob_end_clean();
        $title = '<h1>' . 'Posted in: '.$buffered_cat . '</h1>';

    } elseif( is_search() ){

        global $wp_query;
        $total_results = $wp_query->found_posts;
        $title = $total_results ? 'Search Results for: '.get_search_query() : 'No results found' ;
        $title = '<h1>' . $title . '</h1>';

    } elseif( is_home() || is_archive() ){

        $post = get_queried_object();
        $post_type = is_a($post, 'WP_Post_Type') ? $post->name : 'post';

        $fid = get_option('featured-post--'.$post_type, false);
        if($fid) {
            $featuredPost = new BenjaminFeaturedPost($fid, 'post');
            $title = $featuredPost->output;
        } elseif( $post->post_title )  {
                $title = '<h1>' . $post->post_title . '</h1>';
        } elseif($post->name) {
                $title = '<h1>' . $post->name . '</h1>';
        } else {
            $title = '<h1> Home </h1>';
        }
    } elseif(is_404() ) {
        $title = '<h1>404: Page not found. </h1>';
    } else {
        $post = get_queried_object();
        if( $post->post_title)
            $title = $post->post_title;
        elseif($post->name)
            $title = $post->name;

        $title = '<h1>' . $title .'</h1>';

    }

    return $title;
}
