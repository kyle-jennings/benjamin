<?php

class BenjaminHero {

    public $template;
    public $currentpage;

    public $hasFeaturedVideo = false;
    public $hasFeaturedImage = false;
    public $hasFeaturedPost = false;

    public $size = 'usa-hero--slim';
    public $image = null;
    public $video = null;

    public $title;
    public $pre_title;
    public $sub_title;

    public $url;
    public $content;

    public $HeroContent;
    public $HeroBackground;

    public function __construct($template = null)
    {
        $this->template = $template;

        if (is_front_page()) {
            $this->currentpage = 'frontpage';
        } elseif (is_404()) {
            $this->currentpage = '_404';
        } elseif (is_page() || is_single() || is_singular()) {
            $this->currentpage = 'singular';
        } elseif (is_author()) {
            $this->currentpage = 'author';
        } elseif (is_date()) {
            $this->currentpage = 'date';
        } elseif (is_tag()) {
            $this->currentpage = 'tag';
        } elseif (is_category()) {
            $this->currentpage = 'category';
        } elseif (is_search()) {
            $this->currentpage = 'search';
        } elseif (is_home()) {
            $this->currentpage = 'home';
        } elseif (is_archive()) {
            $this->currentpage = 'archive';
        } else {
            $this->currentpage = 'fallback';
        }


        $this->HeroContent    = new BenjaminHeroContent(null, $this->template, $this->currentpage);
        $this->HeroBackground = new BenjaminHeroBG(null, $this->template, $this->currentpage);

        $this->HeroBackground->getBackground();
    }

    public function __toString()
    {


        return $this->output();
    }


    // the output
    public function output()
    {
        $output = '';
        $size = $this->heroSize($this->template);
        $style = $this->HeroBackground->getStyle($this->template);

        $class = $size;
        $class .= $this->HeroBackground->image ? ' hero--has-background' : '';
        
        $output .= '<section class="usa-hero ' . esc_attr($size) . '" ' . $style . '>';
            $output .= '<div class="usa-grid">';
                $output .= $this->HeroContent->getContent();

            $output .= '</div>';
        $output .= '</section>';
        return $output;
    }


    public function isPostFormat()
    {
        global $post;


        if ($this->currentpage !== 'singular') {
            return false;
        }

        $format = get_post_format();

        if ($format == 'video' && $this->HeroContent->getVideo()) {
            return 'video';
        } elseif ($format == 'gallery' && $this->HeroContent->getGallery()) {
            return 'gallery';
        } elseif ($format == 'image' && $this->HeroContent->getImage()) {
            return 'image';
        } elseif ($format == 'audio' && $this->HeroContent->getAudio()) { 
            add_action('wp_footer', 'benjamin_enqueue_visualizer_script');
            return 'audio';
        } elseif ($format == 'quote' && $this->HeroContent->getQuote()) {
            return 'quote';
        } else {
            return false;
        }

        return false;
    }


    /**
     * The hero has different sizes depending on which template is displayed
     * @param  [type] $template [description]
     * @return [type]           [description]
     */
    public function heroSize($template = null)
    {

        $setting = get_theme_mod($template . '_hero_size_setting', 'slim');

        $size ='usa-hero--'.$setting;
        return $size;
    }
}
