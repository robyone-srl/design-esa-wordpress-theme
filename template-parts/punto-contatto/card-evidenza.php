<?php
global $pc_id, $title_level, $custom_style;
$prefix = '_dci_punto_contatto_';

$full_contatto = dci_get_full_punto_contatto($pc_id);
$contatto = get_post($pc_id);
$voci = dci_get_meta('voci', $prefix, $pc_id);

$other_contacts = array(
    'linkedin',
    'skype',
    'telegram',
    'twitter',
    'whatsapp'
);
$color = "";

if($title_level == "") $title_level = 3;

if($custom_style == "") $color = "info";
else $color = "dark";
if($custom_style == "none") $color = null;

?>
<div class="card card-teaser no-after rounded shadow-sm mb-0 border border-light">
    <div class="card-body pb-5">
        <div class="category-top">
            <span class="category title-xsmall-semi-bold fw-semibold" >Contatto</span>
        </div>
        <h<?php echo $title_level; ?> class="h3 card-title text-paragraph-medium u-grey-light">
            <?php echo $contatto->post_title; ?>
        </h<?php echo $title_level; ?>>
        <div class="card-text">
            <?php if (array_key_exists('indirizzo', $full_contatto) && is_array($full_contatto['indirizzo']) && count ($full_contatto['indirizzo']) ) {
                echo '<div class="mb-3">';
                foreach ($full_contatto['indirizzo'] as $dati) {
                    echo '<p>'.$dati['valore'];
                    if($dati['dettagli']) { echo $dati['dettagli']; }
                    echo '</p>';
                } 
                echo '</div>';
            } ?>
            <?php if (array_key_exists('telefono', $full_contatto) && is_array($full_contatto['telefono']) && count ($full_contatto['telefono']) ) {
                foreach ($full_contatto['telefono'] as $dati) {
                    ?>
                    <p>
                        Telefono: 
                        <a 
                        target="_blank" 
                        aria-label="contatta telefonicamente tramite il numero <?php echo $dati['valore']; ?>" 
                        title="chiama <?php echo $dati['valore']; ?>" 
                        href="tel:<?php echo $dati['valore']; ?>">
                            <?php echo $dati['valore']; ?>
                        </a>
                        <?php echo $dati['dettagli']; ?>
                    </p>
                    <?php
                }
            } ?>
            <?php if (array_key_exists('url', $full_contatto) && is_array($full_contatto['url']) && count ($full_contatto['url']) ) {
                foreach ($full_contatto['url'] as $dati) { ?>
                    <p>
                        Collegamento web:
                        <a 
                        target="_blank" 
                        aria-label="scopri di pi첫 su <?php echo $dati['valore']; ?> - link esterno - apertura nuova scheda" 
                        title="vai sul sito <?php echo $dati['valore']; ?>" 
                        href="<?php echo $dati['valore']; ?>">
                            <?php echo $dati['valore']; ?>
                        </a>
                        <?php echo $dati['dettagli']; ?>
                    </p>
               <?php }
            } ?>
            <?php if (array_key_exists('email', $full_contatto) && is_array($full_contatto['email']) && count ($full_contatto['email']) ) {
                foreach ($full_contatto['email'] as $dati) { ?>
                    <p>
                        Email:
                        <a  
                        aria-label="invia un'email a <?php echo $dati['valore']; ?>"
                        title="invia un'email a <?php echo $dati['valore']; ?>" 
                        href="mailto:<?php echo $dati['valore']; ?>">
                            <?php echo $dati['valore']; ?>
                        </a>
                        <?php echo $dati['dettagli']; ?>
                    </p>
               <?php }
            } ?>
            <?php if (array_key_exists('pec', $full_contatto) && is_array($full_contatto['pec']) && count ($full_contatto['pec']) ) {
                foreach ($full_contatto['pec'] as $dati) { ?>
                    <p>
                        Posta elettronica certificata (PEC):
                        <a  
                        aria-label="invia un'email a <?php echo $dati['valore']; ?>"
                        title="invia un'email a <?php echo $dati['valore']; ?>" 
                        href="mailto:<?php echo $dati['valore']; ?>">
                            <?php echo $dati['valore']; ?>
                        </a>
                        <?php echo $dati['dettagli']; ?>
                    </p>
               <?php }
            } ?>
            <?php foreach ($other_contacts as $type) {
                if (array_key_exists($type, $full_contatto) &&  is_array($full_contatto[$type]) && count ($full_contatto[$type]) ) {
                    foreach ($full_contatto[$type] as $dati) {
                        echo '<p>';
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
    </div>
</div>