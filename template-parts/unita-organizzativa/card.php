<?php
    global $uo_id, $with_border;
    $ufficio = get_post( $uo_id );

    $prefix = '_dci_unita_organizzativa_';
	$descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $ufficio->ID);

    $img = get_the_post_thumbnail_url($ufficio->ID);

    if($with_border) {
?>

<div class="card card-teaser card-teaser-info rounded shadow-sm p-3 mb-2">
    <div class="card-body pe-3">
        <h4 class="card-title text-paragraph-regular-medium-semi mb-3">
            <a class="text-decoration-none" href="<?php echo get_permalink($ufficio->ID); ?>" data-element="service-area">
            <?php echo $ufficio->post_title; ?>
            </a>
        </h4>
	   <?php if ($descrizione_breve) {
		        echo '<div class="card-text"><p class="u-main-black">'.$descrizione_breve.'</p></div>';
	   } ?>
    </div>
    <?php if ($img) { ?>
        <div class="avatar size-xl">
            <?php dci_get_img($img); ?>
        </div>
    <?php } ?>
</div>
<?php } else { ?>
<div class="card card-teaser border rounded shadow p-4">
    <div class="card-body pe-3">
        <h4 class="u-main-black mb-1 title-small-semi-bold-medium">
            <a class="text-decoration-none" href="<?php echo get_permalink($ufficio->ID); ?>">
            <?php echo $ufficio->post_title; ?>
            </a>
        </h4>
	   <?php if ($descrizione_breve) {
		        echo '<div class="card-text"><p class="u-main-black">'.$descrizione_breve.'</p></div>';
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