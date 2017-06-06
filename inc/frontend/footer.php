<?php

function benjamin_footer() {
    $template = benjamin_template_settings('template');

    $sortables = get_theme_mod('footer_sortables_setting');
    if(!$sortables || benjamin_hide_layout_part('footer', $template) ) {
        return;
    }

    $sortables = json_decode($sortables);

    foreach($sortables as $s):
        $name = $s->name;

        switch($name):
            case 'return-to-top':
                get_template_part('components/footers/footer', 'return');
                break;
            case 'footer-menu':
                get_template_part('components/footers/footer', 'menu');
                break;
            case 'widget-area-1':
                get_template_part('components/footers/footer', 'widgets-1');
                break;
            case 'widget-area-2':
                get_template_part('components/footers/footer', 'widgets-2');
                break;

        endswitch;

    endforeach;
}
