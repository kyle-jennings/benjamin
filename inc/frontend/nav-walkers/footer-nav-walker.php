<?php


/**
 * Custom nav walker for the footer area navs
 */
class BenjaminFooterNavbarWalker extends Walker_Nav_Menu {


	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $this->curItem = $item;

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


		$classes = ($is_current && $depth == 0) ? ' usa-current': '';

        $output .= '<li class="usa-width-one-sixth usa-footer-primary-content">';

        $link_class = ($depth == 0) ? 'usa-nav-link' : '';

        if( $permalink && $permalink != '#' ) {
            $output .= '<a class="usa-footer-primary-link ' . esc_attr($classes) . '" href="' . esc_attr($permalink) . '">';
                $output .= '<span>' . $title . '</span>';
            $output .= '</a>';
        }else{
            $output .= '<span class="usa-footer-primary-link ' . esc_attr($classes) . '">';
                $output .= '<span>' . $title . '</span>';
            $output .= '</span>';
        }

	}


}
