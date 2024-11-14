<?php
global $the_query, $load_posts, $load_card_type, $additional_filter;

$load_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 10;

$query = isset($_GET['search']) ? $_GET['search'] : null;

$tax_query = array();

$tax = array (
    'taxonomy' => 'tipi_punto_contatto',
    'field' => 'slug',
    //'terms' => 'ufficio',
    'operator' => 'NOT IN',
);
array_push($tax_query, $tax);


$descrizione = 'tutti i contatti';

$args = array(
	's'         => $query,
    'posts_per_page' => $load_posts,
	'post_type' => 'punto_contatto',
	'tax_query' => $tax_query,
    'orderby'        => 'post_title',
	'order'          => 'ASC'
);

$the_query = new WP_Query( $args );
$posts = $the_query->posts;

$additional_filter = $tax_query;

?>

<div class="py-3">
    <form role="search" id="search-form" method="get" class="search-form">
        <button type="submit" class="d-none"></button>
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
				foreach ($posts as $post) {
					$load_card_type = 'contatto';
					get_template_part( 'template-parts/punto-contatto/lista-contatti');
				}
                ?>
            </div>
            <?php
			get_template_part("template-parts/search/more-results");
            ?>

        </div>
    </form>
</div>