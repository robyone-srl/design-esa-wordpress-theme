<?php
global $gallery;
$dim = count($gallery);


if($dim>=3){ ?>
	<div class="it-carousel-wrapper it-carousel-landscape-abstract-three-cols it-full-carousel it-standard-image splide" data-bs-carousel-splide>
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach ($gallery as $photo) { ?>
					<li class="splide__slide">
						<div class="it-single-slide-wrapper">
							<div class="it-grid-item-wrapper">
								<a href="<?= wp_get_attachment_image_src(attachment_url_to_postid($photo), 'full')[0] ?>" class="lightbox">
									<div class="img-responsive-wrapper">
										<div class="img-responsive">
											<?php dci_get_img($photo, 'img-wrapper object-fit-cover', 'item-gallery'); ?>
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
<?php } else {?>

	<ul class="thumb-nav thumb-nav-auto thumb-nav-auto-2">
		<?php foreach ($gallery as $photo) { ?>
			<li>
				<a href="<?= wp_get_attachment_image_src(attachment_url_to_postid($photo), 'full')[0] ?>" class="lightbox">
					<div class="img-responsive-wrapper">
						<div class="img-responsive">
							<?php dci_get_img($photo, 'img-wrapper object-fit-cover', 'item-gallery'); ?>
						</div>
					</div>
					<span class="it-griditem-text-wrapper">
						<span class="it-griditem-text"><?= get_the_title(get_post(attachment_url_to_postid($photo))->ID) ?></span>
					</span>
				</a>
			</li>
		<?php } ?>
	</ul>
<?php } ?>

<script>
	const tobii = new Tobii({
		captionAttribute: 'title'
	})
</script>