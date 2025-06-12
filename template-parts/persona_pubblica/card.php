<?php

global $pp_id, $with_border, $hide_incarichi, $titleLevel;

$persona = get_post($pp_id);

$prefix = '_dci_persona_pubblica_';

$descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $persona->ID);

    if ($descrizione_breve) {
        $sottotitolo = $descrizione_breve;
    } else if (!$hide_incarichi) {  
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

        foreach ($inc_list as $incarico) {
            array_push($incarichi, $incarico->post_title);
        }

        $incarichi = array_unique($incarichi);
    
        $sottotitolo = implode(', ', $incarichi);
 }

$foto = dci_get_meta('foto', $prefix, $persona->ID);


if($titleLevel == "") $titleLevel = 4;
?>

<div class="card card-teaser <?= $with_border ? 'border border-light shadow-sm' : 'shadow' ?> rounded p-4 d-flex flex-nowrap align-items-center">
    <div class="card-body pe-3">
        <h<?php echo $titleLevel; ?> class="u-main-black mb-1 title-small-semi-bold-medium cart-title">
            <a class="text-decoration-none" href="<?php echo get_permalink($persona->ID); ?>">
                <?php echo $persona->post_title; ?>
            </a>
        </h<?php echo $titleLevel; ?>>
        <div class="card-text">
            <?php
            
            if ($sottotitolo) {
                echo $sottotitolo;
            }
            ?>
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
