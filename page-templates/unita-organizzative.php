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
			?>
			<?php get_template_part("template-parts/hero/hero"); ?>
			<?php get_template_part("template-parts/common/content"); ?>
			<?php get_template_part('template-parts/single/image-large'); ?>
			<?php get_template_part("template-parts/unita-organizzativa/tutte-uo"); ?>
			<?php get_template_part("template-parts/common/valuta-servizio"); ?>
            <?php 
                $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
                if($visualizza_contatto == 'visible')
                    get_template_part("template-parts/common/assistenza-contatti"); 
            ?>
							
		<?php 
			} // End of the loop.
		?>
	</main>

<?php
get_footer();
