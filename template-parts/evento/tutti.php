<?php
global $the_query, $load_posts, $load_card_type, $additional_filter, $order_values, $found_posts, $post_type_multiple;

$max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 10;
$query = isset($_GET['search']) ? $_GET['search'] : null;

$order_values = dci_get_order_values("post_title", "ASC", $_GET["order_by"]);

$args = array(
	's'         => $query,
    'posts_per_page' => $max_posts,
	'post_type'      => ['evento'],
	'meta_key'       => '_dci_evento_data_orario_inizio',
    'order'          => $order_values["dir"],
    'orderby'        => $order_values["field"]

);

$the_query = new WP_Query( $args );
$additional_filter = null;

?>
<?php get_template_part("template-parts/home/calendario") ?>

<div class="bg-grey-card py-3">
    <form role="search" id="search-form" method="get" class="search-form" action="#search-form">
        <div class="container">
            <h2 class="title-xxlarge mb-4 mt-5 mb-lg-10">
                Esplora tutti gli eventi
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
                    $post_type_multiple = "Eventi trovati";

                    get_template_part("template-parts/common/data-list-info-and-ordering");
                ?>

            </div>
            <div class="row g-2" id="load-more">
            <?php 
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) :
			        $the_query->the_post();
                    $post = get_post();

                    $load_card_type = "evento";  
                    get_template_part("template-parts/evento/card-full");
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