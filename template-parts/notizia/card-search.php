<?php
global $post;

$descrizione_breve = dci_get_meta('descrizione_breve');

$page = get_page_by_path( dci_get_group($post->post_type) );    
$arrdata = dci_get_data_pubblicazione_arr("data_pubblicazione", '_dci_notizia_', $post->ID);
$monthName = date_i18n('M', mktime(0, 0, 0, $arrdata[1], 10));
?>

<div class="card card-teaser card-teaser-image card-flex no-after rounded shadow-sm border border-light mb-0 p-3">
    <div class="content aling-top">
        <div class="card-header border-0">
            <?php
            echo '<span class="text-decoration-none title-xsmall-bold mb-2 category text-uppercase text-primary">';
            echo $page->post_title; 
            echo ' - ';
            echo $arrdata[0].' '.strtoupper($monthName).' '.$arrdata[2] ; 
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