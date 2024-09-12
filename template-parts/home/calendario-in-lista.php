<?php
$quanti_eventi_mostrare = dci_get_option('quanti_eventi_mostrare', 'homepage') ?: 3;

$args = array(
	'post_type' => 'evento',
	'posts_per_page' => $quanti_eventi_mostrare,
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'meta_key' => '_dci_evento_data_orario_inizio',
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key' => '_dci_evento_data_orario_fine',
			'value' => current_datetime()->getTimestamp(),
			'compare' => '>='
		),  
		array(
			'key' => '_dci_evento_data_orario_inizio',
			'value' => current_datetime()->modify('-12 hours')->getTimestamp(),
			'compare' => '>='
		),
	 )
);

$the_query = new WP_Query( $args );
$eventi = $the_query->posts;

$quanti_eventi_nascosti = $the_query->found_posts - $quanti_eventi_mostrare;
$btn_mostra_tutti = $quanti_eventi_nascosti > 0 ? "Mostra " . ($quanti_eventi_nascosti > 1 ? 'altri ' . $quanti_eventi_nascosti . ' eventi' : 'un altro evento') : false;

$url_eventi = get_permalink( get_page_by_title('Eventi') );

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
					foreach ($eventi as $evento_id) {
						$post = get_post($evento_id);
						get_template_part("template-parts/evento/card-full");
					}

					if ($btn_mostra_tutti) {
					?>
						<div class="d-flex justify-content-end">

							<a href="<?= $url_eventi ?>" class="btn btn-outline-primary full-mb" aria-label="aria-label" data-element="live-button-events">
								<?= $btn_mostra_tutti ?>
								<svg class="icon icon-primary icon-xs ml-10">
									<use href="#it-arrow-right"></use>
								</svg>
							</a>

						</div>
					<?php } ?>
				<?php } else { ?>
					<div>
						Nessun evento in programma
					</div>
				<?php } ?>
			</div>
		</div>
	</div>