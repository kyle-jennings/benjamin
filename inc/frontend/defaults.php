<?php

function uswds_default_header_order() {
    $arr = array(

        (object) array (
            'name' => 'navbar',
            'label' => 'Navbar'
        ),
        (object) array (
            'name' => 'hero',
            'label' => 'Hero'
        ),
    );

    $banner = (object) array(
                'name' => 'banner',
                'label' => 'Banner'
            );

    if(uswds_is_dot_gov())
        array_unshift($arr, $banner);

    return $arr;
}
