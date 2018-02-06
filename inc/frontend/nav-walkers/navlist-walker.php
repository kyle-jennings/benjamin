<?php



/**
 * Custom nav walker for the list style navs
 */
class BenjaminNavListWalker extends Walker_Nav_Menu {


    function start_lvl( &$output, $depth = 0, $args = array() ) {

		$output .= '<ul>';
	}

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= '</ul>';
    }

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        $is_current = false;
        if($item->classes){
            foreach($item->classes as $key=>$class){
                if(strpos($class, 'current-menu-item') !== false )
                $is_current = true;
            }
        }

		$classes = ($is_current) ? 'usa-current': '';

        $output .= '<li class="usa-navlist-item">';


        if( $permalink && $permalink != '#' ) {
            $output .= '<a class="' . esc_attr($classes) . '" href="' . esc_url($permalink) . '">';
                $output .= '<span>' . $title . '</span>';
            $output .= '</a>';
        }else{
            $output .= '<span class="' . esc_attr($classes) . '">';
                $output .= '<span>' . $title . '</span>';
            $output .= '</span>';
        }

	}


}
