<?php
// Galleria impostata in Configurazione > Vivere l'ente
global $sfondo_grigio;
$sfondo_grigio ?? true;

$photos = dci_get_option('gallery_items', 'vivi') ?: [];
?>

<?php if(count($photos) > 0) { ?>
<section id="galleria">
	<div class="section <?=$sfondo_grigio?'section-muted':'' ?> pb-90 pb-lg-50 px-lg-5 pt-0">
		<div class="container">
			<div class="row row-title pt-5 pt-lg-60 pb-3">
				<div class="col-12 d-lg-flex justify-content-between">
					<h2 class="mb-lg-0">Le nostre foto</h2>
				</div>
			</div>
			<div class="it-carousel-wrapper it-carousel-landscape-abstract-three-cols it-full-carousel it-standard-image splide" data-bs-carousel-splide>
				<div class="splide__track">
					<ul class="splide__list">
						<?php foreach ($photos as $photo) { ?>
							<li class="splide__slide">
								<div class="it-single-slide-wrapper">
									<div class="card-wrapper">
										<div class="card card-img no-after">
											<a class="img-responsive-wrapper" target="_blank" href="<?= $photo ?>">
												<div class="img-responsive">
													<?php dci_get_img($photo, 'img-wrapper object-fit-cover'); ?>
												</div>
											</a>
										</div>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php } ?>