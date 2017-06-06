<?php
/**
 * The is a template part for displaying the hero section
 *
 * @link https://developer.wordpress.org/reference/functions/get_template_part/
 *
 * @package Benjamin
 */


$template = benjamin_template_settings('template');

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
            if( is_front_page() )
                benjamin_get_hero_callout();
            elseif( !is_page() && !is_single() && !is_singular() ) {
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
