<?php
global $servizio, $hide_categories;

$prefix = '_dci_servizio_';
$categorie = get_the_terms($servizio->ID, 'categorie_servizio');
$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $servizio->ID);
$classi_icona = dci_get_meta('classi_icona', $prefix, $servizio->ID);

if ($servizio->post_status == "publish") {
?>
        <div class="cmp-card-latest-messages card-wrapper shadow-sm rounded border border-light">
            <div class="card no-after px-4 pt-4">
                <div class="card-body p-0 mt-2 text-center">
                    <i class="<?= $classi_icona ?> title-xxlarge t-primary"></i>
                    <div class="green-title-big t-primary t-primary mt-3">
                        <?php echo $servizio->post_title; ?>
                    </div>
                </div>
            </div>
        </div>
<?php
}
