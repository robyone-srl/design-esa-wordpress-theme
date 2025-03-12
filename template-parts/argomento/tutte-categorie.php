<?php
    global $argomento, $first_printed;

    $posts = dci_get_grouped_posts_by_term('argomenti-tutti', 'argomenti', $argomento->name, -1);
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
                                data-post-type="argomenti-tutti"
                                data-term="<?= $argomento->slug ?>" 
                            >
                                Tutti
                            </button>

                            <button 
                                type="button" 
                                class="btn btn-outline-primary btn-xs mb-2 mb-md-0"
                                data-post-type="servizi"
                                data-term="<?= $argomento->slug ?>" 
                            >
                                Servizi
                            </button>

                            <button 
                                type="button" 
                                class="btn btn-outline-primary btn-xs mb-2 mb-md-0"
                                data-post-type="amministrazione"
                                data-term="<?= $argomento->slug ?>" 
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
                            <h5 class="modal-title" id="moreOptionsModalLabel">Seleziona un'opzione</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="filterOption" id="optTutti" value="argomenti-tutti">
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

            <div class="row mx-0" id="tutte-cargorie-card-row" data-slug="<?=$argomento->slug?>">

            <div class="card-wrapper px-0 card-teaser-wrapper card-teaser-wrapper-equal card-teaser-block-3" id="tutti">
                    
            
                <?php foreach ($posts as $post) {

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
        </div>
    </div>
</section>
<?php 
    $first_printed = true;
} ?>


