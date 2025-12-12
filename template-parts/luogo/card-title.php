<?php
global $luogo, $show_descrizione;

$prefix = '_dci_luogo_';

$card_title = $luogo->post_title;
$titleparent = null;
$descrizione_breve = dci_get_meta("descrizione_breve", $prefix, $luogo->ID);

$childof = dci_get_meta("childof", $prefix, $luogo->ID);

if(!empty($childof)) {
    $childofwhile = $childof;
    while(!empty($childofwhile)) {
		$titleparent = get_the_title( $childof );
		$indirizzo = dci_get_meta("indirizzo", $prefix, $childof);
        $childofwhile = dci_get_meta("childof", $prefix, $childof);
    }  
} else {
    $indirizzo = dci_get_meta("indirizzo", $prefix, $luogo->ID);
}

if($show_descrizione == '' || $show_descrizione == null) $show_descrizione = false;
?>

<div class="card card-teaser rounded border border-light shadow-sm mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-auto mt-1">
                <svg class="icon">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-map-marker"></use>
                </svg>
            </div>
            <div class="col">
                <div class="card-title">
                    <a href="<?php echo get_permalink($luogo); ?>">
                        <strong>
                            <?php echo $card_title; ?>
                        </strong>
                    </a>
                </div>
                <div class="card-text">
                    <small> <?php
                        if($show_descrizione){
                            echo $descrizione_breve;
                        } else {
							if($titleparent != null && $titleparent != "") echo "<strong>". $titleparent . "</strong><br />";
                            echo $indirizzo;
                        } ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

