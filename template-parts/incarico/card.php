<?php
global $inc_id, $with_border, $card_wrapper, $show_Persona, $title_level;

$incarico = get_post($inc_id);
$prefix = '_dci_incarico_';
$tipo_incarico = get_the_terms($inc_id, "tipi_incarico")[0]->name;
$tipo_incarico = strtolower(trim($tipo_incarico)) == 'altro' ? '' : $tipo_incarico;
$data_inizio_incarico = dci_get_meta('data_inizio_incarico', $prefix, $inc_id);
$data_conclusione_incarico = dci_get_meta('data_conclusione_incarico', $prefix, $inc_id);
$responsabile_struttura = dci_get_meta('responsabile_struttura', $prefix, $inc_id);


$persona_id = dci_get_meta('persona', '_dci_incarico_', $inc_id);
$persona = get_post( $persona_id );

$img = get_the_post_thumbnail_url($inc_id, 'post-thumbnail');

if($title_level == "") $title_level = 4;
?>

<div class="card card-teaser <?= $card_wrapper ? 'card-wrapper' : '' ?> <?= $with_border ? 'border border-light shadow-sm' : 'shadow' ?> rounded p-4">
    <div class="card-body pe-3">
        <h<?php echo $title_level; ?> class="u-main-black mb-1 title-small-semi-bold-medium cart-title">
			<a class="text-decoration-none" href="<?php echo get_permalink($incarico->ID); ?>">
            	<?php echo $incarico->post_title; ?>
            </a>
        </h<?php echo $title_level; ?>>
        <?php if($persona_id && $show_Persona == true){ ?>
        <h5 class="h6"><?php echo $persona->post_title; ?></h5>
        <?php } ?>
        <div class="card-text">
            Incarico <?=$tipo_incarico; ?>
        </div>
    </div>
    <div class="avatar size-xl">
    <?php if(!$img){ ?>
            <svg class="icon svg-marker-simple">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-bookmark"></use>
            </svg>
    <?php }else{ 
        dci_get_img(get_the_post_thumbnail_url($inc_id, 'post-thumbnail'));
    } ?>
    </div>
</div>