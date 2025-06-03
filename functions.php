<?php

/**
 * Design Comuni Italia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Design_Comuni_Italia
 */

/**
 * Funzionalità Trasversali
 */
require get_template_directory() . '/inc/funzionalita_trasversali.php';

/**
 * Load more posts
 */
require get_template_directory() . '/inc/load_more.php';

/**
 * Vocabolario
 */
require get_template_directory() . '/inc/vocabolario.php';

/**
 * Extend User Taxonomy
 */
require get_template_directory() . '/inc/extend-tax-to-user.php';

/**
 * Implement Plugin Activations Rules
 */
require get_template_directory() . '/inc/theme-dependencies.php';

/**
 * Implement CMB2 Custom Field Manager
 */
if (!function_exists('dci_get_tipologia_articoli_options')) {
	require get_template_directory() . '/inc/cmb2.php';
	require get_template_directory() . '/inc/backend-template.php';
}

/**
 * Utils functions
 */
require get_template_directory() . '/inc/utils.php';

/**
 * Breadcrumb class
 */
require get_template_directory() . '/inc/breadcrumb.php';

/**
 * Activation Hooks
 */
require get_template_directory() . '/inc/activation.php';

/**
 * Actions & Hooks
 */
require get_template_directory() . '/inc/actions.php';

/**
 * Gutenberg editor rules
 */
require get_template_directory() . '/inc/gutenberg.php';

/**
 * Welcome page
 */
require get_template_directory() . '/inc/welcome.php';

/**
 * main menu walker
 */
require get_template_directory() . '/walkers/main-menu.php';

/**
 * menu header right walker
 */
require get_template_directory() . '/walkers/menu-header-right.php';

/**
 * footer info walker
 */
require get_template_directory() . '/walkers/footer-info.php';

/**
 * Filters
 */
require get_template_directory() . '/inc/filters.php';

if (!function_exists('dci_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function dci_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Design Comuni Italia, use a find and replace
		 * to change 'design_comuni_italia' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('design_comuni_italia', get_template_directory() . '/languages');


		load_theme_textdomain('easy-appointments', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// image size
		if (function_exists('add_image_size')) {
			add_image_size('article-simple-thumb', 500, 384, true);
			add_image_size('item-thumb', 280, 280, true);
			add_image_size('item-gallery', 730, 485, true);
			add_image_size('vertical-card', 190, 290, true);

			add_image_size('banner', 600, 250, false);
		}
	}
endif;
add_action('after_setup_theme', 'dci_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dci_widgets_init()
{
}
add_action('widgets_init', 'dci_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function dci_scripts()
{

	//wp_deregister_script('jquery');
	wp_enqueue_style('dci-bootstrap-italia-min', get_template_directory_uri() . '/assets/css/bootstrap-italia-comuni.min.css');

	wp_enqueue_style('dci-font', get_template_directory_uri() . '/assets/css/fonts.css');
	wp_enqueue_style('dci-wp-style', get_template_directory_uri() . "/style.css");
	wp_enqueue_style('tobii', get_template_directory_uri() . "/assets/css/tobii.min.css");

	wp_enqueue_script('dci-modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.js');
	wp_enqueue_script('tobii', get_template_directory_uri() . '/assets/js/tobii.min.js');

	wp_enqueue_style('dci-icons');

	// print css
	wp_enqueue_style('dci-print-style', get_template_directory_uri() . '/print.css', array(), '20190912', 'print');

	// footer
	//load Bootstrap Italia latest js if exists in node_modules
	if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/node_modules/bootstrap-italia/dist/js/bootstrap-italia.bundle.min.js')) {
		wp_enqueue_script('dci-bootstrap-italia-min-js', get_template_directory_uri() . '/node_modules/bootstrap-italia/dist/js/bootstrap-italia.bundle.min.js', array(), false, true);
	} else {
		wp_enqueue_script('dci-bootstrap-italia-min-js', get_template_directory_uri() . '/assets/js/bootstrap-italia.bundle.min.js', array(), false, true);
	}
	wp_enqueue_script('dci-comuni', get_template_directory_uri() . '/assets/js/comuni.js', array(), false, true);
	wp_add_inline_script('dci-comuni', 'window.wpRestApi = "' . get_rest_url() . '"', 'before');

	wp_enqueue_script('dci-jquery-easing', get_template_directory_uri() . '/assets/js/components/jquery-easing/jquery.easing.js', array(), false, true);
	wp_enqueue_script('dci-jquery-scrollto', get_template_directory_uri() . '/assets/js/components/jquery.scrollto/jquery.scrollTo.js', array(), false, true);
	wp_enqueue_script('dci-jquery-responsive-dom', get_template_directory_uri() . '/assets/js/components/ResponsiveDom/js/jquery.responsive-dom.js', array(), false, true);
	wp_enqueue_script('dci-jpushmenu', get_template_directory_uri() . '/assets/js/components/jPushMenu/jpushmenu.js', array(), false, true);
	wp_enqueue_script('dci-perfect-scrollbar', get_template_directory_uri() . '/assets/js/components/perfect-scrollbar-master/perfect-scrollbar/js/perfect-scrollbar.jquery.js', array(), false, true);
	wp_enqueue_script('dci-vallento', get_template_directory_uri() . '/assets/js/components/vallenato.js-master/vallenato.js', array(), false, true);
	wp_enqueue_script('dci-jquery-responsive-tabs', get_template_directory_uri() . '/assets/js/components/responsive-tabs/js/jquery.responsiveTabs.js', array(), false, true);
	wp_enqueue_script('dci-fitvids', get_template_directory_uri() . '/assets/js/components/fitvids/jquery.fitvids.js', array(), false, true);
	wp_enqueue_script('dci-sticky-kit', get_template_directory_uri() . '/assets/js/components/sticky-kit-master/dist/sticky-kit.js', array(), false, true);

	wp_enqueue_script('dci-jquery-match-height', get_template_directory_uri() . '/assets/js/components/jquery-match-height/dist/jquery.matchHeight.js', array(), false, true);

	if (is_singular(array("servizio", "unita_organizzativa", "luogo", "evento", "scheda_progetto", "post", "circolare", "indirizzo")) || is_archive() || is_search() || is_post_type_archive("luogo")) {
		wp_enqueue_script('dci-leaflet-js', get_template_directory_uri() . '/assets/js/components/leaflet/leaflet.js', array(), false, true);
	}

	if (is_singular(array("evento", "scheda_progetto")) || is_home() || is_archive()) {
		wp_enqueue_script('dci-clndr-json2', get_template_directory_uri() . '/assets/js/components/clndr/json2.js', array(), false, false);
		wp_enqueue_script('dci-clndr-moment', get_template_directory_uri() . '/assets/js/components/clndr/moment.js', array(), false, false);
		wp_enqueue_script('dci-clndr-underscore', get_template_directory_uri() . '/assets/js/components/clndr/underscore.js', array(), false, false);
		wp_enqueue_script('dci-clndr-clndr', get_template_directory_uri() . '/assets/js/components/clndr/clndr.js', array(), false, false);
		wp_enqueue_script('dci-clndr-it', get_template_directory_uri() . '/assets/js/components/clndr/it.js', array(), false, false);
	}

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	wp_enqueue_script('dci-argomenti', get_template_directory_uri() . '/assets/js/argomenti.js', array('jquery'), null, true);
	$ajax_url = admin_url('admin-ajax.php');
	$inline_script = "
		var myAjax = {
			'ajaxurl': '{$ajax_url}'
		};
	";
	wp_add_inline_script('dci-argomenti', $inline_script);
	wp_enqueue_script('dci-argomenti_card', get_template_directory_uri() . '/assets/js/argomenti_card.js', array(), false, false);
	wp_enqueue_script('dci-ordering-results', get_template_directory_uri() . '/assets/js/ordering.js', array(), false, false);

}
add_action('wp_enqueue_scripts', 'dci_scripts');

function load_eventi_page($posts) {

		$page_current = isset($_POST['pagina_card']) ? intval($_POST['pagina_card']) : 1;
		$post_per_page = isset($_POST['post_per_page']) ? intval($_POST['post_per_page']) : 9;

		$eventi = [];
        $oggi_timestamp = time();

		usort($posts, function($a, $b) {
            $data_inizio_a = get_post_meta($a->ID, '_dci_evento_data_orario_inizio', true);
            $data_inizio_b = get_post_meta($b->ID, '_dci_evento_data_orario_inizio', true);
            return $data_inizio_a <=> $data_inizio_b;
        });

		foreach($posts as $evento){
			$start_timestamp = get_post_meta($evento->ID, '_dci_evento_data_orario_inizio', true);
			$end_timestamp = get_post_meta($evento->ID, '_dci_evento_data_orario_fine', true);
			if($start_timestamp >= $oggi_timestamp || $end_timestamp >= $oggi_timestamp){
				array_push($eventi, $evento);
			}
		}

        $total_eventi = count($eventi);

        if ($total_eventi <= $post_per_page) {
            $eventi_visibili = $eventi;
        } else {
            $offset_eventi = ($page_current - 1) * $post_per_page;
            $eventi_visibili = array_slice($eventi, $offset_eventi, $post_per_page);
        }

        ob_start();
            foreach ($eventi_visibili as $evento) {
                $post = get_post($evento->ID);
                $args = ["post" => $post];
                get_template_part("template-parts/evento/card-full", "", $args);
            }
        $html = ob_get_clean();
		
        return [
			'cards' => $html,
			'total_events' => $total_eventi
		];
}

add_action('wp_ajax_load_eventi_page', 'load_eventi_page');
add_action('wp_ajax_nopriv_load_eventi_page', 'load_eventi_page');

function load_notizie_page($posts) {

    ob_start();

		foreach ($posts as $post) {
			$scheda = $post;
			$args = ["scheda" => $scheda];
			get_template_part("template-parts/home/notizia-evidenza", "", $args);
		}
	$html = ob_get_clean();

    return $html;
}

add_action('wp_ajax_load_notizie_page', 'load_notizie_page');
add_action('wp_ajax_nopriv_load_notizie_page', 'load_notizie_page');

function load_card_page() {
	$term = $_POST['term'];
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : 'argomenti-griglia';
	$page_current = isset($_POST['pagina_card']) ? intval($_POST['pagina_card']) : 1;
	$post_per_page = isset($_POST['post_per_page']) ? intval($_POST['post_per_page']) : 9;
    if (isset($term, $post_type, $page_current)) {

		if ($page_current <= 0) {
			wp_send_json_error(['message' => 'Pagina non valida']);
			return;
		}

        $posts = dci_get_grouped_posts_by_term($post_type, 'argomenti', $term, -1);
        $posts_total = count($posts);

        if (($posts_total > $post_per_page) && $post_type != 'evento') {
            $offset = ($page_current - 1) * $post_per_page;
            $posts = array_slice($posts, $offset, $post_per_page);
        }

        $content = [];
        if ($posts && is_array($posts) && count($posts) > 0){

			if($post_type == 'novita'){
				$content = load_notizie_page($posts);
			}else if($post_type == 'evento'){
				$response = load_eventi_page($posts);
				$content = $response['cards'];
				$posts_total = $response['total_events'];
			}else{
				$content = get_card_content($posts);
			}
        }

        if (!empty($content)) {
            wp_send_json_success([
				'data' => $content,
				'page_count' => $post_per_page,
				'posts_total' => $posts_total,
				'offset' => $offset,
				'total_pages' => ceil($posts_total / $post_per_page),
				'current_page' => $page_current
			]);
        } else {
            wp_send_json_error(['message' => 'Nessun risultato']);
        }
    } else {
        wp_send_json_error(['message' => 'Parametri mancanti']);
    }
}
add_action('wp_ajax_load_card_page', 'load_card_page');
add_action('wp_ajax_nopriv_load_card_page', 'load_card_page');

function get_card_content($card_visibili){
	$content = [];
	foreach ($card_visibili as $post) {
					
		if($post->post_type != 'domanda_frequente'){
					
			$index = 0;
			$card_title = $post->post_title;
			$descrizione_breve = dci_get_meta("descrizione_breve", '', $post->ID);
			$img = get_the_post_thumbnail_url($post) ?? '';
			$tipo = '';

			switch ($post->post_type) {
				case 'luogo':
					$descrizione_breve = dci_get_meta("indirizzo", '', $post->ID);
					$tipo = ('
						<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">
						Luogo
						</span>
					');
				break;
				
				case 'servizio':
					$categorie = get_the_terms($post->ID, 'categorie_servizio');
					if (is_array($categorie) && count($categorie)) {
						$count = 1;
						foreach ($categorie as $categoria) {
							$tipo .= $count == 1 ? '' : ' - ';
							$tipo .= '<a class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase" href="'.get_term_link($categoria->term_id).'">';
							$tipo .=  $categoria->name ; 
							$tipo .= '</a>';
							++$count;
						}
					}
				break;
				
				case 'unita_organizzativa':
					$tipo_organizzazione = get_the_terms($post->ID, 'tipi_unita_organizzativa');
					$tipo = ('
						<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">'.
						$tipo_organizzazione[0]->name.
						'</span>
					');
				break;
				
				case 'sito_tematico':
					$post->guid = dci_get_meta("link", '_dci_sito_tematico_', $post->ID);
					$tipo = ('
						<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">
						Sito tematico
						</span>
					');
				break;

				case 'documento_pubblico':
					$tipo = ('
						<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">
						Documento
						</span>
					');
				break;
				case "page":
					$descrizione_breve = dci_get_meta('descrizione','_dci_page_',$post->ID);
					$tipo = ('
						<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">
						Pagina
						</span>
					');
				break;
			}

			$tipo = preg_replace('/\r|\n|\t/', '', $tipo);
			$tipo = trim($tipo);
				 
			$content[] = [
				'title' => $card_title ?? false,
				'desc' => $descrizione_breve ?? false,
				'head' => $tipo ?? false,
				'link' => $post->guid ?? false,
				'img' => $img ?? false
			];

			$index++;
		}
	}
	return $content;
}
add_action('wp_ajax_get_card_content', 'get_card_content');
add_action('wp_ajax_nopriv_get_card_content', 'get_card_content');

function add_menu_link_class($atts, $item, $args)
{
	if (property_exists($args, 'link_class')) {
		$atts['class'] = $args->link_class;
	}
	return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);

function add_menu_list_item_class($classes, $item, $args)
{
	if (property_exists($args, 'list_item_class')) {
		$classes[] = $args->list_item_class;
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'add_menu_list_item_class', 1, 3);

function max_nav_items($sorted_menu_items, $args)
{
	if (property_exists($args, 'li_slice')) {
		$slice = $args->li_slice;
		$items = array();
		foreach ($sorted_menu_items as $item) {
			if ($item->menu_item_parent != 0) continue;
			$items[] = $item;
		}
		$items = array_slice($items, $slice[0], $slice[1]);
		foreach ($sorted_menu_items as $key => $one_item) {
			if ($one_item->menu_item_parent == 0 && !in_array($one_item, $items)) {
				unset($sorted_menu_items[$key]);
			}
		}
	}
	return $sorted_menu_items;
}
add_filter("wp_nav_menu_objects", "max_nav_items", 10, 2);

function console_log($output, $msg = "log")
{
	echo '<script> console.log("' . $msg . '",' . json_encode($output) . ')</script>';
};

function get_parent_template()
{
	return end(explode('/', get_page_template_slug(wp_get_post_parent_id(get_the_id()))));
}

function custom_upload_mimes($existing_mimes = array())
{
	// add extension to the array
	unset($existing_mimes['css']);
	!isset($existing_mimes['css']) and $existing_mimes['css'] = 'text/css';
	return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');


// BEGIN menu item image

function menu_item_desc($item_id, $item)
{
	wp_enqueue_media();
	wp_enqueue_script( 'dci-custom-media-upload', get_template_directory_uri() . '/inc/admin-js/custom-media-upload.js', ['jquery']);

	$imgid = get_post_meta($item_id, 'menu_item_logo', true);

	if ($imgid)
		$img = wp_get_attachment_url($imgid);
?>
	<br>
	<p>
		<label id="menu_item_logo[<?= $item_id ?>]_label" for="menu_item_logo[<?= $item_id ?>]">Logo</label><br>
		<img style="<?= $imgid ? '':'display: none' ?>" id="menu_item_logo[<?= $item_id ?>]_image" src="<?= $img ?>" width="160px" /><br />
		<input type="hidden" value="<?= $imgid ?>" class="regular-text process_custom_images" id="menu_item_logo[<?= $item_id ?>]" name="menu_item_logo[<?= $item_id ?>]">
		<button class="set_custom_image button" id="menu_item_logo[<?= $item_id ?>]_button">Scegli immagine</button>
		<button style="<?= $imgid ? '':'display: none' ?>" class="remove_custom_image button" id="menu_item_logo[<?= $item_id ?>]_remove_button">Rimuovi immagine</button>
	</p>
<?php
}
add_action('wp_nav_menu_item_custom_fields', 'menu_item_desc', 10, 2);

function save_menu_item_desc($menu_id, $menu_item_db_id)
{
	if (isset($_POST['menu_item_logo'][$menu_item_db_id])) {
		$sanitized_data = sanitize_text_field($_POST['menu_item_logo'][$menu_item_db_id]);
		update_post_meta($menu_item_db_id, 'menu_item_logo', $sanitized_data);
	} else {
		delete_post_meta($menu_item_db_id, 'menu_item_logo');
	}
}
add_action('wp_update_nav_menu_item', 'save_menu_item_desc', 10, 2);

// END menu item image


 // Restituisce il formato e le dimensioni di un allegato
function getFileSizeAndFormat($url) {
    $percorso = parse_url($url);
    $percorso = isset($percorso["path"]) ? substr($percorso["path"], 0, -strlen(pathinfo($url, PATHINFO_BASENAME))) : '';
    $response = wp_remote_head($url);

    if (is_wp_error($response)) {
        return 'Errore nel recupero delle informazioni del file';
    }

    $headers = wp_remote_retrieve_headers($response);
    $content_length = isset($headers['content-length']) ? intval($headers['content-length']) : 0;

    $base = log($content_length, 1024);
    $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');
    $size_formatted = round(pow(1024, $base - floor($base)), 2) . ' ' . $suffixes[floor($base)];

    $info_file = pathinfo($url);
    $file_format = strtoupper(isset($info_file['extension']) ? $info_file['extension'] : '');

    return $file_format . ' ' . $size_formatted;
}

/*
 * Set post views count using post meta
 */
function set_views($post_ID) {
	$key = 'views';
	$count = get_post_meta($post_ID, $key, true); //retrieves the count

	if($count == ''){ //check if the post has ever been seen

		//set count to 0
		$count = 0;

		//just in case
		delete_post_meta($post_ID, $key);

		//set number of views to zero
		add_post_meta($post_ID, $key, '0');

	} else{ //increment number of views
		$count++;
		update_post_meta($post_ID, $key, $count);
	}
}

//keeps the count accurate by removing prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


/**
 * Registra l'hook per accodare lo script JavaScript necessario.
 * Questa funzione viene agganciata a 'cmb2_admin_init'.
 * NOTA: Questa funzione ora si occupa SOLO di accodare lo script.
 */
add_action( 'cmb2_admin_init', 'dci_enqueue_migration_script_for_button' );

function dci_enqueue_migration_script_for_button() {
    // Aggiunge l'azione per accodare gli script JavaScript necessari nelle pagine di amministrazione.
    add_action( 'admin_enqueue_scripts', 'dci_enqueue_migration_assets_updated' );
}

/**
 * Funzione di callback per CMB2 per renderizzare il pulsante di migrazione dopo un campo.
 *
 * @param array    $field_args Argomenti del campo CMB2.
 * @param CMB2_Field $field      Oggetto del campo CMB2.
 */
function dci_render_migration_button_for_cmb2( $field_args, $field ) {
    // L'ID del campo corrente (il campo multiselect a cui stiamo aggiungendo il pulsante)
    $multi_select_field_id = $field_args['id'];
    $post_id = $field->object_id; // Ottiene l'ID del post corrente

    // Deriviamo l'ID del campo sorgente (selezione singola)
    $base_id_part = '';
    $target_suffix = 'unita_organizzative'; // Il suffisso dell'ID del campo corrente (multiselect)
    $source_suffix = 'unita_organizzativa';   // Il suffisso dell'ID del campo sorgente (select)

    if ( substr( $multi_select_field_id, -strlen( $target_suffix ) ) === $target_suffix ) {
        $base_id_part = substr( $multi_select_field_id, 0, -strlen( $target_suffix ) );
    } else {
        // Fallback se il prefisso non può essere derivato facilmente.
        // Potrebbe essere necessario un approccio più robusto se i prefissi variano molto.
        // Per ora, assumiamo che il $field->cmb->prefix() possa dare una mano,
        // o che il formato dell'ID sia consistente.
        // Se il $field->cmb object e il suo prefix() method sono disponibili:
        // $prefix = $field->cmb->prefix();
        // $single_select_field_id = $prefix . $source_suffix;
        // Tuttavia, la derivazione basata sul suffisso è generalmente più affidabile se gli ID sono coerenti.
    }
    $single_select_field_id = $base_id_part . $source_suffix; // Questo è il meta_key del vecchio campo

    // Legge il valore del campo sorgente direttamente dai post meta
    $source_value_from_meta = '';
    if ($post_id && $single_select_field_id) {
        $source_value_from_meta = get_post_meta( $post_id, $single_select_field_id, true );
    }

    // Output dell'HTML per il pulsante e il contenitore dei messaggi
    ?>
    <div style="margin-top: 15px; padding: 12px; border: 1px solid #ccd0d4; border-left-width: 4px; border-left-color: #007cba; background-color: #f6f7f7; border-radius: 4px;">
        <button type="button" class="button dci-migrate-button"
                data-source-field-id="<?php echo esc_attr( $single_select_field_id ); ?>"
                data-target-field-id="<?php echo esc_attr( $multi_select_field_id ); ?>"
                data-source-value-from-meta="<?php echo esc_attr( $source_value_from_meta ); // Aggiunto valore da meta ?>">
            <span class="dashicons dashicons-migrate" style="vertical-align: middle; margin-right: 5px;"></span>
            Trasferisci da '<?php echo esc_html( basename( $single_select_field_id ) ); ?>' a '<?php echo esc_html( basename( $multi_select_field_id ) ); ?>'
        </button>
        <p class="cmb2-metabox-description" style="margin-top: 8px; font-size: 0.9em;">
            Clicca questo pulsante per copiare il valore salvato per il campo obsoleto
            (<code><?php echo esc_html($single_select_field_id); ?></code>, valore attuale: <strong><?php echo esc_html( $source_value_from_meta ? $source_value_from_meta : 'Nessuno o non trovato' ); ?></strong>)
            in questo campo a selezione multipla (<code><?php echo esc_html($multi_select_field_id); ?></code>).<br>
            <strong>Importante:</strong> Dopo aver trasferito il valore, ricorda di <strong>Salvare</strong> o <strong>Aggiornare</strong> il post per rendere effettive le modifiche.
        </p>
        <div class="dci-migration-message" style="margin-top: 10px; padding: 10px; border-radius: 3px; display: none; border-width: 1px; border-style: solid;"></div>
    </div>
    <?php
}

/**
 * Accoda lo script JavaScript esterno per la logica del pulsante di migrazione.
 * (Questa funzione rimane sostanzialmente la stessa della versione precedente,
 * ma le ho dato un nome leggermente diverso per chiarezza nel contesto di questo snippet)
 *
 * @param string $hook_suffix Il suffisso della pagina di amministrazione corrente.
 */
function dci_enqueue_migration_assets_updated( $hook_suffix ) {
    // Esegui lo script solo nelle pagine di modifica ('post.php') o creazione ('post-new.php') dei post.
    // Potresti voler restringere ulteriormente al/ai post_type specifico/i dove usi questo metabox.
    if ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) {
        
        wp_enqueue_script(
            'dci-uo-migration-script', 
            get_template_directory_uri() . '/assets/js/uo_migration.js', 
            array( 'jquery' ),      
            false,                
            true                    
        );
    }
}