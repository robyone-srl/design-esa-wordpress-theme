
<?php
global $scheda, $show_title;
if($show_title == "") $show_title = false;

$schede = dci_get_meta('correlato', '_dci_domanda_frequente_', $post->ID);

if ($schede && count($schede) > 0) { ?>
    
    <div class="container p-0">
        <h3 id="contenuti_evidenza" class="mb-lg-0 <?php if(!$show_title) echo 'd-none'; ?> ">Contenuti correlati</h3>
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