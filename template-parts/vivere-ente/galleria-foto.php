<?php
// Galleria impostata in Configurazione > Vivere l'ente
global $sfondo_grigio, $gallery;
$sfondo_grigio = $sfondo_grigio ?? true;

$gallery = dci_get_option('gallery_items', 'vivi') ?: [];
$nome_sezione = dci_get_option('gallery_title', 'vivi') ?: "";
?>
<?php if (count($gallery) > 0) { ?>
	
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
		<div class="section <?= $sfondo_grigio ? 'section-muted' : '' ?> px-0 pt-0 ">
		
<?php if (count($gallery) < 3) { echo '<div class ="container">'; } ?>
			<?php get_template_part("template-parts/single/gallery"); ?>
	<?php if (count($gallery) < 3) { echo '</div>'; } ?>
		</div>
	</section>

<?php } ?>