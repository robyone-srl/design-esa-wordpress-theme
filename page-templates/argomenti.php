<?php
/* Template Name: Argomenti
 *
 * Argomenti template file
 *
 * @package Design_Comuni_Italia
 */
global $post, $with_shadow;

get_header();

?>
	<main>
		<?php
			while ( have_posts() ) :
				the_post();
				
				$with_shadow = false; 
				get_template_part("template-parts/hero/hero"); 
			
				get_template_part("template-parts/common/content");

				$immagine_visibilita = dci_get_meta('immagine_visibilita', '_dci_page_');
				if($immagine_visibilita == null || $immagine_visibilita == "mostra") {
					get_template_part('template-parts/single/image-large');
				};

				get_template_part("template-parts/argomento/evidenza");	
				get_template_part("template-parts/argomento/argomenti");
				get_template_part("template-parts/common/valuta-servizio");
				
				$visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
				if($visualizza_contatto == 'visible')
					get_template_part("template-parts/common/assistenza-contatti"); 

			endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();