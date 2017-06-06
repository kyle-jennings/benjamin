<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Benjamin_Activate_Layout_Custom_Control extends WP_Customize_Control
{
    public $type = 'layout-toggle';

    public function __construct($manager, $id, $args = array(), $options = array())
    {

        parent::__construct( $manager, $id, $args );
    }


    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {

        if ( empty( $this->choices ) )
            return;
        $name = '_customize-radio-' . $this->id;
        echo '<div class="js--toggle-layout-options active-layout--'.$this->id.'">';
        if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif;
        if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo $this->description ; ?></span>
        <?php endif;
        foreach ( $this->choices as $value => $label ) :
            ?>
            <label>
                <input  type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
                <?php echo esc_html( $label ); ?><br/>
            </label>
            <?php
        endforeach;
        echo '</div>';
    }
}
