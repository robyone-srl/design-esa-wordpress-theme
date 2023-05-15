<?php
global $luogo;
$prefix = '_dci_luogo_';
$c=0;

$posizione_gps = dci_get_meta("posizione_gps", $prefix, $luogo->ID);
$indirizzo = dci_get_meta("indirizzo", $prefix, $luogo->ID);
$post_title = $luogo->post_title;
$permalink = get_permalink($luogo);
$indirizzo = $indirizzo;

?>

<div class="card card-bg rounded mt-4 no-after">
    <div class="card-body p-0">
            <div class="map-wrapper">
                <div class="map" id="map_all"></div>
            </div>

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

    <div class="card-footer py-4 mb-0">
        <svg class="icon">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-map-marker"></use>
        </svg>
        <a title="Indicazioni stradali di <?php echo addslashes($indirizzo); ?>" href="https://www.google.com/maps/dir/<?php echo $posizione_gps["lat"]; ?>,<?php echo $posizione_gps["lng"]; ?>/@<?php echo $posizione_gps["lat"]; ?>,<?php echo $posizione_gps["lng"]; ?>,15z?hl=it">Indicazioni stradali su Google Maps</a>
    </div>
</div>

    