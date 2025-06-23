<?php
global $the_query, $load_posts, $load_card_type, $order_values, $found_posts, $post_type_multiple;

    $max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 6;
    $query = isset($_GET['search']) ? dci_removeslashes($_GET['search']) : null;

    $order_values = dci_get_order_values("post_title", "ASC", $_GET["order_by"]);

    $args = [
        's' => $query,
        'posts_per_page' => $max_posts,
        'post_type'      => ['luogo'],
		'post_status'    => 'publish',
        'order'          => $order_values["dir"],
        'orderby'        => $order_values["field"]
    ];
    $the_query = new WP_Query( $args );

?>


<div class="bg-grey-card py-5">
    <form role="search" id="search-form" method="get" class="search-form" action="#search-form">
        <div class="container">
            <h2 class="title-xxlarge mb-4">
                Esplora tutti i luoghi
            </h2>
            <div>
                <div class="cmp-input-search">
                    <div class="form-group autocomplete-wrapper mb-0">
                        <div class="input-group">
                            <label for="autocomplete-two" class="visually-hidden">Cerca</label>
                            <input type="search" class="autocomplete form-control" placeholder="Cerca per parola chiave"
                                id="autocomplete-two" name="search" value="<?php echo esc_attr($query); ?>"
                                data-bs-autocomplete="[]" />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="button-3">
                                    Invio
                                </button>
                            </div>
                            <span class="autocomplete-icon" aria-hidden="true"><svg class="icon icon-sm icon-primary"
                                    role="img" aria-labelledby="autocomplete-label">
                                    <use href="#it-search"></use>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <?php 
                    $found_posts = $the_query->found_posts;
                    $post_type_multiple = "Luoghi trovati";

                    get_template_part("template-parts/common/data-list-info-and-ordering");
                ?>

            </div>
            <div class="row g-4" id="load-more">
                <?php 


                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) :
			                $the_query->the_post();
                            $post = get_post();

                            $load_card_type = "luogo";
                            get_template_part("template-parts/luogo/card-full");
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