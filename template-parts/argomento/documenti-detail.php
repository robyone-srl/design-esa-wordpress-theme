<?php
    global $argomento;

    $posts = dci_get_grouped_posts_by_term( 'documenti-e-dati' , 'argomenti', $argomento->slug, 3 );

    if($posts) {
?>

<section id="documenti">
    <div class="pt-40 <?php echo $first_printed ? "pt-lg-80  pb-40" : "pt-md-100 pb-50"; ?>">
        <div class="container">
            <div class="row row-title">
                <div class="col-12">
                    <h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 title-large-semi-bold">
                        Documenti
                    </h3>
                </div>
            </div>
            <div class="row mx-0">
                <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                    <?php foreach ($posts as $post) { 
                        $description = dci_get_meta('descrizione_breve');
                        $tipo_documento = get_the_terms($post->ID, 'tipi_documento')[0];
                    ?>
                        <div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0">
                            <div class="card-image-wrapper with-read-more">
                                <div class="card-body p-3">
                                    <div class="category-top">
                                        <a class="title-xsmall-semi-bold fw-semibold text-decoration-none" href="<?php echo get_term_link($tipo_documento->term_id); ?>"><?php echo $tipo_documento->name; ?></a>
                                    </div>
                                    <h4 class="card-title text-paragraph-medium u-grey-light">
                                        <a href="<?php echo get_permalink(); ?>" class="text-decoration-none"><?php echo the_title(); ?></a>
                                    </h4>
                                    <p class="text-paragraph-card u-grey-light m-0"><?php echo $description; ?></p>
                                </div>
                            </div>          
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-lg-3 offset-lg-9">
                    <button 
                        type="button" 
                        class="btn btn-outline-primary w-100"
                        onclick="location.href='<?= dci_get_template_page_url("page-templates/documenti-e-dati.php"); ?>'"
                    >
                        Tutti i documenti
                        <svg class="icon icon-primary">
                            <use xlink:href="#it-arrow-right"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>