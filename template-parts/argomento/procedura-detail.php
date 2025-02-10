<?php
global $argomento;

$posts = dci_get_grouped_posts_by_term('procedura', 'argomenti', $argomento->slug, 10);

if ($posts) {
    $first_printed = true;
?>

    <section id="procedura">
        <div class="bg-grey-card pt-40 pt-md-100 pb-50">
            <div class="container">
                <div class="row row-title">
                    <div class="col-12">
                        <h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 mt-lg-3 title-large-semi-bold">
                            Procedure
                        </h3>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                        <?php foreach ($posts as $post) {
                            $description = dci_get_meta('descrizione_breve');
                            $img = get_the_post_thumbnail_url();
                        ?>
                            <div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0">
                                <div class="card card-img no-after sm-row">
                                    <?php if ($img) { ?>
                                        <div class="img-responsive-wrapper">
                                            <div class="img-responsive img-responsive-panoramic">
                                                <figure class="img-wrapper">
                                                    <?php dci_get_img($img); ?>
                                                </figure>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="card-body p-4">
                                        <h4 class="title-small-semi-bold-big mb-0 ">
                                            <a class="text-decoration-none" href="<?php echo get_permalink(); ?>">
                                                <?php echo the_title(); ?>
                                            </a>
                                        </h4>
                                        <p class="pt-3 d-none d-lg-block text-paragraph-card u-grey-light">
                                            <?php echo $description; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row mt-lg-2">
                    <div class="col-12 col-lg-3 offset-lg-9">
                        <button type="button" class="btn btn-primary text-button w-100" onclick="location.href='<?= dci_get_search_query_url(post_types: ['procedura'], argomenti_ids: [$argomento->term_id]); ?>'">
                            Tutte le procedure
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>