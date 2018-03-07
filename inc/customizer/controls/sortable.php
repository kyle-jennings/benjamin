<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Benjamin_Sortable_Control extends WP_Customize_Control
{
    public $type = 'optional-sortable';
    public $optional;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        parent::__construct( $manager, $id, $args );
    }


    private function calculate_available() {

        $output = '';

        $components = $this->choices;
        $saved = json_decode($this->value());

        foreach($components as $name=>$label){
            $continue = false;
            if(!empty($saved)):

                foreach($saved as $s){

                    if($name == $s->name){
                        $continue = true;
                    }
                }

                if($continue == true)
                    continue;

            endif;

            $output .= $this->get_sortable_markup( $name, $label);
        }
        return $output;
    }


    // the actual list items in teh sortable areas
    private function get_sortable_markup( $name, $label) {

        $output = '';

        $output .= '<li id="'.esc_attr($name).'" class="sortable">';
            $output .=  '<h6 class="sortable__title">';
                $output .= esc_html($label);
            $output .= '</h6>';

        $output .= '</li>';
        return $output;
    }


    // get the active components
    private function get_active(){
        $output = '';
        $components = $this->choices;
        $saved = json_decode($this->value());


        if(empty($saved))
            return $output;

        foreach($saved as $component){
            $name = $component->name;
            $label = $component->label
                ? $component->label
                : ucwords(str_replace('-',' ',$component->name));

            $output .= $this->get_sortable_markup( $name, $label );
        }

        return $output;
    }


    private function get_available(){
        $output = '';
        $output .= $this->calculate_available();
        return $output;
    }


    private function sortable_list_markup($title = null, $target = null) {
        $method = 'get_'.$title;
        $output = '';

        $output .= '<div>';
            $output .= '<h4 class="sortables__list-title">';
                $output .= ucfirst($title);
            $output .= '</h4>';
            $output .= '<ol class="sortables__list js--'.$target.'-sortables ';
                $output .= 'sortables__'.$title.'-list js--sortables-'.$title.' '.$this->id.'" '; // end class
                $output .= 'data-sortable-group="'.$this->id.'" ';
                $output .= 'data-setting="'.$this->setting->id.'"';
            $output .= '>';
                $output .= call_user_func(array($this, $method));
            $output .= '</ol>';
        $output .= '</div>';

        return $output;
    }

    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {
    $target = str_replace('_sortables_control', '', $this->id);

    ?>
        <label>
            <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
            </span>
        </label>

        <p class="description customize-control-description">
            <?php echo $this->description; //WPCS: xss ok.?>
        </p>
        <div class="sortables">

            <?php echo $this->sortable_list_markup( __('active', 'benjamin'), $target); //WPCS: xss ok. ?>


            <?php
            if($this->optional):
                echo $this->sortable_list_markup( __('available', 'benjamin'), $target); //WPCS: xss ok.
            endif;
            ?>

            <input type="hidden"
                id="<?php echo esc_attr($this->id); ?>"
                name="<?php echo esc_attr($this->id); ?>"
                <?php $this->link(); ?>
                data-customize-setting-link="<?php echo esc_attr($this->id); ?>"
                value='<?php echo esc_attr($this->value());?>'
            />
        </div>


        <?php

    }

}
