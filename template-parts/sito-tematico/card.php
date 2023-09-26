<?php
global $sito_tematico_id, $count; 

$sito_tematico = get_post($sito_tematico_id);
$prefix = '_dci_sito_tematico_';
$st_descrizione = dci_get_meta('descrizione_breve', $prefix, $sito_tematico->ID);
$st_link = dci_get_meta('link',$prefix, $sito_tematico->ID);
$st_colore = dci_get_meta('colore',$prefix, $sito_tematico->ID);
$st_img = dci_get_meta('immagine',$prefix, $sito_tematico->ID);

if ($count % 3 == 0) $bg_color = 'blue';
if ($count % 3 == 1) $bg_color = 'warning';
if ($count % 3 == 2) $bg_color = 'dark';

$mostra_sfondo = dci_get_option('siti_tematici_sfondi', 'homepage') ?? false;
?>

<a href="<?php echo $st_link ?>" class="card card-teaser card-bg-<?= $mostra_sfondo ? $bg_color: '' ?> rounded mt-0 p-3 shadow-sm border border-light" target="_blank">
    <?php if($st_img) { ?>
        <div class="avatar size-lg me-3">
            <?php dci_get_img($st_img); ?>
        </div>
    <?php } ?>
    <div class="card-body">
        <h3 class="card-title sito-tematico <?= $mostra_sfondo ? 'text-white': '' ?>">
            <?php echo $sito_tematico->post_title ?>
        </h3>
        <p class="card-text text-sans-serif  <?= $mostra_sfondo ? 'text-white': '' ?>">
            <?php echo $st_descrizione; ?>
        </p>
    </div>
</a>