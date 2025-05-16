<?php
global $procedura, $mostra_dettagli_procedura;

$prefix = '_dci_procedura_';
$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $procedura->ID);

if($mostra_dettagli_procedura == null)
    $mostra_dettagli_procedura = true;

if($procedura->post_status == "publish") {
    ?>
        <div class="cmp-card-latest-messages card-wrapper" data-bs-toggle="modal" data-bs-target="#">
            <div class="card shadow-sm px-4 py-2 rounded border border-light">
                <div class="card-body px-0 py-3">
                    <h3 class="green-title-big t-primary">
                        <a class="text-decoration-none" href="<?php echo get_permalink($procedura->ID); ?>" data-element="service-link"><?php echo $procedura->post_title; ?></a>
                    </h3>
                    <?php if($mostra_dettagli_procedura) echo$descrizione_breve; ?>
                </div>
            </div>
        </div>
    <?php
}