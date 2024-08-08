<?php
global $uo_id, $with_border, $no_vertical_margin;
$ufficio = get_post($uo_id);

$prefix = '_dci_unita_organizzativa_';
$img = get_the_post_thumbnail_url($uo_id);
$punti_contatto = dci_get_meta('contatti', $prefix, $uo_id);

$prefix = '_dci_punto_contatto_';
$contatti = array();
foreach ($punti_contatto as $pc_id) {
    $contatto = dci_get_full_punto_contatto($pc_id);
    array_push($contatti, $contatto);
}
$other_contacts = array(
    'linkedin',
    'pec',
    'skype',
    'telegram',
    'twitter',
    'whatsapp'
);

$card_class = !$with_border ? "" : ("card-wrapper rounded shadow-sm h-auto pb-0 ".($no_vertical_margin?"":"my-5"));
$card_content_class = !$with_border ? ("card card-teaser shadow rounded ".($no_vertical_margin?"":"mt-3")) : "card card-teaser card-teaser-info rounded shadow-sm p-4";
$card_body_class = !$with_border ? "card-body" : "card-body pe-3";
$card_link_class = !$with_border ? "text-decoration-none" : "";

?>

<div class="<?php echo $card_class?>">
    <div class="<?php echo $card_content_class?>">
        <svg class="icon">
            <use xlink:href="#it-pa"></use>
        </svg>
        <div class="<?php echo $card_body_class?>">
            <h3 class="card-title h5">
                <a class="<?php echo $card_link_class?>" href="<?php echo get_permalink($ufficio->ID); ?>">
                    <?php echo $ufficio->post_title; ?>
                </a>
                </h5>
                <div class="card-text" data-element="service-area">
                    <?php foreach ($contatti as $full_contatto) { ?>
                        <div class="card-text mb-3">
                            <?php if (array_key_exists('indirizzo', $full_contatto) && is_array($full_contatto['indirizzo']) && count($full_contatto['indirizzo'])) {
                                echo '<div class="mb-3">';
                                foreach ($full_contatto['indirizzo'] as $dati) {
                                    echo '<p>' . $dati['valore'];
                                    if ($dati['dettagli']) {
                                        echo $dati['dettagli'];
                                    }
                                    echo '</p>';
                                }
                                echo '</div>';
                            } ?>
                            <?php if (array_key_exists('telefono', $full_contatto) && is_array($full_contatto['telefono']) && count($full_contatto['telefono'])) {
                                foreach ($full_contatto['telefono'] as $dati) {
                            ?>
                                    <p>
                                        Telefono:
                                        <a target="_blank" aria-label="contatta telefonicamente tramite il numero <?php echo $dati['valore']; ?>" title="chiama <?php echo $dati['valore']; ?>" href="tel:<?php echo $dati['valore']; ?>">
                                            <?php echo $dati['valore']; ?>
                                        </a>
                                        <?php echo $dati['dettagli']; ?>
                                    </p>
                            <?php
                                }
                            } ?>
                            <?php if (array_key_exists('url', $full_contatto) && is_array($full_contatto['url']) && count($full_contatto['url'])) {
                                foreach ($full_contatto['url'] as $dati) { ?>
                                    <p>
                                        Collegamento web:
                                        <a target="_blank" aria-label="scopri di pi첫 su <?php echo $dati['valore']; ?> - link esterno - apertura nuova scheda" title="vai sul sito <?php echo $dati['valore']; ?>" href="<?php echo $dati['valore']; ?>">
                                            <?php echo $dati['valore']; ?>
                                        </a>
                                        <?php echo $dati['dettagli']; ?>
                                    </p>
                            <?php }
                            } ?>
                            <?php if (array_key_exists('email', $full_contatto) && is_array($full_contatto['email']) && count($full_contatto['email'])) {
                                foreach ($full_contatto['email'] as $dati) { ?>
                                    <p>
                                        Email:
                                        <a target="_blank" aria-label="invia un'email a <?php echo $dati['valore']; ?>" title="invia un'email a <?php echo $dati['valore']; ?>" href="mailto:<?php echo $dati['valore']; ?>">
                                            <?php echo $dati['valore']; ?>
                                        </a>
                                        <?php echo $dati['dettagli']; ?>
                                    </p>
                            <?php }
                            } ?>
                            <?php foreach ($other_contacts as $type) {
                                if (array_key_exists($type, $full_contatto) &&  is_array($full_contatto[$type]) && count($full_contatto[$type])) {
                                    foreach ($full_contatto[$type] as $dati) {                        echo '<p>';
                                        if($icon = SOCIAL_ICONS[$type] ?? false)
                                        { ?>
                                            <svg class="icon icon-secondary icon-sm" aria-hidden="true">
                                                <use xlink:href="#<?= $icon ?>"></use>
                                            </svg>
                                            <span class="visually-hidden"><?= $type ?></span>
                                        <?php }
                                        else
                                            echo $type.': ';
                
                                        echo $dati['valore'].(trim($dati['dettagli']) ? '('.$dati['dettagli'].')' : '') .'</p>';
                                    }
                                }
                            } ?>
                        </div>
                    <?php } ?>
                </div>
        </div>
    </div>
</div>
<?php
$with_border = false;
$no_vertical_margin = false;
