<?php

    global $incarico_id, $with_border;

    $incarico = get_post( $incarico_id );
    
    $is_responsabile = dci_get_meta('di_responsabilita', '_dci_incarico_', $incarico_id) == "true";

    $persona_id = dci_get_meta('persona', '_dci_incarico_', $incarico_id);
    $persona = get_post( $persona_id );

    $prefix = '_dci_persona_pubblica_';
    $descrizione_breve = dci_get_meta('descrizione_breve', $prefix, $persona->ID);
    $foto = dci_get_meta('foto', $prefix, $persona->ID);

?>

<div class="card card-wrapper card-teaser <?= $is_responsabile?'shadow':'border border-light shadow-sm'?> rounded p-4">
    <div class="card-body pe-3">
        <h4 class="u-main-black mb-1 title-small-semi-bold-medium">
            <a class="text-decoration-none" href="<?php echo get_permalink($persona->ID); ?>">
            <?php echo $persona->post_title; ?>
            </a>
        </h4>
        <div class="card-text">
            <?= $incarico->post_title ?>
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