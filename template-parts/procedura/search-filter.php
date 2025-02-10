<?php

$argomenti = dci_get_terms_options('argomenti');
$arr_ids = array_keys((array)$argomenti);

$post_types = array();
if(isset($_GET["post_types"]))
    $post_types = $_GET["post_types"];

$post_terms = array();
if(isset($_GET["post_terms"]))
    $post_terms = $_GET["post_terms"];
?>

<div class="accordion argomenti_accordion">
    <div class="accordion-item">
          <div id="collapse-one" class="accordion-collapse collapse d-lg-block" role="region" aria-labelledby="accordion-title-one">
                  <div class="accordion-body">
                        <fieldset class="argomenti_fieldset">
                            <div class="categoy-list pb-4">
                                <ul>
                                    <?php 
                                        foreach ($arr_ids as $arg_id) {
                                        $argomento = get_term_by('id', $arg_id, 'argomenti');
                                        $slug = $argomento->slug;
                                    ?>
                                    <li>
                                        <div class="form-check">
                                            <div class="checkbox-body border-light py-1">
                                                <input
                                                    type="checkbox" 
                                                    id="<?php echo $arg_id; ?>" 
                                                    name="post_terms[]" 
                                                    value="<?php echo $arg_id; ?>"
                                                    <?php if(in_array($arg_id, $post_terms)) echo " checked "; ?>
                                                    onChange="this.form.submit()"
                                                />
                                                <label 
                                                    for="<?php echo $arg_id; ?>" 
                                                    class="subtitle-small_semi-bold mb-0 category-list__list"
                                                >
                                                    <?php echo $argomento->name; ?> 
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </fieldset>   
                   </div>
          </div>
    </div>
</div>

                                        
<script>
    $(document).ready(function () {
        SetupArgomenti();
    });

    $(window).resize(function() {
        SetupArgomenti();
    });

    function SetupArgomenti () {
        $(".argomenti_fieldset_title").remove();

            if (window.innerWidth >= 992) {
                $(".argomenti_fieldset").prepend("<legend class=\"h6 px-2 pt-3 mb-0 text-uppercase category-list__title argomenti_fieldset_title\">Filtra per argomenti</legend>");
                $(".argomenti_accordion .border-bottom").remove();

                const accordionButton = $('#accordion-title-one button');
                if (accordionButton) {
                    accordionButton.attr('data-bs-toggle', '');  // Rimuove il comportamento di toggle
                    console.log("Rimosso toggle");
                }
            }
            if (window.innerWidth < 992) {
                                    
                                
                $(".argomenti_accordion .accordion-item").prepend(`
                <div class="border-bottom">
                    <span class="accordion-header" id="accordion-title-one">
                        <button class="accordion-button pb-10 px-3 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-one" aria-expanded="true" aria-controls="collapse-one">
                            <legend class="h6 text-uppercase category-list__title mb-0">Filtra per argomenti</legend>
                            <svg class="icon icon-xs right d-lg-none">
                                <use href="#it-expand"></use>
                            </svg>
                        </button>
                    </span>
                </div>
                `);


                const accordionButton = $('#accordion-title-one button');
                if (accordionButton) {
                    accordionButton.attr('data-bs-toggle', 'collapse');  // Ripristina il comportamento di toggle
                    console.log("Aggiunto toggle");
                }
            }
    }


</script>