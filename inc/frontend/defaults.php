<?php

function benjamin_default_header_order() {
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

    if(benjamin_is_dot_gov())
        array_unshift($arr, $banner);

    return $arr;
}
