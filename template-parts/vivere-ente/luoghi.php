<?php
    // Per selezionare i contenuti in evidenza tramite flag
    // $luoghi = dci_get_highlighted_posts(['luogo'], 6);

    //Per selezionare i contenuti in evidenza tramite configurazione
    $visualizza_luoghi = dci_get_option('vivi_visualizzazione_luoghi','vivi');
    if($visualizza_luoghi == 'false'){
        $luoghi = dci_get_option('luoghi_evidenziati','vivi');
    }else{
        $luoghi = dci_get_option('luoghi_evidenziati','luoghi');
    }
    

    $url_luoghi = get_permalink(get_page_by_path('vivere-ente/luoghi'));
    if (is_array($luoghi) && count($luoghi)) {
?>

<div class="bg-grey-dsk py-5">
    <div class="container">
        <h2 class="title-xxlarge mb-4">Scopri i luoghi</h2>
        <div class="row g-4">
            <?php
                foreach ($luoghi as $luogo_id) {
                    $post = get_post($luogo_id);
                    get_template_part("template-parts/luogo/card-full");
                }
            ?>
            <div class="d-flex justify-content-end">
                <a href="<?= $url_luoghi ?>" class="btn btn-outline-primary full-mb" aria-label="Tutti i luoghi" data-element="live-button-locations">
                    Tutti i luoghi 
                    <svg class="icon icon-primary icon-xs ml-10">
                      <use href="#it-arrow-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
<?php } ?>