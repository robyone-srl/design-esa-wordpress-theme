<?php
global $luogo, $showTitle, $showPermalink, $showParent;
$prefix = '_dci_luogo_';
$c=0;

$post_title = $luogo->post_title;
$permalink = get_permalink($luogo);

$childof = dci_get_meta("childof", $prefix, $luogo->ID);

if(!empty($childof)) {
    $childofwhile = $childof;
    while(!empty($childofwhile)) {
        $posizione_gps = dci_get_meta("posizione_gps", $prefix, $childof);
        $indirizzo = dci_get_meta("indirizzo", $prefix, $childof);
        $quartiere = dci_get_meta("quartiere", $prefix, $childof);
        $circoscrizione = dci_get_meta("circoscrizione", $prefix, $childof);
        $childofwhile = dci_get_meta("childof", $prefix, $childof);
    }  
} else {
    $posizione_gps = dci_get_meta("posizione_gps", $prefix, $luogo->ID);
    $indirizzo = dci_get_meta("indirizzo", $prefix, $luogo->ID);
    $quartiere = dci_get_meta("quartiere", $prefix, $luogo->ID);
    $circoscrizione = dci_get_meta("circoscrizione", $prefix, $luogo->ID);
}

?>

<div class="card card-bg rounded mt-4 no-after">
    <div class="card-header">
        <?php if($showTitle) { ?>
        <div class="card-title h6">
            <?php if($showTitle) { 
                echo '<p class="mb-0">';
                echo $showPermalink ? '<a href="' . get_permalink($luogo)  . '">':'';
                echo $post_title;
                echo $showPermalink ? '</a>':'';
                if($childof && !$showParent) {
                    echo '<small class="d-block">di ' . get_the_title($childof)  . '</small>';
                }
                echo "</p>";
            } ?>

        </div>
            <?php
        } ?>
            <?php if($childof && $showParent) {
                echo "<p>";
                echo '<span class="d-block">Questo luogo fa parte di: </span>';
                    ?><a href="<?php echo get_permalink($childof); ?>" data-focus-mouse="false">
                         <?php echo get_the_title($childof); ?>
                    </a><?php
                echo "</p>";
            }

        if(isset($indirizzo) && $indirizzo != ""){ ?>
			<div class="d-block"><?php echo $indirizzo; ?></div>
		<?php } ?>

        <?php if($quartiere || $circoscrizione) { ?>
            <small class="d-block"><?php echo $quartiere; ?> <?php if($quartiere && $circoscrizione) { echo "-"; } ?> <?php echo $circoscrizione; ?></small>
        <?php } ?>

        <?php if(isset($cap) && $cap != ""){ ?>
			<div class="location-title">
			    <span><?php _e( "CAP", "design_comuni_italia" ); ?></span>
            </div>
            <div class="location-content">
                <p><?php echo $cap; ?></p>
            </div>
		<?php } ?>
	</div><!-- /card-header -->

    <div class="card-body p-0">
        <div class="map-wrapper">
            <div class="map" id="map_all"></div>
        </div>
	</div><!-- /card-body -->

    <script>
        jQuery(function() {
            var mymap = L.map('map_all', {
                zoomControl: true,
                scrollWheelZoom: false
            }).setView([<?php echo $posizione_gps["lat"]; ?>, <?php echo $posizione_gps["lng"]; ?>], 13);

            let marker;
            marker = L.marker([<?php echo $posizione_gps["lat"]; ?>, <?php echo $posizione_gps["lng"]; ?>, { title: '<?php echo addslashes($post_title); ?>'}]).addTo(mymap);
            marker.bindPopup('<b><a href="<?php echo $permalink ?>"><?php echo addslashes($post_title); ?></a></b><br><?php echo addslashes($indirizzo); ?><br /><a title="Indicazioni stradali di <?php echo addslashes($indirizzo); ?>" href="https://www.google.com/maps/dir/<?php echo $posizione_gps["lat"]; ?>,<?php echo $posizione_gps["lng"]; ?>/@<?php echo $posizione_gps["lat"]; ?>,<?php echo $posizione_gps["lng"]; ?>,15z?hl=it">Indicazioni stradali su Google Maps</a>');

            // add the OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '',
                maxZoom: 18,
            }).addTo(mymap);

            var arrayOfMarkers = [ [ <?php echo $posizione_gps["lat"]; ?>, <?php echo $posizione_gps["lng"]; ?>] ];
            var bounds = new L.LatLngBounds(arrayOfMarkers);
            mymap.fitBounds(bounds);
        });
    </script>

    <div class="card-footer py-3 mb-0">
        <svg class="icon">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-map-marker"></use>
        </svg>
        <a title="Indicazioni stradali di <?php echo addslashes($indirizzo); ?>" href="https://www.google.com/maps/dir/<?php echo $posizione_gps["lat"]; ?>,<?php echo $posizione_gps["lng"]; ?>/@<?php echo $posizione_gps["lat"]; ?>,<?php echo $posizione_gps["lng"]; ?>,15z?hl=it">Indicazioni stradali su Google Maps</a>
    </div>
</div>

    