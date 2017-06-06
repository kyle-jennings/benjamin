<?php


function benjamin_get_sidebar($template, $sidebar_pos = 'none'){

    $vertical = array('left', 'right');
    $horizontal = array('top', 'bottom');

    $class = '';
    if(in_array($sidebar_pos, $vertical)):
        $class = BENJAMIN_SIDEBAR_WIDTH;
    else:
        $class = BENJAMIN_FULL_WIDTH;
    endif;
    $visibility = get_theme_mod($template . '_sidebar_visibility_setting');
    $class .= ' '. $visibility;
?>

    <div class="<?php echo $class; ?> widgetarea--<?php echo $template; ?>">
        <?php dynamic_sidebar($template); ?>
    </div>

<?php


}
