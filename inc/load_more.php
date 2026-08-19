<?php


add_action( 'wp_enqueue_scripts', 'load_more_script' );
function load_more_script() {
	global $wp_query, $the_query, $wp_the_query;

    wp_enqueue_script( 'dci-load_more', get_template_directory_uri() . '/assets/js/load_more.js', array('jquery'), null, true );
    $variables = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'posts' => json_encode( $wp_query->query_vars ), 
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages,
        'nonce' => wp_create_nonce('dci_load_more'),
    );
    wp_localize_script('dci-load_more', "data", $variables);
}

function load_template_part($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}


function dci_sanitize_load_more_post_types($post_types) {
	$allowed = array('post', 'page', 'categoria_servizio', 'documento_pubblico', 'dataset', 'domanda_frequente', 'incarico', 'persona_pubblica', 'notizia', 'evento', 'servizio', 'unita_organizzativa', 'luogo', 'contatto', 'punto_contatto', 'sito_tematico');
    $post_types = is_array($post_types) ? $post_types : array($post_types);
    $post_types = array_map('sanitize_key', $post_types);
    $post_types = array_values(array_intersect($post_types, $allowed));
    return !empty($post_types) ? $post_types : array('post');
}

function dci_safe_json_array_from_post($key) {
    if (!isset($_POST[$key])) {
        return array();
    }
    $decoded = json_decode(wp_unslash($_POST[$key]), true);
    return is_array($decoded) ? $decoded : array();
}


// load more posts
add_action("wp_ajax_load_more" , "load_more");
add_action("wp_ajax_nopriv_load_more" , "load_more");
function load_more(){
	global $servizio, $i, $hide_categories, $title_level;

    // prepare our arguments for the query
    $load_card_type = isset($_POST['load_card_type']) ? sanitize_key(wp_unslash($_POST['load_card_type'])) : '';
    $post_types = dci_sanitize_load_more_post_types(dci_safe_json_array_from_post('post_types'));
	
    $url_query_params = dci_safe_json_array_from_post('query_params');

	$post_count = isset($_POST['post_count']) ? absint($_POST['post_count']) : 0;
    $load_posts = isset($_POST['load_posts']) ? absint($_POST['load_posts']) : 10;
    $posts_per_page = max(1, min(50, $post_count + $load_posts));
    $search = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';
    $order_by = isset($_POST['order_by']) ? sanitize_text_field(wp_unslash($_POST['order_by'])) : '';

	$additional_filter =  dci_safe_json_array_from_post('additional_filter');
	$filter_ids =  dci_safe_json_array_from_post('filter_ids');
	$filter_value =  isset($_POST['filter_value']) ? sanitize_text_field(wp_unslash($_POST['filter_value'])) : '';
	$filters =  dci_safe_json_array_from_post('filters');
	$tax_query =  dci_safe_json_array_from_post('tax_query');
	
	$title_level =  dci_safe_json_array_from_post('title_level');

	$order_values = dci_get_order_values("post_title", "ASC", $order_by);

	$post_status_to_include = array('publish');

    if ( is_user_logged_in() ) {
        $post_status_to_include[] = 'private'; 
    }

	$args = array(
		's' => $search,
        'posts_per_page' => $posts_per_page,
        'post_type' => $post_types,
		'post_status'    => $post_status_to_include,
		'order'=> $order_values["dir"],
		'orderby' => $order_values["field"]
	);
	
	if ( in_array("luogo", $post_types) ) {
		$main_meta_query = [
			'relation' => 'OR',
		];

		$main_meta_query[] = [
			'key'     => '_dci_luogo_childof',
			'compare' => 'NOT EXISTS',
		];
		$main_meta_query[] = [
			'key'     => '_dci_luogo_childof',
			'value'   => '0',
			'compare' => '=',
		];

		if (!empty($filter_value) && $filter_value === 'only_main') {
			$args['meta_query'] = $main_meta_query;
		}
	}
		
	
	if (in_array("servizio", $post_types)) {
		$main_meta_query = [
			'relation' => 'OR',
		];

		$main_meta_query[] = [
			'key'     => '_dci_servizio_servizi_richiesti',
			'compare' => 'NOT EXISTS',
		];
		$main_meta_query[] = [
			'key'     => '_dci_servizio_servizi_richiesti',
			'value'   => '',
			'compare' => '=',
		];

		
		if (!empty($filter_value) && $filter_value === 'only_main') {
			$args['meta_query'] = $main_meta_query;
		}
	}
	
	if ( $post_types == "notizia" ) {
		$args = array(
			's' => $_POST['search'],
			'posts_per_page' => $_POST['post_count'] + $_POST['load_posts'],
			'post_type'      => $post_types,
			'post_status'    => $post_status_to_include
		);
	}

	if ( $post_types == "evento" ) {
		$args = array(
			's' => $_POST['search'],
			'posts_per_page' => $_POST['post_count'] + $_POST['load_posts'],
			'post_type'      => $post_types,
			'post_status'    => $post_status_to_include,
			'meta_key' => '_dci_evento_data_orario_inizio',
		);
		
		$args['orderby'] = 'meta_value';
		$args['order'] = 'DESC';
	}

	if ( isset($url_query_params["post_terms"]) ) {
		$terms = array_map('absint', (array) $url_query_params['post_terms']);
		$taxquery = array(
			array(
				'taxonomy' => 'argomenti',
				'field' => 'id',
				'terms' => $terms
			)
		);

		$args['tax_query'] = $taxquery;
	}

	if ( isset($tax_query) ){
        $args['tax_query'] = $tax_query;
    }

	if ( isset($filter_ids) )
		$args['post__in'] = $filter_ids;

	if (isset($url_query_params['post_types'])) {
        $args['post_type'] = dci_sanitize_load_more_post_types($url_query_params['post_types']);
    }
    if (isset($url_query_params['s'])) {
        $args['s'] = sanitize_text_field($url_query_params['s']);
    }
	
	// it is always better to use WP_Query but not here
	$new_query = new WP_Query($args);

	$out = '';
    if( $new_query->have_posts() ) :
		$i = 0;
		// run the loop
		while( $new_query->have_posts() ): $new_query->the_post();
            $post = get_post();
            ++$i;

			switch ($load_card_type) {
				case "categoria_servizio":
						$servizio = $post;
						$hide_categories = true;
						$out .= load_template_part("template-parts/servizio/card");
					break;
				case "documento":
						$out .= load_template_part("template-parts/documento/cards-list");
					break;
				case "domanda-frequente":
						$out .= load_template_part("template-parts/domanda-frequente/item");
					break;
				case "incarico":
						$out .= load_template_part("template-parts/incarico/cards-list");
					break;
				case "persona_pubblica":
						$out .= load_template_part("template-parts/persona_pubblica/cards-list");
					break;
				case "global-search":
						$out .= load_template_part("template-parts/search/item");
					break;
				case "notizia":
						$out .= load_template_part("template-parts/novita/cards-list");
					break;
				case "evento":
						$out .= load_template_part("template-parts/evento/card-full");
					break;
				case "servizio":
						$servizio = $post;
						$out .= '<div class="col-12 col-lg-4">'.load_template_part("template-parts/servizio/card").'</div>';
					break;
				case "unita-organizzativa":
						$out .= load_template_part("template-parts/unita-organizzativa/cards-list");
					break;
				case "luogo":
					$out .= load_template_part("template-parts/luogo/card-full");
					break;
				case "contatto":
					$out .= load_template_part("template-parts/punto-contatto/lista-contatti");
				default:
					break;
				}

			endwhile;

	endif;

	$res = array();
    $res['response'] = $out;
    $res['post_count'] = count($new_query->posts);
    if ($new_query->found_posts <= count($new_query->posts)) {
        $res['all_results'] = true;
    }

    wp_reset_postdata();
    wp_send_json($res);
}