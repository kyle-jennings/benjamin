<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Benjamin_Checkbox_Group_Control extends WP_Customize_Control
{
    public $type = 'checkbox-group';

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        parent::__construct( $manager, $id, $args );
    }

    public function render_content()
    {
        if ( empty( $this->choices ) )
            return;

        $output = '';
        $saved = json_decode($this->value());

        $output .= '<span class="customize-control-title">'.esc_html($this->label).'</span>';

        $output .= '<p class="description customize-control-description">';
            $output .= esc_html($this->description);
        $output .= '</p>';

        $output .= '<ul id="js--'.esc_attr($this->id).'"
            class="checkbox-group js--checkbox-group"
            data-setting="'.esc_attr($this->setting->id).'"
            >';
            foreach($this->choices as $k=>$v){
                $checked = null;

                if($saved && in_array($k, $saved))
                    $checked = 'checked';

                $output .= '<li>';

                    $output .= '<label>';
                        $output .= '<input name="'.esc_attr($this->id).'" type="checkbox" value="'.$k.'" '.$checked.'>';
                        $output .= $v;
                    $output .= '</label>';

                $output .= '</li>';
            }

        $output .= '</ul>';

        $output .= '<input type="hidden" id="'.esc_attr($this->id).'" ';
            $output .= 'name="'.esc_attr($this->id).'" data-customize-setting-link="'.esc_attr($this->setting->id).'" ';
            $output .= 'value=\''.$this->value().'\' ';
        $output .= ' />';

        echo $output; //WPCS: xss ok.
    }
}
