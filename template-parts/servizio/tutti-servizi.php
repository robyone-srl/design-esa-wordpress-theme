<?php
global $posts, $the_query, $load_posts, $servizio, $load_card_type, $should_have_grey_background;

$max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 4;
$load_posts = 4;
$query = isset($_GET['search']) ? dci_removeslashes($_GET['search']) : null;
$args = array(
    's' => $query,
    'posts_per_page' => $max_posts,
    'post_type'      => 'servizio',
    'orderby'        => 'post_title',
    'order'          => 'ASC'
);
$the_query = new WP_Query($args);

$posts = $the_query->posts;

// Per selezionare i contenuti in evidenza tramite flag
// $post_types = dci_get_post_types_grouped('servizi');
// $servizi_evidenza = dci_get_highlighted_posts( $post_types, 10);

//Per selezionare i contenuti in evidenza tramite configurazione
$servizi_evidenza = dci_get_option('servizi_evidenziati', 'servizi');
?>
<div id="tutti-servizi" class="<?= !($should_have_grey_background=(!$should_have_grey_background)) ? 'bg-grey-dsk':'' ?>">
    <form role="search" id="search-form" method="get" class="search-form">
        <button type="submit" class="d-none"></button>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="title-xxlarge mb-4 mt-5 mb-lg-10">
                        Esplora tutti i servizi
                    </h2>
                </div>
                <div class="pt-lg-50 pb-lg-50">
                    <div class="cmp-input-search">
                        <div class="form-group autocomplete-wrapper mb-2 mb-lg-4">
                            <div class="input-group">
                                <label for="autocomplete-two" class="visually-hidden">Cerca una parola chiave</label>
                                <input type="search" class="autocomplete form-control" placeholder="Cerca una parola chiave" id="autocomplete-two" name="search" value="<?php echo $query; ?>" data-bs-autocomplete="[]" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" id="button-3">
                                        Invio
                                    </button>
                                </div>
                                <span class="autocomplete-icon" aria-hidden="true"><svg class="icon icon-sm icon-primary" role="img" aria-labelledby="autocomplete-label">
                                        <use href="#it-search"></use>
                                    </svg></span>
                            </div>
                        </div>
                        <p id="autocomplete-label" class="mb-4">
                            <strong><?php echo $the_query->found_posts; ?> </strong>servizi trovati in ordine alfabetico
                        </p>
                    </div>
                    <div class="row g-4" id="load-more">
                        <?php foreach ($posts as $servizio) {
                            $load_card_type = "servizio";
                            ?>
                            <div class="col-12 col-lg-6">
                            <?php
                            get_template_part("template-parts/servizio/card");
                            ?>
                            </div>
                            <?php
                        } ?>
                    </div>
                    <?php get_template_part("template-parts/search/more-results"); ?>
                </div>
            </div>
        </div>
    </form>
</div>
<?php wp_reset_query(); ?>