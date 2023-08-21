<?php
global $pc_id;
$prefix = '_dci_punto_contatto_';

$full_contatto = dci_get_full_punto_contatto($pc_id);
$contatto = get_post($pc_id);
$voci = dci_get_meta('voci', $prefix, $pc_id);

$other_contacts = array(
    'linkedin',
    'pec',
    'skype',
    'telegram',
    'twitter',
    'whatsapp'
);
?>

<div class="card card-teaser card-teaser-info rounded shadow-sm p-4 me-3">
    <div class="card-body pe-3">
        <h5 class="card-title">
            <a href="#">
            <?php echo $contatto->post_title; ?>
            </a>
        </h5>
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
                        target="_blank" 
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
                        echo '<p>'.$type.': '.$dati['valore'].' ('.$dati['dettagli'].')</p>';
                    }
                } 
            } ?>
        </div>
    </div>
</div>