<?php
global $post, $title_level;

$prefix = '_dci_unita_organizzativa_';
$descrizione_breve = dci_get_meta('descrizione_breve');

$img = get_the_post_thumbnail_url();
$contatti = dci_get_meta('contatti');

$prefix = '_dci_punto_contatto_';
$indirizzi = array();
foreach ($contatti ?? null as $punto_contatto_id) {
    $voci = dci_get_meta('voci', $prefix, $punto_contatto_id);
    foreach ($voci as $voce) {
        if ($voce[$prefix.'tipo_punto_contatto'] == 'indirizzo')
            array_push($indirizzi, $voce[$prefix.'valore']);
    }
}

if($title_level == "") $title_level = 4;
?>

<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-teaser border rounded shadow p-4 h-100">
        <div class="card-body pe-3">
            <h<?php echo $title_level; ?> class="u-main-black mb-1 title-small-semi-bold-medium">
                <a class="text-decoration-none" href="<?php echo get_permalink($post->ID); ?>">
                    <?php echo $post->post_title; ?>
                </a>
            </h<?php echo $title_level; ?>>
            <div class="card-text">
                <?php if ($descrizione_breve) {
                          echo '<p class="u-main-black">'.$descrizione_breve.'</p>';
                      } ?>
                <?php foreach ($indirizzi as $indirizzo) {
                          echo '<p>'.$indirizzo.'</p>';
                      }?>
            </div>
        </div>
        <?php if ($img) { ?>
        <div class="avatar size-xl">
            <?php dci_get_img($img); ?>
        </div>
        <?php } ?>
    </div>
</div>
