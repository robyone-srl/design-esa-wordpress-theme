<?php
    global $argomento;

    $posts = dci_get_grouped_posts_by_term( 'novita-evento' , 'argomenti', $argomento->slug, 3 );

    if($posts) {
        $first_printed = true;
?>

<section id="novita">
    <div class="bg-grey-card pt-40 pt-md-100 pb-50">
        <div class="container">
            <div class="row row-title">
                <div class="col-12">
                <h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 mt-lg-3 title-large-semi-bold">
                    Novità
                </h3>
                </div>
            </div>
            <div class="row pt-4 mt-lg-2 pb-lg-4">
                <?php foreach ($posts as $post) { 
                    $description = dci_get_meta('descrizione_breve');
                    $img = get_the_post_thumbnail_url();
                    if ($post->post_type == 'evento') {
                        get_template_part( 'template-parts/evento/card-full' );
                    } else { 
                    $tipo_notizia = get_the_terms($post->ID, 'tipi_notizia')[0];
                    $arrdata = dci_get_data_pubblicazione_arr("data_pubblicazione", '_dci_notizia_', $post->ID);
                    $monthName = date_i18n('M', mktime(0, 0, 0, $arrdata[1], 10));
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-wrapper">
                        <div class="card card-img no-after sm-row">
                            <?php if($img) { ?>
                                <div class="img-responsive-wrapper">
                                    <div class="img-responsive img-responsive-panoramic">
                                        <figure class="img-wrapper">
                                            <?php dci_get_img($img); ?>
                                        </figure>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="card-body p-4">
                                <div class="category-top">
                                    <a class="text-decoration-none fw-semibold" href="<?php echo get_term_link($tipo_notizia->term_id); ?>">
                                        <?php echo $tipo_notizia->name; ?>
                                    </a>
                                    <span class="data u-grey-light">
                                        <?php echo $arrdata[0] . ' ' . $monthName . ' ' . $arrdata[2]?>
                                    </span>
                                </div>
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
                </div>
                <?php }} ?>
            </div>
            <div class="row mt-lg-2">
                <div class="col-12 col-lg-3 offset-lg-9">
                <button 
                    type="button" 
                    class="btn btn-primary text-button w-100"
                    onclick="location.href='<?= get_search_query_url(post_types: ['notizia', 'evento'], argomenti_ids: [$argomento->term_id]); ?>'"
                >
                    Tutte le novità
                </button>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>