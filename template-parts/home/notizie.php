<?php
global $scheda;
// Per mostrare la notizia più recente
$post_id = dci_get_option('notizia_evidenziata', 'homepage', true)[0] ?? null;
if ($post_id) {
    $post = get_post($post_id);
}

//Notizie in homepage
$posts = null;
$notizie_in_home = dci_get_option('notizie_in_home', 'homepage');
if ($notizie_in_home && $notizie_in_home > 0) {
    $args  = array(
        'post_type'      => 'notizia',
        'post_status'    => 'publish',
        'posts_per_page' => $notizie_in_home,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'exclude'        => $post_id ? [$post_id] : [],
    );
    $posts = get_posts($args);
    //$post  = array_shift( $posts  );
}

$img               = dci_get_meta("immagine", '_dci_notizia_', $post->ID);
$arrdata           = dci_get_data_pubblicazione_arr("data_pubblicazione", '_dci_notizia_', $post->ID);
$monthName         = date_i18n('M', mktime(0, 0, 0, $arrdata[1], 10));
$descrizione_breve = dci_get_meta("descrizione_breve", '_dci_notizia_', $post->ID);
$argomenti         = dci_get_meta("argomenti", '_dci_notizia_', $post->ID);

$overlapping = "";
?>
<!-- Tag section is opened in home.php -->
<section id="notizie" aria-describedby="novita-in-evidenza">
    <div class="section-content">
        <div class="container">
            <h2 id="novita-in-evidenza" class="visually-hidden">Novità in evidenza</h2>
            <?php if ($post_id) {
                $overlapping = "card-overlapping";
            ?>
                <?php get_template_part("template-parts/home/notizia-hero"); ?>
            <?php }
            if ($posts && is_array($posts) && count($posts) > 0) { ?>
                <?php if (!$post_id) { ?>
                    <div class="row row-title pt-lg-60 pb-3">
                        <div class="col-12 d-lg-flex justify-content-between">
                            <h2 id="ultime-news" class="mb-lg-0">Ultime notizie</h2>
                        </div>
                    </div>
                <?php } ?>
                <div class="row mb-2">
                    <div class="card-wrapper px-0 <?php echo $overlapping; ?> card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                        <?php
                        foreach ($posts as $post) {
                            if ($post) {
                                get_template_part("template-parts/home/notizia-evidenza");
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row my-4 justify-content-md-center">
                    <a class="read-more pb-3" href="<?php echo dci_get_template_page_url("page-templates/novita.php"); ?>">
                        <button type="button" class="btn btn-outline-primary">Tutte le novità
                            <svg class="icon">
                                <use xlink:href="#it-arrow-right"></use>
                            </svg>
                        </button>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>