<?php
global $the_query, $load_posts, $load_card_type, $tax_query;

$post_id = get_the_ID();
$incarico = get_the_terms($post_id, 'tipi_incarico');

$tipologia_incarico = $incarico[0]->slug;

$opzione_visualizzazione = dci_get_meta('filtro_tipo_incarico_select', '_dci_page_');

if($opzione_visualizzazione == null){
    switch ($post->post_name){
	    case 'politici': $tipo_incarico = 'politico'; $descrizione = 'degli incarichi'; $load_posts = 9; break;
	    case 'personale-amministrativo': $tipo_incarico = 'amministrativo'; $descrizione = 'degli incarichi'; $load_posts = 9; break;
	    case 'personale-sanitario': $tipo_incarico = 'sanitario'; $descrizione = 'degli incarichi'; $load_posts = 9; break;
	    case 'personale-socio-assistenziale': $tipo_incarico = 'socio-assistenziale'; $descrizione = 'degli incarichi'; $load_posts = 9; break;
	    case 'altro': $tipo_incarico = 'altro'; $descrizione = 'degli incarichi'; $load_posts = 9; break;
        default:
        $tipo_incarico = ''; $descrizione = 'di tutti gli incarichi'; $load_posts = 9; break;
    }
}

$query = isset($_GET['search']) ? $_GET['search'] : null;

$args = array(
	's'         => $query,
	'posts_per_page'    => $load_posts,
	'post_type' => 'incarico',
	'post_status' => 'publish',
	'orderby'        => 'post_title',
	'order'          => 'ASC',
);

if($opzione_visualizzazione == 'scegli'){
    $tax_query = array(
        array (
            'taxonomy' => 'tipi_incarico',
            'field' => 'slug',
            'terms' => $tipologia_incarico
        ));
    $args['tax_query'] = $tax_query;
    
    $descrizione = 'degli incarichi';
}else if ($opzione_visualizzazione == 'tutti') {
	$descrizione = 'degli incarichi';
}


if($opzione_visualizzazione == null && $tipo_incarico!="") {
    $tax_query = array(
        array (
            'taxonomy' => 'tipi_incarico',
            'field' => 'slug',
            'terms' => $tipo_incarico
        ));
    
    $args['tax_query'] = $tax_query;
} 

$the_query = new WP_Query( $args );
$incarichi = $the_query->posts;
?>

<div class="bg-grey-card py-3">
    <form role="search" id="search-form" method="get" class="search-form">
        <div class="container">
            <h2 class="title-xxlarge mb-4 mt-5 mb-lg-10">
                Elenco <?= $descrizione ?>
            </h2>
            <div class="cmp-input-search">
                <div class="form-group autocomplete-wrapper mb-2 mb-lg-4">
                    <div class="input-group">
                        <label for="autocomplete-two" class="visually-hidden">Cerca una parola chiave</label>
                        <input
                                type="search"
                                class="autocomplete form-control"
                                placeholder="Cerca una parola chiave"
                                id="autocomplete-two"
                                name="search"
                                value="<?php echo $query; ?>"
                                data-bs-autocomplete="[]"
                        />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="button-3">
                                Invio
                            </button>
                        </div>
                        <span class="autocomplete-icon" aria-hidden="true">
                            <svg class="icon icon-sm icon-primary" role="img" aria-labelledby="autocomplete-label">
                            <use href="#it-search"></use></svg>
                        </span>
                    </div>
                </div>
                <p id="autocomplete-label" class="mb-4">
                    <strong><?php echo $the_query->found_posts; ?></strong> risultati in ordine alfabetico
                </p>
            </div>
            <div  class="row g-2" id="load-more">
                <?php
				    foreach ($incarichi as $post) {
                        get_template_part( 'template-parts/incarico/cards-list' );
				    }
				?>
            </div>
			<?php
				$load_card_type = 'incarico';
				get_template_part("template-parts/search/more-results");
			?>       
        </div>
    </form>
</div>