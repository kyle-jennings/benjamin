<?php


class NavbarWalker extends Walker_Nav_Menu {


    function start_lvl( &$output, $depth = 0, $args = array() ) {

        $id = 'side-nav-'.$this->curItem->menu_order;
		$output .= '<ul class="usa-nav-submenu" id="'.$id.'" aria-hidden="true">';
	}

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= '</ul>';
    }

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {


        $this->curItem = $item;
        $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        $is_current = false;
        foreach($item->classes as $key=>$class){
            if(strpos($class, 'current-menu-item') !== false )
                $is_current = true;
        }

		$classes = ($is_current && $depth == 0) ? ' usa-current': '';
        $child_active = $item->current_item_ancestor || in_array('current-page-ancestor', $item->classes) ? 'child-active' : '';

        $output .= '<li>';

        $link_class = ($depth == 0) ? 'usa-nav-link' : '';
        $link_class .= $classes;

        if($depth == 0 && $args->walker->has_children){
            $output  .= '<button class=" usa-accordion-button usa-nav-link '.$child_active.'"
            aria-expanded="false" aria-controls="side-nav-'.$item->menu_order.'">';
                $output .= '<span>'.$title.'</span>';
            $output .= '</button>';
        }elseif( $permalink && $permalink != '#' ) {
            $output .= '<a href="'.$permalink.'" class="'.$link_class.'">';
                $output .= '<span>'.$title.'</span>';
            $output .= '</a>';
        }else{
            $output .= '<span class="'.$link_class.'">';
                $output .= '<span>'.$title.'</span>';
            $output .= '</span>';
        }


        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}


}
