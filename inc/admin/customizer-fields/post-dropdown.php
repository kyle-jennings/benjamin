<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return null;

class Post_Dropdown_Custom_Control extends WP_Customize_Control
{
    private $posts = false;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $postargs = wp_parse_args($options, array('numberposts' => '-1'));
        $this->posts = get_posts($postargs);

        parent::__construct( $manager, $id, $args );
    }

    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {
        if(!empty($this->posts))
        {
            ?>
                <label>
                    <span class="customize-post-dropdown">
                        <?php echo esc_html( $this->label ); ?>
                    </span>
                    <select name="<?php echo $this->id; ?>"
                        id="<?php echo $this->id; ?>"
                        <?php $this->link(); ?>
                        data-customize-setting-link="<?php echo $this->id; ?>"
                    >
                    <?php
                        foreach ( $this->posts as $post )
                        {
                            echo '<option value="'.$post->ID.'" '
                                    . selected($this->value(), $post->ID, false)
                                . '>';
                                echo $post->post_title;
                            echo '</option>';

                        }
                    ?>
                    </select>
                </label>
            <?php
        }
    }
}
