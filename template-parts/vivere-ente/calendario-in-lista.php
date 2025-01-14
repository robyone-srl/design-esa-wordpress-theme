<?php
global $recurrence_index;

$quanti_eventi_mostrare = dci_get_option('vivi_numero_eventi', 'vivi') ?: 3;

$eventi = dci_get_eventi_calendar_array();
usort($eventi, fn($a, $b) => $a['_dci_evento_data_orario_inizio'] <=> $b['_dci_evento_data_orario_inizio']);
$eventi = array_slice($eventi, 0, $quanti_eventi_mostrare);


$url_eventi = dci_get_template_page_url("page-templates/eventi.php");

?>
	<div class="section section-muted pb-90 pb-lg-50 px-lg-5 pt-0">
		<div class="container">
			<div class="row row-title pt-5 pt-lg-60 pb-3">
				<div class="col-12 d-lg-flex justify-content-between">
					<h2 class="mb-lg-0">Prossimi eventi</h2>
				</div>
			</div>

			<div class="row g-4">
				<?php if (count($eventi)) { ?>

					<?php
					foreach ($eventi as $evento) {
						$post = get_post($evento['id']);
						$recurrence_index = $evento['indice_ricorrenza'] ?? -1;
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