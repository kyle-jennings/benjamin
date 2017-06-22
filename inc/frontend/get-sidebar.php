<?php


function benjamin_get_sidebar($template, $position = 'none'){

    $class = '';
    $vertical = array('left', 'right');
    $horizontal = array('top', 'bottom');

    $sidebar_width = get_theme_mod('sidebar_size_setting');
    $sidebar_width = $sidebar_width ? constant($sidebar_width) : BENJAMIN_ONE_THIRD;

    if(in_array($position, $vertical)):
        $class = $sidebar_width;
    endif;

    $visibility = get_theme_mod($template . '_sidebar_visibility_setting');
    $class .= ' '. $visibility;
?>

    <div class="sidebar <?php echo $class; ?> widgetarea--<?php echo $template; ?>">
        <?php dynamic_sidebar($template); ?>
    </div>

<?php


}
