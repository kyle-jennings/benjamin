<?php


class FooterNavbarWalker extends Walker_Nav_Menu {


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

        $output .= '<li class="usa-width-one-sixth usa-footer-primary-content">';

        $link_class = ($depth == 0) ? 'usa-nav-link' : '';

        if( $permalink && $permalink != '#' ) {
            $output .= '<a class="usa-footer-primary-link '.$classes.'" href="'.$permalink.'">';
                $output .= '<span>'.$title.'</span>';
            $output .= '</a>';
        }else{
            $output .= '<span class="usa-footer-primary-link '.$classes.'">';
                $output .= '<span>'.$title.'</span>';
            $output .= '</span>';
        }


        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}


}
