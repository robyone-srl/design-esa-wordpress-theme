<?php
global $the_query, $load_posts, $load_card_type;

$max_posts = isset($_GET["max_posts"]) ? $_GET["max_posts"] : 6;
$query = isset($_GET["search"]) ? dci_removeslashes($_GET["search"]) : null;

$order_option = isset($_GET["order_by"])
    ? sanitize_text_field($_GET["order_by"])
    : "alphabetical_asc";

$args = [
    "s" => $query,
    "posts_per_page" => $max_posts,
    "post_type" => ["documento_pubblico", "dataset"],
];

if ($order_option === "data-pubb") {
    $args["orderby"] = "date";
    $args["order"] = "DESC";
} else if ($order_option === "data-pubb-asc") {
    $args["orderby"] = "date";
    $args["order"] = "ASC";
} else if ($order_option === "alphabetical_desc") {
    $args["orderby"] = "post_title";
    $args["order"] = "DESC";
} else { 
    $args["orderby"] = "post_title";
    $args["order"] = "ASC";
}

$the_query = new WP_Query($args);
?>

<div class="bg-grey-card py-5">
  <form role="search" id="search-form" method="get" class="search-form" action="#search-form">
    <div class="container">
      <h2 class="title-xxlarge mb-4">
        Esplora tutti i documenti
      </h2>
      <div>
        <div class="cmp-input-search">
          <div class="form-group autocomplete-wrapper mb-0">
            <div class="input-group">
              <label for="autocomplete-two" class="visually-hidden">Cerca</label>
              <input type="search" class="autocomplete form-control" placeholder="Cerca per parola chiave"
                id="autocomplete-two" name="search" value="<?php echo esc_attr($query); ?>" data-bs-autocomplete="[]" />
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit" id="button-3">
                  Invio
                </button>
              </div>
              <span class="autocomplete-icon" aria-hidden="true"><svg class="icon icon-sm icon-primary" role="img"
                  aria-labelledby="autocomplete-label">
                  <use href="#it-search"></use>
                </svg></span>
            </div>
            
            <input type="hidden" name="order_by" id="hidden-order-by" value="<?php echo esc_attr($order_option); ?>">

            <div class="d-flex align-items-center justify-content-between" data-current-order="<?php echo esc_attr($order_option); ?>">
                <p id="autocomplete-label" class="u-grey-light text-paragraph-card mt-4 mb-4 mt-lg-30 mb-lg-30 mb-0 mt-0 pe-2">
                    <span class="badge rounded-pill bg-primary"> <?= $the_query->found_posts ?> </span> documenti trovati in <strong id="current-order-text">
                    <?php
                        if ($order_option === "data-pubb") {
                            echo "ordine di pubblicazione decrescente";
                        } else if ($order_option === "data-pubb-asc") {
                            echo "ordine di pubblicazione crescente";
                        } else if ($order_option === "alphabetical_desc") {
                            echo "ordine alfabetico inverso (Z-A)";
                        } else { 
                            echo "ordine alfabetico (A-Z)";
                        }
                    ?>
                    </strong>
                </p>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#OrderModal">
                        <span class="visually-hidden">Apri opzioni di ordinamento</span>
                        <use xlink:href="#it-more-actions"></use>
                        <svg class="icon icon-sm icon-white align-top">
                            <use xlink:href="#it-more-actions"></use>
                        </svg>
                    </button>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="OrderModal" tabindex="-1" aria-labelledby="OrderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="OrderModalLabel">Seleziona un'opzione di ordinamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="filterOption" id="opt-alphabetical_asc" value="alphabetical_asc" <?= $order_option === "alphabetical_asc" ? "checked" : "" ?>>
                            <label class="form-check-label" for="opt-alphabetical_asc">Ordine alfabetico (A-Z)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="filterOption" id="opt-alphabetical_desc" value="alphabetical_desc" <?= $order_option === "alphabetical_desc" ? "checked" : "" ?>>
                            <label class="form-check-label" for="opt-alphabetical_desc">Ordine alfabetico inverso (Z-A)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="filterOption" id="opt-data-pubb-asc" value="data-pubb-asc" <?= $order_option === "data-pubb-asc" ? "checked" : "" ?> >
                            <label class="form-check-label" for="opt-data-pubb-asc">Ordine di pubblicazione crescente</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="filterOption" id="opt-data-pubb" value="data-pubb" <?= $order_option === "data-pubb" ? "checked" : "" ?> >
                            <label class="form-check-label" for="opt-data-pubb">Ordine di pubblicazione decrescente</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Chiudi</button>
                        <button type="button" class="btn btn-primary" id="save-selection" disabled>Salva</button>
                    </div>
                </div>
            </div>
        </div>
      <div class="row g-4" id="load-more">

        <?php
        if ($the_query->have_posts()):
            while ($the_query->have_posts()):
                $the_query->the_post();
                $post = get_post();

                $load_card_type = "documento";
                get_template_part("template-parts/documento/cards-list");
            endwhile;
        endif;

        wp_reset_postdata();
        ?>
      </div>
      <?php get_template_part("template-parts/search/more-results"); ?>
    </div>
  </form>
</div>
<?php wp_reset_query(); ?>