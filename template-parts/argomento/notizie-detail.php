<?php
global $scheda, $argomento, $first_printed;

$risultato_notizie = dci_get_posts_by_term_by_date( 'notizia' , 'argomenti', $argomento->slug, true);

$risultato_notizie = array_slice($risultato_notizie, 0, 3);

if ($risultato_notizie && is_array($risultato_notizie) && count($risultato_notizie) > 0) {
?>
    <div class="section-content py-5">
        <div class="container">
            <div class="row row-title pt-30 pt-lg-60 pb-3">
                <div class="col-12">
				<h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 title-large-semi-bold">Notizie recenti</h3>
			</div>
            </div>
            <div class="row mb-2">
                <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                    <?php
                    foreach ($risultato_notizie as $i) {
                        if ($i) {
							$scheda = $i;
                            get_template_part("template-parts/home/notizia-evidenza"); 
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-lg-3 offset-lg-9">
                    <button 
                        type="button" 
                        class="btn btn-outline-primary w-100"
                        onclick="location.href='<?= dci_get_template_page_url("page-templates/novita.php"); ?>'"
                    >
                        Tutte le novità
                        <svg class="icon icon-primary">
                            <use xlink:href="#it-arrow-right"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
    $first_printed = true;
} ?>