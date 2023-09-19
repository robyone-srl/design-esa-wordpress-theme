<?php
//Per selezionare i contenuti in evidenza tramite configurazione
$servizi = dci_get_option('servizi_evidenziati', 'servizi');

if (!empty($servizi)) {
?>

    <div class="bg-grey-dsk py-5">
        <div class="container">
            <h2 class="title-xxlarge mb-4">Servizi in evidenza</h2>
            <div class="row g-4">
                <?php
                foreach ($servizi as $servizio_id) {
                    $post = get_post($servizio_id);
                    get_template_part("template-parts/servizio/card-full");
                }
                ?>
                <div class="d-flex justify-content-end">
                    <a href="#tutti-servizi" class="btn btn-outline-primary full-mb" aria-label="aria-label" data-element="live-button-locations">
                        Tutti i servizi
                        <svg class="icon icon-primary icon-xs ml-10">
                            <use href="#it-arrow-right"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>