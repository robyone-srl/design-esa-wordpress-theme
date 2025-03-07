<?php
/* Template Name: Vivere l'Ente
 *
 * Vivere il comune template file
 *
 * @package Design_Comuni_Italia
 */
global $post;
get_header();

?>
	<main>
		<?php
		while ( have_posts() ) :
			the_post();

			$visualizzazione_eventi = dci_get_option('vivi_visualizzazione_eventi', 'vivi') ?? 'in-evidenza';
			$img = !empty(dci_get_option('immagine', 'vivi'))
    			? dci_get_option('immagine', 'vivi')
    			: get_template_directory_uri()."\assets\placeholders\img-placeholder-500x384.png";
			$didascalia = dci_get_option('didascalia', 'vivi');
			?>
			<?php get_template_part("template-parts/hero/hero"); ?>
			<?php get_template_part("template-parts/common/content"); ?>
			<section class="hero-img mb-20 mb-lg-50">
				<section class="it-hero-wrapper it-hero-small-size cmp-hero-img-small">
					<div class="img-responsive-wrapper">
						<div class="img-responsive">
							<div class="img-wrapper">
								<?php dci_get_img($img); ?>
							</div>
						</div>
					</div>
				</section>
				<p class="title-xsmall cmp-hero-img-small__description">
					<?php echo $didascalia; ?>
				</p>
			</section>
			<?php
			if($visualizzazione_eventi == 'in-evidenza'){
				get_template_part("template-parts/vivere-ente/eventi");
			}else{
				get_template_part("template-parts/vivere-ente/calendario", $visualizzazione_eventi);
			}
			 ?>
			<?php get_template_part("template-parts/vivere-ente/luoghi"); ?>
			<?php get_template_part("template-parts/vivere-ente/cards-list"); ?>
			<?php get_template_part("template-parts/vivere-ente/galleria-foto"); ?>
			<?php get_template_part("template-parts/common/valuta-servizio"); ?>
            <?php 
                $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
                if($visualizza_contatto == 'visible')
                    get_template_part("template-parts/common/assistenza-contatti"); 
            ?>
							
		<?php 
			endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();



