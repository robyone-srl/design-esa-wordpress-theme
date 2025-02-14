
<?php
global $scheda, $should_have_grey_background;

$schede = dci_get_option('schede_evidenziate', 'comunica') ?? null;

if ($schede && count($schede) > 0) { ?>
<section aria-describedby="contenuti_evidenza" class="<?= !($should_have_grey_background=(!$should_have_grey_background)) ? 'bg-grey-dsk':'' ?>">
    <div class="section-content">
        <div class="section-muted pb-90 pb-lg-50 px-lg-5 pt-0">
            <div class="container">
                <div class="row row-title pt-5 pt-lg-60 pb-3">
                    <div class="col-12 d-lg-flex justify-content-between">
                        <h2 id="contenuti_evidenza" class="mb-lg-0">Contenuti in evidenza</h2>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                        <?php $count = 1;
                        foreach ($schede as $scheda) {
                            if ($scheda) {
                                get_template_part("template-parts/ipab-comunica/scheda-evidenza");
                            }
                            ++$count;
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>