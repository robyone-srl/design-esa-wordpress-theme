<?php
global $procedura, $mostra_dettagli_procedura;

    $procedura_post = get_post($procedura);

$prefix = '_dci_procedura_';
$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $procedura_post->ID);

if($mostra_dettagli_procedura == null)
    $mostra_dettagli_procedura = true;

if($procedura_post->post_status == "publish") {
    ?>
    <div class="col-12 col-lg-6">
        <div class="cmp-card-latest-messages card-wrapper" data-bs-toggle="modal" data-bs-target="#">
            <div class="card shadow-sm px-4 py-2 rounded border border-light">
                <div class="card-body px-0 py-3">
                    <h3 class="green-title-big t-primary">
                        <a class="text-decoration-none" href="<?php echo get_permalink($procedura_post->ID); ?>" data-element="service-link"><?php echo $procedura_post->post_title; ?></a>
                    </h3>
                    <?php if($mostra_dettagli_procedura) echo$descrizione_breve; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}