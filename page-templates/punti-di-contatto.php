<?php
/* Template Name: Punti di contatto
 *
 * contatti template file
 *
 * @package Design_Comuni_Italia
 */
global $post;
$search_url = esc_url( home_url( '/' ));
get_header();

?>
	<main>
		<?php
		while ( have_posts() ) :
			$container_posts[] = the_post();
		endwhile;

		foreach ( $container_posts as $container_post ) {
			$with_shadow = true;	
		?>
			<?php get_template_part("template-parts/punto-contatto/hero"); ?>
			<?php get_template_part('template-parts/single/image-large'); ?>
			<?php  
				$visualizza_dati_fiscali = dci_get_meta('vedi_info_principali','_dci_page_');
				if($visualizza_dati_fiscali == 'true')
					get_template_part('template-parts/punto-contatto/contatti-top');
			?>
			<?php get_template_part("template-parts/punto-contatto/evidenza"); ?>
			<?php get_template_part("template-parts/punto-contatto/tutti-contatti"); ?>
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