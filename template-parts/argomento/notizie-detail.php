<?php
global $scheda, $argomento, $first_printed;

$risultato_notizie = dci_get_posts_by_term_by_date('notizia', 'argomenti', $argomento->slug, true);

$notizie_per_pagina = 3;

$total_notizie = count($risultato_notizie);

if ($total_notizie <= $notizie_per_pagina) {
    $notizie_visibili = $risultato_notizie;
    $pagine_notizie_totali = 1; 
} else {
    $pagine_notizie_totali = ceil($total_notizie / $notizie_per_pagina);
    $pagina_notizie_corrente = isset($_GET['pagina_notizie']) ? intval($_GET['pagina_notizie']) : 1;
    $pagina_notizie_corrente = min($pagina_notizie_corrente, $pagine_notizie_totali);
    $offset = ($pagina_notizie_corrente - 1) * $notizie_per_pagina;
    $notizie_visibili = array_slice($risultato_notizie, $offset, $notizie_per_pagina);
}

if ($notizie_visibili && is_array($notizie_visibili) && count($notizie_visibili) > 0) {
?>
    <div class="section-content py-5" id="notizie">
        <div class="container">
            <div class="row row-title pt-30 pt-lg-60 pb-3">
                <div class="col-12">
                    <h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 title-large-semi-bold">Notizie recenti</h3>
                </div>
            </div>
            <div class="row mb-2" id="notizie-row">
                <div class="card-wrapper card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                    <?php
                    foreach ($notizie_visibili as $i) {
                        if ($i) {
                            $scheda = $i;
                            get_template_part("template-parts/home/notizia-evidenza"); 
                        }
                    }
                    ?>
                </div>
            </div>

            <?php if ($pagine_notizie_totali > 1): ?>
                <div class="row mt-4" id="notizie-pagination-container" data-notizia-corrente="<?=$pagina_notizie_corrente?>" data-notizie-totali="<?=$pagine_notizie_totali?>" data-slug="<?=$argomento->slug?>">
                    <div class="col-12">
                        <nav>
                            <ul class="pagination justify-content-center" id="notizie-pagination">
                                <?php if ($pagina_notizie_corrente > 1): ?>
                                    <li class="page-item" id="prev-page-notizie">
                                        <a class="page-link" href="javascript:void(0);" data-page="<?= $pagina_notizie_corrente - 1 ?>" aria-label="Precedente">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item" id="prev-page-notizie" style="display: none;">
                                        <a class="page-link" href="javascript:void(0);" aria-label="Precedente">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php 
                                $maxPages = 5;
                                $startPage = max(1, $pagina_notizie_corrente - floor($maxPages / 2));
                                $endPage = min($pagine_notizie_totali, $startPage + $maxPages - 1);

                                for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="page-item <?= ($i == $pagina_notizie_corrente) ? 'active' : '' ?>" id="page-notizie-<?= $i ?>">
                                        <a class="page-link <?= ($i == $pagina_notizie_corrente) ? 'border border-primary rounded' : '' ?>" 
                                           href="javascript:void(0);" data-page="<?= $i ?>">
                                           <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagina_notizie_corrente < $pagine_notizie_totali): ?>
                                    <li class="page-item" id="next-page-notizie">
                                        <a class="page-link" href="javascript:void(0);" data-page="<?= $pagina_notizie_corrente + 1 ?>" aria-label="Successivo">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item" id="next-page-notizie" style="display: none;">
                                        <a class="page-link" href="javascript:void(0);" aria-label="Successivo">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
    $first_printed = true;
}
?>