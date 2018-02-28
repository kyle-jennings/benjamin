<?php

function benjamin_get_sidebar($template, $position = 'none', $size ='BENJAMIN_ONE_FOURTH'){

    $class = '';
    $vertical = array('left', 'right');
    $horizontal = array('top', 'bottom');

    $size = $size ? constant($size) : BENJAMIN_ONE_THIRD;

    if(in_array($position, $vertical)):
        $class = $size;
    endif;

    $visibility = get_theme_mod($template . '_sidebar_visibility_setting', 'always-visible');
    $class .= ' '. $visibility;

    ?>

    <div class="sidebar <?php echo esc_attr($class); ?> widgetarea--<?php echo esc_attr($template); ?>">
        <?php dynamic_sidebar($template); ?>
    </div>

    <?php


}
