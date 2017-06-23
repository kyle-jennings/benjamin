<?php
/**
 * The is a template part for displaying the hero section
 *
 * @link https://developer.wordpress.org/reference/functions/get_template_part/
 *
 * @package Benjamin
 */


$template = benjamin_template();

$style = '';
if ( $hero_image = benjamin_hero_image($template) ){
    $pos = get_theme_mod($template.'_hero_position_setting', 'top-left');
    $pos = str_replace('-',' ', $pos);
    $style = 'style="';
        $style .= 'background-image: url(\''.$hero_image.'\');';
        $style .= 'background-position: '.$pos.';';
    $style .= '"';
}

$video = null;
// $vurl = benjamin_hero_video($template);;
// if($vurl)
//     $video = benjamin_get_the_video_markup($vurl, 'background');
?>

 <section class="usa-hero <?php echo benjamin_hero_size($template); ?>" <?php echo $style; ?> >
     <?php echo $video; ?>
     <div class="usa-grid">
         <?php benjamin_the_hero_content(); ?>
     </div>
 </section>
