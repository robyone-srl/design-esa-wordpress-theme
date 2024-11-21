<?php
global $the_query, $load_posts, $load_card_type, $tax_query, $additional_filter, $filter_ids;

$post_id = get_the_ID();
$incarico = get_the_terms($post_id, 'tipi_incarico');

$tipologia_incarico = $incarico[0]->slug;
//var_dump($tipo_incarico);

$opzione_visualizzazione = dci_get_meta('pi_select', '_dci_page_');

$query = $_GET['search'] ?? null;

if($opzione_visualizzazione == null){
    switch ($post->post_name){
	    case 'politici': $tipo_incarico = 'politico'; $descrizione = 'del personale'; break;
	    case 'personale-amministrativo': $tipo_incarico = 'amministrativo'; $descrizione = 'del personale'; break;
	    case 'personale-sanitario': $tipo_incarico = 'sanitario'; $descrizione = 'del personale'; break;
	    case 'personale-socio-assistenziale': $tipo_incarico = 'socio-assistenziale'; $descrizione = 'del personale'; break;
	    case 'altro': $tipo_incarico = 'altro'; $descrizione = 'del personale'; break;
    }
}

if($opzione_visualizzazione == 'scegli'){
    $tax_query = array(
	    array (
		    'taxonomy' => 'tipi_incarico',
		    'field' => 'slug',
		    'terms' => $tipologia_incarico
	    )
    );
    $descrizione = 'gli incarichi';
} else if ($opzione_visualizzazione == 'tutti'){
    $descrizione = 'gli incarichi';
}

if($opzione_visualizzazione == null){
    $tax_query = array(
	array (
		'taxonomy' => 'tipi_incarico',
		'field' => 'slug',
		'terms' => $tipo_incarico
	));
}

$args_incarichi = array(
	'post_type' => 'incarico',
	'tax_query' => $tax_query,
    'posts_per_page' => -1
);

$incarichi = get_posts($args_incarichi);
$persone_ids = array();

foreach($incarichi as $incarico) {
	$persone = get_post_meta($incarico->ID, '_dci_incarico_persona');
	foreach($persone as $persona) {
		$persone_ids[] = $persona;
	}
}

$filter_ids = array_unique($persone_ids);

$search_value = isset($_GET['search']) ? $_GET['search'] : null;
$args = array(
	's'         => $search_value,
	'posts_per_page'    => -1,
	'post_type' => 'persona_pubblica',
	'post_status' => 'publish',
	'orderby'        => 'post_title',
	'order'          => 'ASC',
    'post__in' => empty($persone_ids) ? [0] : $filter_ids,
);

$the_query = new WP_Query( $args );
$persone = $the_query->posts;
?>

<div class="bg-grey-card py-3">
    <form role="search" id="search-form" method="get" class="search-form">
        <button type="submit" class="d-none"></button>
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
                    <strong><?php echo $the_query->found_posts; ?> </strong>risultati in ordine alfabetico
                </p>
            </div>
            <div  class="row g-2" id="load-more">
                <?php
				    foreach ($persone as $post) {
                        get_template_part( 'template-parts/persona_pubblica/cards-list' );
				    }
				?>
            </div>
			<?php
				$load_card_type = 'persona_pubblica';
				get_template_part("template-parts/search/more-results");
			?>       
        </div>
    </form>
</div>