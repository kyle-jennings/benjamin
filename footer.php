<?php
/**
* The template for displaying the footer
*
* Contains the closing of the #content div and all content after.
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package Benjamin
*/

?>

</main><!-- #main-content -->

    <?php
        $footer_size = get_theme_mod('footer_size_setting');
        $footer_size = $footer_size ? $footer_size : 'slim';
        get_template_part('components/footers/footer', $footer_size);
    ?>

<?php wp_footer(); ?>

</body>
</html>
