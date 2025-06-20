<?php
/**
 * Archivio Tassonomia Tipi Documento
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#custom-taxonomies
 * @link https://italia.github.io/design-comuni-pagine-statiche/sito/tipi_documento.html
 *
 * @package Design_Comuni_Italia
 */

global $the_query, $load_posts, $load_card_type, $documento, $tax_query, $title, $description, $data_element, $hide_categories;

$obj = get_queried_object();
$max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 3;
$load_posts = 3;
$query = isset($_GET['search']) ? dci_removeslashes($_GET['search']) : null;

$prefix_term = "dci_term_tipi_documento_";
$default_field = dci_get_term_meta('campo_ordinamento', $prefix_term, $obj->term_id);
$default_dir = dci_get_term_meta('direzione_ordinamento', $prefix_term, $obj->term_id);

$order_values = dci_get_order_values($default_field, $default_dir, $_GET["order_by"]);

$args = array(
    's' => $query,
    'posts_per_page' => $max_posts,
    'post_type'      => 'documento_pubblico',
    'tipi_documento' => $obj->slug,
    'order'=> $order_values["dir"],
    'orderby' => $order_values["field"]
);


$the_query = new WP_Query( $args );
$documenti = $the_query->posts;

$tax_query = array(
	array (
		'taxonomy' => 'tipi_documento',
		'field' => 'slug',
		'terms' => $obj->slug
	));

get_header();
?>
 <main>
    <?php 
      $title = $obj->name;
      $description = $obj->description;
      $data_element = 'data-element="page-name"';
      get_template_part("template-parts/hero/hero"); 
    ?>
  
    <div class="bg-grey-card">
      <form role="search" id="search-form" method="get" class="search-form">
          <div class="container">
            <div class="row ">
              <h2 class="visually-hidden">Esplora tutti i documenti</h2>
              <div class="col-12 pt-30 pt-lg-50 pb-lg-50">
                <div class="cmp-input-search">
                  <div class="form-group autocomplete-wrapper mb-2 mb-lg-4">
                  <div class="input-group">
                  <label for="autocomplete-two" class="visually-hidden">Cerca una parola chiave</label>
                  <input type="search" 
                    class="autocomplete form-control" 
                    placeholder="Cerca una parola chiave"
                    id="autocomplete-two"
                    name="search"
                    value="<?php echo $query; ?>"
                    data-bs-autocomplete="[]">
                  <div class="input-group-append">
                      <button class="btn btn-primary" type="submit" id="button-3">
                          Invio
                      </button>
                  </div>
                  <span class="autocomplete-icon" aria-hidden="true">
                    <svg class="icon icon-sm icon-primary" role="img" aria-labelledby="autocomplete-label"><use href="#it-search"></use></svg>
                  </span>
                  </div>

                  <?php 
        $found_posts = $the_query->found_posts;
        $post_type_multiple = "documenti";

        get_template_part("template-parts/common/data-list-info-and-ordering");
      ?>

                  </div>
                </div>
                <div class="row g-4" id="load-more">
                    <?php foreach ($documenti as $post) { 
                        $load_card_type = "documento";
                        $hide_categories = true;
                        $full_width = true;
                        get_template_part("template-parts/documento/cards-list");    
                    } ?>
                </div>
                <?php get_template_part("template-parts/search/more-results"); ?>
              </div>
            </div>
          </div>
      </form>
    </div>
    
    <?php echo get_template_part( 'template-parts/common/valuta-servizio'); ?>
    <?php 
        $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
        if($visualizza_contatto == 'visible')
            get_template_part("template-parts/common/assistenza-contatti"); 
    ?>
  </main>
<?php
get_footer();
