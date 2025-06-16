<?php
/* Template Name: Eventi
 *
 * Eventi template file
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
			$with_shadow = false;
			?>
			<?php get_template_part("template-parts/hero/hero"); ?>

			<?php get_template_part("template-parts/common/content"); ?>
			<?php get_template_part('template-parts/single/image-large'); ?>
			<?php get_template_part("template-parts/evento/evidenza"); ?>
			<?php get_template_part("template-parts/evento/tutti"); ?>
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
