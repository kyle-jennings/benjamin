<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Benjamin_Color_Scheme_Custom_Control extends WP_Customize_Control
{
    public $type = 'color-scheme';
    
    public function __construct($manager, $id, $args = array(), $options = array())
    {

        parent::__construct( $manager, $id, $args );
    }


    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {

        $schemes = $this->choices;
    ?>
        <label>
            <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
            </span>
            <ul>
                <?php
                    foreach($schemes as $name=>$colors):
                ?>
                <li class="cf">
                    <input type="radio" name="<?php echo $this->id; ?>"
                        <?php $this->link(); ?>
                        data-customize-setting-link="<?php echo $this->id; ?>"
                        value="<?php echo $name; ?>"
                        <?php selected($this->value(), $name) ?>
                        />
                        <?php echo ucfirst($name); ?>

                    <ul class="swatches">
                        <?php foreach($colors as $color): ?>
                            <li class="swatch"
                            style="background-color:<?php echo $color; ?>;"></li>
                        <?php endforeach; ?>
                    </ul>

                </li>
            <?php endforeach; ?>

            </ul>
        </label>
    <?php
    }
}
