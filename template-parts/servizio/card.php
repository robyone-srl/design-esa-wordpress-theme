<?php
global $servizio, $hide_categories, $mostra_dettagli_servizi;

$prefix = '_dci_servizio_';
$categorie = get_the_terms($servizio->ID, 'categorie_servizio');
$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $servizio->ID);
if($mostra_dettagli_servizi == null)
    $mostra_dettagli_servizi = true;

if($servizio->post_status == "publish") {
    ?>
        <div class="cmp-card-latest-messages card-wrapper" data-bs-toggle="modal" data-bs-target="#">
            <div class="card shadow-sm px-4 py-2 rounded border border-light">
                <?php if (!$hide_categories && $mostra_dettagli_servizi == true) { ?>
                    <span class="visually-hidden">Categoria:</span>
                    <div class="card-header border-0 px-0 pb-0">
                        <?php if (is_array($categorie) && count($categorie)) {
                            $count = 1;
                            foreach ($categorie as $categoria) {
                                echo $count == 1 ? '' : ' - ';
                                echo '<a class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase" href="'.get_term_link($categoria->term_id).'">';
                                echo $categoria->name ; 
                                echo '</a>';
                                ++$count;
                            }
                        } ?>
                    </div>
                <?php } ?>

                <div class="card-body px-0 py-2">
                    <h3 class="green-title-big t-primary <?php if(!$mostra_dettagli_servizi) echo "pt-2"; ?>">
                        <a class="text-decoration-none" href="<?php echo get_permalink($servizio->ID); ?>" data-element="service-link"><?php echo $servizio->post_title; ?></a>
                    </h3>
                    <?php if($mostra_dettagli_servizi == true){ ?>
                            <p class="mb-1 text-paragraph">
                                <?php echo $descrizione_breve; ?>
                            </p> <?php
                     } ?>
                </div>
            </div>
        </div>
    <?php
}