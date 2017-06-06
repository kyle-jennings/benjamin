<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Benjamin_Activated_Sortable_Custom_Control extends WP_Customize_Control
{
    public $type = 'optiona-sortable';
    
    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->visibility_settings = $args['visibility_settings'] ? $args['visibility_settings'] : false;
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

        $output .= '<li id="'.$name.'" class="sortable">';
            $output .=  '<h6 class="sortable__title">';
                $output .= $label;
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


        <div class="sortables">

            <div>
                <h4 class="sortables__list-title">Active</h4>
                <ol class="sortables__list js--<?php echo $target; ?>-sortables sortables__active-list
                    js--sortables-active <?php echo $this->id ?>"
                    data-sortable-group="<?php echo $this->id ?>"
                    >
                    <?php echo $this->get_active(); ?>
                </ol>
            </div>

            <div>
                <h4 class="sortables__list-title">Available</h4>
                <ol class="sortables__list js--<?php echo $target; ?>-sortables js--sortables-available
                <?php echo $this->id ?>"
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
