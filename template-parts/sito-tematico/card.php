<?php
global $sito_tematico_id;

$sito_tematico = get_post($sito_tematico_id);
$prefix = '_dci_sito_tematico_';
$st_descrizione = dci_get_meta('descrizione_breve', $prefix, $sito_tematico->ID);
$st_link = dci_get_meta('link',$prefix, $sito_tematico->ID);
$st_colore = dci_get_meta('colore',$prefix, $sito_tematico->ID);
$st_img = dci_get_meta('immagine',$prefix, $sito_tematico->ID);

$colore_sfondo = dci_get_meta('colore',$prefix, $sito_tematico->ID) ?: false;
$sfondo_scuro = $colore_sfondo ? is_this_dark_hex($colore_sfondo) : true;
?>

<a href="<?php echo $st_link ?>" style="<?= ($colore_sfondo) ? 'background-color:'.$colore_sfondo : '' ?>" class="card card-teaser <?= $colore_sfondo ? '' : 'bg-primary' ?> rounded mt-0 p-3 shadow-sm border border-light" target="_blank">
    <?php if($st_img) { ?>
        <div class="logo-sito-tematico size-xl bg-none me-3">
            <?php dci_get_img($st_img); ?>
        </div>
    <?php } ?>
    <div class="card-body">
        <h3 class="card-title sito-tematico titolo-sito-tematico <?= $sfondo_scuro ? 'text-white':'text-dark' ?>">
            <?php echo $sito_tematico->post_title ?>
        </h3>
        <p class="card-text text-sans-serif <?= $sfondo_scuro ? 'text-white':'' ?>">
            <?php echo $st_descrizione; ?>
        </p>
    </div>
</a>