<?php
/**
 * Widget API: WP_Widget_Recent_Posts class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */
/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class Benjamin_Widget_Recent_Posts extends WP_Widget
{
    /**
    * Sets up a new Recent Posts widget instance.
    *
    * @since 2.8.0
    * @access public
    */
    public function __construct()
    {
        $widget_ops = array(
        'classname' => 'widget_recent_entries',
        'description' => __('Your site&#8217;s most recent Posts.', 'benjamin'),
        'customize_selective_refresh' => true,
        );

        parent::__construct('recent-posts', __('Recent Posts', 'benjamin'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';
    }



    private function menuStyleArgs($style = 'side_nav')
    {
        if ($style == 'side_nav') :
            $class = 'usa-sidenav-list';
        elseif ($style == 'nav_list') :
            $class = 'usa-unstyled-list';
        else :
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
        var dropdown = document.getElementById("<?php echo esc_js($dropdown_id); ?>");

        function onCommentChange() {
            if (dropdown.selectedIndex <= 0)
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


    public function dropdown($r, $show_date)
    {
        $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";

        echo '<select id="' . esc_attr($dropdown_id) . '">';
        echo '<option>-- ' . __('Select Post', 'benjamin') . ' --</option>'; // WPCS: xss ok.

        while ($r->have_posts()) :
            $r->the_post(); ?>
            <option value="<?php the_permalink(); ?>">
                <?php get_the_title() ? the_title() : the_ID(); ?>
                <?php if ($show_date) : ?>
                    &nbsp;&#45;&nbsp;<?php echo get_the_date(); ?>
                <?php endif; ?>
            </option>
        <?php
        endwhile;

        echo '</select>';
        echo $this->dropdown_js($dropdown_id); // WPCS: xss ok.
    }



    public function menu($r, $style, $show_date)
    {
        $style_args = $this->menuStyleArgs($style);
        $class = $style_args ? 'class="'.esc_attr($style_args).'"' : '';

        echo '<ul ' . $class . '>';// WPCS: xss ok.
        ?>
        <?php while ($r->have_posts()) :
            $r->the_post(); ?>
        <li>
            <a href="<?php the_permalink(); ?>">
            <?php get_the_title() ? the_title() : the_ID(); ?>
            <?php if ($show_date) : ?>
                <span class="post-date">&nbsp;&#45;&nbsp;<?php echo get_the_date(); ?></span>
            <?php endif; ?>
            </a>
        </li>
        <?php endwhile;


        echo '</ul>';
    }



    /**
     * Outputs the content for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Posts widget instance.
     */
    public function widget($args, $instance)
    {
        if (! isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }
        $style = ! empty($instance['menu_style']) ? $instance['menu_style'] : 'side_nav';

        $title = (! empty($instance['title'])) ? $instance['title'] : __('Recent Posts', 'benjamin');
        
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        $number = (! empty($instance['number'])) ? absint($instance['number']) : 5;
        if (! $number) {
            $number = 5;
        }

        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
        /**
        * Filters the arguments for the Recent Posts widget.
        *
        * @since 3.4.0
        *
        * @see WP_Query::get_posts()
        *
        * @param array $args An array of arguments used to retrieve the recent posts.
        */
        $r = new WP_Query(apply_filters('widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        )));
        if ($r->have_posts()) :
    ?>
        <?php echo $args['before_widget']; //WPCS: xss ok. ?>
        <?php
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title']; //WPCS: xss ok.
        }

        if ($style == 'dropdown') {
            $this->dropdown($r, $show_date);
        } else {
            $this->menu($r, $style, $show_date);
        }

        echo $args['after_widget']; //WPCS: xss ok. ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        endif;
    }
    /**
     * Handles updating the settings for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;

        if (! empty($new_instance['menu_style'])) {
            $instance['menu_style'] = sanitize_text_field($new_instance['menu_style']);
        }


        return $instance;
    }
    /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $instance Current settings.
     */
    public function form($instance)
    {
        $title     = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number    = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
        $saved_style = isset($instance['menu_style']) ? $instance['menu_style'] : '';
    ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'benjamin'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" placeholder="<?php esc_attr_e('Recent Posts', 'benjamin'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts to show:', 'benjamin'); ?></label>
        <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox"<?php checked($show_date); ?> id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" />
        <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html_e('Display post date?', 'benjamin'); ?></label></p>

        <?php
        // styles
        $find = array('-', '_');
        $menu_styles = array('dropdown', 'side_nav', 'nav_list', 'list');

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('menu_style')); ?>">
                    <?php esc_html_e('Menu Style:', 'benjamin'); ?>
            </label>
            <select id="<?php echo esc_attr($this->get_field_id('menu_style')); ?>"
                  name="<?php echo esc_attr($this->get_field_name('menu_style')); ?>">
                <?php
                foreach ($menu_styles as $style) :
                    $label = ucwords(str_replace($find, ' ', $style));
                ?>
                <option value="<?php echo esc_attr($style); ?>"
                    <?php selected($saved_style, $style); ?>>
                    <?php echo esc_html($label); ?>
                </option>
                <?php
                endforeach;
                ?>
            </select>
        </p>
<?php
    }
}
