<?php
global $should_have_grey_background;

$tipo_visualizzazione_servizi = dci_get_option('categorie_esplora_tipo', 'servizi');
if($tipo_visualizzazione_servizi == 'filtro'){
    $categorie_servizio_ids = dci_get_option('categorie_esplora', 'servizi');
}else {
	$categorie_servizio_ids = array_column(get_terms(
    array(
        'taxonomy' => 'categorie_servizio',
        'hide_empty' => false
    )
    ), 'term_id');
}
?>
<div class="<?= !($should_have_grey_background=(!$should_have_grey_background)) ? 'bg-grey-dsk':'' ?>">
    <div class="container py-5">
        <h2 class="title-xxlarge mb-4">Esplora per categoria</h2>
        <div class="row g-4">
            <?php foreach ($categorie_servizio_ids as $categoria_servizio_id) {
                
                $categoria = get_term_by('term_id', $categoria_servizio_id, 'categorie_servizio');
                $url = get_term_link($categoria->term_id, 'categorie_servizio');
            ?>
                <div class="col-md-6 col-xl-4">
                    <div class="cmp-card-simple card-wrapper pb-0 rounded border border-light">
                        <div class="card bg-white shadow-sm rounded">
                            <div class="card-body">
                                <a class="text-decoration-none" href="<?php echo $url; ?>" data-element="service-category-link">
                                    <h3 class="card-title t-primary"><?php echo $categoria->name; ?></h3>
                                </a>
                                <p class="text-secondary mb-0">
                                    <?php echo $categoria->description; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>