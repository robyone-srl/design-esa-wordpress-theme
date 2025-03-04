<?php
global $post;

$prefix = '_dci_servizio_';
$categorie = get_the_terms($post->ID, 'categorie_servizio');
$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $post->ID);

if($post->post_status == "publish") {
    ?>
        <div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0 p-3">
            <div class="content aling-top">
                <span class="visually-hidden">Categoria:</span>
                <div class="card-header border-0">
                    <?php if (is_array($categorie) && count($categorie)) {
                        $count = 1;
                        foreach ($categorie as $categoria) {
                            echo $count == 1 ? '' : ' - ';
                            echo '<a class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase" href="'.get_term_link($categoria->term_id).'">';
                            echo $categoria->name ; 
                            echo '</a>';
                            ++$count;
                        }
                    } ?>
                </div>
                <div class="card-body px-3 pb-3">
                    <h4 class="card-title text-paragraph-medium u-grey-light">
                        <a class="text-decoration-none" href="<?php echo get_permalink($post->ID); ?>" data-element="service-link"><?php echo $post->post_title; ?></a>
                    </h4>
                    <p class="text-paragraph-card u-grey-light m-0"><?php echo $descrizione_breve; ?></p>
                </div>
            </div>
        </div>
    <?php
}