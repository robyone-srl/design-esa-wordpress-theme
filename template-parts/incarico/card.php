<?php
global $inc_id, $with_border, $card_wrapper;

$incarico = get_post($inc_id);

$prefix = '_dci_incarico_';
$tipo_incarico = get_the_terms($inc_id, "tipi_incarico")[0]->name;
$tipo_incarico = strtolower(trim($tipo_incarico)) == 'altro' ? '' : $tipo_incarico;
$data_inizio_incarico = dci_get_meta('data_inizio_incarico', $prefix, $inc_id);
$data_conclusione_incarico = dci_get_meta('data_conclusione_incarico', $prefix, $inc_id);
$responsabile_struttura = dci_get_meta('responsabile_struttura', $prefix, $inc_id);

$unita_organizzativa = dci_get_meta('unita_organizzativa', $prefix, $inc_id);

$persona_id = dci_get_meta('persona', '_dci_incarico_', $inc_id);
$persona = get_post( $persona_id );

if($unita_organizzativa != "") {
    $unita_organizzativa = get_post($unita_organizzativa);
}
?>

<div class="card card-teaser <?= $card_wrapper ? 'card-wrapper' : '' ?> <?= $with_border ? 'border border-light shadow-sm' : 'shadow' ?> rounded p-4">
    <div class="card-body pe-3">
        <h4 class="u-main-black mb-1 title-small-semi-bold-medium cart-title">
			<a class="text-decoration-none" href="<?php echo get_permalink($incarico->ID); ?>">
            	<?php echo $incarico->post_title; ?>
            </a>
        </h4>
        <h5 class="h6"><?php echo $persona->post_title; ?></h5>
        <div class="card-text">
            Incarico <?=$tipo_incarico; ?>
            <?php 
            if($unita_organizzativa != "") {
                echo " presso ". $unita_organizzativa->post_title;

                $sede_principale_uo = dci_get_meta('sede_principale', '_dci_unita_organizzativa_', $unita_organizzativa->ID);
                if($sede_principale_uo != "") {
                    $sede_principale_uo = get_post($sede_principale_uo);

                    echo " di ". $sede_principale_uo->post_title;
                }
            }

			if($data_inizio_incarico != "") {
            	if($data_conclusione_incarico != "" && $data_conclusione_incarico > time()) { 
                	echo " concluso in data " . printDateTime('d LLLL Y', $data_conclusione_incarico);
                } else if ($data_inizio_incarico < time()) {
                	echo " iniziato in data " . printDateTime('d LLLL Y', $data_inizio_incarico);
                } else {
                	echo " che inizierà in data " . printDateTime('d LLLL Y', $data_inizio_incarico);
                }
            }
            ?>
        </div>
    </div>
    <div class="avatar size-xl">
            <svg class="icon svg-marker-simple">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-bookmark"></use>
            </svg>
    </div>
</div>