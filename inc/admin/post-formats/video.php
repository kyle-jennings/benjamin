<?php

class PostFormatVideo extends PostFormat {

    // register the metabox
    public static function register_meta_box($screens = array())
    {

        foreach(self::$screens as $screen){
            add_meta_box(
                'post_formats_video',
                __('Video', 'benjamin'),
                array('PostFormatVideo', 'meta_box_markup'),
                $screen,
                'top',
                'default'
            );
        }
    }


    // the markup
    public static function meta_box_markup($post)
    {

        wp_nonce_field('post_format_video_nonce', 'post_format_video_nonce');
        $url = get_post_meta($post->ID, '_post_format_video', true);

    ?>

        <div class="pfp-media-holder">
            <?php echo call_user_func( array('PostFormatVideo', 'get_the_video_player_markup'), $url );  // WPCS: xss ok.  ?>
        </div>

        <a class="button pfp-js-media-library" data-media="video"
            id="post_format_video_select">
            <span class="dashicons dashicons-format-video"></span>
            Select Video
        </a>

        <span class="pfp-or-hr">or use an oembed url</span>

        <input class="post_format_value" data-media="video" name="post_format_video" type="url"
            id="post_format_video_value" value="<?php echo esc_url_raw($url); ?>" />

        <a class="pfp-js-remove-media" data-media="video"
            href="#" >Remove Video</a>

        <?php
    }


    // save the value
    public static function meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $nonce = isset( $_POST[ 'post_format_video_nonce'] ) 
            ? wp_verify_nonce( $_POST['post_format_video_nonce'], 'post_format_video_nonce')  // WPCS: xss ok.
            : false;
        $is_valid_nonce = $nonce ? 'true' : 'false';

        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }

        if(isset($_POST['post_format_video'])){
            update_post_meta($post_id, '_post_format_video', esc_url($_POST['post_format_video']) );
        }
    }



    // determine the type of video - must be valid
    private static function get_video_type($url) {

        $type = null;
        if('.mp4' == substr( $url, -4 ) ){
            $type = 'mp4';
        } elseif( '.mov' == substr( $url, -4 ) ) {
            $type = 'mov';
        } elseif('.webm' == substr( $url, -5 )) {
            $type = 'webm';
        } elseif ( preg_match( '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $url ) ) {
            $type = 'youtube';
        } elseif( preg_match('#^https?://(.+\.)?vimeo\.com/.*#', $url ) ) {
            $type = 'vimeo';
        }

        return $type;
    }


    // regex to find the youtube ID, this will be used for various things such as the video thumbnail
    public static function get_youtube_id($url) {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1];
    }


    //the video player markup
    public static function get_the_video_player_markup($url = null) {
        if(!$url)
            return;

        $settings = '';
        $src = 'src';
        $type = self::get_video_type($url);

        $output = '';

        $atts = '';

        if($type !== 'youtube' && $type !== 'vimeo'){

            $atts = 'controls';
            $output .= '<video class="video pfp-video" '.esc_attr($atts).' '.$src.'="'.esc_attr($url).'" type="video/'.esc_attr($type).'"></video>';

        }else {

            $id = self::get_youtube_id($url);
            $poster = 'style="background: url(http://img.youtube.com/vi/'.$id.'/0.jpg) no-repeat cover;"';

            $settings = 'controls=1';
            $url = 'https://www.youtube.com/embed/'.$id.'?'.$settings;

            $output .= '<iframe class="video pfp-embed" '.$src.'="'.esc_attr($url).'" frameborder="0" height="100%" width="100%" allowfullscreen ></iframe>';

        }



        return $output;
    }


    // this might not be needed anymore
    private static function youtubeEmbedLink($url)
    {
        $id = self::get_youtube_id($url);
        return 'https://www.youtube.com/embed/'.$id;
    }



    // this might not be needed anymore
    private static function displayVideo($url = null, $type = 'local')
    {
        $vis = 'pfp-hide';
        if(!$url)
            return $vis;

        if($type == 'youtube' && self::get_video_type($url) == 'youtube')
            $vis = '';

        if($type !=='youtube' && in_array( self::get_video_type($url), array('mp4','mov','webm') ) )
            $vis = '';

        return $vis;
    }


}
