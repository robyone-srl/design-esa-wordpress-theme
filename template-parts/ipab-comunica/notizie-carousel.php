<?php
// Per mostrare la notizia in evidenza
$post_id = dci_get_option('notizia_evidenziata', 'comunica', true)[0] ?? null;

// schede evidenziate, per escludere dalla query le notizie già evidenziate
$schede = dci_get_option('schede_evidenziate', 'comunica') ?: [];

//Notizie in comunica
$posts = null;
$notizie_in_home = dci_get_option('notizie_in_comunica', 'comunica');
if ($notizie_in_home && $notizie_in_home > 0) {
    $args  = array(
        'post_type'      => 'notizia',
        'post_status'    => 'publish',
        'posts_per_page' => $notizie_in_home,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'exclude'        => [...($post_id ? [$post_id] : []), ...$schede],
    );
    $posts = get_posts($args);
    //$post  = array_shift( $posts  );
}

if ($post_id) {
    array_unshift($posts, get_post($post_id));
}
?>

<div class="container px-0">
    <h2 id="contenuti_evidenza" class="my-lg-4">Contenuti in evidenza</h2>
    <div class="it-carousel-wrapper it-carousel-landscape-abstract splide mw-100" data-bs-carousel-splide>
        <div class="splide__track pt-0 px-0">
            <ul class="splide__list">
                <?php
                foreach ($posts as $post) {
                ?>
                    <li class="splide__slide">
                        <div class="it-single-slide-wrapper">
                            <?php get_template_part("template-parts/ipab-comunica/notizia-hero"); ?>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>