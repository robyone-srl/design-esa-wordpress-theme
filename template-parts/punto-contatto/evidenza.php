<?php
    global $custom_style;
    $custom_style = 1;

    $posts_evidenza = dci_get_meta('contatti_evidenza', '_dci_page_');

    if (is_array($posts_evidenza) && count($posts_evidenza)) {
?>

<div class="bg-grey-card pb-5">
    <div class="container">
        <h2 class="title-xxlarge mb-4">
        Contatti in evidenza
        </h2>
        <div class="row g-4"> <?php 
            foreach ($posts_evidenza as $post_id) { 
                $contatto = get_post($post_id);
                if(isset($contatto)){
                    $post = get_post($post_id); ?>
                    <div class="col-md-6 col-lg-4">
                        <?php get_template_part( 'template-parts/punto-contatto/card'); ?>
                    </div> <?php 
                }
            } ?>
        </div>
    </div>
</div>
<?php } ?>