<?php
/* Template Name: Unità Organizzative
 *
 * Servizi template file
 *
 * @package Design_Comuni_Italia
 */
global $post, $with_shadow;
$search_url = esc_url( home_url( '/' ));
get_header();

?>
	<main>
		<?php
			while ( have_posts() ) :
				$container_posts[] = the_post();
			endwhile;

			
			foreach ( $container_posts as $container_post ) {
				$with_shadow = false;
				get_template_part("template-parts/hero/hero");
				get_template_part("template-parts/common/content");

				$immagine_visibilita = dci_get_meta('immagine_visibilita', '_dci_page_');
				if($immagine_visibilita == null || $immagine_visibilita == "mostra") {
					get_template_part('template-parts/single/image-large');
				};

				get_template_part("template-parts/unita-organizzativa/tutte-uo");
				get_template_part("template-parts/common/valuta-servizio");
				
				$visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
				if($visualizza_contatto == 'visible')
					get_template_part("template-parts/common/assistenza-contatti"); 
			} // End of the loop.
		?>
	</main>
<?php
get_footer();
