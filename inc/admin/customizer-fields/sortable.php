<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Sortable_Custom_Control extends WP_Customize_Control
{

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->visibility_settings = $args['visibility_settings'] ? $args['visibility_settings'] : false;
        parent::__construct( $manager, $id, $args );
    }


    private function calculate_available() {

        $output = '';

        $components = $this->choices;
        $saved = $this->value();

        if(!empty($saved))
            $components = $this->map_saved_components($saved);


        foreach($components as $name=>$label){
            $output .= $this->get_sortable_markup( $name, $label);
        }
        return $output;
    }


    // the actual list items in teh sortable areas
    private function get_sortable_markup( $name, $label) {

        $output = '';

        $output .= '<li id="'.$name.'" class="sortable">';
            $output .=  '<h6 class="sortable__title">';
                $output .= $label;
            $output .= '</h6>';

        $output .= '</li>';
        return $output;
    }


    private function map_saved_components($saved = array()){
        $ret = array();
        $saved = json_decode($saved);

        foreach($saved as $comp){
            $name = $comp->name;
            $label = $comp->label;
            if(array_key_exists($name, $this->choices) ){
                $ret[$name] = $label;
            }
        }

        // should add the missing component
        $ret = array_merge($ret, $this->choices);
        // $missing = array_diff($this->choices, $ret);
        // foreach($missing as $n=>$l)
        //     $ret[$name] = $l;

        return $ret;
    }

    private function get_available(){
        $output = '';
        $output .= $this->calculate_available();
        return $output;
    }


    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {

    ?>
        <label>
            <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
            </span>
        </label>


        <div class="sortables">

            <div>
                <ol class="sortables__list js--sortables sortables__active-list
                    js--sortable-active <?php echo $this->id ?>"
                    data-sortable-group="<?php echo $this->id ?>"
                    >
                    <?php echo $this->get_available(); ?>
                </ol>
            </div>


            <input type="hidden"
                id="<?php echo $this->id; ?>"
                name="<?php echo $this->id; ?>"
                <?php $this->link(); ?>
                data-customize-setting-link="<?php echo $this->id; ?>"
                value='<?php echo $this->value();?>'
            />
        </div>


        <?php

    }

}
