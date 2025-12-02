<?php
global $should_have_grey_background;
//Per selezionare i contenuti in evidenza tramite configurazione
$procedure = dci_get_option('procedure_evidenziate', 'procedure');

if (!empty($procedure)) {
?>
    <div class="py-5 <?= !($should_have_grey_background=(!$should_have_grey_background)) ? 'bg-grey-dsk':'' ?>">
        <div class="container">
            <h2 class="title-xxlarge mb-4">Procedure in evidenza</h2>
            <div class="row g-4">
                <?php
                foreach ($procedure as $procedure_id) {
                    $post = get_post($procedure_id);
                    get_template_part("template-parts/procedura/card-full");
                }
                ?>
                <div class="d-flex justify-content-end">
                    <a href="#tutte-procedure" class="btn btn-outline-primary full-mb" aria-label="aria-label" data-element="live-button-locations">
                        Tutte le procedure
                        <svg class="icon icon-primary icon-xs ml-10">
                            <use href="#it-arrow-right"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>