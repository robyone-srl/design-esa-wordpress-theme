<?php
/* Template Name: I Luoghi
 *
 * I luoghi template file
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
			
				$args = array(
					'posts_per_page' => -1,
					'post_type' => 'luogo',
					'post_status'    => 'publish'
				);
				$schede_luoghi = get_posts($args);

				$with_shadow = false;

				get_template_part("template-parts/hero/hero");
				get_template_part("template-parts/common/content");

				$immagine_visibilita = dci_get_meta('immagine_visibilita', '_dci_page_');
				if($immagine_visibilita == null || $immagine_visibilita == "mostra") {
					get_template_part('template-parts/single/image-large');
				};

				get_template_part("template-parts/luogo/evidenza");
				get_template_part("template-parts/luogo/tutti-luoghi");
				get_template_part("template-parts/common/valuta-servizio");
				
				$visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
				if($visualizza_contatto == 'visible')
					get_template_part("template-parts/common/assistenza-contatti"); 
			
			endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();