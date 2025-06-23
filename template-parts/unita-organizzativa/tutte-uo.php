<?php

global $the_query, $load_posts, $load_card_type, $additional_filter, $tax_query, $order_values, $found_posts, $post_type_multiple;

$post_id = get_the_ID();
$organizzazione = get_the_terms($post_id, 'tipi_unita_organizzativa');

$tipo_organizzazione = [];

$order_values = dci_get_order_values("post_title", "ASC", $_GET["order_by"]);

if($organizzazione && is_array($organizzazione) && count($organizzazione) > 0)
foreach ($organizzazione as $tipo) {
	array_push($tipo_organizzazione, $tipo->slug);
}

$opzione_visualizzazione = dci_get_meta('uo_select', '_dci_page_');

$max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 10;

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
    $descrizione = 'unit&agrave; organizzative';
}else if($opzione_visualizzazione == 'tutti'){
    $descrizione = 'unit&agrave; organizzative';
}



$args = array(
	's'         => $query,
    'posts_per_page' => $max_posts,
	'post_type' => ['unita_organizzativa'],
	'tax_query' => $tax_query,
    'orderby'        => $order_values["field"],
	'order'          => $order_values["dir"]
);

$the_query = new WP_Query( $args );
?>

<div class="bg-grey-card py-3">
    <form role="search" id="search-form" method="get" class="search-form" action="#search-form">
        <div class="container">
            <h2 class="title-xxlarge mb-4 mt-5 mb-lg-10">
                Esplora le <?= $descrizione ?>
            </h2>
            <div class="cmp-input-search">
                <div class="form-group autocomplete-wrapper mb-0">
                    <div class="input-group">
                        <label for="autocomplete-two" class="visually-hidden">Cerca una parola chiave</label>
                        <input
                            type="search"
                            class="autocomplete form-control"
                            placeholder="Cerca una parola chiave"
                            id="autocomplete-two"
                            name="search"
                            value="<?php echo esc_attr($query); ?>"
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
                <?php 
                    $found_posts = $the_query->found_posts;
                    $post_type_multiple = $descrizione;

                    get_template_part("template-parts/common/data-list-info-and-ordering");
                ?>
            </div>
            <div class="row g-2" id="load-more">

                <?php 

                
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) :
			            $the_query->the_post();
                        $post = get_post();
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