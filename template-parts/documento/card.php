<?php
global $documento;

$url = get_permalink($documento->ID);
?>
<div class="card card-teaser shadow-sm p-4s rounded border border-light flex-nowrap">
    <svg class="icon" aria-hidden="true"> 
        <use xlink:href="#it-clip"></use>
    </svg>
    <div class="card-body">
        <h3 class="card-title h5">
            <a class="text-decoration-none" href="<?php echo $url; ?>" aria-label="Vai al documento <?php echo $documento->post_title; ?>" title="Vai al documento <?php echo $documento->post_title; ?>">
                <?php echo $documento->post_title; ?>
            </a>
        </h3>
        <div class="card-text">
            <p>
                <?php echo dci_get_meta('descrizione_breve','_dci_documento_pubblico_',$documento->ID); ?>
            </p>
        </div>
    </div>
</div>