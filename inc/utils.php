<?php

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
if(!function_exists("dci_get_option")) {
	function dci_get_option( $key = '', $type = "dci_options", $default = false ) {
		if ( function_exists( 'cmb2_get_option' ) ) {
			// Use cmb2_get_option as it passes through some key filters.
			return cmb2_get_option( $type, $key, $default );
		}

		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( $type, $default );

		$val = $default;

		if ( 'all' == $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}

		return $val;
	}
}



if(!function_exists("dci_get_post_type_icon_by_id")) {
    function dci_get_post_type_icon_by_id($id) {
        $icon = ''; //can insert here a default Icon
        if ($id != ''){
            $type = get_post_type($id);
            $icon = dci_get_post_type_icon_by_type($type);
        }
        return $icon;
    }
}

if(!function_exists("dci_get_post_type_icon_by_type")) {
    function dci_get_post_type_icon_by_type($post_type) {
        $icon = '';
        /*  rimossa option associazione icona-post_type
        if ($post_type != '') {
            $icon = dci_get_option('icona_post_type_'.$post_type,'content');
        }
        */
        return $icon;
    }
}

if(!function_exists("dci_get_children_pages")) {
    function dci_get_children_pages($parent = '', $only_direct = true)
    {

       $args = array(
           'child_of' => 0
       );

        if ($parent !== '') {
            $page = get_page_by_title($parent);
            $args['child_of'] =  $page->ID ;
            if ($only_direct) {
                $args['parent'] =  $page->ID ;
            }
            $pages = get_pages( $args );
        }
        else {
            $pages = get_pages( $args );//all pages
        }

        if ($pages) {
            foreach ($pages as $page) {
                $result[$page->post_title] = array(
                    'title' => $page->post_title,
                    'id' => $page->ID,
                    'link' =>  get_page_link( $page->ID ),
                    'description' => dci_get_meta('descrizione','_dci_page_', $page->ID),
                    'slug' =>  $page->post_name
                );
            }
        }
        return $result;
    }
}

if(!function_exists("dci_get_children_pages_by_path")) {
    function dci_get_children_pages_by_path($parentpath = '', $only_direct = true, $sort_order = null, $sort_column = null)
    {

       $args = array(
           'child_of' => 0
       );
        if ($sort_order != null) {
            $args['sort_order'] = $sort_order; 
        }
        if ($sort_column != null) {
	        $args['sort_column'] = $sort_column; 
        }

        if ($parentpath !== '') {
            $page = get_page_by_path($parentpath);
            $args['child_of'] =  $page->ID ;
            if ($only_direct) {
                $args['parent'] =  $page->ID ;
            }
            $pages = get_pages( $args );
        }
        else {
            $pages = get_pages( $args );//all pages
        }

        if ($pages) {
            foreach ($pages as $page) {
                $result[$page->post_title] = array(
                    'title' => $page->post_title,
                    'id' => $page->ID,
                    'link' =>  get_page_link( $page->ID ),
                    'description' => dci_get_meta('descrizione','_dci_page_', $page->ID),
                    'slug' =>  $page->post_name
                );
            }
        }
        return $result;
    }
}

/**
 * Define members check user function if not defined and return true
 * @param  int     $user_id
 * @param  int     $post_id
 * @return bool
 */
if(!function_exists("dci_members_can_user_view_post")) {
    function dci_members_can_user_view_post($user_id, $post_id) {
        if(!function_exists("members_can_user_view_post")) {
            return true;
        }else{
            return members_can_user_view_post($user_id, $post_id);
        }

    }
}

/**
 * Wrapper function for get_post_meta
 * @param string $key
 * @return mixed meta_value
 */
if(!function_exists("dci_get_meta")){
	function dci_get_meta( $key = '', $prefix = "", $post_id = "") {
        if ( ! dci_members_can_user_view_post(get_current_user_id(), $post_id) ) return false;

		if($post_id == "")
			$post_id = get_the_ID();

		$post_type = get_post_type($post_id);

		if($prefix != "")
			return get_post_meta( $post_id, $prefix . $key, true );

		$prefixes = dci_get_tipologie_prefixes();
		foreach ($prefixes as $name => $prefix){
            if (is_singular($name)  || (isset($post_type) && $post_type == $name)) {
                return get_post_meta( $post_id, $prefix . $key, true );
            }
        }
		return get_post_meta( $post_id, $key, true );
	}
}

/**
 * Wysiwyg fields wrapper function with wpautop()
 * @param string $key
 * @param string $prefix
 * @param string $post_id
 * @return mixed
 */
if(!function_exists("dci_get_wysiwyg_field")) {
    function dci_get_wysiwyg_field($key = '', $prefix = "", $post_id = "") {
        return wpautop(dci_get_meta ($key,$prefix,$post_id));
    }
}

if(!function_exists("dci_get_term_meta")){
    function dci_get_term_meta( $key , $prefix, $term_id) {
            return get_term_meta($term_id, $prefix.$key, true );
    }
}
/**
 * Wrapper function for user avatar
 * @param object user
 * @return string url
 */
if(!function_exists("dci_get_user_avatar")){
	function dci_get_user_avatar( $user = false, $size=250 ) {
		if(!$user && is_user_logged_in()){
			$user = wp_get_current_user();
		}
        $foto_id = null;
		$foto_url = get_the_author_meta('_dci_persona_foto', $user->ID);
		if($foto_url)
            $foto_id = attachment_url_to_postid($foto_url);

        if(isset($foto_id) && $foto_id)
            $avatar = wp_get_attachment_image_url($foto_id, "item-thumb");
		else
		    $avatar = get_avatar_url( $user->ID, array("size" => $size) );

		$avatar = apply_filters("dci_avatar_url", $avatar, $user);
		return $avatar;
	}
}

add_filter( 'get_avatar' , 'dci_custom_avatar' , 1 , 5 );
function dci_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );
    }

    if ( $user && is_object( $user ) ) {

        $foto_url = get_the_author_meta('_dci_persona_foto', $user->ID);
        if($foto_url)
            $foto_id = attachment_url_to_postid($foto_url);

        if(isset($foto_id) && $foto_id) {
            $avatar = wp_get_attachment_image_url($foto_id, "item-thumb");
            $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
    }

    return $avatar;
}

/**
 * get all posts of given post type and taxonomy term
 * @param string $post_type
 * @param string $taxonomy_name
 * @param string $term_name
 * @return mixed
 */
if(!function_exists("dci_get_posts_by_term")) {
    function dci_get_posts_by_term( $post_type = 'post', $taxonomy_name = '', $term_name = '' ) {
        $posts = get_posts(array(
                'showposts' => -1,
                'post_type' => $post_type,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy_name,
                        'field' => 'name',
                        'terms' => array($term_name))
                ),
                'orderby' => 'title',
                'order' => 'ASC')
        );
        return $posts;
    }
}

/**
 * get all posts of given post type and taxonomy term ordered by date
 * @param string $post_type
 * @param string $taxonomy_name
 * @param string $term_name
 * @return mixed
 */
if(!function_exists("dci_get_posts_by_term_by_date")) {
    function dci_get_posts_by_term_by_date( $post_type = 'post', $taxonomy_name = '', $term_name = '', $order = false ) {
        $order = $order ? 'ASC' : 'DESC';
        $posts = get_posts(array(
                'showposts' => -1,
                'post_type' => $post_type,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy_name,
                        'field' => 'slug',
                        'terms' => array($term_name))
                ),
                'orderby' => 'date',
                'order' => $order)
        );
        return $posts;
    }
}

/**
 * get all posts ordered by date, given their groupname
 */
if(!function_exists("dci_get_grouped_posts_by_term")) {
    function dci_get_grouped_posts_by_term( $group , $taxonomy_name = '', $term_name = '', $amount = -1 ) {
        $post_types = dci_get_post_types_grouped($group);
        if ( is_array($term_name) ) $terms = $term_name;
        else $terms = array($term_name);

        $args = array(
            'showposts' => $amount,
            'post_type' => $post_types,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy_name,
                    'field' => 'slug',
                    'terms' => $terms)
            ),
            'orderby' => 'title',
            'order' => 'ASC',
        );
        $queried_object = get_queried_object(); 
        if (is_object($queried_object) && (get_class($queried_object) == "WP_Post")) {
            $args['post__not_in'] = array($queried_object->ID);
        }
        $posts = get_posts($args);
        return $posts;
    }
}

/**
 * get all posts related to specific Term flagged 'In evidenza'
 */
if(!function_exists("dci_get_highlighted_posts_by_term")) {
    function dci_get_highlighted_posts_by_term(  $taxonomy_name = '', $term_name = '', $amount = 5) {
        $post_types = dci_get_sercheable_tipologie();
        $posts = get_posts(array(
                'post_type' => $post_types,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy_name,
                        'field' => 'name',
                        'terms' => array($term_name))
                ),
                'meta_query' => array(
                    array(
                        'key'     => 'in_evidenza',
                        'value'   => null,
                        'compare' => '!=',
                    )
                ),
                'numberposts' => $amount,
                'orderby' => 'date',
                'order' => 'DESC')
        );
        return $posts;
    }
}

/**
 * get all posts related to specific Term flagged 'In evidenza'
 */
if(!function_exists("dci_get_highlighted_posts")) {
    function dci_get_highlighted_posts(  $post_types = array(), $amount = -1) {
        if(empty($post_types)){
            $post_types = dci_get_sercheable_tipologie();
        }

        $posts = get_posts(array(
                'post_type' => $post_types,
                'meta_query' => array(
                    array(
                        'key'     => 'in_evidenza',
                        'value'   => null,
                        'compare' => '!=',
                    )
                ),
                'numberposts' => $amount,
                'orderby' => 'date',
                'order' => 'DESC')
        );
        return $posts;
    }
}

//calendario homepage
if(!function_exists("dci_get_calendar")) {
    function dci_get_calendar($days = 7){
        $calendar = dci_create_calendar($days);
        return $calendar;
    }
}

/**
 * get group related to current page
 */
if(!function_exists("dci_get_current_group")) {
    function dci_get_current_group() {
        if (is_front_page()) {
            //console_log('HOME');
            return null;
        }

        if (is_search()){
            return null;
        }

        if (is_tax()) {
            //console_log('TERM TAX');
            $taxonomy = get_queried_object() -> taxonomy;
            //gets post types related to taxonomy
            if ($taxonomy) {
                $taxObject = get_taxonomy($taxonomy);
                $postTypeArray = $taxObject->object_type;
            }
            //if there's only one post type related
            if (!empty($postTypeArray) && count($postTypeArray) === 1) {
                $tipo_post = reset($postTypeArray);
                return dci_get_group($tipo_post);
            } else {
                return ;
            }
            return !empty($tipo_post) ? dci_get_group($tipo_post) : null;
        }

        if (is_author()) {
            //console_log('PERSONA');
            //return 'amministrazione';
            return null;
        }

        if ( is_archive()  ) {
            //console_log('ARCHIVIO');
            $tipo_post = get_queried_object() -> name;
            return  dci_get_group($tipo_post);
        }

        if (is_page()) {
            //console_log('PAGE')
            $sitesubdir = wp_make_link_relative(get_site_url()) . '/';
            $sitesubdir = substr($sitesubdir, 1);
            $rel_url = wp_make_link_relative(get_permalink());
            $rel_url =  preg_replace('/^' . preg_quote('/', '/') . '/', '', $rel_url);
            $rel_url = str_replace($sitesubdir, '', $rel_url);
            $group_slug = strtok($rel_url, '/');

            if (in_array($group_slug, dci_get_tipologie_names())) {
                return dci_get_group($group_slug);
            }


            return $group_slug;
        }

        $current_post_type = get_post_type();
        if ( ($current_post_type != false)) {
            //console_log('POST');
            return dci_get_group(get_post_type());
        }

        return null;
    }
}

function dci_get_empty_calendar_array($days) {
    $calendar = array();
    for ($i = 0; $i <= $days-1; $i++){
        $calendar [date('Y-m-d', strtotime(' +'.$i.' day'))] = array();
    }
    return $calendar;
}

function dci_get_eventi_calendar_array($days = 30) {
    $args = array(
        'post_type' => 'evento',
        'fields' => 'ids',
        'meta_query' => array(
		'relation' => 'OR',
		array( // the event is not finished yet
			'key' => '_dci_evento_data_orario_fine',
			'value' => current_datetime()->getTimestamp(),
			'compare' => '>='
		),  
		array( // the event hasn't begun or has begun since less than 12 hours
			'key' => '_dci_evento_data_orario_inizio',
			'value' => current_datetime()->modify('-12 hours')->getTimestamp(),
			'compare' => '>='
		),
	 )
    );
    $eventi = get_posts($args);
    $eventi_calendar_array = array();

    foreach( $eventi as $evento){
        $evento_base = array(
            'id' => $evento,
            'titolo' => get_the_title( $evento ),
            'link' => get_post_permalink($evento),
            'tipo_evento' => dci_get_tipo_evento($evento),
        );

        $ricorrenze = dci_get_evento_recurrences($evento);

        if($ricorrenze){
            for($i = 0; $i < count($ricorrenze); $i++){
                $ricorrenza = $ricorrenze[$i];
                $data_orario_inizio = $ricorrenza['_dci_evento_data_orario_inizio'];
                $data_orario_fine =   $ricorrenza['_dci_evento_data_orario_fine'];
    
                $eventi_calendar_array [] = array_merge($evento_base, array(
                    '_dci_evento_data_orario_inizio' => $data_orario_inizio,
                    '_dci_evento_data_orario_fine' => $data_orario_fine,
                    'data_inizio' =>($data_orario_inizio != "") ?  gmdate("Y-m-d", $data_orario_inizio) : "",
                    'data_fine' => ($data_orario_fine != "") ?  gmdate("Y-m-d", $data_orario_fine): "",
                    'indice_ricorrenza' => $i
                ));
            }
        }
        else
        {
            $data_orario_inizio = dci_get_meta('data_orario_inizio','_dci_evento_',$evento);
            $data_orario_fine =   dci_get_meta('data_orario_fine','_dci_evento_',$evento);
    
            $eventi_calendar_array [] = array_merge($evento_base, array(
                '_dci_evento_data_orario_inizio' => $data_orario_inizio,
                '_dci_evento_data_orario_fine' => $data_orario_fine,
                'data_inizio' =>($data_orario_inizio != "") ?  gmdate("Y-m-d", $data_orario_inizio) : "",
                'data_fine' => ($data_orario_fine != "") ?  gmdate("Y-m-d", $data_orario_fine): "",
            ));
        }
    }
	
	$results = [];
	foreach($eventi_calendar_array as $evento) {
		if(strtotime($evento["data_inizio"]) <= strtotime('+' . $days . ' days'))
			$results[] = $evento;
	}
	
   return $results;
}

function dci_create_calendar($days = 7){
    $eventi = dci_get_eventi_calendar_array();
    $calendar = dci_get_empty_calendar_array($days);

    foreach ($calendar as $key => &$giorno){
        foreach ($eventi as $evento){
            $evento = dci_is_evento_in_calendar($evento,$key);
            if ($evento['is_in_calendar']) {
                $giorno['eventi'] [] = array(
                    'id' => $evento['id'],
                    'titolo' => $evento['titolo'],
                    'link' => $evento['link'],
                    'stato' => $evento['stato'],
                    'tipo_evento' => $evento['tipo_evento']
                );
            }
        }
    }

    return $calendar;
}

function dci_is_evento_in_calendar($evento, $date){

    if (($evento['data_inizio'] == $date) && ($evento['data_fine'] == $date) || (($evento['data_fine'] < $evento['data_inizio']) && $evento['data_inizio'] == $date)){
        $evento['stato'] = 'giorno singolo';
        $evento['is_in_calendar'] = true;
    }

    else if ($date == $evento['data_inizio']){
        $evento['stato'] = 'inizio';
        $evento['is_in_calendar'] = true;
    }
    else if($date == $evento['data_fine']){
        $evento['stato'] = 'fine';
        $evento['is_in_calendar'] = true;
    }
    else if(($evento['data_inizio']< $date) && ($evento['data_fine']>$date)){
        $evento['stato'] = 'in corso';
        $evento['is_in_calendar'] = true;
    }
    else {
        $evento['is_in_calendar'] = false;
    }

    return $evento;
}

function dci_get_tipo_evento($id) {
    $term = get_the_terms($id, 'tipi_evento');
    if (is_array($term)) {
        $term = array_shift( $term );
    }
    $result = array();
    if (is_array($term)) {
        $result = array(
            'name' => $term->name,
            'slug' => $term->slug,
            'id' => $term->term_id,
        );
    }
    return $result;
}

/**
 * get all children events
 */
if (!function_exists("dci_get_eventi_figli")) {
    function dci_get_eventi_figli($id = '')
    {
        if ($id == '') {
            $id = get_the_ID();
        }

        $children = array();

        $posts = get_posts([
            'post_type' => 'evento',
            'post_status' => 'publish',
            'numberposts' => -1,
            'orderby' => 'date',
            'order'    => 'DESC'
        ]);

        foreach ($posts as $post) {
            if (dci_get_meta('evento_genitore','_dci_evento_', $post->ID) == $id){
                $children [] = $post;
            }
        }

        return $children;
    }
}




/**
 * Wrapper function for Argomenti taxonomy list
 * @return array arguomenti
 */
if (!function_exists("dci_get_argomenti_of_post")) {
    function dci_get_argomenti_of_post($singular = false)
    {
        global $post;

        if (!$singular) {
            $singular = $post;
        }

        $argomenti_terms = wp_get_object_terms($singular->ID, 'argomenti');
        return $argomenti_terms;
    }
}

/**
 * Function to get mapbox access token
 * @return string accesstoken
 */
if (!function_exists("dci_get_mapbox_access_token")) {
    function dci_get_mapbox_access_token()
    {
        global $post;

        $accesstoken = dci_get_option("mapbox_key", "setup");
        if (trim($accesstoken) == "") {
            $accesstoken = dci_ACCESSTOKEN_MAPBOX;
        }

        return $accesstoken;
    }
}

/**
 * @param WP_Query|null $wp_query
 * @param bool $echo
 *
 * @return string
 * Accepts a WP_Query instance to build pagination (for custom wp_query()),
 * or nothing to use the current global $wp_query (eg: taxonomy term page)
 * - Tested on WP 4.9.5
 * - Tested with Bootstrap 4.1
 * - Tested on Sage 9
 *
 * USAGE:
 *     <?php echo dci_bootstrap_pagination(); ?> //uses global $wp_query
 * or with custom WP_Query():
 *     <?php
 *      $query = new \WP_Query($args);
 *       ... while(have_posts()), $query->posts stuff ...
 *       echo bootstrap_pagination($query);
 *     ?>
 */
function dci_bootstrap_pagination(\WP_Query $wp_query = null, $echo = true)
{
    if (null === $wp_query) {
        global $wp_query;
    }
    $pages = paginate_links([
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'type' => 'array',
            'show_all' => false,
            'end_size' => 3,
            'mid_size' => 1,
            'prev_next' => true,
            'prev_text' => __('« '),
            'next_text' => __(' »'),
            'add_args' => false,
            'add_fragment' => ''
        ]
    );
    if (is_array($pages)) {
        //$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
        $pagination = '<div class="pagination"><ul class="pagination">';
        foreach ($pages as $page) {
            $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
        }
        $pagination .= '</ul></div>';
        if ($echo) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }
    return null;
}

/**
 *
 * Contatore dei post totali raggruppati in base al gruppo di ricerca di appartenenza
 *
 * @param $post_types
 *
 * @return bool|int
 */
function dci_count_grouped_posts($post_types)
{
    if (!is_array($post_types))
        return false;
    $count = 0;
    foreach ($post_types as $post_type) {
        $count_posts = wp_count_posts($post_type);
        if (isset($count_posts->publish))
            $count += $count_posts->publish;
    }
    return $count;

}

/**
 * recupera la url del template in base al nome
 * @param $TEMPLATE_NAME
 *
 * @return string|null
 */
function dci_get_template_page_url($TEMPLATE_NAME)
{
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $TEMPLATE_NAME,
        'hierarchical' => 0
    ));

    if ($pages) {
        foreach ($pages as $page) {
            if ($page->ID)
                return get_page_link($page->ID);
        }
    }
    return null;
}

/**
 * recupera id page template in base al nome
 * @param $TEMPLATE_NAME
 *
 * @return string|null
 */
function dci_get_template_page_id($TEMPLATE_NAME)
{
    $url = null;
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $TEMPLATE_NAME,
        'hierarchical' => 0
    ));
    if ($pages) {
        foreach ($pages as $page) {
            if ($page->ID)
                return $page->ID;
        }
    }

    return 0;
}

/**
 * restituisce intero
 * @param $value
 * @param $field_args
 * @param $field
 * @return int|string
 */
function dci_sanitize_int($value, $field_args, $field)
{
    // Don't keep anything that's not numeric
    if (!is_numeric($value)) {
        $sanitized_value = '';
    } else {
        // Ok, let's clean it up.
        $sanitized_value = absint($value);
    }
    return $sanitized_value;
}

if (!function_exists("dci_pluralize_string")) {
    function dci_pluralize_string($string)
    {
        switch ($string) {
            case "Biblioteca":
                $string = "Biblioteche";
                break;

            case "Palestra":
                $string = "Palestre";
                break;

            case "Edificio scolastico":
                $string = "Edifici scolastici";
                break;

            case "Teatro":
                $string = "Teatri";
                break;

            case "Laboratorio":
                $string = "Laboratori";
                break;

            case "Giardino":
                $string = "Giardini";
                break;

            case "Dirigenza Scolastica":
                $string = "Dirigenze Scolastiche";
                break;

            case "Segreteria":
                $string = "Segreterie";
                break;

            case "Scuola":
                $string = "Scuole";
                break;

            case "Commissione":
                $string = "Commissioni";
                break;

            case "Organo Collegiale":
                $string = "Organi Collegiali";
                break;

            case "Associazione scolastica":
                $string = "Associazioni scolastiche";
                break;

            case "Mensa":
                $string = "Mense";
                break;

            case "Documento Generico":
                $string = "Documenti Generici";
                break;

            case "Bandi e Gare":
                $string = "Bandi e Gare";
                break;

            case "Contratto":
                $string = "Contratti";
                break;

            case "Delibera":
                $string = "Delibere";
                break;

            case "Verbale":
                $string = "Verbali";
                break;

            case "Regolamento":
                $string = "Regolamenti";
                break;

            case "Documento Programmatico":
                $string = "Documenti Programmatici";
                break;

            case "Documento Didattico":
                $string = "Documenti Didattici";
                break;

            case "Modulistica":
                $string = "Modulistica";
                break;

            case "Albo online":
                $string = "Albo online";
                break;

            case "Progetto area scientifica":
                $string = "Progetti area scientifica";
                break;

            case "Progetto area umanistica":
                $string = "Progetti area umanistica";
                break;

            case "Progetto di integrazione":
                $string = "Progetti di integrazione";
                break;

            case "Progetto di orientamento":
                $string = "Progetti di orientamento";
                break;

            case "Progetto territorio e ambiente":
                $string = "Progetti territorio e ambiente";
                break;


            case "Indirizzo di Studio":
                $string = "Indirizzi di studio";
                break;

            case "Scuola / Istituto":
                $string = "Scuole / Istituti";
                break;

            case "":
                $string = "";
                break;

        }

        return $string;
    }
}

/**
 * funzione per la gestione del nome autore
 */
function dci_get_display_name($user_id)
{

    $display = get_the_author_meta('display_name', $user_id);
    $nome = get_the_author_meta('first_name', $user_id);
    $cognome = get_the_author_meta('last_name', $user_id);
    if (($nome != "") && ($cognome != ""))
        return $nome . " " . $cognome;
    else
        return $display;

}


/**
 *  Funzione per la ricerca di un valore in un array multiplo
 *  * @param string $search_for Value to search
 * @param array $search_in Array where to search
 * @param mixed $okey Previous value
 * @return mixed
 * @since  0.1.0
 */
if (!function_exists("dci_multi_array_search")) {
    function dci_multi_array_search($search_for, $search_in, $okey = false)
    {
        foreach ($search_in as $key => $element) {
            $key = $okey ? $okey : $key;
            if (($element === $search_for) || (is_array($element) && $key = dci_multi_array_search($search_for, $element, $key))) {
                return $key;
            }
        }
        return false;
    }
}


/**
 *  Tronca un testo in base ai valori specificati
 *  * @param $string initial text
 * @param $limit truncate length
 * @param string $break
 * @param string $pad
 * @return string
 * @since 0.1.0
 */
if (!function_exists("dci_truncate")) {
    function dci_truncate($string, $limit, $break = " ", $pad = "...")
    {
        $string = html_entity_decode($string, ENT_QUOTES, "UTF-8");

        $string = strip_tags($string);
        if (mb_strlen($string) <= $limit)
            return $string;

        // is $break present between $limit and the end of the string?
        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < mb_strlen($string) - 1) {
                $string = mb_substr($string, 0, $breakpoint) . $pad;
            }
        }

        return $string;
    }
}


/**
 * Returns the post_date in format [d,m,y] of a post
 * @param  string  $key
 * @param  string  $prefix
 * @param  int     $post_id
 * @return array
 */
if(!function_exists("dci_get_data_pubblicazione_arr")) {
    function dci_get_data_pubblicazione_arr($key = '', $prefix = '', $post_id = null) {
        global $post;
        $arrdata = array();
        if (!$post) $post = get_post($post_id);

        $data_pubblicazione = dci_get_meta($key, $prefix , $post_id);
        if (!$data_pubblicazione) {
            $data_pubblicazione = explode(' ',$post->post_date)[0];
            $arrdata =  array_reverse(explode("-", $data_pubblicazione));
        } else {
            $arrdata =  explode("-", date('d-m-y',$data_pubblicazione));  
        }
        return $arrdata;
    }
}


/**
 * Returns the post_date in timestamp format of a post
 * @param  string  $key
 * @param  string  $prefix
 * @param  int     $post_id
 * @return string
 */
if(!function_exists("dci_get_data_pubblicazione_ts")) {
    function dci_get_data_pubblicazione_ts($key = '', $prefix = '', $post_id = null) {
        global $post;
        if (!$post) $post = get_post($post_id);

        $data_pubblicazione = dci_get_meta($key, $prefix , $post_id);
        if (!$data_pubblicazione) {
            $data_pubblicazione = strtotime(explode(' ',$post->post_date)[0]);
        }
        return $data_pubblicazione;
    }
}


/**
 * Returns the a formatted version of punto-contatto from id
 * @param  int     $post_id
 * @return array
 */
if(!function_exists("dci_get_full_punto_contatto")) {
    function dci_get_full_punto_contatto($pc_id) {
        $prefix = '_dci_punto_contatto_';
        $voci = dci_get_meta('voci', $prefix, $pc_id);
        $arrdata = array();

        foreach ($voci as $voce) {
            $tipo = $voce[$prefix.'tipo_punto_contatto'];
            $valore = $voce[$prefix.'valore'];
            $dettagli = array_key_exists($prefix.'dettagli',$voce) ? $voce[$prefix.'dettagli'] : null;

            $dati = array("valore"=>$valore, "dettagli"=>$dettagli);

            if ( !array_key_exists($tipo, $arrdata) ){
                $arrdata[$tipo] = array();
            } 
            array_push($arrdata[$tipo], $dati);
        }

        return $arrdata;
    }
}

/**
 * public documents (bandi) related to service category
 * @param string $id_categoria_servizio
 * @param int $amount
 * @return array
 */
if(!function_exists("dci_get_related_bando")) {
    function dci_get_related_bandi($id_categoria_servizio = '', $amount = -1) {
        $bandi = array();

        $args = array(
            'post_type' => 'documento_pubblico',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'tipi_documento',
                    'field' => 'slug',
                    'terms' => array('documento-albo-pretorio')
                ),
                array(
                    'taxonomy' => 'tipi_doc_albo_pretorio',
                    'field' => 'slug',
                    'terms' => array( 'bando')
                ),
            ),
            'numberposts' => $amount,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $bandi =  get_posts( $args );


        $args = array(
            'post_type' => 'servizio',
            'fields' => 'ids',
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        if ($id_categoria_servizio == '') {
            if (is_tax()) {
                $id_categoria_servizio = get_queried_object()->term_id;
            }
        }

        if ($id_categoria_servizio != '') {
            $args['tax_query'] =  array(
                array(
                    'taxonomy' => 'categorie_servizio',
                    'field' => 'id',
                    'terms' => array($id_categoria_servizio)
                )
            );
        }

        $servizi =   get_posts( $args );

        $result = array();
        foreach ($bandi as $bando) {
            foreach ($servizi as $servizio) {
                $array_servizi =  dci_get_meta('servizi', '_dci_documento_pubblico_', $bando-> ID) ;
                if (is_array( $array_servizi ) && in_array($servizio,$array_servizi)) {

                    $result [] = array(
                        'id' => $bando -> ID,
                        'titolo' => $bando-> post_title,
                        'link' => get_permalink($bando -> ID),
                        'description' =>  dci_get_meta('descrizione_breve', '_dci_documento_pubblico_', $bando-> ID)
                    );
                }
            }
        }

       return $result;

    }
}

/**
 * structures related to service category
 * @param string $id_categoria_servizio
 * @param int $amount
 * @return array
 */
if(!function_exists("dci_get_related_unita_amministrative")) {
    function dci_get_related_unita_amministrative($id_categoria_servizio = '', $amount = -1) {

        $args = array(
            'post_type' => 'servizio',
            'fields' => 'ids',
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        if ($id_categoria_servizio == '') {
            if (is_tax()) {
                $id_categoria_servizio = get_queried_object()->term_id;
            }
        }

        if ($id_categoria_servizio != '') {
            $args['tax_query'] =  array(
                array(
                    'taxonomy' => 'categorie_servizio',
                    'field' => 'id',
                    'terms' => array($id_categoria_servizio)
                )
            );
        }

        $id_servizi =  get_posts( $args );

        $unita_organizzative = array();

        foreach ($id_servizi as $id_servizio) {
            $id = dci_get_meta('unita_responsabile', '_dci_servizio_', $id_servizio);

            if (!dci_contains_element_with($unita_organizzative, $key= 'id', $value = $id)){
                $unita_organizzative [] = array(
                    'id' => $id,
                    'link' => get_permalink($id),
                    'title' => get_the_title($id)
                );
            }
        }
        return $unita_organizzative;
    }
}

function dci_contains_element_with( $array, $key, $value) {
    if (is_array($array)) {
        foreach ($array as $el) {
            if ($el[$key] == $value) {
                return true;
            }
        }
    }
    return false;
}

// Returns an img tag with appropriate attributes

if(!function_exists("dci_get_img")) {
    function dci_get_img( $url, $classes = '', $size = null ) {
        $img_post = attachment_url_to_postid($url) != 0 ? get_post( attachment_url_to_postid($url) ) : null;

        $scaled_url = is_null($img_post) ? $url : wp_get_attachment_image_src($img_post -> ID, $size)[0];
        $image_alt = is_null($img_post) ? "" : get_post_meta( $img_post->ID, '_wp_attachment_image_alt', true);
        $image_title = is_null($img_post) ? "" : get_the_title( $img_post->ID );

        $img = '<img src="'.$scaled_url.'" ';        
        if ($classes) $img .= 'class="'.$classes.'" ';
        if ($image_alt) $img .= 'alt="'.$image_alt.'" ';
        if ($image_title) $img .= 'title="'.$image_title.'" ';
        $img .= '/>';

        echo $img;
    }
}

//Fix relativo issue #262
//Ad ogni invio del form lo "slash" viene moltiplicato (es. primo invio: /, secondo invio: //, terzo invio: ////, quarto invio: ////////), fino al raggiungimento del limite massimo previsto dal webserver per il metodo GET.

if(!function_exists("dci_removeslashes")) {
    function dci_removeslashes($string) { 
        $string=implode("",explode("\\",$string)); 
        return stripslashes(trim($string)); 
    }
}

function printDateTime($format, $date) {
	$format =  new IntlDateFormatter('it_IT', IntlDateFormatter::FULL, IntlDateFormatter::FULL,  'Europe/Rome', IntlDateFormatter::GREGORIAN, $format);
	return datefmt_format( $format, $date);
}



// PER I CSS CUSTOM

// render css file field
function cmb2_render_callback_for_css_file( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
    echo $field_type_object->input( array( 'type' => 'file', 'accept'=>'text/css' ) );
}
add_action( 'cmb2_render_css_file', 'cmb2_render_callback_for_css_file', 10, 5 );

function dci_get_custom_css_sub_folder(){
    return '/custom-css/';
}

function dci_get_custom_css_folder_path(){
    return WP_CONTENT_DIR.dci_get_custom_css_sub_folder();
}

function dci_get_custom_css_file_path($file_name_no_path){
    return dci_get_custom_css_folder_path().$file_name_no_path;
}

function dci_get_custom_css_file_url($file_name_no_path){
    return content_url(dci_get_custom_css_sub_folder().$file_name_no_path);
}

function dci_add_custom_file_field_to_box(&$box, $css_name, $file_field_name, $checkbox_field_name){
    if(file_exists(dci_get_custom_css_file_path($css_name))){
        $box->add_field( array(
            'name' => 'Stile personalizzato',
            'desc' => 'Al momento, è in uso un foglio di stile personalizzato al posto di <strong>'.$css_name.'</strong>. Per tornare a usare quello predefinito o per caricare una nuova versione, disabilita questa opzione e salva le modifiche.',
            'id'   => $checkbox_field_name,
            'type' => 'checkbox',
            'default' => 'on'
        ));
    }
    else{

        $box->add_field( array(
        'id'    => $file_field_name,
        'name' => __('Stile personalizzato', 'design_comuni_italia' ),
        'desc' => __('Customizzazione del foglio di stile <strong>'.$css_name.'</strong> per personalizzare la grafica del sito. <br> <strong>Nota</strong>. Se il campo è vuoto viene utilizzato quello di default presente nel tema' , 'design_comuni_italia' ),
        'type' => 'css_file'
        ));
    }
}

function dci_is_this_dark_hex($hex){
    return dci_luma_hex($hex) < .5;
}

function dci_luma_hex($hex){
    return dci_luma(hexdec(substr($hex,1,2)), hexdec(substr($hex,3,2)), hexdec(substr($hex,5,2)));
}

function dci_luma($r, $g, $b)
{
  return (0.2126 * (float)$r + 0.7152 * (float)$g + 0.0722 * (float)$b) / 255.0;
}

function dci_get_search_query_url($term = '', $post_types = [], $argomenti_ids = []){
    return '/?'.build_query(
        array(
            's' => $term,
            'post_types' => $post_types,
            'post_terms' => $argomenti_ids
        )
    );
}

function dci_get_incarichi_con_unita_organizzativa(){
    $args = [
        'post_type' => 'incarico',
        'posts_per_page' => -1
    ];

    $incarichi = get_posts($args);

    $incarichi_organizzati = array();

    foreach($incarichi as $incarico){
        $id_persona = dci_get_meta('persona', '_dci_incarico_', $incarico->ID);
        $id_uo = dci_get_meta('unita_organizzativa', '_dci_incarico_', $incarico->ID);
        $incarichi_organizzati[$incarico->ID] = $incarico->post_title.' presso '.get_post($id_uo)?->post_title;
    }

    return $incarichi_organizzati;
}


function dci_get_incarichi_con_nomi(){
    $args = [
        'post_type' => 'incarico',
        'posts_per_page' => -1
    ];

    $incarichi = get_posts($args);

    $incarichi_organizzati = array();

    foreach($incarichi as $incarico){
        $id_persona = dci_get_meta('persona', '_dci_incarico_', $incarico->ID);
        $id_uo = dci_get_meta('unita_organizzativa', '_dci_incarico_', $incarico->ID);
        $incarichi_organizzati[$incarico->ID] = get_post($id_persona)?->post_title.' ('.$incarico->post_title.')';
    }

    return $incarichi_organizzati;
}

function dci_get_default_home_sections(){
    return [
        'hero',
        'notizie',
        'contenuti-evidenza',
        'calendario',
        'argomenti',
        'siti-tematici',
        'domande-frequenti',
        'ricerca',
        'valuta-servizio',
        'assistenza-contatti',
    ];
}

function dci_get_evento_next_recurrence_timestamps($id)
{
    $index_of_next_recurrence = dci_get_evento_next_recurrence_index($id);

    if ($index_of_next_recurrence < 0)
        return [
            '_dci_evento_data_orario_inizio' => get_post_meta($id, '_dci_evento_data_orario_inizio', true),
            '_dci_evento_data_orario_fine' => get_post_meta($id, '_dci_evento_data_orario_fine', true)
        ];

    $recurrences = dci_get_evento_recurrences($id);

    return [
        '_dci_evento_data_orario_inizio' => $recurrences[$index_of_next_recurrence]['_dci_evento_data_orario_inizio'],
        '_dci_evento_data_orario_fine' => $recurrences[$index_of_next_recurrence]['_dci_evento_data_orario_fine'],
    ];
}

function dci_get_evento_next_recurrence_index($id)
{
    if (get_post_meta($id, '_dci_evento_evento_ripetuto', true) !== "true")
        return -1;

    $recurrences = dci_get_evento_recurrences($id);

    $index_of_next_recurrence = -1;
    $closer_recurrence_timestamp_difference = PHP_INT_MAX;
    $now = current_datetime()->getTimestamp();

    for ($i = 0; $i < count($recurrences); $i++) {
        $recurrence = $recurrences[$i];
        $timestamp_difference = $recurrence['_dci_evento_data_orario_inizio'] - $now;

        if ($timestamp_difference < $closer_recurrence_timestamp_difference && $recurrence['_dci_evento_data_orario_fine'] > $now) {
            $index_of_next_recurrence = $i;
            $closer_recurrence_timestamp_difference = $timestamp_difference;
        }
    }

    return $index_of_next_recurrence;
}

function dci_get_evento_recurrences($id)
{
    if (get_post_meta($id, '_dci_evento_evento_ripetuto', true) !== "true")
        return null;

    $recurrences = dci_get_meta('gruppo_eventi_ripetuti', '_dci_evento_', $id);
    usort($recurrences, fn($a, $b) => $a['_dci_evento_data_orario_inizio'] <=> $b['_dci_evento_data_orario_inizio']);
    return $recurrences;
}

function dci_get_order_values($default_field = "post_title", $default_dir = "ASC", $order_option = null) {
    $order_values = array();
    
    $order_values["field"] = $default_field;
    $order_values["dir"] = $default_dir;

    if (isset($order_option))
    {
        switch (sanitize_text_field($order_option)) {
            case "publish_date_desc":
                $order_values["field"] = "publish_date";
                $order_values["dir"] = "DESC";
                break;
            case "publish_date_asc":
                $order_values["field"] = "publish_date";
                $order_values["dir"] = "ASC";
                break;
            case "post_title_desc":
                $order_values["field"] = "post_title";
                $order_values["dir"] = "DESC";
                break;
            default:
                $order_values["field"] = "post_title";
                $order_values["dir"] = "ASC";
                break;
        }
    }

    if(is_null($order_values["field"]) || $order_values["field"]  == "") $order_values["field"] = "post_title";
    if(is_null($order_values["dir"]) || $order_values["dir"] == "") $order_values["dir"] = "ASC";
    
    $order_values["option"] = $order_values["field"] . "_" . (strtolower($order_values["dir"]));

    return $order_values;
}


function dci_get_campo_ordinamento_radio_options(){
    $result = array(
            '' => __( 'Predefinito (titolo)', 'cmb2' ),
            'post_title'   => __( 'Titolo', 'cmb2' ),
            'publish_date'   => __( 'Data pubblicazione', 'cmb2' )
    );

    return $result;
}

function dci_get_direzione_ordinamento_radio_options(){
    $result = array(
            '' => __( 'Predefinito (ascendente)', 'cmb2' ),
            'ASC'   => __( 'Ascendente', 'cmb2' ),
            'DESC'   => __( 'Discendente', 'cmb2' )
    );

    return $result;
}