
<?php
global $scheda;

$schede = dci_get_meta('correlati', '_dci_domanda_frequente_', $post->ID);

if ($schede && count($schede) > 0) { ?>
    
    <div class="container">
        <h3 id="contenuti_evidenza" class="mb-lg-0 d-none">Contenuti in evidenza</h3>
        <div class="mb-2">
            <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-6">
                <?php $count = 1;
                foreach ($schede as $scheda) {
                    if ($scheda) {
                        get_template_part("template-parts/domanda-frequente/scheda-evidenza");
                    }
                    ++$count;
                } ?>
            </div>
        </div>
    </div>
<?php } ?>