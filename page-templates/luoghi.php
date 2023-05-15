<?php
/* Template Name: Luoghi
 *
 * Servizi template file
 *
 * @package Design_Comuni_Italia
 */
global $luogo, $with_shadow;
$search_url = esc_url( home_url( '/' ));
get_header();

$mappa_primo_piano = dci_get_option("posizione_mappa", "luoghi") === 'true' ? true : false;
$arr_luoghi = array();
$c=0;

?>
<main>
    <?php

    get_template_part("template-parts/hero/hero");
    if($mappa_primo_piano) {
        // recupero la lista delle tipologie
        $i=0;
        $locations = [];

        $filtro_tipi_luoghi = dci_get_option("strutture_luoghi", "luoghi");
        $tipi_luogo = get_terms('tipi_luogo' );
        $tipi_luogo = array_filter($tipi_luogo, function($e) use($filtro_tipi_luoghi){
            return in_array($e->slug, $filtro_tipi_luoghi);
        });

    ?>
            <section class="section bg-white section-map-wrapper">
                <div class="map-aside ps-container ps-theme-default ps-active-y">
                    <?php
                        foreach($tipi_luogo as $tipo){
                            $args = array(
                                'post_type' => 'luogo',
                                'tax_query' => array(array(
                                    'taxonomy' => 'tipi_luogo',
                                    'field' => 'slug',
                                    'terms' => $tipo,
                                    'include_children' => false
                                )),
                            );

                            $the_query = new WP_Query( $args );
                            //var_dump($the_query->request);

                            $luoghi = $the_query->posts;
                            if (is_array($luoghi) && count($luoghi) > 0) {
                                ?>
                                <h2 class="h3">
                                    <?php echo $tipo->name; ?>
                                </h2>
                    <?php
                                    foreach ($luoghi as $luogo) {
                                        $posizione_gps = dci_get_meta("posizione_gps", "_dci_luogo_", $luogo->ID);
                                        $indirizzo = dci_get_meta("indirizzo", '', $luogo->ID);
                                        $prefix = '_dci_luogo_';

                                        $posizione_gps = dci_get_meta("posizione_gps", $prefix, $luogo->ID);
                                        if ($posizione_gps && $posizione_gps["lat"] && $posizione_gps["lng"]) {
                                            $indirizzo = dci_get_meta("indirizzo", $prefix, $luogo->ID);
                                            $arr_luoghi[$c]["post_title"] = $luogo->post_title;
                                            $arr_luoghi[$c]["permalink"] = get_permalink($luogo);
                                            $arr_luoghi[$c]["gps"] = $posizione_gps;
                                            $arr_luoghi[$c]["indirizzo"] = $indirizzo;
                                            $c++;
                                        }

                                        get_template_part("template-parts/luogo/card-title");
                                    }
                            }
                        }
                    ?>
                </div>
                <div class="map-wrapper">
                    <div class="map_all" id="map_all"></div>
                </div>
            </section>
    <!-- /section -->
    <script>
        jQuery(function() {
            var mymap = L.map('map_all', {
                zoomControl: true,
                scrollWheelZoom: false
            }).setView([<?php echo $arr_luoghi[0]["gps"]["lat"]; ?>, <?php echo $arr_luoghi[0]["gps"]["lng"]; ?>], 13);

            let marker;
            <?php foreach ($arr_luoghi as $marker){ ?>

            marker = L.marker([<?php echo $marker["gps"]["lat"]; ?>, <?php echo $marker["gps"]["lng"]; ?>, { title: '<?php echo addslashes($marker["post_title"]); ?>'}]).addTo(mymap);
            marker.bindPopup('<b><a href="<?php echo $marker["permalink"] ?>"><?php echo addslashes($marker["post_title"]); ?></a></b><br><?php echo addslashes($marker["indirizzo"]); ?>');

            <?php } ?>

            // add the OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '',
                maxZoom: 18,
            }).addTo(mymap);

            var arrayOfMarkers = [<?php foreach ($arr_luoghi as $marker){ ?> [ <?php echo $marker["gps"]["lat"]; ?>, <?php echo $marker["gps"]["lng"]; ?>], <?php } ?>];
            var bounds = new L.LatLngBounds(arrayOfMarkers);
            mymap.fitBounds(bounds);
        });
    </script>
    <?php
    }

    get_template_part("template-parts/luogo/tutti");

    ?>

</main>

<?php
get_footer();
