<?php
global $recurrence_index, $argomento, $first_printed;

$eventi = dci_get_posts_by_term_by_date('evento', 'argomenti', $argomento->slug, true);
$oggi_timestamp = current_time('timestamp');  

$eventi = array_filter($eventi, function($evento) use ($oggi_timestamp) {
    $start_timestamp = get_post_meta($evento->ID, '_dci_evento_data_orario_inizio', true);
    
    return $start_timestamp >= $oggi_timestamp;
});

usort($eventi, function($a, $b) {
    $data_inizio_a = get_post_meta($a->ID, '_dci_evento_data_orario_inizio', true);
    $data_inizio_b = get_post_meta($b->ID, '_dci_evento_data_orario_inizio', true);
    return $data_inizio_a <=> $data_inizio_b;
});

$eventi_per_pagina = 3;

$total_eventi = count($eventi);

if ($total_eventi <= $eventi_per_pagina) {
    $eventi_visibili = $eventi;
    $pagine_eventi_totali = 1; 
} else {
    $pagine_eventi_totali = ceil($total_eventi / $eventi_per_pagina);
    $pagina_eventi_corrente = isset($_GET['pagina_eventi']) ? intval($_GET['pagina_eventi']) : 1;
    $pagina_eventi_corrente = min($pagina_eventi_corrente, $pagine_eventi_totali);
    $offset_eventi = ($pagina_eventi_corrente - 1) * $eventi_per_pagina;
    $eventi_visibili = array_slice($eventi, $offset_eventi, $eventi_per_pagina);
}

if ($eventi_visibili && is_array($eventi_visibili) && count($eventi_visibili) > 0) {
?>
    <div class="section-content pb-5 pt-<?= $first_printed ? 3 : 'lg-70' ?> bg-grey-dsk" id="eventi">
        <div class="container">
            <div class="row row-title pt-5 pt-lg-60 pb-3">
                <div class="col-12">
                    <h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 title-large-semi-bold">Prossimi eventi</h3>
                </div>
            </div>

            <div class="row g-4">
                <?php
                foreach ($eventi_visibili as $evento) {
                    $post = get_post($evento->ID);
                    get_template_part("template-parts/evento/card-full");
                } ?>
            </div>

            <?php if ($pagine_eventi_totali > 1): ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php if ($pagina_eventi_corrente > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= add_query_arg('pagina_eventi', $pagina_eventi_corrente - 1) ?>#eventi" aria-label="Precedente">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $pagine_eventi_totali; $i++): ?>
                                    <li class="page-item <?= ($i == $pagina_eventi_corrente) ? 'active' : '' ?>">
                                        <a class="page-link <?= ($i == $pagina_eventi_corrente) ? 'border border-primary rounded' : '' ?>" href="<?= add_query_arg('pagina_eventi', $i) ?>#eventi" data-page="<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagina_eventi_corrente < $pagine_eventi_totali): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= add_query_arg('pagina_eventi', $pagina_eventi_corrente + 1) ?>#eventi" aria-label="Successivo">
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
} ?>
