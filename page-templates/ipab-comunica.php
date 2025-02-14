<?php
/* Template Name: IPAB comunica
 *
 * Comunica template file
 *
 * @package Design_Comuni_Italia
 */
global $post, $with_shadow;
$search_url = esc_url( home_url( '/' ));
get_header();

$visualizzazione_eventi = dci_get_option('visualizzazione_eventi', 'comunica') ?? '';
$visualizzazione_notizie = dci_get_option('visualizzazione_notizie', 'comunica') ?? '';

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
			<?php $should_have_grey_background = true ?>
			<?php  get_template_part("template-parts/ipab-comunica/contenuti-evidenza"); ?>
			<?php get_template_part("template-parts/ipab-comunica/notizie", $visualizzazione_notizie); ?>
			<?php get_template_part("template-parts/ipab-comunica/calendario", $visualizzazione_eventi); ?>
			<?php get_template_part("template-parts/ipab-comunica/argomenti"); ?>
			

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