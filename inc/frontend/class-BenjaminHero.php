<?php

class BenjaminHero {

    public $template;
    public $currentPage;
    public $hasFeaturedVideo = false;
    public $hasFeaturedImage = false;
    public $hasFeaturedPost = false;

    public $size = 'usa-hero--slim';
    public $image = null;
    public $video = null;

    public $title;
    public $url;
    public $content;

    public function __construct($template = null) {
        $this->template = $template;
        $this->getBackground($template);
    }

    public function __toString() {

        return $this->output();
    }


    // the output
    public function output(){
        $output = '';
        $size = $this->heroSize($this->template);
        $style = $this->getStyle($this->template);
        $output .= '<section class="usa-hero '.$size.'" '.$style.'>';
            $output .= $this->videoMarkup();
            $output .= '<div class="usa-grid">';
                $output .= $this->getContent();
            $output .= '</div>';
        $output .= '</section>';

        return $output;
    }


    // set the background image and video BG
    public function getBackground($template) {
        if( in_array( $template, array('single','page')) || is_single() || is_page() ){

            $this->image = $this->getSingularImage($template);
            $this->video = $this->getSingularVideo($template);

        } elseif( is_front_page() || is_404() ) {

            $this->setMediaFromCustSetting($template);

        } elseif( is_home() || is_archive() ) {
            $post = get_queried_object();
            $this->postType = $post_type = is_a($post, 'WP_Post_Type') && !is_home() ? $post->name : 'post';
            $this->hasFeaturedPost = get_option('featured-post--'.$post_type, false);


            // set the hero image
            if($this->hasFeaturedPost){
                $this->featuredPost = new BenjaminFeaturedPost($this->hasFeaturedPost, $post_type);
                $this->image = $this->getFeaturedPostMedia('image');
                $this->video = $this->getFeaturedPostMedia('video');

            } else {
                $this->setMediaFromCustSetting($template);
            }

        } else {

            $this->setMediaFromCustSetting($template);
        }
    }


    // set the media BGs set in teh customizer
    public function setMediaFromCustSetting($template){
        $this->image = get_theme_mod($template . '_image_setting', null);
        $this->video = get_theme_mod($template . '_video_setting', null);
    }


    // Add some inline CSS to the hero when we are using a background image
    public function getStyle($template) {
        if(!$this->image)
            return;

        $pos = get_theme_mod($template.'_hero_position_setting', 'top-left');
        $pos = str_replace('-',' ', $pos);
        $output = 'style="';
            $output .= 'background-image: url(\''.$this->image.'\');';
            $output .= 'background-position: '.$pos.';';
        $output .= '"';

        return $output;
    }


    // grab the video markup
    public function videoMarkup() {
    

        if(!$this->video )
            return;

        if( !function_exists('franklin_get_the_video_markup') ) {
            return;
        }
        return franklin_get_the_video_markup($this->video, 'background');
    }


    // singular templates either have a featured image, or custommizer setting
    public function getSingularImage($template) {

        if( has_post_thumbnail() )
            return get_the_post_thumbnail_url();
        else
            return get_theme_mod($template . '_image_setting', null);

    }


    // singular templates either have a featured video, or custommizer setting
    public function getSingularVideo($template) {
        if( $this->hasFeaturedVideo() )
            return benjamin_get_the_post_video_url();
        else
            return get_theme_mod($template . '_video_setting', null);
    }


    // A featured post well have a featured image
    public function getFeaturedPostMedia($media = 'image') {

        if($this->featuredPost && $this->featuredPost->$media )
            $media = $this->featuredPost->$media;
        else
            $media = get_theme_mod($this->template . '_'.$media.'_setting', null);


        return $media;
    }


    // does the post have a featured video?
    public function hasFeaturedVideo() {
        global $post;

        if(get_post_meta($post->ID, 'featured-video', true))
            return true;

        return false;
    }


    /**
     * The hero has different sizes depending on which template is displayed
     * @param  [type] $template [description]
     * @return [type]           [description]
     */
    function heroSize($template = null){

        $setting = get_theme_mod($template . '_hero_size_setting', 'slim');

        $size ='usa-hero--'.$setting;
        return $size;
    }

    public function frontpageContent() {

        $output = '';
        $content = get_theme_mod('frontpage_hero_content_setting', 'callout');

        if($content == 'page') {
            $page = get_theme_mod('frontpage_hero_page_setting', 0);
            if( !is_null($page) && $page != 0 ) {
                $page = get_page($page);
                $output .= apply_filters('the_content', $page->post_content);
            }
        } elseif($content == 'callout') {
            $output .= $this->heroCallout();
        } else {
            $output = '<h1>' . get_bloginfo( 'name', 'display' ) . '</h1>';
        }

        return $output;
    }


    /**
     * The front page displays a "callout", here is the markup
     * @return [type] [description]
     */
    public function heroCallout(){
        $id = get_theme_mod('frontpage_hero_callout_setting', 0);

        $description = get_bloginfo( 'description', 'display' );
        $title = get_bloginfo( 'name', 'display' );

        if(!$title || !$description)
            return '<h1>' . $title .'</h1>';


        $output = '';

        $output .= '<div class="usa-hero-callout usa-section-dark">';
            $output .= '<h1>'.$title.'</h1>';

                if ( $description || is_customize_preview() )
                    $output .= '<p class="site-description">'.$description.'</p>';

                if( !is_null($id) && $id != 0 )
                    $output .= '<a class="usa-button usa-button-big usa-button-secondary"
                        href="'.get_the_permalink($id).'">Learn More</a>';

        $output .= '</div>';

        return $output;
    }


    /**
     * The Feed title will either show the author tagline, category / tag tag line
     * The date (month / year), search results, or the post type's featured post
     * @return [type] [description]
     */
    function getContent() {

        if( is_front_page() )
            return $this->frontpageContent();
        elseif( is_404() )
            return $this->the404title();
        elseif( is_page() || is_single() || is_singular() )
            return $this->singularTitle();
        elseif( is_author() )
            return $this->authorFeedTitle();
        elseif( is_date() )
            return $this->dateTitle();
        elseif( is_category() )
            return $this->catFeedTitle();
        elseif( is_search() )
            return $this->searchTitle();
        elseif( is_home() || is_archive() )
            return $this->feedContent();
        else
            return $this->defaultTitle();

    }


    // the fallback
    public function defaultTitle() {
        $post = get_queried_object();
        if( $post->post_title)
            $title = $post->post_title;
        elseif($post->name)
            $title = $post->name;

        return '<h1>' . $title .'</h1>';
    }


    // the 404 page has special powers
    public function the404title(){
        /**
         * the 404 settings
         *
         * returns:
         * $content
         * $pid
         * $header_page
         *
         */
        extract(benjamin_get_404_settings());

        if($header_page) {
            $page = get_page($header_page);
            return apply_filters('the_content', $page->post_content);
        } else {
            return '<h1>404: Page not found. </h1>';
        }

    }

    // title for single posts, CPTs, or pages
    public function singularTitle() {
        $output = '';

        $output .= '<h1>'.get_the_title().'</h1>';
        if ( 'page' !== get_post_type() ) :
            $output .= '<div class="entry-meta">';
                $output .= benjamin_get_hero_meta();
            $output .= '</div>';
        endif;

        return $output;
    }

    // author feed title
    public function authorFeedTitle(){
        $auth = get_user_by('slug', get_query_var('author_name'));
        return '<h1>' . 'Posts by: '.$auth->display_name . '</h1>';
    }

    // date title
    public function dateTitle() {
        if( is_month())
            $title = 'Posted in: ' . get_the_date('F, Y');
        else
            $title = 'Posted in: ' . get_the_date('Y');

        return '<h1>' . $title .'</h1>';
    }


    // category feed title
    public function catFeedTitle() {
        ob_start();
            single_cat_title();
            $buffered_cat = ob_get_contents();
        ob_end_clean();
        return '<h1>' . 'Posted in: '.$buffered_cat . '</h1>';

    }


    // search title
    public function searchTitle() {
        global $wp_query;
        $total_results = $wp_query->found_posts;
        $title = $total_results ? 'Search Results for: ' . get_search_query() : 'No results found' ;

        return '<h1>' . $title . '</h1>';

    }


    // The feed either shows the featured post content, the feed type, or the name of the page
    public function feedContent() {
        $output = '';

        $post = get_queried_object();
        $post_type = is_a($post, 'WP_Post_Type') ? $post->name : 'post';

        if( $this->hasFeaturedPost ) {
            $output = $this->featuredPost->output;
        } elseif( isset($post->post_title) )  {
            $output = '<h1>' . $post->post_title . '</h1>';
        } elseif( isset($post->name) ) {
            $output = '<h1>' . $post->name . '</h1>';
        } else {
            $output = '<h1> Home </h1>';
        }

        return $output;
    }
}
