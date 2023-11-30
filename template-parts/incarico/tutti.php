<?php
global $the_query, $load_posts, $load_card_type, $tax_query, $additional_filter;


$query = $_GET['search'] ?? null;


switch ($post->post_name){
	case 'politici': $tipo_incarico = 'politico'; $descrizione = 'del personale'; $max_posts = $_GET['max_posts'] ?? null;  $load_posts = 10; break;
	case 'personale-amministrativo': $tipo_incarico = 'amministrativo'; $descrizione = 'del personale'; $max_posts = $_GET['max_posts'] ?? null;  $load_posts = 10; break;
	case 'personale-sanitario': $tipo_incarico = 'sanitario'; $descrizione = 'del personale'; $max_posts = $_GET['max_posts'] ?? null;  $load_posts = 10; break;
	case 'altro': $tipo_incarico = 'altro'; $descrizione = 'del personale'; $max_posts = $_GET['max_posts'] ?? null;  $load_posts = 10; break;
}

$query = isset($_GET['search']) ? $_GET['search'] : null;


$tax_query = array(
	array (
		'taxonomy' => 'tipi_incarico',
		'field' => 'slug',
		'terms' => $tipo_incarico
	));


$args = array(
	's'         => $query,
	'posts_per_page'    => -1,
	'post_type' => 'incarico',
	'post_status' => 'publish',
	'orderby'        => 'post_title',
	'order'          => 'ASC',
	'tax_query' => $tax_query
);

$the_query = new WP_Query( $args );
$incarichi = $the_query->posts;

$incarichi_deduplicati = [];
foreach($incarichi as $incarico){
    $incarichi_deduplicati[dci_get_meta('persona', '_dci_incarico_', $incarico->ID)] = $incarico;
}

$additional_filter = $tax_query;
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
				    foreach ($incarichi_deduplicati as $post) {
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