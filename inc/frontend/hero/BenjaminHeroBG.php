<?php

class BenjaminHeroBG
{

    public $post_id;
    public $template;

    public $hasFeaturedImage = false;
    public $isFeaturedPost = false;

    public function __construct($post_id, $template, $currentpage)
    {
        $this->post_id = $post_id;
        $this->template = $template;
        $this->currentpage = $currentpage;
    }

    // set the background image and video BG
    public function getBackground() {


        if( is_front_page() || is_404() ) {
            // examine('front or 404');
            $this->setMediaFromCustSetting($this->template);

        } elseif( in_array( $this->template, array('single','page')) || is_single() || is_page() ){
            // examine('single or page');
            $this->image = $this->getSingularImage($this->template);

        } elseif( is_home() ) {
            // examine('home');
            $post = get_queried_object();
            $this->postType = $post_type = is_a($post, 'WP_Post_Type') && !is_home() ? $post->name : 'post';


            $isFeaturedPost = get_option('featured-post--'.$post_type, false);

            // set the hero image
            if( $isFeaturedPost){
                $this->featuredPost = new FeaturedPost($isFeaturedPost, $post_type);
                $this->image = $this->getFeaturedPostMedia('image');

            } else {
                $this->setMediaFromCustSetting($this->template);
            }

        } else {

            $this->setMediaFromCustSetting($this->template);
        }
    }


    // set the media BGs set in teh customizer
    public function setMediaFromCustSetting($template){
        $this->image = get_theme_mod($template . '_image_setting', null);
        if(!filter_var($this->image, FILTER_VALIDATE_URL) || filter_var($this->image, FILTER_VALIDATE_INT))
            $this->image = wp_get_attachment_url($this->image);
    }


    // Add some inline CSS to the hero when we are using a background image
    public function getStyle($template) {
        if(!$this->image)
            return;

        $pos = get_theme_mod($template . '_hero_position_setting', 'top-left');
        $pos = str_replace('-',' ', $pos);
        $output = 'style="';
            $output .= 'background-image: url(\'' . esc_url($this->image) . '\');';
            $output .= 'background-position: ' . esc_attr($pos) . ';';
        $output .= '"';

        return $output;
    }


    // grab the video markup
    public function videoMarkup() {
        if(!$this->video)
            return;
        return benjamin_get_the_video_markup($this->video, 'background');
    }


    // singular templates either have a featured image, or custommizer setting
    public function getSingularImage($template) {

        global $post;

        $format = get_post_format();
        if($format && $this->postFormatBackground($format) )
            return $this->postFormatBackground($format);
        elseif( has_post_thumbnail() )
            return get_the_post_thumbnail_url();
        else
            return get_theme_mod($template . '_image_setting', null);

    }


    public function postFormatBackground($format = null)
    {
        global $post;

        switch($format):
            case 'video':
                $url = get_post_meta($post->ID, '_post_format_video', true);
                if( $url && $id = benjamin_get_youtube_id($url) )
                    return 'http://img.youtube.com/vi/'.$id.'/maxresdefault.jpg';
                break;
            case 'gallery':
                $gallery = get_post_meta($post->ID, '_post_format_gallery', true);
                if($gallery){
                    $gallery = explode(',', $gallery);
                    return wp_get_attachment_image_url( array_shift($gallery), 'full' );
                }
                break;
            case 'image':
                if( has_post_thumbnail() )
                    return get_the_post_thumbnail_url();
                break;
        endswitch;


    }

    // A featured post well have a featured image
    public function getFeaturedPostMedia($media = 'image') {

        $media = 'image';

        if($this->featuredPost && $this->featuredPost->$media )
            $media = $this->featuredPost->$media;
        else
            $media = get_theme_mod($this->template . '_'.$media.'_setting', null);


        return $media;
    }


}
