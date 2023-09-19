<?php
global $servizio, $should_have_grey_background;
$categorie = dci_get_option('categorie_banner_secondario', 'servizi') ?: [];
$titolo = dci_get_option('titolo_banner_secondario', 'servizi');

$tax_query = array();

foreach ($categorie as $categoria) {

    $tax = array(
        'taxonomy' => 'categorie_servizio',
        'field' => 'slug',
        'terms' => $categorie,
    );
    array_push($tax_query, $tax);
}

if (count($categorie) > 1) {
    $tax_query["relation"] = "OR";
}

$args = array(
    'nopaging' => true,
    'post_type' => 'servizio',
    'tax_query' => $tax_query,
    'orderby' => 'post_title',
    'order' => 'ASC'
);

$the_query = new WP_Query($args);


if (count($categorie) > 0) {
    $servizi = $the_query->posts;
}

if (!empty($servizi)) {
?>
    <div class="py-5 <?= !($should_have_grey_background=(!$should_have_grey_background)) ? 'bg-grey-dsk':'' ?>">
        <div class="container">
            <h2 class="title-xxlarge mb-4"><?= $titolo ?: "Servizi inclusi" ?></h2>
            <ul class="row g-4">
                <?php
                    foreach ($servizi as $servizio_id) {
                        ?>
                        <li class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <?php
                            $servizio = get_post($servizio_id);
                            get_template_part("template-parts/servizio/card-con-icona");
                            ?>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </div>
<?php } ?>