<?php

/**
 * Nav Menu API: Main_Menu_Walker class
 *
 * @package WordPress
 * @subpackage Nav_Menus
 * @since 4.6.0
 */

/**
 * Custom class used to implement an HTML list of nav menu items.
 *
 * @since 3.0.0
 *
 * @see Walker
 */


class Main_Menu_Walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
	{
		$img_id = get_post_meta($item->ID, 'menu_item_logo', true);

		$output .= "<li class='nav-item'>";
		// set active tab
		$group = $args->current_group == 'documenti-e-dati' ? 'amministrazione' : $args->current_group;
		$active_class = '';

		if (basename($item->url) == $group) {
			$active_class = 'active';
		}

		// set data-element for crawler
		$data_element = '';
		if ($item->title == 'Amministrazione') $data_element .= 'management';
		if ($item->title == 'Novità') $data_element .= 'news';
		if ($item->title == 'Servizi') $data_element .= 'all-services';
		if ($item->title == 'Vivere il Comune') $data_element .= 'live';

		if ($item->url && $item->url != '#') {
			$output .= '<a class="nav-link ' . $active_class . '" href="' . $item->url . '" data-element="' . $data_element . '">';
		} else {
			$output .= '<span>';
		}

		if ($img_id ?? false)
			$output .= '<svg width="28" height="28" aria-hidden="true" class="me-2 mb-1">       
			<image xlink:href="' . wp_get_attachment_image_url($img_id, 'small') . '" width="28" height="28"/>    
			</svg>';

		$output .= '<span>'.$item->title.'</span>';

		if ($item->url && $item->url != '#') {
			$output .= '</a>';
		} else {
			$output .= '</span>';
		}
	}
}
