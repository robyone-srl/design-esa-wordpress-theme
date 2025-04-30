<?php
global $scheda;

$giorni_per_filtro = dci_get_option("giorni_per_filtro", "comunica");
$data_limite_filtro = strtotime("-". $giorni_per_filtro . " day");

// Per mostrare la notizia più recente
$post_id = dci_get_option('notizia_evidenziata', 'comunica', true)[0] ?? null;
if ($post_id) {
    $post = get_post($post_id);
	if ($post->post_status != "publish") {
		$post_id = null;
		$post = null;
	}
}

// schede evidenziate, per escludere dalla query le notizie già evidenziate
$schede = dci_get_option('schede_evidenziate', 'comunica') ?: [];

//Notizie 
$notizie_in_comunica = dci_get_option('notizie_in_comunica', 'comunica');

if (isset($notizie_in_comunica) && $notizie_in_comunica > 0) {

    $args  = array(
        'post_type'      => 'notizia',
        'post_status'    => 'publish',
        'posts_per_page' => $notizie_in_comunica,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'exclude'        => [...($post_id ? [$post_id] : []), ...$schede],
    );

    if($giorni_per_filtro != "" || $giorni_per_filtro > 0) {
        $filter = array(
            'date_query' => array(
            	array(
					'after' => '-'. $giorni_per_filtro . ' day',
                	'inclusive' => true,
            	),
            ),
        );
		$args = array_merge($args,$filter);       	
    }
    if(get_posts($args)){
        $posts = get_posts($args);

        $arrdata           = dci_get_data_pubblicazione_arr("data_pubblicazione", '_dci_notizia_', $post->ID);
        $monthName         = date_i18n('M', mktime(0, 0, 0, $arrdata[1], 10));
        $descrizione_breve = dci_get_meta("descrizione_breve", '_dci_notizia_', $post->ID);
        $argomenti         = dci_get_meta("argomenti", '_dci_notizia_', $post->ID);

        $overlapping = "";

        if ($post_id || ($posts && is_array($posts) && count($posts) > 0)) {
        ?>
            <div class="container">
                <?php if ($post_id) {
                    ?> <h2 id="novita-in-evidenza" class="my-lg-5">Novità in evidenza</h2> <?php
                    $overlapping = "card-overlapping";
                    get_template_part("template-parts/home/notizia-hero");
                }
                if ($posts && is_array($posts) && count($posts) > 0) { ?>
                    <?php if (!$post_id) { ?>
                        <div class="row row-title pt-30 pt-lg-60 pb-3">
                            <div class="col-12 d-lg-flex justify-content-between">
                                    <h2 id="novita-in-evidenza" class="mb-lg-0">Notizie recenti</h2>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row mb-2">
                        <div class="card-wrapper <?php echo $overlapping; ?> card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                            <?php
                            foreach ($posts as $post) {
                                if ($post) {
								    $scheda = $post;
                                    get_template_part("template-parts/home/notizia-evidenza"); 
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                    <a class="btn btn-outline-primary full-mb" href="<?php echo dci_get_template_page_url("page-templates/novita.php"); ?>">
                        Tutte le novità
                        <svg class="icon icon-primary icon-xs ml-10">
                            <use xlink:href="#it-arrow-right"></use>
                        </svg>

                    </a>
                </div>
                <?php } ?>
            </div>
        <?php }
    }
}
?>
    