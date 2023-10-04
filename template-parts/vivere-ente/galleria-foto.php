<?php
// Galleria impostata in Configurazione > Vivere l'ente
global $sfondo_grigio;
$sfondo_grigio = $sfondo_grigio ?? true;

$photos = dci_get_option('gallery_items', 'vivi') ?: [];
$nome_sezione = dci_get_option('gallery_title', 'vivi') ?: "";
?>
<?php if (count($photos) > 0) { ?>
	<section id="galleria">
		<?php if ($nome_sezione) { ?>
			<div class="section <?= $sfondo_grigio ? 'section-muted' : '' ?> px-lg-5 pt-0 py-0">
				<div class="container">
					<div class="row row-title pt-3 pt-lg-60 pb-3">
						<div class="col-12 d-lg-flex justify-content-between">
							<h2 class="mb-lg-0"><?= $nome_sezione ?></h2>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="section <?= $sfondo_grigio ? 'section-muted' : '' ?> px-0 pt-0 it-carousel-wrapper it-carousel-landscape-abstract-three-cols it-full-carousel it-standard-image splide" data-bs-carousel-splide>
			<div class="splide__track">
				<ul class="splide__list">
					<?php foreach ($photos as $photo) { ?>
						<li class="splide__slide">
							<div class="it-single-slide-wrapper">
								<div class="it-grid-item-wrapper">
									<a href="<?= $photo ?>" class="lightbox">
										<div class="img-responsive-wrapper">
											<div class="img-responsive">
												<?php dci_get_img($photo, 'img-wrapper object-fit-cover'); ?>
											</div>
										</div>
										<span class="it-griditem-text-wrapper">
											<span class="it-griditem-text"><?= get_the_title(get_post(attachment_url_to_postid($photo))->ID) ?></span>
										</span>
									</a>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</section>

	<script>
		const tobii = new Tobii({
			captionAttribute: 'title'
		})
	</script>
<?php } ?>