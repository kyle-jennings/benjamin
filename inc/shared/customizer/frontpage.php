<?php


function benjamin_frontpage_settings($wp_customize) {


    // select the what to display in the header
    $wp_customize->add_setting( 'frontpage_hero_content_setting', array(
        'default'  => 'callout',
        'sanitize_callback' => 'benjamin_frontpage_hero_content_sanitize',
    ) );

    $wp_customize->add_control( 'frontpage_hero_content_control', array(
            'description' => __('Select what to display in the header.','benjamin'),
            'label'   => __('Header Page Content', 'benjamin'),
            'section' => 'frontpage_settings_section',
            'settings'=> 'frontpage_hero_content_setting',
            'priority' => 1,
            'type' => 'select',
            'choices' => array(
                'callout' => 'Callout',
                'page' => 'Select a Page',
                'nothing' => 'Nothing',
            )
        )
    );


    // Select the page link to use in the callout
     $wp_customize->add_setting( 'frontpage_hero_callout_setting', array(
         'default' => '',
         'sanitize_callback' => 'absint',
     ) );
     $wp_customize->add_control( 'frontpage_hero_callout_control',
         array(
             'description' => __('Display a button link in the callout to a selected page','benjamin'),
             'label'   => __('Callout Button Link', 'benjamin'),
             'section' => 'frontpage_settings_section',
             'settings'=> 'frontpage_hero_callout_setting',
             'type'    => 'dropdown-pages',
             'priority' => 1,
             'active_callback' => function() use ( $wp_customize ) {
                   return 'callout' === $wp_customize->get_setting( 'frontpage_hero_content_setting' )->value();
              },
         )
     );



    $wp_customize->add_setting( 'frontpage_hero_page_setting', array(
        'default'        => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'frontpage_hero_page_control', array(
            'label'   => __('Select a Page', 'benjamin'),
            'section' => 'frontpage_settings_section',
            'settings'=> 'frontpage_hero_page_setting',
            'type'    => 'dropdown-pages',
            'priority' => 1,
            'active_callback' => function() use ( $wp_customize ) {
                  return 'page' === $wp_customize->get_setting( 'frontpage_hero_content_setting' )->value();
             },
         )
    );



     /**
      * Sortables
      * @var string
      */
     $wp_customize->add_setting( 'frontpage_sortables_setting', array(
         'default'        => '',
         'sanitize_callback' => 'benjamin_frontpage_sortable_sanitize',
     ) );

     $description = 'The page content is sortable, and optional.  Simply drag the
     available components from the "available" box over to active.  This setting
     does not depend on the "Settings Active" setting above.';

     $wp_customize->add_control( new Benjamin_Sortable_Control( $wp_customize,
        'frontpage_sortables_control', array(
            'description' => $description,
            'label'   => __('Sortable Page Content', 'benjamin'),
            'section' => 'frontpage_settings_section',
            'settings'=> 'frontpage_sortables_setting',
            'priority' => 1,
            'optional' => true,
            'choices' => array(
                    'widget-area-1' => 'Widget Area 1',
                    'widget-area-2' => 'Widget Area 2',
                    'widget-area-3' => 'Widget Area 3',
                    'page-content' => 'Page Content'
                ),
            )
        )
    );

}
add_action('customize_register', 'benjamin_frontpage_settings');


/**
 * ----------------------------------------------------------------------------
 * Sanitization settings
 * ----------------------------------------------------------------------------
 */


function benjamin_frontpage_hero_callout_sanitize($val) {
    $pages = get_posts(array('post_type' => 'page', 'posts_per_page' => -1, 'fields' => 'ids'));

    if( !in_array($val, $pages) && 'publish' == get_post_status( $val ) )
        return null;

    return $val;
}


function benjamin_frontpage_sortable_sanitize($val) {
    $valids = array(
        'widget-area-1',
        'widget-area-2',
        'widget-area-3',
        'page-content',
    );

    $valid = true;
    $tmp_val = json_decode($val);
    foreach($tmp_val as $v){
        if( !in_array($v->name, $valids) )
            $valid = false;
    }

    if(!$valid)
        return null;

    return $val;
}


function benjamin_frontpage_hero_content_sanitize($val) {

    $valids = array(
        'callout',
        'page',
        'nothing',
    );


    if( !in_array($val, $valids) )
        return null;

    return $val;
}
