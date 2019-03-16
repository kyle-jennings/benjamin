<?php
/**
 * The front page template file
 *
 * It is used to display the front page of the website.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Benjamin
 */


get_header();

/**
 * get all the settings needed for the the template layout
 *
 * returns:
 * $template
 * $main_width
 * $hide_content
 * $sidebar_position
 *
 */
extract( benjamin_template_settings() );

if( !$hide_content ):
?>


<section id="primary" class="usa-grid usa-section">
    <?php
        if($sidebar_position == 'left'):
            benjamin_get_sidebar($template, $sidebar_position, $sidebar_size);
        endif;
    ?>

    <div class="main-content <?php echo esc_attr($main_width); ?>">
    	<?php
            benjamin_page_sortables('frontpage_sortables_setting');
        ?>
    </div>

    <?php
        if($sidebar_position == 'right'):
          benjamin_get_sidebar($template, $sidebar_position, $sidebar_size);
        endif;
    ?>

</section>

<?php
endif;

get_footer();
