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
			
			?>
			<?php
				$with_shadow = false; 
				get_template_part("template-parts/hero/hero"); 
			?>
			<?php get_template_part("template-parts/common/content"); ?>
			<?php get_template_part('template-parts/single/image-large'); ?>
			<?php get_template_part("template-parts/argomento/evidenza"); ?>			
			<?php get_template_part("template-parts/argomento/argomenti"); ?>	
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
