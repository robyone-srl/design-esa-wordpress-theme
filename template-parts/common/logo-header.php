<?php
$barra_intestazione_light = dci_get_option("tema_chiaro_nav_intestazione");

$image_option_name = $barra_intestazione_light ? 'stemma_comune_mobile' : 'stemma_comune';

if (dci_get_option($image_option_name)) {
?>
<svg width="82" height="82" class="icon" aria-hidden="true">       
     <image xlink:href="<?php echo dci_get_option($image_option_name);?>" width="82" height="82"/>    
</svg>
<?php } ?>