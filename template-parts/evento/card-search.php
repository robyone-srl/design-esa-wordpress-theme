<?php
global $post;

$descrizione_breve = dci_get_meta('descrizione_breve', '_dci_evento_',$post->ID);
$timestampI = dci_get_evento_next_recurrence_timestamps($post->ID)['_dci_evento_data_orario_inizio'];
$timestampF = dci_get_evento_next_recurrence_timestamps($post->ID)['_dci_evento_data_orario_fine'];
$arrdataI = explode('-', date_i18n("j-F-Y", $timestampI));
$arrdataF = explode('-', date_i18n("j-F-Y", $timestampF));
?>

<div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0 p-3">
    <div class="content aling-top">
        <div class="card-header border-0">
            <?php
            echo '<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">';
            echo $arrdataI[0].' '.$arrdataI[1].' '.$arrdataI[2] ; 
            echo ' - ';
            echo $arrdataF[0].' '.$arrdataF[1].' '.$arrdataF[2] ; 
            echo '</span>';
            ?>
        </div>
        <div class="card-body px-3 pb-3">
            <h4 class="card-title text-paragraph-medium u-grey-light">
		        <a href="<?= $post->guid ?>" class="text-decoration-none"><?= $post->post_title; ?></a>
	        </h4>
	        <p class="text-paragraph-card u-grey-light m-0"><?php echo $descrizione_breve; ?></p>
        </div>
    </div>
</div>