<?php
global $posts, $the_query, $load_posts, $procedura, $load_card_type, $should_have_grey_background;

$max_posts = isset($_GET['max_posts']) ? $_GET['max_posts'] : 4;
$load_posts = 4;

$query = isset($_GET['search']) ? dci_removeslashes($_GET['search']) : null;

$post_types = array();
if (isset($_GET["post_types"])) {
    $post_types = $_GET["post_types"];
}

$post_terms = array();
if (isset($_GET["post_terms"])) {
    $post_terms = $_GET["post_terms"];
}

$args = array(
    's'              => $query,
    'posts_per_page' => $max_posts,
    'post_type'      => 'procedura',
    'orderby'        => 'post_title',
    'order'          => 'ASC'
);

if (!empty($post_types)) {
    $args['post_type'] = $post_types;
}

if (!empty($post_terms)) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'argomenti',
            'field'    => 'id',
            'terms'    => $post_terms
        )
    );
}

$the_query = new WP_Query($args);

?>

<div class="container py-5">
    <h2>Tutte le procedure</h2>
    <div class="row row-column-menu-left border-light mt-3">
        <form role="search" id="search-form" method="get" class="search-form px-0" action="#search-form">

            <div class="container">
                <div class="row">
                    
                    <div class="cmp-input-search mb-4">
                        <div class="form-group autocomplete-wrapper mb-0">
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
                                        <use href="#it-search"></use>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 mb-3 border-col">
                        <div class="cmp-navscroll sticky-top">
                            <nav class="navbar it-navscroll-wrapper navbar-expand-lg py-0" aria-label="Filtra per" data-bs-navscroll>
                                <div class="menu-wrapper pb-0">
                                    <div class="link-list-wrapper">
                                        <?php get_template_part("template-parts/procedura/search-filter"); ?>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>


                    <div class="col-12 col-lg-9">
                        <div id="tutte-procedure" class="<?= !($should_have_grey_background=(!$should_have_grey_background)) ? 'bg-grey-dsk':'' ?>">
                            
                            <div class="pt-lg-30 pb-lg-60 ps-4">
                                <p id="autocomplete-label" class="mb-4">
                                    <strong><?php echo $the_query->found_posts; ?> </strong> procedure trovate in ordine alfabetico
                                </p>
                                <div class="row g-4" id="load-more">
                                    <?php 
                                    if ($the_query->have_posts()) :
                                        while ($the_query->have_posts()) :
			                                    $the_query->the_post();
                                                $procedura = get_post();

                                                $load_card_type = "procedura";  ?>
                                                <div class="col-12 col-lg-6">  <?php
                                                    $mostra_dettagli_procedura = true;
                                                    get_template_part("template-parts/procedura/card"); ?>
                                                </div>  <?php
		                                endwhile;
                                    endif; 

                                    wp_reset_postdata();
                                    ?>
                                </div>
                                <?php get_template_part("template-parts/search/more-results"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>      
</div>

