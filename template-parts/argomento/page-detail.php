<?php
global $argomento, $first_printed, $grey_background;

$posts = dci_get_grouped_posts_by_term('page', 'argomenti', $argomento->slug, -1);

$total_cards = count($posts);
$card_per_pagina = 3;

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

    if($posts) {
?>
<section id="pagine" class="pb-5">
    <div class="pt-40 <?php echo $first_printed ? "pt-lg-80 pb-60" : "pt-md-100 pb-40"; ?> <?=$grey_background ? "bg-grey-dsk" : "";?>">
        <div class="container">
            <div class="border-bottom border-2 <?=$grey_background ? "" : "border-light";?>">
                <div class="row align-items-center pb-2">
                    <h3 class="col-12 col-md-5 title-large-semi-bold pb-0 mb-0">
                    Pagine                 
                </div>               
            </div>

                <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                    <?php foreach ($card_visibili as $post) {

				        get_template_part("template-parts/common/card-search");

                    }?>
                </div>

            <div class="pagination-container">
                <?php if ($pagine_card_totali > 1): ?>
                    <div class="row mt-4 card-pagination-row" data-card-corrente="<?=$pagina_card_corrente?>" data-card-totali="<?=$pagine_card_totali?>" data-post-type="page" data-posts-per-page="<?=$card_per_pagina?>">
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
    if($grey_background == true){
        $grey_background = false;
    }else{
        $grey_background = true;
    }
} ?>


