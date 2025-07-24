<?php
global $argomento, $first_printed;

$posts = dci_get_grouped_posts_by_term('argomenti-griglia', 'argomenti', $argomento->slug, -1);

$total_cards = count($posts);
$card_per_pagina = 9;

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
<section id="tutti" class="pb-5">
    <div class="pt-40 <?php echo $first_printed ? "pt-lg-80 pb-40" : "pt-md-100 pb-50"; ?>">
        <div class="container">
            <div class="border-bottom border-2 border-light">
                <div class="row align-items-center pb-2">
                    <h3 class="col-12 col-md-5 title-large-semi-bold pb-0 mb-0">
                    <?php 
                    if($first_printed){echo "Gli altri contenuti";} else {echo"Tutti i contenuti"; }?>
                    </h3>

                    <div class="col-12 col-md-7 d-flex justify-content-start justify-content-md-end pb-2">
                        <div class="filters-list d-flex flex-wrap justify-content-start justify-content-md-end gap-2">
                            <button 
                                type="button" 
                                class="btn btn-primary btn-xs mb-2 mb-md-0"
                                data-post-type="argomenti-griglia"
                            >
                                Tutti
                            </button>

                            <button 
                                type="button" 
                                class="btn btn-outline-primary btn-xs mb-2 mb-md-0"
                                data-post-type="servizi"
                            >
                                Servizi
                            </button>

                            <button 
                                type="button" 
                                class="btn btn-outline-primary btn-xs mb-2 mb-md-0"
                                data-post-type="amministrazione"
                            >
                                Unit&agrave; organizzative
                            </button>
                        </div>

                        <button 
                            type="button" 
                            class="btn btn-outline-primary btn-xs mb-2 mb-md-0 ms-2 mx-1" 
                            data-bs-toggle="modal" 
                            data-bs-target="#moreOptionsModal"
                            id="btn-more-options" 
                        >
                            ...
                        </button>
                    </div>
                </div>               
            </div>

            <div class="modal fade" id="moreOptionsModal" tabindex="-1" aria-labelledby="moreOptionsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="h5 modal-title" id="moreOptionsModalLabel">Seleziona un'opzione</div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="filterOption" id="optTutti" value="argomenti-griglia">
                                <label class="form-check-label" for="optTutti">Tutti</label>
                            </div>
                            <?php 
                                define('TIPI_POST', jsonToArray(get_template_directory()."/inc/tutte-tipologie.json")['tipi_tipologie']);

                                foreach(TIPI_POST as $i){
                                    $value = $i['value'];
                                    $name = $i['name'];

                                    if($value != 'vivere-ente' && $value != 'post'){ ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="filterOption" id="opt<?=$value?>" value="<?=$value?>">
                                            <label class="form-check-label" for="opt<?=$value?>"><?=$name?></label>
                                        </div> 
                                    <?php }
                                } ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Chiudi</button>
                            <button type="button" class="btn btn-primary" id="save-selection">Salva</button>
                        </div>
                    </div>
                </div>
            </div>

                <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3">
                    <?php foreach ($card_visibili as $post) {

                        switch ($post->post_type) {
		                    case "servizio":
				                    get_template_part("template-parts/".$post->post_type."/card-search");
			                    break;
		                    case "documento_pubblico":
                                    get_template_part("template-parts/documento/card-search");
			                    break;
		                    case "unita_organizzativa":
                                    get_template_part("template-parts/unita-organizzativa/card-search");
			                    break;
                            case "luogo":
                                    get_template_part("template-parts/".$post->post_type."/card-search");
			                    break;
                            case "sito_tematico":
                                    get_template_part("template-parts/sito-tematico/card-search");
			                    break;
                            case "page":
                                    get_template_part("template-parts/common/card-search");
			                    break;
                            case "procedura":
                                    get_template_part("template-parts/procedura/card-search");
			                    break;
		                }
                    }?>
                </div>

            <div class="pagination-container">
                <?php if ($pagine_card_totali > 1): ?>
                    <div class="row mt-4 card-pagination-row" data-card-corrente="<?=$pagina_card_corrente?>" data-card-totali="<?=$pagine_card_totali?>" data-post-type="argomenti-griglia" data-posts-per-page="<?=$card_per_pagina?>">
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


