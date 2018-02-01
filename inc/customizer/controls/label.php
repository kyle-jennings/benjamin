<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Benjamin_Label_Custom_Control extends WP_Customize_Control
{
    public $type = 'label';

    public function __construct($manager, $id, $args = array(), $options = array())
    {

        parent::__construct( $manager, $id, $args );
    }


    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {

    ?>
        <label>
            <h2>
                <?php echo esc_html( $this->label ); ?>
            </h2>
        </label>
        <p class="description customize-control-description">
            <?php echo esc_html($this->description); ?>
        </p>
    <?php
    }
}
