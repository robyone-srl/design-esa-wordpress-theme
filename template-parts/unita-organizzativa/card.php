<?php
    global $uo_id, $with_border, $mostra_dettagli_sede, $h100, $title_level;
    $ufficio = get_post( $uo_id );

    $prefix = '_dci_unita_organizzativa_';
	$descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $ufficio->ID);

    $img = get_the_post_thumbnail_url($ufficio->ID);

    if($title_level == "") $title_level = 4;

    if($with_border) {
?>

<div class="card card-teaser card-teaser-info rounded shadow-sm py-3 mb-2 mt-0<?php echo $h100==true ? "h-100" : ""; ?>">
    <div class="card-body pe-3">
        <h<?php echo $title_level; ?> class="card-title text-paragraph-regular-medium-semi">
            <a class="text-decoration-none" href="<?php echo get_permalink($ufficio->ID); ?>" data-element="service-area">
            <?php echo $ufficio->post_title; ?>
            </a>
        </h<?php echo $title_level; ?>>
	   <?php if ($descrizione_breve && $mostra_dettagli_sede) {
		        echo '<div class="card-text mt-2"><p class="u-main-black">'.$descrizione_breve.'</p></div>';
	   } ?>
    </div>
    <?php if ($img) { ?>
    <div class="avatar size-xl">
        <?php dci_get_img($img); ?>
    </div>
    <?php } ?>
</div>

<?php } else { ?>

<div class="card card-teaser card-teaser-info rounded shadow-sm ps-3 pe-3 mb-2 flex-nowrap">
    <div class="card-body pe-3">
        <h<?php echo $title_level; ?> class="card-title text-paragraph-regular-medium-semi">
            <a class="text-decoration-none" href="<?php echo get_permalink($ufficio->ID); ?>" data-element="service-area">
            <?php echo $ufficio->post_title; ?>
            </a>
        </h<?php echo $title_level; ?>>
	   <?php if ($descrizione_breve && $mostra_dettagli_sede) {
		        echo '<div class="card-text mt-3"><p class="u-main-black">'.$descrizione_breve.'</p></div>';
	   } ?>
    </div>
    <?php if ($img) { ?>
        <div class="avatar size-xl">
            <?php dci_get_img($img); ?>
        </div>
    <?php } ?>
</div>

<?php } 
$with_border = false;
?>