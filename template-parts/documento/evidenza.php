<?php
    global $post;
    
    $original_post = $post;

    $has_elementi_evidenza = dci_get_option('contenuti_evidenziati', 'documenti');
    
    $contenuti_evidenza = is_array($has_elementi_evidenza) ? array_filter($has_elementi_evidenza) : [];
    
    if (count($contenuti_evidenza)) {
?>
<div class="container py-5">
    <h2 class="title-xxlarge mb-4">In evidenza</h2>
    <div class="row g-4">
        <?php foreach ($contenuti_evidenza as $post_id) { 
            $post = get_post($post_id);
            setup_postdata($post);
            
            $description = dci_get_meta('descrizione_breve', $post->ID);
            $tipo_documento = false;
            if ($post->post_type == "documento_pubblico") {
                $termini = get_the_terms($post->ID, 'tipi_documento');
                
                if (!empty($termini) && !is_wp_error($termini)) {
                    $tipo_documento = $termini[0];
                }
            }
        ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card-wrapper rounded shadow-sm border border-light pb-0">
                    <div class="card bg-none no-after">
                        <div class="card-body">
                            <div class="categoryicon-top">
                                <svg class="icon icon-sm" aria-hidden="true">
                                    <use href="#it-file"></use>
                                </svg>
                                <span class="text fw-semibold">
                                <?php if ($tipo_documento) { ?>
                                    <a class="text-decoration-none" href="<?php echo get_term_link($tipo_documento->term_id); ?>"><?php echo $tipo_documento->name; ?></a>
                                <?php } else if ($post->post_type == 'dataset') { ?>
                                    <a href="<?php echo get_post_type_archive_link( 'dataset' ); ?>">Dataset</a>
                                <?php } else { ?>
                                    <span>Contenuto</span> 
                                <?php } ?>
                                </span>
                            </div>
                            <a class="text-decoration-none" href="<?php echo get_permalink(); ?>">
                                <h3 class="card-title h4"><?php the_title(); ?></h3>
                            </a>
                            <p class="text-secondary mb-0"><?php echo $description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        }     
        $post = $original_post;
        wp_reset_postdata();
        ?>
    </div>
</div>
<?php } ?>