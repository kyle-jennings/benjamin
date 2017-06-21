<?php
/**
 * The is a template part for displaying the hero section
 *
 * @link https://developer.wordpress.org/reference/functions/get_template_part/
 *
 * @package Benjamin
 */


$template = benjamin_template_settings('template');

$content = get_theme_mod('_404_page_content_setting', 'default');
$pid = get_theme_mod('_404_page_select_setting', null);
$move_content = get_theme_mod('_404_move_page_content_setting', null);

$style = '';
if ( $hero_image = benjamin_hero_image($template) ){
    $style .= 'style="background-image: url(\''.$hero_image.'\')"';
}
?>

 <section class="usa-hero <?php echo benjamin_hero_size($template); ?>" <?php echo $style; ?> >
     <div class="usa-grid">
         <?php
            // This is all gross, fix it
            // should be a class
            if( is_front_page() ){
                benjamin_get_hero_callout();
            } elseif(is_404() && $content !== 'default' && $pid && $move_content == 'yes' ) {
                $page = get_page($pid);
                echo apply_filters('the_content', $page->post_content);
            } elseif( !is_page() && !is_single() && !is_singular() ) {
                echo benjamin_get_feed_title();
            } else {
                echo '<h1>'.get_the_title().'</h1>';
                if ( 'page' !== get_post_type() ) :
        		echo '<div class="entry-meta">';
        			echo benjamin_get_hero_meta();
        		echo '</div>';
        		endif;
            }
         ?>
     </div>
 </section>
