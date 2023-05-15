<?php
global $inc_id, $conclusione_incarico_pp;
$prefix = '_dci_incarico_';

$incarico = get_post($inc_id);
$tipo_incarico = wp_get_object_terms( $inc_id,  'tipi_incarico' );
$data_inizio_incarico = dci_get_meta('data_inizio_incarico', $prefix, $inc_id);
$data_conclusione_incarico = dci_get_meta('data_conclusione_incarico', $prefix, $inc_id);
$responsabile_struttura = dci_get_meta('responsabile_struttura', $prefix, $inc_id);

$unita_organizzativa = dci_get_meta('unita_organizzativa', $prefix, $inc_id);

if($unita_organizzativa != "") {
    $unita_organizzativa = get_post($unita_organizzativa);
}

$locale = setlocale(LC_ALL, 'it_IT@euro', 'it_IT', 'it', 'it');
?>

<div class="card card-teaser card-teaser-info rounded shadow-sm p-4 me-3">
    <div class="card-body pe-3">
        <h5 class="card-title">
            <?php echo $incarico->post_title; ?>
        </h5>
        <div class="card-text">
            <p>Incarico <?php echo strtolower($tipo_incarico[0]->name); ?>
            <?php 
            if($unita_organizzativa != "") {
                echo " presso ". $unita_organizzativa->post_title;

                $sede_principale_uo = dci_get_meta('sede_principale', '_dci_unita_organizzativa_', $unita_organizzativa->ID);
                if($sede_principale_uo != "") {
                    $sede_principale_uo = get_post($sede_principale_uo);

                    echo " di ". $sede_principale_uo->post_title;
                }
            }
            ?>
             </p>

            <?php if($data_inizio_incarico != "") {?>
                <p><strong>Inizio:</strong> <?php echo strftime('%d %B %Y',$data_inizio_incarico); ?></p>
            <?php } ?>

            <?php if($data_conclusione_incarico != "") {?>
                <p><strong>Conclusione:</strong> <?php echo strftime('%d %B %Y',$data_conclusione_incarico); ?></p>
            <?php } ?>
        </div>
    </div>
</div>