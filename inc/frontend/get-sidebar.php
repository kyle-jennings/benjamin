<?php


function benjamin_get_sidebar($template, $position = 'none'){

    $class = '';
    $vertical = array('left', 'right');
    $horizontal = array('top', 'bottom');

    if(in_array($position, $vertical)):
        $class = BENJAMIN_SIDEBAR_WIDTH;
    endif;

    $visibility = get_theme_mod($template . '_sidebar_visibility_setting');
    $class .= ' '. $visibility;
?>

    <div class="sidebar <?php echo $class; ?> widgetarea--<?php echo $template; ?>">
        <?php dynamic_sidebar($template); ?>
    </div>

<?php


}
