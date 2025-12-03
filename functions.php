<?php

/**
 * Design Comuni Italia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Design_Comuni_Italia
 */

/*
* Fix errori accessibilità e standard HTML e CSS
*/
add_filter( 'wp_img_tag_add_auto_sizes', '__return_false' );

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

				case "procedura":
					$descrizione_breve = dci_get_meta('descrizione_breve','_dci_procedura_',$post->ID);
					$tipo = ('
						<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">
						Procedura
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
	$classId = get_post_meta($item_id, 'menu_item_icon_class', true);
	?>
	<p>
		<label id="label_icon_class" for="menu_item_icon_class[<?= $item_id ?>]">Classe icona</label>
		<input type="text" value="<?= $classId ?>" placeholder="Classe icona da mostrare" id="menu_item_icon_class[<?= $item_id ?>]" class="widefat edit-menu-item-title" name="menu_item_icon_class[<?= $item_id ?>]">
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


	if (isset($_POST['menu_item_icon_class'][$menu_item_db_id])) {
		$sanitized_data = sanitize_text_field($_POST['menu_item_icon_class'][$menu_item_db_id]);
		update_post_meta($menu_item_db_id, 'menu_item_icon_class', $sanitized_data);
	} else {
		delete_post_meta($menu_item_db_id, 'menu_item_icon_class');
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
 * Aggiunge una pagina di menu "Utilities" in WordPress Admin.
 */
add_action( 'admin_menu', 'dci_add_utilities_admin_page' );
function dci_add_utilities_admin_page() {
    add_menu_page(
       'Strumenti del tema ESA', 
       'Strumenti del tema ESA', 
       'manage_options',
       'dci_data_migration_utilities',  
       'dci_render_utilities_page_content', 
       'dashicons-admin-tools',
       80
    );
}

/**
 * Renderizza il contenuto per la pagina di Utilities.
 */
function dci_render_utilities_page_content() {
	$valore_corrente = get_option( 'nascondi_menu_procedura', 'yes' );
    ?>
    <div class="wrap migrations">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
            
            <?php 
                wp_nonce_field( 'salva_opzioni_menu_procedura', 'nascondi_menu_procedura_nonce' ); 
            ?>
            <input type="hidden" name="action" value="salva_opzioni_menu_procedura_custom">

            <h2><?='Controllo visibilità Menu Amministrazione'?></h2>
            <p>
                <?='Seleziona "Sì" per nascondere la voce di menu "Come fare per" (Procedure) per tutti gli utenti.'?>
            </p>
            <table class="form-table">
                <tr>
                    <th scope="row">Nascondi "Come fare per"</th>
                    <td>
                        <?php 
                        echo '<input type="radio" id="procedura_no" name="nascondi_menu_procedura" value="no" ' . checked( 'no', $valore_corrente, false ) . ' />';
                        echo '<label for="procedura_no"> No, mantieni la voce visibile.</label><br>';
                        
                        echo '<input type="radio" id="procedura_si" name="nascondi_menu_procedura" value="yes" ' . checked( 'yes', $valore_corrente, false ) . ' />';
                        echo '<label for="procedura_si"> Sì, nascondi la voce "Come fare per".</label>';
                        ?>
                    </td>
                </tr>
            </table>
            
            <?php 
                submit_button('Salva visibilità'); 
            ?>
        </form>
		<hr>
        <div id="dci-migration-controls">
            <h2><?='Migrazione Incarico-Unità Organizzativa > Incarico-Unità Organizzative (Versione DCI 1.10.4 - Revisione 17)'?></h2>
            <p>
                <?='Questa operazione cercherà in tutti i post di tipo <strong>Incarico</strong> il vecchio campo "Unità Organizzativa" (singolo) e trasferirà il suo valore al nuovo campo "Unità Organizzative" (multiplo), se non già presente.'?>
            </p>
            <p>
                <strong><?='Attenzione:'?></strong> <?='Questa operazione potrebbe richiedere del tempo su siti con molti post. Si consiglia di eseguire un backup del database prima di procedere.'?>
            </p>

            <button class="button button-primary start-bulk-migration-button" data-type="uo">
                <?='Avvia Migrazione Massiva Unità Organizzative'?>
            </button>

            <h2><?='Migrazione Contenuti in evidenza > Schede in evidenza (Versione DCI 1.12.2 - Revisione 1)'?></h2>
			<p>
                <?='Questa operazione cercherà tutti i contenuti in evidenza con il vecchio meccanismo e li trasferirà nel nuovo.'?>
            </p>

			<button class="button button-primary start-bulk-migration-button" data-type="evidenza">
                <?='Avvia Migrazione Massiva dei contenuti in evidenza '?>
            </button>

			<h2><?='Migrazione Fase-Servizio > Fase-Servizio (Versione DCI 1.12.3 - Revisione 4?)'?></h2>
			<p>
                <?='Questa operazione cercherà tutte le fasi di servizio con il vecchio meccanismo e le trasferirà nel nuovo.'?>
            </p>
			<p>
                <strong><?='Attenzione:'?></strong> <?='Le fasi inserite manualmente attraverso il vecchio campo Gruppo-Fase non verranno migrate automaticamente.'?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?action=dci_export_manual_phases' ) ); ?>">
						<?='Esporta Backup Fasi inserite manualmente in CSV'?>
                </a>
			</p>
			<button class="button button-primary start-bulk-migration-button" data-type="fase-servizio">
                <?='Avvia Migrazione Massiva delle fasi '?>
            </button>
        </div>
			
        <span id="dci-bulk-migration-spinner" class="spinner" style="float: none; visibility: hidden; margin-left: 5px;"></span>

        <div id="dci-migration-feedback" style="margin-top: 20px; padding: 15px; border: 1px solid #ccd0d4; background-color: #f6f7f7; display: none;">
            <h3><?='Risultati Migrazione:'?></h3>
            <div id="dci-migration-results-content"></div>
        </div>
    </div>
    <?php
}

/**
 * Accoda lo script JavaScript per la pagina di utilities.
 */
add_action( 'admin_enqueue_scripts', 'dci_enqueue_utilities_page_scripts' );
function dci_enqueue_utilities_page_scripts( $hook_suffix ) {
    if ( 'toplevel_page_dci_data_migration_utilities' !== $hook_suffix ) {
        return;
    }

    $script_path = get_template_directory_uri() . '/inc/admin-js/bulk_migration.js';
    $script_version = '1.0.1'; // Cambia per invalidare la cache
	$text_processing = 'Elaborazione in corso...';
	$text_error = 'Si è verificato un errore. Controlla la console del browser per i dettagli.';

    wp_enqueue_script(
        'dci-bulk-migration-script',
        $script_path,
        array( 'jquery' ),
        $script_version,
        true
    );

    // Passa dati allo script, come il nonce per AJAX e l'action hook
    wp_localize_script(
        'dci-bulk-migration-script',
        'dci_bulk_migration_params',
        array(
			'uo' =>
				array (
					'ajax_url'      => admin_url( 'admin-ajax.php' ),
					'nonce'         => wp_create_nonce( 'dci_bulk_migration_nonce' ),
					'action'        => 'dci_perform_uo_bulk_migration',
					'text_processing' => $text_processing,
					'text_error'    => $text_error
				),
			'evidenza' =>
				array (
					'ajax_url'      => admin_url( 'admin-ajax.php' ),
					'nonce'         => wp_create_nonce( 'dci_bulk_migration_nonce' ),
					'action'        => 'dci_perform_evidenza_bulk_migration',
					'text_processing' => $text_processing,
					'text_error'    => $text_error			
				),
			'fase-servizio' =>
				array (
					'ajax_url'      => admin_url( 'admin-ajax.php' ),
					'nonce'         => wp_create_nonce( 'dci_bulk_migration_nonce' ),
					'action'        => 'dci_perform_fase_servizio_bulk_migration',
					'text_processing' => $text_processing,
					'text_error'    => $text_error
				)
        )
    );
}

/**
 * Gestore AJAX per l'operazione di migrazione massiva UO
 */
add_action( 'wp_ajax_dci_perform_uo_bulk_migration', 'dci_ajax_perform_uo_bulk_migration_handler' );
function dci_ajax_perform_uo_bulk_migration_handler() {
    // Verifica Nonce e permessi utente
    check_ajax_referer( 'dci_bulk_migration_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( 'Non hai i permessi per eseguire questa operazione.', 403 );
        return;
    }

    $meta_prefix = '_dci_incarico_';

    $old_meta_key = $meta_prefix . 'unita_organizzativa';
    $new_meta_key = $meta_prefix . 'incarico_unita_organizzative';

    $post_types_to_process = array('incarico');

    $args = array(
        'post_type'      => $post_types_to_process,
		'posts_per_page' => -1, // Processa tutti i post corrispondenti
        'post_status'    => 'any', // Considera tutti gli stati dei post
        'meta_query'     => array(
            array(
                'key'     => $old_meta_key,
                'compare' => 'EXISTS', // Processa solo i post che hanno il vecchio meta key
            ),
        ),
        'fields'         => 'ids',
    );

    $post_ids = get_posts( $args );

    $processed_count = 0;
    $updated_count = 0;
    $already_migrated_count = 0;
    $no_value_old_field_count = 0;
    $errors = array();

    if ( empty( $post_ids ) ) {
        wp_send_json_success( array(
            'message' => 'Nessun post trovato con il vecchio campo meta da migrare.',
            'stats'   => array(
                'processed' => $processed_count,
                'updated'   => $updated_count,
                'already_migrated' => $already_migrated_count,
                'no_value_old_field' => $no_value_old_field_count,
            )
        ) );
        return;
    }

    foreach ( $post_ids as $post_id ) {
        $processed_count++;
        $old_value = get_post_meta( $post_id, $old_meta_key, true );

        if ( empty( $old_value ) ) {
            // Il meta key esiste ma il valore è vuoto
            $no_value_old_field_count++;
            continue;
        }

        $new_values_array = get_post_meta( $post_id, $new_meta_key, true );
        if ( ! is_array( $new_values_array ) ) {
            $new_values_array = array();
        }

        // Rimuovi eventuali valori vuoti dall'array esistente
        $new_values_array = array_filter( $new_values_array, function($value) {
            return !empty($value);
        });

        if ( ! in_array( $old_value, $new_values_array ) ) {
            $new_values_array[] = $old_value;
            $update_result = update_post_meta( $post_id, $new_meta_key, $new_values_array );
            if ( false === $update_result ) {
                $errors[] = sprintf( 'Errore durante l\'aggiornamento del post ID %d.', $post_id );
            } else {
                $updated_count++;
            }
        } else {
            $already_migrated_count++;
        }
    }

    $response_message = sprintf(
        'Migrazione completata. Post processati: %d. Post aggiornati: %d. Valori già migrati/presenti: %d. ',
        $processed_count,
        $updated_count,
        $already_migrated_count,
        $no_value_old_field_count
    );

    if ( ! empty( $errors ) ) {
        $response_message .= "\n" . 'Si sono verificati alcuni errori:' . "\n" . implode( "\n", $errors );
        wp_send_json_error( array(
            'message' => $response_message,
            'stats'   => array(
                'processed' => $processed_count,
                'updated'   => $updated_count,
                'already_migrated' => $already_migrated_count,
                'no_value_old_field' => $no_value_old_field_count,
                'errors'    => count($errors)
            )
        ) );
    } else {
        wp_send_json_success( array(
            'message' => $response_message,
            'stats'   => array(
                'processed' => $processed_count,
                'updated'   => $updated_count,
                'already_migrated' => $already_migrated_count,
                'no_value_old_field' => $no_value_old_field_count,
            )
        ) );
    }
}

/**
 * Gestore AJAX per l'operazione di migrazione massiva EVIDENZA.
 */
add_action( 'wp_ajax_dci_perform_evidenza_bulk_migration', 'dci_ajax_perform_evidenza_bulk_migration_handler' );
function dci_ajax_perform_evidenza_bulk_migration_handler() {
	
	check_ajax_referer( 'dci_bulk_migration_nonce', 'nonce' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( 'Non hai i permessi per eseguire questa operazione.', 403 );
		return;
	}

	$old_schede_ids = dci_get_option('schede_evidenziate', 'homepage');
	$new_schede_group = dci_get_option('schede_evidenza', 'homepage');

	$processed_count = 0;
	$updated_count = 0;
	$already_migrated_count = 0;
	$no_value_old_field_count = 0;
	$errors = array();
	
	if ( ! is_array( $new_schede_group ) ) {
		$new_schede_group = array();
	}

	if ( empty( $old_schede_ids ) || ! is_array( $old_schede_ids ) ) {
		wp_send_json_success( array(
			'message' => 'Nessun contenuto in evidenza trovato con il vecchio metodo da migrare.',
			'stats'   => array(
				'processed' => 0,
				'updated'   => 0,
				'already_migrated' => count($new_schede_group),
				'no_value_old_field' => 0,
			)
		) );
		return;
	}

	$new_schede_post_ids = array();
	foreach ( $new_schede_group as $group_item ) {
		if ( isset( $group_item['tipo_evidenza'] ) && $group_item['tipo_evidenza'] === 'content' && ! empty( $group_item['contenuto_evidenza'] ) && is_array( $group_item['contenuto_evidenza'] ) ) {
			$new_schede_post_ids[] = reset( $group_item['contenuto_evidenza'] );
		}
	}
	
	$processed_count = count( $old_schede_ids );
	$items_were_added = false; 

	foreach ( $old_schede_ids as $old_post_id ) {
		if ( empty( $old_post_id ) ) {
			$no_value_old_field_count++;
			continue;
		}
		
		$old_post_id = intval($old_post_id);

		if ( ! in_array( $old_post_id, $new_schede_post_ids ) ) {
			$new_schede_group[] = array(
				'tipo_evidenza'      => 'content',
				'contenuto_evidenza' => array( (string) $old_post_id ),
				'termine_evidenza'   => '',
				'expiration'         => '',
			);
			$updated_count++;
			$items_were_added = true; 
		} else {
			$already_migrated_count++;
		}
	}
	
	if ( $items_were_added ) {
		$update_result = cmb2_update_option( "homepage", "schede_evidenza", $new_schede_group );
	
		if ( false === $update_result ) {
			$errors[] = 'Errore critico durante il salvataggio dei nuovi dati nella tabella options.';
		}
	}

	$response_message = sprintf(
		'Migrazione completata. Contenuti processati: %d. Contenuti aggiornati: %d. Contenuti già migrati/presenti: %d. Contenuti con valore vuoto ignorati: %d.',
		$processed_count,
		$updated_count,
		$already_migrated_count,
		$no_value_old_field_count
	);

	if ( ! empty( $errors ) ) {
		$response_message .= "\n" . 'Si sono verificati alcuni errori:' . "\n" . implode( "\n", $errors );
		wp_send_json_error( array(
			'message' => $response_message,
			'stats'   => array(
				'processed' => $processed_count,
				'updated'   => $updated_count,
				'already_migrated' => $already_migrated_count,
				'no_value_old_field' => $no_value_old_field_count,
				'errors'    => count($errors)
			)
		) );
	} else {
		wp_send_json_success( array(
			'message' => $response_message,
			'stats'   => array(
				'processed' => $processed_count,
				'updated'   => $updated_count,
				'already_migrated' => $already_migrated_count,
				'no_value_old_field' => $no_value_old_field_count,
			)
		) );
	}
}

/**
 * Genera e scarica un file CSV con le vecchie fasi scritte a mano, ottimizzato per Excel.
 */
function dci_export_manual_phases_to_csv() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Non hai i permessi per eseguire questa operazione.', 403 );
    }

    $meta_key = '_dci_servizio_scadenze';
    
    $args = array(
        'post_type'      => 'servizio',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'meta_query'     => array(
            array(
                'key'     => $meta_key,
                'compare' => 'EXISTS',
            ),
        ),
        'fields'         => 'ids',
    );

    $post_ids = get_posts( $args );

    $csv_header = array( 'Post ID', 'Post Title', 'Fase Index', 'Titolo Fase', 'Giorni', 'Descrizione' );
    $csv_data = array();

    if ( ! empty( $post_ids ) ) {
        foreach ( $post_ids as $post_id ) {
            $post = get_post($post_id);
            $manual_phases = get_post_meta( $post_id, $meta_key, true );

            if ( is_array( $manual_phases ) && ! empty( $manual_phases ) ) {
                $fase_index = 0;
                foreach ( $manual_phases as $phase ) {
                    $csv_data[] = array(
                        $post_id,
                        $post->post_title,
                        $fase_index++,
                        isset($phase['titolo']) ? $phase['titolo'] : '',
                        isset($phase['giorni']) ? $phase['giorni'] : '',
                        isset($phase['descrizione']) ? str_replace(array("\r", "\n", "\t"), ' ', $phase['descrizione']) : '',
                    );
                }
            }
        }
    }
    
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename=backup_fasi_manuali_' . date('Y-m-d') . '.csv');
    
    $output = fopen('php://output', 'w');
    
    fputs($output, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
    
    fputcsv($output, $csv_header, ';');
    
    foreach ($csv_data as $row) {
        fputcsv($output, $row, ';');
    }
    
    fclose($output);
    exit;
}

add_action( 'admin_action_dci_export_manual_phases', 'dci_export_manual_phases_to_csv' );


/**
 * Gestore AJAX per l'operazione di migrazione massiva FASI-SERVIZIO
 */
add_action( 'wp_ajax_dci_perform_fase_servizio_bulk_migration', 'dci_ajax_perform_fase_servizio_bulk_migration_handler' );
function dci_ajax_perform_fase_servizio_bulk_migration_handler() {
	
    check_ajax_referer( 'dci_bulk_migration_nonce', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( 'Non hai i permessi per eseguire questa operazione.', 403 );
        return;
    }

    $old_meta_key = '_dci_servizio_fasi'; 
    $new_meta_key = '_dci_servizio_fasi_raggruppate';

    $args = array(
        'post_type'      => 'servizio',
		'posts_per_page' => -1, 
        'post_status'    => 'any',
        'meta_query'     => array(
            array(
                'key'     => $old_meta_key,
                'compare' => 'EXISTS', 
            ),
        ),
        'fields'         => 'ids',
    );

    $post_ids = get_posts( $args );

    $processed_count = 0;
    $updated_count = 0;
    $already_migrated_count = 0;
    $no_value_old_field_count = 0;
    $errors = array();

    if ( empty( $post_ids ) ) {
        wp_send_json_success( array(
            'message' => 'Nessun post di tipo "servizio" trovato con il vecchio campo fasi da migrare.',
            'stats'   => array(
                'processed' => 0,
            )
        ) );
        return;
    }

    foreach ( $post_ids as $post_id ) {
        $processed_count++;
        $old_values = get_post_meta( $post_id, $old_meta_key, true ); 

        if ( empty( $old_values ) || ! is_array( $old_values ) ) {
            $no_value_old_field_count++;
            continue;
        }

        $new_values_group = get_post_meta( $post_id, $new_meta_key, true );
        if ( ! is_array( $new_values_group ) ) {
            $new_values_group = array();
        }

        $existing_phase_ids = array();
        foreach ( $new_values_group as $group_item ) {
            if ( ! empty( $group_item['fase_selezionata'] ) ) {
                $existing_phase_ids[] = $group_item['fase_selezionata'];
            }
        }
        
        $items_were_added = false;

        foreach ( $old_values as $phase_id ) {
            $phase_id = (string) $phase_id;
            
            if ( ! in_array( $phase_id, $existing_phase_ids ) ) {
                
                $new_values_group[] = array(
                    'fase_selezionata' => $phase_id,
                    'type_date'        => 'days', 
                    'scadenza_fase'    => '',
                    'count_giorni'     => '',
                );
                
                $updated_count++;
                $items_were_added = true;
                $existing_phase_ids[] = $phase_id;
            } else {
                $already_migrated_count++;
            }
        }
        
        if ( $items_were_added ) {
            $update_result = update_post_meta( $post_id, $new_meta_key, $new_values_group );
            if ( false === $update_result ) {
                $errors[] = sprintf( 'Errore durante l\'aggiornamento del post ID %d.', $post_id );
            }
        }
    }

    $response_message = sprintf(
        'Migrazione Fasi Servizio completata. Post di servizio processati: %d. Fasi aggiunte/aggiornate: %d. Fasi già presenti: %d. Post con campo vecchio vuoto ignorati: %d.',
        $processed_count,
        $updated_count,
        $already_migrated_count,
        $no_value_old_field_count
    );

    if ( ! empty( $errors ) ) {
        $response_message .= "\n" . 'Si sono verificati alcuni errori:' . "\n" . implode( "\n", $errors );
        wp_send_json_error( array(
            'message' => $response_message,
            'stats'   => array(
                'processed' => $processed_count,
                'updated'   => $updated_count,
                'already_migrated' => $already_migrated_count,
                'no_value_old_field' => $no_value_old_field_count,
                'errors'    => count($errors)
            )
        ) );
    } else {
        wp_send_json_success( array(
            'message' => $response_message,
            'stats'   => array(
                'processed' => $processed_count,
                'updated'   => $updated_count,
                'already_migrated' => $already_migrated_count,
                'no_value_old_field' => $no_value_old_field_count,
            )
        ) );
    }
}

/**
 * 1. Registra solo l'impostazione nel database.
 */
function nascondi_procedura_registra_impostazioni_custom() {
    $option_group = 'dci_utilities_options';
    $option_name = 'nascondi_menu_procedura';

    register_setting(
        $option_group, 
        $option_name, 
        array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => 'yes',
        )
    );
}
add_action( 'admin_init', 'nascondi_procedura_registra_impostazioni_custom' );


/**
 * 2. Rimuovi la voce di menu del CPT 'procedura' in base al valore dell'impostazione.
 */
function rimuovi_procedura_condizionale() {
    $nascondi_procedura = get_option( 'nascondi_menu_procedura', 'no' );

    if ( $nascondi_procedura === 'yes' ) {
        $slug_cpt = 'edit.php?post_type=procedura'; 
        remove_menu_page( $slug_cpt ); 
    }
}
add_action( 'admin_menu', 'rimuovi_procedura_condizionale' );

/**
 * Gestisce l'invio del form custom e salva l'opzione manualmente.
 */
function dci_handle_salva_opzioni_menu_procedura_custom() {
    
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Non hai i permessi necessari.' );
    }
    if ( ! isset( $_POST['nascondi_menu_procedura_nonce'] ) || ! wp_verify_nonce( $_POST['nascondi_menu_procedura_nonce'], 'salva_opzioni_menu_procedura' ) ) {
        wp_die( 'Controllo di sicurezza fallito.' );
    }

    $nuovo_valore = 'no';
    if ( isset( $_POST['nascondi_menu_procedura'] ) ) {
        $nuovo_valore = sanitize_text_field( $_POST['nascondi_menu_procedura'] );
    }

    update_option( 'nascondi_menu_procedura', $nuovo_valore );

    wp_safe_redirect( add_query_arg( 
        array( 
            'page' => 'dci_data_migration_utilities', 
            'settings-updated' => 'true'
        ), 
        admin_url( 'admin.php' ) 
    ) );
    exit;
}
add_action( 'admin_post_salva_opzioni_menu_procedura_custom', 'dci_handle_salva_opzioni_menu_procedura_custom' );


/* DEBUG: Mostra un avviso in admin con il percorso esatto del file SimpleXLSX.php
add_action('admin_notices', function() {
    $path = get_template_directory() . '/inc/lib/SimpleXLSX.php';
    echo '<div class="notice notice-warning is-dismissible" style="z-index: 99999;">';
    echo '<h3>DEBUG PERCORSO</h3>';
    echo '<p>Il sistema sta cercando il file esattamente qui:<br>';
    echo '<strong>' . $path . '</strong></p>';
    
    if (file_exists($path)) {
        echo '<p style="color:green; font-weight:bold;">IL FILE ESISTE!</p>';
    } else {
        echo '<p style="color:red; font-weight:bold;">IL FILE NON È STATO TROVATO.</p>';
        echo '<p>Controlla che:<br>';
        echo '1. La cartella "lib" esista dentro "inc".<br>';
        echo '2. Il file si chiami "SimpleXLSX.php" (occhio alle maiuscole S e XLSX!).</p>';
    }
    echo '</div>';
});
*/


/**
 * CARICAMENTO LIBRERIA EXCEL E FIX NAMESPACE
 */

$xlsx_path = get_template_directory() . '/inc/lib/SimpleXLSX.php';
if (file_exists($xlsx_path)) {
    require_once $xlsx_path;
    if (class_exists('Shuchkin\SimpleXLSX')) {
        class_alias('Shuchkin\SimpleXLSX', 'SimpleXLSX');
    }
}

/**
 * 1. REGISTRAZIONE PAGINA DI IMPORTAZIONE
 */
add_action('admin_menu', 'dci_register_import_page');
function dci_register_import_page() {
    add_submenu_page(
        'dci_data_migration_utilities', 
        'Importa Dati', 
        'Importa Excel ESA', 
        'manage_options', 
        'dci-import-excel', 
        'dci_render_import_page'
    );
}

/**
 * 2. INTERFACCIA GRAFICA IMPORTATORE
 */
function dci_render_import_page() {
    if (isset($_POST['dci_fix_gps_nonce']) && wp_verify_nonce($_POST['dci_fix_gps_nonce'], 'dci_fix_gps_action')) {
        dci_fix_gps_data();
    }

    // B. Gestione Opzioni Visualizzazione (Checkbox)
    if (isset($_POST['dci_toggle_gps_col_nonce']) && wp_verify_nonce($_POST['dci_toggle_gps_col_nonce'], 'dci_toggle_gps_col_action')) {
        $val = isset($_POST['show_gps_column']) ? 1 : 0;
        update_option('dci_show_gps_column', $val);
        echo '<div class="notice notice-success is-dismissible"><p>Impostazioni visualizzazione aggiornate.</p></div>';
    }

    // C. Gestione Importazione
    if (isset($_FILES['import_file']) && isset($_POST['dci_import_nonce'])) {
        dci_handle_excel_upload();
    }

    // Recupero stato attuale checkbox
    $show_gps_checked = get_option('dci_show_gps_column', 0); // Default 0 (Disattivato)
    ?>
    <div class="wrap">
        <h1>Importazione Dati da Excel (Modello ESA)</h1>
        
        <div class="card" style="max-width: 800px; padding: 20px; margin-top: 20px;">
            <h2>1. Carica il file Excel</h2>
            <p>Carica qui il file <code>.xlsx</code> compilato. Il sistema riconoscerà automaticamente le schede e importerà i dati partendo dalle righe predefinite.</p>
            
            <?php 
            if (!class_exists('SimpleXLSX')) {
                echo '<div class="notice notice-error inline"><p><strong>ERRORE CRITICO:</strong> La classe <code>SimpleXLSX</code> non è stata caricata.</p></div>';
            } else {
                ?>
                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field('dci_import_action', 'dci_import_nonce'); ?>
                    <label for="import_file" style="font-weight:bold; display:block; margin-bottom:10px;">Seleziona File (.xlsx):</label>
                    <input type="file" name="import_file" id="import_file" accept=".xlsx" required>
                    <p class="submit">
                        <input type="submit" class="button button-primary button-large" value="Avvia Importazione Dati">
                    </p>
                </form>
                <?php
            }
            ?>
        </div>

        <div class="card" style="max-width: 800px; padding: 20px; margin-top: 20px; border-left: 4px solid #f0b849;">
            <h2>2. Manutenzione Dati</h2>
            
            <p><strong>Strumento di Riparazione:</strong> Usa questo pulsante se noti problemi con la mappa dei luoghi (caricamento infinito). Rimuoverà dati GPS non validi.</p>
            <form method="post" style="margin-bottom: 20px;">
                <?php wp_nonce_field('dci_fix_gps_action', 'dci_fix_gps_nonce'); ?>
                <input type="submit" class="button button-secondary" value="Ripara campi GPS">
            </form>

            <hr style="border-top: 1px solid #ddd; margin: 20px 0;">

            <p><strong>Opzioni Visualizzazione:</strong> Attiva questa opzione per vedere una colonna "Stato GPS" nella lista dei Luoghi. Utile per capire quali luoghi mancano di coordinate.</p>
            <form method="post">
                <?php wp_nonce_field('dci_toggle_gps_col_action', 'dci_toggle_gps_col_nonce'); ?>
                <label for="show_gps_column">
                    <input type="checkbox" name="show_gps_column" id="show_gps_column" value="1" <?php checked(1, $show_gps_checked); ?>>
                    Mostra colonna stato GPS nella lista Luoghi
                </label>
                <br><br>
                <input type="submit" class="button" value="Salva Impostazione">
            </form>
        </div>
    </div>
    <?php
}

function dci_fix_gps_data() {
    global $wpdb;
    $results = $wpdb->get_results("SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = '_dci_luogo_posizione_gps'");
    $count = 0;

    foreach ($results as $row) {
        $value = maybe_unserialize($row->meta_value);
        // Validazione rigorosa: deve essere array con lat e lng
        $is_valid = (is_array($value) && isset($value['lat']) && isset($value['lng']) && !empty($value['lat']));
        
        if (!$is_valid) {
            delete_post_meta($row->post_id, '_dci_luogo_posizione_gps');
            $count++;
        }
    }
    echo '<div class="notice notice-success is-dismissible"><p><strong>Riparazione completata:</strong> ' . $count . ' campi GPS non validi o vuoti sono stati bonificati.</p></div>';
}

/**
 * 3. LOGICA DI LETTURA EXCEL
 */
function dci_handle_excel_upload() {
    if (!wp_verify_nonce($_POST['dci_import_nonce'], 'dci_import_action')) return;
    
    @set_time_limit(300); 
    @ini_set('memory_limit', '512M');

    if ($xlsx = SimpleXLSX::parse($_FILES['import_file']['tmp_name'])) {
        
        $sheetNames = $xlsx->sheetNames();
        $map = [
            'Luoghi'              => ['func' => 'import_sheet_luoghi',  'start_row' => 11], 
            'Unità organizzative' => ['func' => 'import_sheet_uo',      'start_row' => 8],  
            'Persone e incarichi' => ['func' => 'import_sheet_persone', 'start_row' => 7],  
            'Servizi'             => ['func' => 'import_sheet_servizi', 'start_row' => 12]  
        ];

        $locations_missing_gps = [];

        echo '<div class="notice notice-success is-dismissible"><p><strong>Importazione Completata!</strong></p>';
        
        foreach ($sheetNames as $sheetIndex => $sheetName) {
            $cleanName = trim($sheetName);
            
            if (isset($map[$cleanName])) {
                
                $display_title = $cleanName;
                switch ($cleanName) {
                    case 'Luoghi':
                        $url = admin_url('edit.php?post_type=luogo');
                        $display_title = "<a href='{$url}' target='_blank'><strong>{$cleanName}</strong></a>";
                        break;
                    case 'Unità organizzative':
                        $url = admin_url('edit.php?post_type=unita_organizzativa');
                        $display_title = "<a href='{$url}' target='_blank'><strong>{$cleanName}</strong></a>";
                        break;
                    case 'Servizi':
                        $url = admin_url('edit.php?post_type=servizio');
                        $display_title = "<a href='{$url}' target='_blank'><strong>{$cleanName}</strong></a>";
                        break;
                    case 'Persone e incarichi':
                        $url_p = admin_url('edit.php?post_type=persona_pubblica');
                        $url_i = admin_url('edit.php?post_type=incarico');
                        $display_title = "<a href='{$url_p}' target='_blank'><strong>Persone</strong></a> e <a href='{$url_i}' target='_blank'><strong>Incarichi</strong></a>";
                        break;
                }

                echo "<p>Elaborazione scheda: $display_title <br>";
                $rows = $xlsx->rows($sheetIndex);
                
                $startRowIndex = $map[$cleanName]['start_row'];
                $new_count = 0;
                $update_count = 0;
                $functionName = $map[$cleanName]['func'];
                
                for ($i = $startRowIndex; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    if (empty(trim($row[0])) && empty(trim($row[1]))) continue;
                    
                    $result = $functionName($row);
                    
                    if ($result && is_array($result)) {
                        if (isset($result['action']) && $result['action'] === 'new') {
                            $new_count++;
                        } elseif (isset($result['action']) && $result['action'] === 'update') {
                            $update_count++;
                        }

                        if (isset($result['gps_pending']) && $result['gps_pending'] === true) {
                            $locations_missing_gps[] = $result;
                        }
                    }
                }
                
                echo "<span style='color:#00a32a; font-weight:bold;'>$new_count nuovi inseriti</span> | ";
                echo "<span style='color:#d63638; font-weight:bold;'>$update_count aggiornati</span>";
                echo "</p><hr style='margin: 5px 0;'>";
            }
        }
        
        if (!empty($locations_missing_gps)) {
            echo '<div style="background-color: #fff8e5; border-left: 4px solid #ffb900; padding: 10px 15px; margin-top: 15px; max-height: 400px; overflow-y: auto;">';
            echo '<h3 style="margin-top:0; color:#b36b00;">Luoghi con indirizzo non geolocalizzati durante l\'importazione</h3>';
            echo '<p>Clicca sui nomi per aprire la scheda e inserire manualmente la geolocalizzazione.</p>';
            echo '<ol style="margin-left: 20px;">';
            foreach ($locations_missing_gps as $loc) {
                $edit_link = get_edit_post_link($loc['id']);
                echo "<li style='margin-bottom: 5px;'>";
                echo "<a href='{$edit_link}' target='_blank' style='font-weight:bold; text-decoration:none;'>{$loc['title']}</a> ";
                echo "<span class='dashicons dashicons-external' style='font-size:14px; vertical-align:middle; color:#666;'></span>";
                echo "</li>";
            }
            echo '</ol>';
            echo '</div>';
        }

        echo '</div>';

    } else {
        echo '<div class="notice notice-error"><p>' . SimpleXLSX::parseError() . '</p></div>';
    }
}

/**
 * 4. FUNZIONI DI MAPPING
 */

function import_sheet_luoghi($row) {
    $nome = trim($row[0]);
    if(empty($nome)) return false;

    $parts = array_filter([$row[7], $row[8], $row[11], $row[9], $row[10]]); 
    $indirizzo = implode(', ', $parts);
    
    $argomenti = [];
    for($j=12; $j<count($row); $j++) { 
        if(!empty($row[$j]) && stripos($row[$j], 'Note') === false) $argomenti[] = $row[$j]; 
    }

    $tipi_luogo = [];
    if (!empty($row[2]) && strtoupper(trim($row[2])) !== 'NESSUNO') {
        $tipi_luogo[] = $row[2];
    }

    $contacts_conf = array('post_type' => 'punto_contatto');
    if (empty(trim($row[4]))) {
        ESA_Content_Importer::ensure_placeholder_contact();
        $contacts_conf['value'] = 'Contatto mancante';
        $contacts_conf['is_dedicated'] = false; 
    } else {
        $contacts_conf['value'] = $row[4];
        $contacts_conf['is_dedicated'] = true; 
        $contacts_conf['parent_name'] = $nome;
    }

    // 1. IMPORTAZIONE
    $res = ESA_Content_Importer::import_post(array(
        'title' => $nome,
        'post_type' => 'luogo',
        'parent_title' => $row[3],
        'content' => $row[1],
        'meta_input' => array(
            '_dci_luogo_descrizione_breve' => $row[1],
            '_dci_luogo_indirizzo' => $indirizzo,
            '_dci_luogo_cap' => $row[11],
            '_dci_luogo_modalita_accesso' => $row[5],
            '_dci_luogo_orario_apertura' => $row[6],
            // GPS RIMOSSO
        ),
        'taxonomies' => array(
            'tipi_luogo' => $tipi_luogo,
            'argomenti' => $argomenti
        ),
        'relations' => array(
            '_dci_luogo_punti_contatto' => $contacts_conf
        )
    ));

    // 2. PULIZIA AUTOMATICA POST-IMPORTAZIONE
    if ($res && isset($res['id'])) {
        $post_id = $res['id'];
        $gps_val = get_post_meta($post_id, '_dci_luogo_posizione_gps', true);
        $is_valid = (is_array($gps_val) && isset($gps_val['lat']) && isset($gps_val['lng']) && !empty($gps_val['lat']));
        
        if (!$is_valid) {
            delete_post_meta($post_id, '_dci_luogo_posizione_gps');
        }

        // Flag per lista finale
        if (!empty($indirizzo)) {
            $check_gps = get_post_meta($post_id, '_dci_luogo_posizione_gps', true);
            if (empty($check_gps)) {
                $res['gps_pending'] = true;
                $res['title'] = $nome;
            }
        }
    }

    return $res;
}

function import_sheet_uo($row) {
    $nome = trim($row[0]);
    if(empty($nome)) return false;

    $argomenti = [];
    for($j=6; $j<count($row); $j++) { if(!empty($row[$j]) && stripos($row[$j], 'Note') === false) $argomenti[] = $row[$j]; }

    $contacts_conf = array('post_type' => 'punto_contatto');
    if (empty(trim($row[3]))) {
        ESA_Content_Importer::ensure_placeholder_contact();
        $contacts_conf['value'] = 'Contatto mancante';
        $contacts_conf['is_dedicated'] = false;
    } else {
        $contacts_conf['value'] = $row[3];
        $contacts_conf['is_dedicated'] = true;
        $contacts_conf['parent_name'] = $nome;
    }

    return ESA_Content_Importer::import_post(array(
        'title' => $nome,
        'post_type' => 'unita_organizzativa',
        'parent_title' => $row[5], 
        'content' => $row[1],
        'meta_input' => array(
            '_dci_unita_organizzativa_descrizione_breve' => $row[1]
        ),
        'taxonomies' => array(
            'tipi_unita_organizzativa' => $row[2],
            'argomenti' => $argomenti
        ),
        'relations' => array(
            '_dci_unita_organizzativa_sede_principale' => array('value' => $row[4], 'post_type' => 'luogo', 'single' => true),
            '_dci_unita_organizzativa_contatti' => $contacts_conf
        )
    ));
}

function import_sheet_persone($row) {
    $nome_completo = trim($row[0]);
    if(empty($nome_completo)) return false;

    $parts = explode(' ', $nome_completo);
    $cognome = '';
    $nome = $nome_completo; 
    if (count($parts) > 1) {
        $cognome = array_pop($parts);
        $nome = implode(' ', $parts);
    }

    $persona_res = ESA_Content_Importer::import_post(array(
        'title' => $nome_completo,
        'post_type' => 'persona_pubblica',
        'meta_input' => array(
            '_dci_persona_pubblica_nome' => $nome,
            '_dci_persona_pubblica_cognome' => $cognome,
            '_dci_persona_pubblica_nominativo' => $nome_completo 
        )
    ));
    $persona_id = ($persona_res && isset($persona_res['id'])) ? $persona_res['id'] : null;

    $desc_incarico = !empty($row[1]) ? trim($row[1]) : 'Incarico di ' . $nome_completo;
    
    $contacts_conf = array('post_type' => 'punto_contatto');
    if (empty(trim($row[3]))) {
        ESA_Content_Importer::ensure_placeholder_contact();
        $contacts_conf['value'] = 'Contatto mancante';
        $contacts_conf['is_dedicated'] = false;
    } else {
        $contacts_conf['value'] = $row[3];
        $contacts_conf['is_dedicated'] = true;
        $contacts_conf['parent_name'] = $nome_completo;
    }

    return ESA_Content_Importer::import_post(array(
        'title' => $desc_incarico,
        'post_type' => 'incarico',
        'taxonomies' => array(
            'tipi_incarico' => $row[2]
        ),
        'meta_input' => array(
            '_dci_incarico_persona' => $persona_id, 
            '_dci_incarico_responsabile' => (stripos($row[5], 'Si') !== false ? 'true' : 'false')
        ),
        'relations' => array(
            '_dci_incarico_unita_organizzativa' => array('value' => $row[4], 'post_type' => 'unita_organizzativa'),
            '_dci_incarico_punti_contatto' => $contacts_conf
        )
    ));
}

function import_sheet_servizi($row) {
    $titolo = trim($row[0]);
    if(empty($titolo)) return false;

    $argomenti = [];
    for($j=7; $j<count($row); $j++) { if(!empty($row[$j]) && stripos($row[$j], 'Note') === false) $argomenti[] = $row[$j]; }

    $contacts_conf = array('post_type' => 'punto_contatto');
    if (empty(trim($row[6]))) {
        ESA_Content_Importer::ensure_placeholder_contact();
        $contacts_conf['value'] = 'Contatto mancante';
        $contacts_conf['is_dedicated'] = false;
    } else {
        $contacts_conf['value'] = $row[6];
        $contacts_conf['is_dedicated'] = true;
        $contacts_conf['parent_name'] = $titolo;
    }

    return ESA_Content_Importer::import_post(array(
        'title' => $titolo,
        'post_type' => 'servizio',
        'content' => $row[1],
        'meta_input' => array(
            '_dci_servizio_descrizione_breve' => $row[1],
            '_dci_servizio_a_chi_e_rivolto' => $row[4],
            '_dci_servizio_stato' => 'true'
        ),
        'taxonomies' => array(
            'categorie_servizio' => $row[3],
            'argomenti' => $argomenti
        ),
        'relations' => array(
            '_dci_servizio_unita_responsabile' => array('value' => $row[5], 'post_type' => 'unita_organizzativa', 'single' => true),
            '_dci_servizio_punti_contatto' => $contacts_conf,
            '_dci_servizio_servizi_inclusi' => array('value' => $row[2], 'post_type' => 'servizio')
        )
    ));
}

/**
 * 5. CLASSE HELPER
 */
if (!class_exists('ESA_Content_Importer')) {
    class ESA_Content_Importer {

        public static function get_id_by_title($title, $post_type) {
            global $wpdb;
            $title = trim($title);
            if(empty($title)) return null;

            $query = $wpdb->prepare(
                "SELECT ID, post_status FROM $wpdb->posts WHERE post_title = %s AND post_type = %s LIMIT 1",
                $title, $post_type
            );
            
            $res = $wpdb->get_row($query);

            if ($res) {
                if ($res->post_status === 'trash') {
                    return null; 
                }
                return $res->ID;
            }
            return null;
        }

        public static function ensure_placeholder_contact() {
            $title = 'Contatto mancante';
            $id = self::get_id_by_title($title, 'punto_contatto');
            if (!$id) {
                $res = self::import_post(array(
                    'title' => $title,
                    'post_type' => 'punto_contatto',
                    'content' => 'Contatto generico assegnato automaticamente quando non specificato.'
                ));
                $id = ($res && isset($res['id'])) ? $res['id'] : null;
            }
            return $id;
        }

        public static function create_dedicated_contact($contact_string, $parent_name) {
            $contact_string = trim($contact_string);
            if (empty($contact_string)) return null;
            
            $raw_values = preg_split('/[,\n\r]+/', $contact_string);
            $raw_values = array_filter(array_map('trim', $raw_values)); 
            
            if (empty($raw_values)) return null;

            $group_title = "Contatti " . $parent_name;
            
            $contact_id = self::get_id_by_title($group_title, 'punto_contatto');
            
            if (!$contact_id) {
                global $wpdb;
                $trash_id = $wpdb->get_var($wpdb->prepare(
                    "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = 'punto_contatto' AND post_status = 'trash' LIMIT 1",
                    $group_title
                ));

                if ($trash_id) {
                    wp_publish_post($trash_id);
                    $contact_id = $trash_id;
                } else {
                    $res = self::import_post(array(
                        'title' => $group_title,
                        'post_type' => 'punto_contatto'
                    ));
                    $contact_id = ($res && isset($res['id'])) ? $res['id'] : null;
                }
            }

            if (!$contact_id) return null;

            $repeater_values = [];
            $taxonomies_to_set = [];

            foreach ($raw_values as $val) {
                $type = (strpos($val, '@') !== false) ? 'email' : 'telefono';
                $taxonomies_to_set[] = ucfirst($type);

                $repeater_values[] = array(
                    '_dci_punto_contatto_tipo_punto_contatto' => $type,
                    '_dci_punto_contatto_valore' => $val
                );
            }

            update_post_meta($contact_id, '_dci_punto_contatto_voci', $repeater_values);
            if (!empty($taxonomies_to_set)) {
                wp_set_object_terms($contact_id, array_unique($taxonomies_to_set), 'tipi_punto_contatto');
            }

            return $contact_id;
        }

        public static function import_post($args) {
            $post_title = trim($args['title']);
            if(empty($post_title)) return false;

            $post_type = $args['post_type'];
            
            global $wpdb;
            $existing = $wpdb->get_row($wpdb->prepare(
                "SELECT ID, post_status FROM $wpdb->posts WHERE post_title = %s AND post_type = %s LIMIT 1",
                $post_title, $post_type
            ));
            
            $post_data = array(
                'post_title'    => $post_title,
                'post_content'  => isset($args['content']) ? $args['content'] : '',
                'post_status'   => 'publish',
                'post_type'     => $post_type,
                'post_author'   => get_current_user_id(),
            );

            $action_taken = '';

            if ($existing) {
                if ($existing->post_status === 'trash') {
                    $post_data['ID'] = $existing->ID;
                    wp_update_post($post_data);
                    $action_taken = 'new';
                } else {
                    $post_data['ID'] = $existing->ID;
                    wp_update_post($post_data);
                    $action_taken = 'update';
                }
            } else {
                $post_id = wp_insert_post($post_data);
                $action_taken = 'new';
            }

            $post_id = ($existing) ? $existing->ID : $post_id;

            if (is_wp_error($post_id)) return false;

            if (isset($args['meta_input'])) {
                foreach ($args['meta_input'] as $key => $value) {
                    if(!empty($value)) update_post_meta($post_id, $key, $value);
                }
            }

            if (isset($args['taxonomies'])) {
                foreach ($args['taxonomies'] as $tax => $terms) {
                    if (taxonomy_exists($tax) && !empty($terms)) {
                        if(!is_array($terms)) $terms = array_map('trim', explode(',', $terms));
                        wp_set_object_terms($post_id, $terms, $tax);
                    }
                }
            }

            if (isset($args['relations'])) {
                foreach ($args['relations'] as $meta_key => $conf) {
                    $ids = array();
                    
                    if ($conf['post_type'] === 'punto_contatto') {
                        if (empty($conf['value'])) {
                            $dummy_id = self::ensure_placeholder_contact();
                            if ($dummy_id) $ids[] = $dummy_id;
                        } 
                        elseif (isset($conf['is_dedicated']) && $conf['is_dedicated'] === true) {
                            $cid = self::create_dedicated_contact($conf['value'], $conf['parent_name']);
                            if ($cid) $ids[] = $cid;
                        }
                        else {
                            $found = self::get_id_by_title($conf['value'], 'punto_contatto');
                            if ($found) $ids[] = $found;
                        }
                    } 
                    else {
                        if (!empty($conf['value'])) {
                            $raw_values = preg_split('/[,\n\r]+/', $conf['value']);
                            foreach($raw_values as $t) {
                                $t = trim($t);
                                if(empty($t)) continue;
                                $found = self::get_id_by_title($t, $conf['post_type']);
                                if ($found) $ids[] = $found;
                            }
                        }
                    }

                    if (!empty($ids)) {
                        $val = (isset($conf['single']) && $conf['single']) ? $ids[0] : $ids;
                        update_post_meta($post_id, $meta_key, $val);
                    }
                }
            }
            
            if(isset($args['parent_title']) && !empty($args['parent_title'])) {
                $parent_id = self::get_id_by_title($args['parent_title'], $post_type);
                if($parent_id) wp_update_post(array('ID' => $post_id, 'post_parent' => $parent_id));
            }

            return array('id' => $post_id, 'action' => $action_taken);
        }
    }
}

/**
 * ============================================================
 * UTILITY: COLONNA STATO GPS NELLA LISTA LUOGHI
 * ============================================================
 */
add_filter('manage_luogo_posts_columns', 'dci_add_gps_column');
function dci_add_gps_column($columns) {
    if (!get_option('dci_show_gps_column')) {
        return $columns;
    }
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['gps_status'] = '<span class="dashicons dashicons-location"></span> GPS';
        }
    }
    return $new_columns;
}

add_action('manage_luogo_posts_custom_column', 'dci_show_gps_status', 10, 2);
function dci_show_gps_status($column, $post_id) {
    if ($column === 'gps_status') {
        $gps_data = get_post_meta($post_id, '_dci_luogo_posizione_gps', true);
        
        $has_gps = false;
        if (is_array($gps_data) && !empty($gps_data['lat']) && !empty($gps_data['lng'])) {
            $has_gps = true;
        }

        if ($has_gps) {
            echo '<span style="color:#46b450;" class="dashicons dashicons-yes" title="Coordinate OK"></span>';
        } else {
            echo '<span style="color:#dc3232;" class="dashicons dashicons-no-alt" title="Coordinate mancanti"></span>';
        }
    }
}

/**
 * ============================================================
 * FILTRO CMB2 PER EVITARE IL CARICAMENTO INFINITO DELLA MAPPA
 * Se il dato GPS nel DB non è valido, lo nasconde al widget.
 * ============================================================
 */
add_filter('cmb2_override_meta_value', 'dci_sanitize_gps_on_load', 10, 4);
function dci_sanitize_gps_on_load($value, $object_id, $args, $field) {
    if ($field->id() === '_dci_luogo_posizione_gps') {
        $raw_value = get_post_meta($object_id, '_dci_luogo_posizione_gps', true);
        
        if (!empty($raw_value) && (!is_array($raw_value) || empty($raw_value['lat']))) {
            return '';
        }
    }
    return $value;
}
?>