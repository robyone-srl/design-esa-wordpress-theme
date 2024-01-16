<?php
global $domanda_frequente_id;

$domanda_frequente = get_post($domanda_frequente_id);
$prefix = '_dci_domanda_frequente_';
$df_risposta = dci_get_meta('risposta', $prefix, $domanda_frequente->ID);
?>

<div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0">
                            <div class="card-image-wrapper with-read-more">
                                <div class="card-body p-3">
                                        <h4 class="card-title text-paragraph-medium u-grey-light">
                                            <a href="<?php echo get_permalink(); ?>" class="text-decoration-none"><?php echo the_title(); ?></a>
                                        </h4>
                                </div>
                            </div>
                        </div>