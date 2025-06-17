<?php

global $the_query, $load_posts, $load_card_type, $additional_filter, $tax_query;

$post_id = get_the_ID();
$organizzazione = get_the_terms($post_id, 'tipi_unita_organizzativa');

$tipo_organizzazione = [];

if($organizzazione && is_array($organizzazione) && count($organizzazione) > 0)
foreach ($organizzazione as $tipo) {
	array_push($tipo_organizzazione, $tipo->slug);
}

$opzione_visualizzazione = dci_get_meta('uo_select', '_dci_page_');

$load_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 10;

$query = isset($_GET['search']) ? $_GET['search'] : null;

$tax_query = array();

if($opzione_visualizzazione == null){
    switch ($post->post_name){
	    case 'aree-gestionali':

            $tax = array (
                'taxonomy' => 'tipi_unita_organizzativa',
                'field' => 'slug',
                'terms' => 'ufficio',
                'operator' => 'NOT IN',
            );
            array_push($tax_query, $tax);

            $tax = array (
		        'taxonomy' => 'tipi_unita_organizzativa',
		        'field' => 'slug',
		        'terms' => 'struttura-amministrativa',
	        );
            array_push($tax_query, $tax);

            $descrizione = 'tutte le aree gestionali';
            break;

	    case 'uffici':

            $tax = array (
		        'taxonomy' => 'tipi_unita_organizzativa',
		        'field' => 'slug',
		        'terms' => 'ufficio',
	        );
            array_push($tax_query, $tax);

            $descrizione = 'tutti gli uffici';
            break;

        case 'organi-di-governo-e-controllo':
            $tax = array (
                'taxonomy' => 'tipi_unita_organizzativa',
                'field' => 'slug',
                'terms' => ' struttura-di-governo-e-controllo',
            );
            array_push($tax_query, $tax);
            $descrizione = 'tutti gli organi di governo e controllo';
            break;
    }
}

if($opzione_visualizzazione == 'scegli'){
    $tax = array (
        'taxonomy' => 'tipi_unita_organizzativa',
        'field' => 'slug',
        'terms' => $tipo_organizzazione,
    );
    array_push($tax_query, $tax);
    $descrizione = 'le unit&agrave; organizzative';
}else if($opzione_visualizzazione == 'tutti'){
    $descrizione = 'le unit&agrave; organizzative';
}



$args = array(
	's'         => $query,
    'posts_per_page' => $load_posts,
	'post_type' => 'unita_organizzativa',
	'tax_query' => $tax_query,
    'orderby'        => 'post_title',
	'order'          => 'ASC'
);

$the_query = new WP_Query( $args );
?>

<div class="bg-grey-card py-3">
    <form role="search" id="search-form" method="get" class="search-form" action="#search-form">
        <div class="container">
            <h2 class="title-xxlarge mb-4 mt-5 mb-lg-10">
                Esplora <?= $descrizione ?>
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
                            data-bs-autocomplete="[]" />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="button-3">
                                Invio
                            </button>
                        </div>
                        <span class="autocomplete-icon" aria-hidden="true">
                            <svg class="icon icon-sm icon-primary" role="img" aria-labelledby="autocomplete-label">
                                <use href="#it-search"></use>
                            </svg>
                        </span>
                    </div>
                </div>
                <p id="autocomplete-label" class="mb-4">
                    <strong>
                        <?php echo $the_query->found_posts; ?>
                    </strong>risultati in ordine alfabetico
                </p>
            </div>
            <div class="row g-2" id="load-more">

                <?php 

                
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) :
			            $the_query->the_post();
                        $post = get_post();
                        /*echo "<pre>";
                        //print_r($post);
                        echo "<pre>";*/
                        $load_card_type = "unita-organizzativa";  
                        get_template_part("template-parts/unita-organizzativa/cards-list");
		            endwhile;
                endif; 

                wp_reset_postdata();
                ?>

            </div>
            <?php
			get_template_part("template-parts/search/more-results");
            ?>

        </div>
    </form>
</div>