<?php
global $recurrence_index, $argomento, $first_printed;

$posts = dci_get_posts_by_term_by_date('evento', 'argomenti', $argomento->slug, true);
$oggi_timestamp = current_time('timestamp');  

$posts = array_filter($posts, function($evento) use ($oggi_timestamp) {
    $end_timestamp = get_post_meta($evento->ID, '_dci_evento_data_orario_fine', true);
    
    return $end_timestamp >= $oggi_timestamp;
});

usort($posts, function($a, $b) {
    $data_fine_a = get_post_meta($a->ID, '_dci_evento_data_orario_fine', true);
    $data_fine_b = get_post_meta($b->ID, '_dci_evento_data_orario_fine', true);
    return $data_fine_a <=> $data_fine_b;
});

$card_per_pagina = 3;

$total_cards = count($posts);

if ($total_cards <= $card_per_pagina) {
    $card_visibili = $posts;
    $pagine_card_totali = 1;
} else {
    $pagine_card_totali = ceil($total_cards / $card_per_pagina);
    $pagina_card_corrente = isset($_POST['pagina_card']) ? intval($_POST['pagina_card']) : 1;
    $pagina_card_corrente = min($pagina_card_corrente, $pagine_card_totali);
    $offset = ($pagina_card_corrente - 1) * $card_per_pagina;
    $card_visibili = array_slice($posts, $offset, $card_per_pagina);
}

if ($posts) {
?>
<section id="eventi">
    <div class="pt-40 <?php echo $first_printed ? "pt-lg-80 pb-40" : "pt-md-100 pb-50"; ?> bg-grey-dsk">
        <div class="container">
            <div class="border-bottom border-2 mb-3">
                <div class="row align-items-center pb-2">
                    <h3 class=" title-large-semi-bold">Prossimi eventi</h3>
                </div>               
            </div>

            <div class="card-wrapper row g-4">
                <?php
                foreach ($card_visibili as $evento) {
                    $post = get_post($evento->ID);
                    get_template_part("template-parts/evento/card-full");
                } ?>
            </div>

            <div class="pagination-container">
                <?php if ($pagine_card_totali > 1): ?>
                    <div class="row mt-4 card-pagination-row" data-card-corrente="<?=$pagina_card_corrente?>" data-card-totali="<?=$pagine_card_totali?>" data-post-type="evento" data-posts-per-page="<?=$card_per_pagina?>">
                        <div class="col-12">
                            <nav>
                                <ul class="pagination justify-content-center card-pagination-ul">
                                    <?php if ($pagina_card_corrente > 1): ?>
                                        <li class="page-item prev-page-card">
                                            <a class="page-link" href="javascript:void(0);" data-page="<?= $pagina_card_corrente - 1 ?>" aria-label="Precedente">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php 
                                    $maxPages = 5;
                                    $startPage = max(1, $pagina_card_corrente - floor($maxPages / 2));
                                    $endPage = min($pagine_card_totali, $startPage + $maxPages - 1);

                                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                                        <li class="page-item <?= ($i == $pagina_card_corrente) ? 'active' : '' ?> page-card-<?= $i ?>">
                                            <a class="page-link <?= ($i == $pagina_card_corrente) ? 'border border-primary rounded' : '' ?>" 
                                               href="#" data-page="<?= $i ?>">
                                               <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($pagina_card_corrente < $pagine_card_totali): ?>
                                        <li class="page-item next-page-card">
                                            <a class="page-link" href="#" data-page="<?= $pagina_card_corrente + 1 ?>" aria-label="Successivo">
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
    </div>
</section>
<?php 
    $first_printed = true;
} ?>


