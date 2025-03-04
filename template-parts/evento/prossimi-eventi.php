<?php
global $recurrence_index, $argomento, $is_set_event, $is_set_notizie;

$is_set_event = true;
$eventi = dci_get_posts_by_term_by_date( 'evento' , 'argomenti', $argomento->slug, true);
$eventi = array_slice($eventi, 0, 3);
$url_eventi = dci_get_template_page_url("page-templates/eventi.php");

if($is_set_notizie){
	$padding = 3;
}else {
	$padding = 'lg-70';
}
if(count($eventi)>0){
?>

<div class="section-content pb-5 pt-<?=$padding?> bg-grey-dsk">
	<div class="container">
		<div class="row row-title pt-5 pt-lg-60 pb-3">
			<div class="col-12 d-lg-flex justify-content-between">
				<h3 class="mb-lg-0 title-large-semi-bold">Prossimi eventi</h3>
			</div>
		</div>

		<div class="row g-4">
			<?php if (count($eventi)) { ?>

				<?php
				foreach ($eventi as $evento) {
					$post = get_post($evento->ID);
					get_template_part("template-parts/evento/card-full");
				}

				?>
				<div class="d-flex justify-content-end">

					<a href="<?= $url_eventi ?>" class="btn btn-outline-primary full-mb" aria-label="aria-label" data-element="live-button-events">
						Mostra tutti gli eventi
						<svg class="icon icon-primary icon-xs ml-10">
							<use href="#it-arrow-right"></use>
						</svg>
					</a>

				</div>
			<?php } else { ?>
				<div>
					Nessun evento in programma
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php } else { 
	$is_set_event = false;
} ?>