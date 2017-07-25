<?php
/**
 * Widget API: WP_Widget_Recent_Comments class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Recent Comments widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class Benjamin_Widget_Recent_Comments extends WP_Widget {
	/**
	 * Sets up a new Recent Comments widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_comments',
			'description' => __( 'Your site&#8217;s most recent comments.', 'benjamin' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'recent-comments', __( 'Recent Comments', 'benjamin' ), $widget_ops );
		$this->alt_option_name = 'widget_recent_comments';
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action( 'wp_head', array( $this, 'recent_comments_style' ) );
		}
	}
 	/**
	 * Outputs the default styles for the Recent Comments widget.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function recent_comments_style() {
		/**
		 * Filters the Recent Comments default widget styles.
		 *
		 * @since 3.1.0
		 *
		 * @param bool   $active  Whether the widget is active. Default true.
		 * @param string $id_base The widget ID.
		 */
		if ( ! current_theme_supports( 'widgets' ) // Temp hack #14876
			|| ! apply_filters( 'show_recent_comments_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
		<?php
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


    public function dropdown($comments, $first_dropdown)
    {
        $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
        $first_dropdown = false;

        $output = '';

        $output .= '<select id="'.$dropdown_id.'">';
        $output .= '<option>-- Select Comment --</option>';
        if ( is_array( $comments ) && $comments ) {
            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
            _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );
            foreach ( (array) $comments as $comment ) {
                $output .= '<option value="'.get_comment_link( $comment ) .'" >';

            /* translators: comments widget: 1 - comment author -  post link */
            $output .= esc_html(  get_comment_author_link( $comment ) . ' &#45; &nbsp;' . get_the_title( $comment->comment_post_ID ) );


                $output .= '</option>';
            }
        }


        $output .= '</select>';
        $output .= $this->dropdown_js($dropdown_id);

        return $output;
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


    public function menu($comments, $style)
    {
        // set up vars
        $style_args = $this->menuStyleArgs($style);
        $class = $style_args ? 'class="'.$style_args.'"' : '';
        $li_class = ($style_args == 'list') ? 'class="recentcomments"' : '';

        $output = '';
        $output .= '<ul id="recentcomments" '.$class.'>';
        if ( is_array( $comments ) && $comments ) {
            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
            _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );
            foreach ( (array) $comments as $comment ) {
                $output .= '<li '.$li_class.'>';
                $output .= '<a href="' . esc_url( get_comment_link( $comment ) ) . '">' .
                    '<span class="comment-author-link">' . get_comment_author( $comment ) . ' &#45;  </span> &nbsp;'
                    . get_the_title( $comment->comment_post_ID ) . '</a>'; // WPCS: xss ok.
                $output .= '</li>';
            }
        }
        $output .= '</ul>';

        return $output;
    }



	/**
	 * Outputs the content for the current Recent Comments widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Comments widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		static $first_dropdown = true;
		$output = '';
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Comments', 'benjamin' );

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        $style = ! empty( $instance['menu_style'] ) ? $instance['menu_style'] : 'side_nav';

		if ( ! $number )
			$number = 5;
		/**
		 * Filters the arguments for the Recent Comments widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Comment_Query::query() for information on accepted arguments.
		 *
		 * @param array $comment_args An array of arguments used to retrieve the recent comments.
		 */
		$comments = get_comments( apply_filters( 'widget_comments_args', array(
			'number'      => $number,
			'status'      => 'approve',
			'post_status' => 'publish'
		) ) );

        $output .= $args['before_widget'];

		if ( $title ) {
			$output .= $args['before_title'] . $title . $args['after_title'];
		}

        if($style == 'dropdown') {
            $output .= $this->dropdown($comments, $first_dropdown);
        } else {
            $output .= $this->menu($comments, $style);
        }


		$output .= $args['after_widget'];
		echo $output; // WPCS: xss ok.
	}
	/**
	 * Handles updating settings for the current Recent Comments widget instance.
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
		$instance['number'] = absint( $new_instance['number'] );
        if ( ! empty( $new_instance['menu_style'] ) ) {
            $instance['menu_style'] = sanitize_text_field($new_instance['menu_style']);
        }

		return $instance;
	}
	/**
	 * Outputs the settings form for the Recent Comments widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $saved_style = isset( $instance['menu_style'] ) ? $instance['menu_style'] : '';

		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'benjamin' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" placeholder="<?php esc_attr_e( 'Recent Comments', 'benjamin' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of comments to show:', 'benjamin' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" /></p>

        <?php
        // styles
        $find = array('-', '_');
        $menu_styles = array('dropdown', 'side_nav', 'nav_list', 'list');

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'menu_style' )); ?>">
                    <?php esc_html_e( 'Menu Style:', 'benjamin' ); ?>
            </label>
            <select id="<?php echo esc_attr($this->get_field_id( 'menu_style' ) ); ?>"
                  name="<?php echo esc_attr($this->get_field_name( 'menu_style' ) ); ?>">
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
	/**
	 * Flushes the Recent Comments widget cache.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @deprecated 4.4.0 Fragment caching was removed in favor of split queries.
	 */
	public function flush_widget_cache() {
		_deprecated_function( __METHOD__, '4.4.0' );
	}
}
