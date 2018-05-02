<?php
/**
 * Widget API: WP_Widget_Pages class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Pages widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class Benjamin_Widget_Pages extends WP_Widget {
	/**
	 * Sets up a new Pages widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_pages',
			'description' => __( 'A list of your site&#8217;s Pages.', 'benjamin' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'pages', __( 'Pages', 'benjamin' ), $widget_ops );
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


    public function dropdown($sortby, $exclude, $show_children)
    {
        $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";

        $output = '';
		$output .= '<select id="'.esc_attr($dropdown_id).'">';
        $output .= '<option>-- Select Page --</option>';
        $pages = get_pages(array(
            'sort_column' => $sortby,
            'exclude' => $exclude,
            'depth' => 1
        ));


        $last_id = 0;
        foreach($pages as $page){
            // sets the indent
            $indent = ($show_children == '1' && $page->post_parent > 0)
                ? '&nbsp;&nbsp; - ' : '' ;

            $output .= '<option value="' . esc_url(get_permalink($page->ID)) . '">';
                $output .= $indent . $page->post_title; // WPCS: xss ok.
            $output .= '</option>';
        }
        $output .= '</select>';
        $output .= $this->dropdown_js($dropdown_id);

        echo $output;// WPCS: xss ok.
    }


    public function child_menu($children)
    {
        $output = '';
        $output .= '<ul class="usa-sidenav-sub_list">';
        foreach($children as $child){
            $output .= '<li>';
                $output .= '<a href="' . esc_url(get_permalink($child->ID)) . '">';
                    $output .= $child->post_title;
                $output .= '</a>';
            $output .= '</li>';
        }
        $output .= '</ul>';

        return $output;
    }

    public function menu($sortby, $exclude, $style, $show_children)
    {
        $style_args = $this->menuStyleArgs($style);
        $class = $style_args ? 'class="'.$style_args.'"' : '';

        $output = '';
		$output .= '<ul '.$class.'>';

        $pages = get_pages(array(
            'sort_column' => $sortby,
            'exclude' => $exclude,
            'parent' => 0
        ));

        $children = array();
        if($show_children == '1'):
            $children_q = get_pages(array(
                'sort_column' => $sortby,
                'exclude' => $exclude,
            ));

            foreach($children_q as $child) {
                if($child->post_parent > 0){
                    $children[$child->post_parent][] = $child;
                }
            }
        endif;


        $last_id = 0;
        foreach($pages as $page){

            $output .= '<li>';
                $output .= '<a href="' . esc_url(get_permalink($page->ID)) . '">';
                    $output .= $page->post_title;
                $output .= '</a>';

                if(!empty($children[$page->ID]))
                    $output .= $this->child_menu($children[$page->ID]);
            $output .= '</li>';

            $last_id = $page->ID;

        }

        $output .= '</ul>';

        echo $output; //WPCS: xss ok.
    }

	/**
	 * Outputs the content for the current Pages widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Pages widget instance.
	 */
	public function widget( $args, $instance ) {
		/**
		 * Filters the widget title.
		 *
		 * @since 2.6.0
		 *
		 * @param string $title    The widget title. Default 'Pages'.
		 * @param array  $instance An array of the widget's settings.
		 * @param mixed  $id_base  The widget ID.
		 */
         $children = ! empty( $instance['children'] ) ? '1' : '0';

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? null : $instance['title'], $instance, $this->id_base );
		$sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
		$exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];
		if ( $sortby == 'menu_order' )
			$sortby = 'menu_order, post_title';

        $style = ! empty( $instance['menu_style'] ) ? $instance['menu_style'] : 'side_nav';

		/**
		 * Filters the arguments for the Pages widget.
		 *
		 * @since 2.8.0
		 *
		 * @see wp_list_pages()
		 *
		 * @param array $args An array of arguments to retrieve the pages list.
		 */
		$depth = ($children == '1') ? 2 : 1;
		$out = wp_list_pages( apply_filters( 'widget_pages_args', array(
			'title_li'    => '',
			'echo'        => 0,
			'sort_column' => $sortby,
			'exclude'     => $exclude,
            'depth'       => $depth
		) ) );

        // if no pages exists, just return false. this prevents further code
        // execution as well as prevents WP's original nested conditionals.
		if ( empty( $out ) )
            return false;

		echo $args['before_widget']; // WPCS: xss ok.
		if ( $title ) {
			echo $args['before_title'] . esc_html($title) . $args['after_title']; // WPCS: xss ok.
		}

        if($style == 'dropdown') {
            $this->dropdown($sortby, $exclude, $children);
        } elseif($style !== 'list') {
            $this->menu($sortby, $exclude, $style, $children);
        } else {
            echo '<ul>';
                echo $out; //WPCS: xss ok.
            echo '</ul>';
        }

		echo $args['after_widget']; // WPCS: xss ok.

	}
	/**
	 * Handles updating settings for the current Pages widget instance.
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
		if ( in_array( $new_instance['sortby'], array( 'post_title', 'menu_order', 'ID' ) ) ) {
			$instance['sortby'] = $new_instance['sortby'];
		} else {
			$instance['sortby'] = 'menu_order';
		}
		$instance['exclude'] = sanitize_text_field( $new_instance['exclude'] );
        $instance['children'] = !empty($new_instance['children']) ? 1 : 0;

        if ( ! empty( $new_instance['menu_style'] ) ) {
            $instance['menu_style'] = sanitize_text_field($new_instance['menu_style']);
        }

		return $instance;
	}
	/**
	 * Outputs the settings form for the Pages widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'sortby' => 'post_title', 'title' => '', 'exclude' => '') );
        $saved_style = isset( $instance['menu_style'] ) ? $instance['menu_style'] : '';
        $children = isset( $instance['children'] ) ? (bool) $instance['children'] : false;

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'benjamin' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" placeholder="<?php esc_attr_e( 'Pages', 'benjamin' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>"><?php esc_html_e( 'Sort by:', 'benjamin' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'sortby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>" class="widefat">
				<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php esc_html_e('Page title', 'benjamin'); ?></option>
				<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php esc_html_e('Page order', 'benjamin'); ?></option>
				<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php esc_html_e( 'Page ID', 'benjamin' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>"><?php esc_html_e( 'Exclude:', 'benjamin' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['exclude'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>" class="widefat" />
			<br />
			<small><?php esc_html_e( 'Page IDs, separated by commas.', 'benjamin' ); ?></small>
		</p>

        <input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('children')); ?>" name="<?php echo esc_attr($this->get_field_name('children')); ?>"<?php checked( $children ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('children')); ?>"><?php esc_html_e( 'Show child pages', 'benjamin' ); ?></label></p>


        <?php
        // styles
        $find = array('-', '_');
        $menu_styles = array('dropdown', 'side_nav', 'nav_list', 'list');

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
