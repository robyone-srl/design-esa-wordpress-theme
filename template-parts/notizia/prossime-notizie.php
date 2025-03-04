<?php
global $scheda, $argomento, $is_set_notizie;

$is_set_notizie = true;

//Notizie in homepage
$risultato_eventi = dci_get_posts_by_term_by_date( 'notizia' , 'argomenti', $argomento->slug, true);

$risultato_eventi = array_slice($risultato_eventi, 0, 3);
if ($risultato_eventi && is_array($risultato_eventi) && count($risultato_eventi) > 0) {
?>
    <div class="section-content py-5">
        <div class="container">
        <?php
            if ($risultato_eventi && is_array($risultato_eventi) && count($risultato_eventi) > 0) { ?>
                <div class="row row-title pt-30 pt-lg-60 pb-3">
                    <div class="col-12 d-lg-flex justify-content-between">
                        <h3 id="ultime-news" class="mb-lg-0 title-large-semi-bold">Notizie recenti</h3>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                        <?php
                        foreach ($risultato_eventi as $i) {
                            if ($i) {
								$scheda = $i;
                                get_template_part("template-parts/home/notizia-evidenza"); 
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
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
<?php } else {
    $is_set_notizie = false;
}?>