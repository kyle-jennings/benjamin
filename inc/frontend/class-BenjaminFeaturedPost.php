<?php

class BenjaminFeaturedPost
{
    public $id;
    public $post_type;
    public $video = null;
    public $image = null;
    public $format;
    public $date_format = 'n/j/Y';
    public $output = '';


    public function __construct($id = null, $post_type = 'post', $format = null)
    {
        if (is_null($id) || $id == 0 || !isset($id)) {
            return false;
        }

        $this->id = $id;
        $this->post_type = $post_type;
        $this->format = $format;
        $this->postInformation();
        $this->postImage();
        $this->setContent();
    }


    public function __toString()
    {
        return $this->output;
    }


    public function setContent()
    {

        $label = get_post_type_object($this->post_type)->labels->singular_name;

        $post = get_queried_object();
        if ($post->post_title) {
            $pre_title = $post->post_title;
        } elseif ($post->name) {
            $pre_title = $post->name;
        }

        $output = '';
        $output .= '<div class="usa-featured-post-hero">';
            $output .= '<span class="post-title">';
                $output .= __('Featured ', 'benjamin') . ucfirst($label);
            $output .= '</span>';

            $output .= '<h1>';
                $output .= '<a href="' . $this->url . '">' . $this->title . '</a>';
            $output .= '</h1>';
            $output .= '<div class="entry-meta">';
                $output .= $this->getMeta();
            $output .= '</div>';

        if ($this->format == 'use-excerpt' && $this->excerpt) {
            $output .= '<p class="header-content__description">';
                $output .= $this->excerpt;
            $output .= '</p>';
        }

        $output .= '</div>';
        $this->output = $output;
    }


    private function postInformation()
    {
        $id = $this->id;
        $post = get_post($id);
        $this->title = get_the_title($id);
        $this->terms = get_the_term_list($id, 'category', null, ', ');
        $this->date = get_the_date($this->date_format, $id);
        $this->url = esc_url(get_permalink($id));
        $this->excerpt = get_the_excerpt($id);

        $this->author = $post->post_author;
    }

    private function postVideo()
    {
        if (benjamin_has_post_video()) {
            $this->video = benjamin_get_the_post_video_url();
        }
    }


    private function postImage()
    {
        $sizes = get_intermediate_image_sizes();
        $thumb_id = get_post_thumbnail_id($this->id);
        $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);

        // we cannot use the default image because it interfeers with our user settings
        if (strpos(reset($thumb_url_array), 'wp-includes/images/media/default.png')) {
            return false;
        }

        $this->image = $thumb_url_array[0];
    }


    public function getMeta()
    {


        $id = $this->id;
        $aid = $this->author;

        $m = get_the_time('m');
        $d = get_the_date('F j');
        $y = get_the_time('Y');

        $month_url = get_month_link($y, $m);
        $year_url = get_year_link($y);
        $date = '';
        $date .= '<a class="entry-date published" href="' . $month_url . '">' . $d . '</a>, ';
        $date .= '<a class="entry-date published" href="' . $year_url . '">' . $y . '</a>';

        $author = '<span class="author vcard">';
        if (function_exists('coauthors_posts_links')) {
            $author .= coauthors_posts_links(null, null, null, null, false);
        } else {
            $author .= '<a class="url fn n"
                href="' . get_author_posts_url($aid) . '">';
                $author .= get_the_author_meta('display_name', $aid);
            $author .= '</a>';
        }
        $author .= '</span>';

        $cats = '';
        // benjamin_get_cpt_custom_tax_terms($this->id);
        if ($categories_list = benjamin_get_the_category_list($this->id)) {
            $cats = '<span class="cat-links">' . __('Posted in&nbsp;', 'benjamin') . $categories_list . '</span>';
        }

        return '<span class="posted-on">' . $date . '</span>
            <span class="byline"> - ' . $author . '</span> <br > ' . $cats;
    }
}
