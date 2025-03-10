<?php
global $recurrence_index, $argomento, $first_printed;

$quanti_eventi_mostrare = dci_get_option('quanti_eventi_mostrare', 'homepage') ?: 3;

$eventi = dci_get_posts_by_term_by_date( 'evento' , 'argomenti', $argomento->slug, true);
$oggi_timestamp = current_time('timestamp');  

$eventi = array_filter($eventi, function($evento) use ($oggi_timestamp) {
    $start_timestamp = get_post_meta($evento->ID, '_dci_evento_data_orario_inizio', true);
    
    return $start_timestamp >= $oggi_timestamp;
});

usort($eventi, function($a, $b) {
    $data_inizio_a = get_post_meta($a->ID, '_dci_evento_data_orario_inizio', true);
    $data_inizio_b = get_post_meta($b->ID, '_dci_evento_data_orario_inizio', true);
    return $data_inizio_a <=> $data_inizio_b;
});


$eventi = array_slice($eventi, 0, $quanti_eventi_mostrare);
$url_eventi = dci_get_template_page_url("page-templates/eventi.php");

if($first_printed){
	$padding = 3;
} else {
	$padding = 'lg-70';
}

if(count($eventi)>0){
?>

<div class="section-content pb-5 pt-<?=$padding?> bg-grey-dsk">
	<div class="container">
		<div class="row row-title pt-5 pt-lg-60 pb-3">
			<div class="col-12">
				<h3 class="u-grey-light border-bottom border-semi-dark pb-2 pb-lg-3 title-large-semi-bold">Prossimi eventi</h3>
			</div>
		</div>

		<div class="row g-4">
			<?php
			foreach ($eventi as $evento) {
				$post = get_post($evento->ID);
				get_template_part("template-parts/evento/card-full");
			} ?>
		</div>
		<div class="row mt-4">
            <div class="col-12 col-lg-3 offset-lg-9">
                <button 
                    type="button" 
                    class="btn btn-outline-primary w-100"
                    onclick="location.href='<?= dci_get_template_page_url("page-templates/eventi.php"); ?>'"
                >
                    Mostra tutti gli eventi
                    <svg class="icon icon-primary">
                        <use xlink:href="#it-arrow-right"></use>
                    </svg>
                </button>
            </div>
        </div>
	</div>
</div>
<?php 
	$first_printed = true;
} ?>