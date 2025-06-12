<?php
global $post, $luogo_option_name;
$c=0;
$luogo_option_name ??= 'luogo_custom';

$nome_luogo_custom = trim(dci_get_meta("nome_$luogo_option_name"));
$posizione_gps =  dci_get_meta("posizione_gps_$luogo_option_name");
$indirizzo_luogo_custom = trim(dci_get_meta("indirizzo_$luogo_option_name"));
$arrq = array();
if(trim(dci_get_meta("quartiere_$luogo_option_name")))
	$arrq[]=dci_get_meta("quartiere_$luogo_option_name");
if(trim(dci_get_meta("circoscrizione_$luogo_option_name")))
	$arrq[]=dci_get_meta("circoscrizione_$luogo_option_name");
?>


<?php if($nome_luogo_custom || $indirizzo_luogo_custom || !empty($arrq)) { ?>

<div class="card card-bg rounded mb-0 no-after">
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
	<div class="card-footer py-3">
		<svg class="icon">
			<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-map-marker"></use>
		</svg>
		<a title="Indicazioni stradali di <?php echo addslashes($indirizzo); ?>" href="https://www.google.com/maps/dir/<?php echo $posizione_gps["lat"]; ?>,<?php echo $posizione_gps["lng"]; ?>/@<?php echo $posizione_gps["lat"]; ?>,<?php echo $posizione_gps["lng"]; ?>,15z?hl=it">Indicazioni stradali su Google Maps</a>
	</div>
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