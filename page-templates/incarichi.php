<?php
/* Template Name: Incarichi
 *
 * Incarichi template file
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
			the_post();

			$with_shadow = true;
			?>
			<?php get_template_part("template-parts/incarico/hero"); ?>
			<?php get_template_part('template-parts/single/image-large'); ?>
			<?php get_template_part("template-parts/incarico/tutti"); ?>
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
