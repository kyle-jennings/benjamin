<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Benjamin_Checkbox_Group_Control extends WP_Customize_Control
{
    public $type = 'checkbox-group';

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->visibility_settings = $args['visibility_settings'] ? $args['visibility_settings'] : false;
        parent::__construct( $manager, $id, $args );
    }

    public function render_content()
    {
        if ( empty( $this->choices ) )
            return;

        $output = '';
        $saved = json_decode($this->value());

        $output .= '<span class="customize-control-title">'.$this->label.'</span>';

        $output .= '<ul id="js--'.$this->id.'"
            class="checkbox-group js--checkbox-group"
            data-setting="'.$this->setting->id.'"
            >';
            foreach($this->choices as $k=>$v){
                $checked = null;

                if($saved && in_array($k, $saved))
                    $checked = 'checked';

                $output .= '<li>';

                    $output .= '<label>';
                        $output .= '<input name="'.$this->id.'" type="checkbox" value="'.$k.'" '.$checked.'>';
                        $output .= $v;
                    $output .= '</label>';

                $output .= '</li>';
            }

        $output .= '</ul>';

        $output .= '<input type="hidden" id="'.$this->id.'" ';
            $output .= 'name="'.$this->id.'" data-customize-setting-link="'.$this->setting->id.'" ';
            $output .= 'value=\''.$this->value().'\' ';
        $output .= ' />';

        echo $output;
    }
}
