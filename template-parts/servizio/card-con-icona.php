<?php
global $servizio, $hide_categories;

$prefix = '_dci_servizio_';
$categorie = get_the_terms($servizio->ID, 'categorie_servizio');
$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $servizio->ID);
$classi_icona = dci_get_meta('classi_icona', $prefix, $servizio->ID);

if($servizio->post_status == "publish") {
    ?>
        <div class="cmp-card-latest-messages mb-3 mb-30" data-bs-toggle="modal" data-bs-target="#">
            <div class="card shadow-sm px-4 pt-4 pb-2 rounded border border-light">
                <div class="card-body p-0 my-2 text-center">
                    <i class="<?= $classi_icona ?> title-xxlarge t-primary"></i>
                <h3 class="green-title-big t-primary mt-3">
                    <a class="text-decoration-none" href="<?php echo get_permalink($servizio->ID); ?>" data-element="service-link"><?php echo $servizio->post_title; ?></a>
                </h3>
                </div>
            </div>
        </div>
    <?php
}