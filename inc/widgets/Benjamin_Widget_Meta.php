<?php
/**
 * Widget API: WP_Widget_Meta class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement a Meta widget.
 *
 * Displays log in/out, RSS feed links, etc.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class Benjamin_Widget_Meta extends WP_Widget {

	/**
	 * Sets up a new Meta widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_meta',
			'description' => __( 'Login, RSS, &amp; WordPress.org links.', 'benjamin' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'meta', __( 'Meta','benjamin' ), $widget_ops );
	}


    private function menuStyleArgs($style = 'side_nav'){
        if($style == 'side_nav'):
            $class = 'usa-sidenav-list';
        elseif($style == 'nav_list'):
            $class = 'usa-unstyled-list';
        else:
            $class = '';
        endif;

        return $class;
    }


    public function dropdown_js($dropdown_id)
    {

        ob_start();
        ?>
        <script type='text/javascript'>
        /* <![CDATA[ */
        (function() {
        var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );

        function onCommentChange() {
            if (dropdown.selectedIndex <= 0 )
                return false;

            location.href = dropdown.options[ dropdown.selectedIndex ].value;
        }
        dropdown.onchange = onCommentChange;
        })();
        /* ]]> */
        </script>
        <?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }


    public function menu( $style )
    {
        $style_args = $this->menuStyleArgs($style);
        $class = $style_args ? 'class="'.esc_attr($style_args).'"' : '';


        echo '<ul '.$class.'>'; // WPCS: xss ok.

        wp_register();
        ?>
        <li><?php wp_loginout(); ?></li>
        <li><a href="<?php echo esc_url( get_bloginfo( 'rss2_url' ) ); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>', 'benjamin'); // WPCS: xss ok. ?></a></li>
        <li><a href="<?php echo esc_url( get_bloginfo( 'comments_rss2_url' ) ); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>', 'benjamin'); // WPCS: xss ok. ?></a></li>
        <?php
        /**
         * Filters the "Powered by WordPress" text in the Meta widget.
         *
         * @since 3.6.0
         *
         * @param string $title_text Default title text for the WordPress.org link.
         */
        echo apply_filters( 'widget_meta_poweredby', sprintf( '<li><a href="%s" title="%s">%s</a></li>', // WPCS: xss ok.
            esc_url( __( 'https://wordpress.org/', 'benjamin' ) ),
            esc_attr__( 'Powered by WordPress, state-of-the-art semantic personal publishing platform.', 'benjamin' ),
            _x( 'WordPress.org', 'meta widget link text', 'benjamin' )
        ) );

        wp_meta();


        echo '</ul>';


    }


	/**
	 * Outputs the content for the current Meta widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Meta widget instance.
	 */
	public function widget( $args, $instance ) {
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty($instance['title']) ? __( 'Meta', 'benjamin' ) : $instance['title'], $instance, $this->id_base );
        $style = ! empty( $instance['menu_style'] ) ? $instance['menu_style'] : 'side_nav';


		echo $args['before_widget']; // WPCS: xss ok.
		if ( $title ) {
			echo $args['before_title'] . esc_html($title) . $args['after_title']; // WPCS: xss ok.
		}

        if($style == 'dropdown') {
            $this->dropdown();
        } else {
            $this->menu($style );
        }

		echo $args['after_widget']; // WPCS: xss ok.
	}

	/**
	 * Handles updating settings for the current Meta widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
        if ( ! empty( $new_instance['menu_style'] ) ) {
            $instance['menu_style'] = sanitize_text_field($new_instance['menu_style']);
        }

		return $instance;
	}

	/**
	 * Outputs the settings form for the Meta widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = sanitize_text_field( $instance['title'] );
        $saved_style = isset( $instance['menu_style'] ) ? $instance['menu_style'] : '';

?>
			<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'benjamin'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                placeholder="<?php esc_attr_e( 'Meta', 'benjamin' ); ?>"
                type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
        // styles
        $find = array('-', '_');
        $menu_styles = array('side_nav', 'nav_list', 'list');

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'menu_style' )); ?>">
                    <?php esc_html_e( 'Menu Style:', 'benjamin' ); ?>
            </label>
            <select id="<?php echo esc_attr($this->get_field_id( 'menu_style' )); ?>"
                  name="<?php echo esc_attr($this->get_field_name( 'menu_style' )); ?>">
                <?php
                    foreach ( $menu_styles as $style ) :
                        $label = ucwords(str_replace($find, ' ', $style ));
                ?>
                    <option value="<?php echo esc_attr( $style ); ?>"
                        <?php selected( $saved_style, $style ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <?php
	}
}
