<?php
    global $pc_id;
    $prefix = '_dci_evento_';
    $punti_contatto = dci_get_meta("punti_contatto", $prefix, $post->ID);
    $contatti_p_tit = dci_get_option('contattaci_titolo', 'footer');
    $contatti_p_cont = dci_get_option("contattaci_contenuto", 'footer');
?>
    <div class="container py-5">        
        <?php if (is_array($contatti_p_cont) && count($contatti_p_cont)) { ?>
            <h2 class="mb-4 text-center">
                <?php
                    if(!isset($contatti_p_tit) || $contatti_p_tit == ''){
                        echo "Contattaci";
                    } else {
                        echo $contatti_p_tit;
                    }
                ?>
            </h2>
            <div class="row g-4">
                <?php foreach ($contatti_p_cont as $pc_id) {
                    echo 
                    ('
                        <div class="col-md-6 col-xl-4">                        
                        <div class="cmp-card-simple card-wrapper pb-0 rounded">
                    ');
                    get_template_part("template-parts/punto-contatto/card");
                    echo 
                    ('
                        </div>
                        </div>
                    ');
                } ?>
            </div>
            
        <?php } ?>
    </div>