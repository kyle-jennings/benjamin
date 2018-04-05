<?php

function benjamin_page_sortables($target = null) {

    if($target == null)
        return false;

    $page_content_label = __('Page Content', 'benjamin');
    $target_name = strtok($target, '_');

    $sortables = get_theme_mod($target, '[{"name":"page-content","label":"' . $page_content_label . '"}]');


    if(!$sortables || $sortables == '[]'){
        $sortables = '[{"name":"page-content","label":"' . $page_content_label . '"}]';
    }

    $sortables = json_decode($sortables);
    foreach($sortables as $s){
        $name = $s->name;
        switch($name):
            case 'widget-area-1':
                benjamin_sortable_widget_area_content($target_name, 1);
                break;
            case 'widget-area-2':
                benjamin_sortable_widget_area_content($target_name, 2);
                break;
            case 'widget-area-3':
                benjamin_sortable_widget_area_content($target_name, 3);
                break;
            case 'page-content':
                benjamin_page_content($target_name);
                break;
        endswitch;
    }

}

function benjamin_page_content($target = null) {
    ?>
    <div class="sortable-row sortable-row--<?php echo esc_attr($target); ?> cf">
    <?php
    if ( have_posts() ) :

        /* Start the Loop */
        while ( have_posts() ) : the_post();

            /*
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
             if ( 'posts' == get_option( 'show_on_front' ) && $target == 'frontpage' ) {
                 get_template_part( 'template-parts/feed/content', get_post_format() );
             } else {
                 get_template_part( 'template-parts/singles/content', 'page' );
             }


        endwhile;

        the_posts_navigation();

    else :

        get_template_part( 'template-parts/content', 'none' );

    endif;
    ?>
    </div>
    <?php
}


function benjamin_sortable_widget_area_content($target = null, $num) {
    if(!$target || !$num)
        return false;

    $target = $target . '-widget-area-'.$num;

?>
    <div class="sortable-row sortable-row--<?php echo esc_attr($target); ?> cf">
        <?php dynamic_sidebar($target); ?>
    </div>
<?php
}


function benjamin_sortable_default($target_name){

    $url = esc_url(admin_url( 'customize.php?autofocus[section]='.$target_name.'_settings_section' ));

    $output = '';
    $output .= '<h2>' . __('Page not configured', 'benjamin') . '</h2>';
    $output .= '<p> <a href="'.$url.'">Click here</a> to set up this page. </p>';

    return $output;
}
