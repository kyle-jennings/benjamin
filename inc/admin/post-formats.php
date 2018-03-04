<?php

class PostFormat {
    
    public static $screens = array();
    public static $formats = array( 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'aside', 'status');

    public static function init($screens = array() ){
        self::$screens = $screens;

        add_theme_support('post-formats', self::$formats);

        // creates the forms for each psot format type
        foreach(self::$formats as $format){

            // so long the class exists, add teh metabox and save meta code
            if( class_exists( 'PostFormat' . ucfirst($format) ) ) {
                $className = 'PostFormat' . ucfirst($format);
                $class = new $className(self::$screens);

                add_action('add_meta_boxes', array($class, 'register_meta_box'));
                add_action('save_post', array($class, 'meta_box_save'));
            }


        }


        // init the actions, enque scripts, and add metaboxes after the title area
        add_action('init', array('PostFormat', 'cpt_support'), 11);
        add_action('admin_enqueue_scripts', array('PostFormat', 'enqueue'));
        add_action('edit_form_after_title', array('PostFormat', 'display_meta_boxes'));


    }



    // displays the metaboxes
    public static function display_meta_boxes()
    {
        global $post, $wp_meta_boxes;

        do_meta_boxes( get_current_screen(), 'top', $post );
        unset( $wp_meta_boxes[get_post_type($post)]['top'] );

    }


    // add support for CPTs
    public static function cpt_support(){
        foreach(self::$screens as $screen){
            add_post_type_support($screen, 'post-formats');
            call_user_func('register_taxonomy_for_object_type', 'post_format', $screen );
        }
    }


    /**
     * Enqueue the JS scripts
     * @return [type] [description]
     */
    public static function enqueue(){
        global $typenow;

        if(in_array($typenow, self::$screens)){
            $file = get_template_directory_uri() . '/assets/admin/js/';
            $file .=  '_benjamin-post-formats-min.js';

            wp_enqueue_script('post_formats_js', $file, array('jquery'), null, true);

        }
    }

}


$files = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', '_markup');
$admin_root = dirname(__FILE__ );

foreach($files as $file)
    require_once $admin_root . DIRECTORY_SEPARATOR . 'post-formats' . DIRECTORY_SEPARATOR . $file . '.php';

PostFormat::init( 
    array( 'post', 'page' ) 
);