<?php
global $i;

$description = dci_get_wysiwyg_field('risposta'); 
?>


<div class="accordion-item rounded">
    <div class="accordion-header" id="headingfaq-<?php echo $i; ?>">
        <button class="accordion-button collapsed title-snall-semi-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefaq-<?php echo $i; ?>" aria-expanded="true" aria-controls="collapsefaq-<?php echo $i; ?>">
            <span class="button-wrapper">
                <span class="h5"> <?php echo $post->post_title; ?> </span>
                <span class="icon-wrapper">
                    <svg class="icon icon-xs me-1 icon-primary">
                    <use href="#" xlink:href="#"></use>
                    </svg>
                </span>
            </span>
        </button>
    </div>                    
    <div id="collapsefaq-<?php echo $i; ?>" class="accordion-collapse collapse p-0" data-bs-parent="#accordionExamplefaq-1" role="region" aria-labelledby="headingfaq-<?php echo $i; ?>">
        <div class="accordion-body">                    
            <div class="mb-3">
                <?php echo $description; ?>
            </div>
            <div class="mt-5"> <?php
                get_template_part("template-parts/domanda-frequente/contenuti-evidenza"); ?>
            </div>
        </div>                            
    </div>
</div>  
