<?php
global $incarico, $documento, $url, $url_label;
$prefix = '_dci_incarico_';

$incarico_post = get_post($incarico);
$inc_id = $incarico_post->ID;

$tipo_incarico = get_the_terms($inc_id, "tipi_incarico");
$data_inizio_incarico = dci_get_meta('data_inizio_incarico', $prefix, $inc_id);
$data_insediamento = dci_get_meta('data_insediamento', $prefix, $inc_id);
$data_conclusione_incarico = dci_get_meta('data_conclusione_incarico', $prefix, $inc_id);
$responsabile_struttura = dci_get_meta('responsabile_struttura', $prefix, $inc_id);

$compensi = dci_get_wysiwyg_field("compensi", $prefix, $inc_id);
$importi_viaggi_servizi = dci_get_wysiwyg_field("importi_viaggi_servizi", $prefix, $inc_id);
$ulteriori_informazioni = dci_get_wysiwyg_field("ulteriori_informazioni", $prefix, $inc_id);

$atto_nomina = dci_get_meta("atto_nomina", $prefix, $inc_id);

$unita_organizzativa = dci_get_meta('unita_organizzativa', $prefix, $inc_id);

$url_trasparenza = dci_get_meta("url_trasparenza", $prefix, $inc_id);

if($unita_organizzativa != "") {
    $unita_organizzativa = get_post($unita_organizzativa);
}

$locale = setlocale(LC_ALL, 'it_IT@euro', 'it_IT', 'it', 'it');
?>

<div class="card card-teaser card-teaser-info rounded shadow-sm p-4 me-3">
    <div class="card-body pe-3">
        <h5 class="card-title">
            <?php echo $incarico_post->post_title; ?>
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

             <?php if($url_trasparenza != "") {?>
                <div class="pt-2 mt-2">
                                <?php 
                                      $url = $url_trasparenza;
                                      $url_label = "Scheda dedicata in Amministrazione Trasparente";
                                      get_template_part("template-parts/documento/url");
                                ?>
                            </div>
            <?php } ?>

             <?php if($atto_nomina != "") {?>
                <div class="pt-2 mt-2">
                    <?php 
                        $documento = get_post($atto_nomina);       
                        get_template_part("template-parts/documento/card-ico");
                    ?>
                </div>
            <?php } ?>

             <?php if($data_inizio_incarico != "" || $data_insediamento != "" || $data_conclusione_incarico != "") {?>
                <div class="border-top pt-2 mt-3 mb-3">
                    <h6>Periodo di svolgimento</h6>

                    <?php if($data_inizio_incarico != "") {?>
                    <p class="mb-0"><strong>Inizio:</strong> <?php echo printDateTime('d LLLL Y', $data_inizio_incarico); ?></p>
                    <?php } ?>

                    <?php if($data_insediamento != "") {?>
                        <p class="mb-0"><strong>Insediamento:</strong> <?php echo printDateTime('d LLLL Y', $data_insediamento); ?></p>
                    <?php } ?>

                    <?php if($data_conclusione_incarico != "") {?>
                        <p class="mb-0"><strong>Conclusione:</strong> <?php echo printDateTime('d LLLL Y', $data_conclusione_incarico); ?></p>
                    <?php } ?>
                </div>
            <?php } ?>


            <?php if($compensi != "") {?>
                <div class="border-top pt-2 mt-2"><h6>Compensi:</h6> <?php echo $compensi; ?></div>
            <?php } ?>

            <?php if($importi_viaggi_servizi != "") {?>
                <div class="border-top pt-2 mt-2"><h6>Importi di viaggi e/o servizio:</h6> <?php echo $importi_viaggi_servizi; ?></div>
            <?php } ?>


            <?php if($ulteriori_informazioni != "") {?>
                <div class="border-top pt-2 mt-2"><h6>Ulteriori informazioni:</h6> <?php echo $ulteriori_informazioni; ?></div>
            <?php } ?>
        </div>
    </div>
</div>