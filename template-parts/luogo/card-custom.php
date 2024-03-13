<?php
global $post;
$c=0;

$nome_luogo_custom = trim(dci_get_meta("nome_luogo_custom"));
$posizione_gps =  dci_get_meta("posizione_gps_luogo_custom");
$indirizzo_luogo_custom = trim(dci_get_meta("indirizzo_luogo_custom"));
$arrq = array();
if(trim(dci_get_meta("quartiere_luogo_custom")))
	$arrq[]=dci_get_meta("quartiere_luogo_custom");
if(trim(dci_get_meta("circoscrizione_luogo_custom")))
	$arrq[]=dci_get_meta("circoscrizione_luogo_custom");
?>


<?php if($nome_luogo_custom || $indirizzo_luogo_custom || !empty($arrq)) { ?>

<div class="card card-bg rounded mb-5">
	<div class="card-header">
		<strong class="d-block"><?php echo  $nome_luogo_custom; ?></strong>
		<small class="d-block"><?php echo  $indirizzo_luogo_custom; ?></small>
		<small class="d-block"><?php echo implode(" - ", $arrq);  ?></small>
	</div><!-- /card-header -->

	<div class="card-body p-0">
		<div class="row variable-gutters">
			<div class="col-lg-12">
				<div class="map-wrapper h-100">
					<div class="map h-100" id="map_<?php echo $c; ?>"></div>
				</div>
			</div><!-- /col-lg-12 -->
		</div><!-- /row -->
	</div><!-- /card-body -->
</div><!-- /card card-bg rounded -->

<script>
    jQuery(function() {
        var mymap = L.map('map_<?php echo $c; ?>', {
            zoomControl: false,
            scrollWheelZoom: false
        }).setView([<?php echo $posizione_gps["lat"]; ?>, <?php echo $posizione_gps["lng"]; ?>], 15);

        L.marker([<?php echo $posizione_gps["lat"]; ?>, <?php echo $posizione_gps["lng"]; ?>]).addTo(mymap);

        // add the OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '',
            maxZoom: 18,
        }).addTo(mymap);
    });
</script>
<?php } ?>