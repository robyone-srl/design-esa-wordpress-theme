<?php

global $pp_id, $with_border, $hide_incarichi, $title_level;

$persona = get_post($pp_id);

$prefix = '_dci_persona_pubblica_';
$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $persona->ID);
$foto = dci_get_meta('foto', $prefix, $persona->ID);

$punti_contatto = dci_get_meta('punti_contatto', $prefix, $persona->ID);
$contatti = array();
foreach ($punti_contatto as $pc_id) {
    $contatto = dci_get_full_punto_contatto($pc_id);
    array_push($contatti, $contatto);
}
$other_contacts = array(
    'linkedin',
    'skype',
    'telegram',
    'twitter',
    'whatsapp'
);

$inc_args = array(
    'post_type' => 'incarico',
    'meta_query' => array(
        array(
            'key'     => '_dci_incarico_persona',
            'value'   => $persona->ID
        ),
    ),
    'numberposts' => -1,
    'post_status' => 'publish',
    'orderby' => 'post_title',
    'order' => 'ASC',
);
$inc_query = new WP_Query($inc_args);
$inc_list = get_posts($inc_args);

$incarichi = array();

if(!$hide_incarichi){
    foreach ($inc_list as $incarico) {
        array_push($incarichi, $incarico->post_title);
    }
}

$incarichi = array_unique($incarichi);

if($title_level == "") $title_level = 4;
?>

<div class="card card-teaser <?= $with_border ? 'border border-light shadow-sm' : 'shadow' ?> rounded p-4">
    <div class="card-body pe-3 flex-nowrap">
        <h<?php echo $title_level; ?> class="u-main-black mb-1 title-small-semi-bold-medium cart-title">
            <a class="text-decoration-none" href="<?php echo get_permalink($persona->ID); ?>">
                <?php echo $persona->post_title; ?>
            </a>
        </h<?php echo $title_level; ?>>
        <div class="card-text">
            <?php
            if ($descrizione_breve) {
                echo $descrizione_breve;
            } else {
                echo implode(', ', $incarichi);
            }
            ?>
        </div>

        <div class="card-text" data-element="service-area">
            <?php foreach ($contatti as $full_contatto) { ?>
                <div class="card-text my-3">
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
                                <a target="_blank" aria-label="scopri di più su <?php echo $dati['valore']; ?> - link esterno - apertura nuova scheda" title="vai sul sito <?php echo $dati['valore']; ?>" href="<?php echo $dati['valore']; ?>">
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
                    <?php if (array_key_exists('pec', $full_contatto) && is_array($full_contatto['pec']) && count($full_contatto['pec'])) {
                        foreach ($full_contatto['pec'] as $dati) { ?>
                            <p>
                                Posta elettronica certificata (PEC):
                                <a aria-label="invia un'email PEC a <?php echo $dati['valore']; ?>" title="invia un'email PEC a <?php echo $dati['valore']; ?>" href="mailto:<?php echo $dati['valore']; ?>">
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
    <div class="avatar size-xl">
        <?php if ($foto) { ?>
        <?php dci_get_img($foto);
        } else {
        ?>
            <svg class="icon svg-marker-simple">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-user"></use>
            </svg>
        <?php } ?>
    </div>
</div>
<?php
$with_border = false;
?>