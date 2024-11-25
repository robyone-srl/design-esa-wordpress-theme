<?php
/* Template Name: Servizi
 *
 * Servizi template file
 *
 * @package Design_Comuni_Italia
 */
global $post;
get_header();

$div_count = 0;

function open_alternate_div_background()
{
	global $div_count;
	if ($div_count++ % 0) {
?>
		<div class="bg-grey-dsk">
		<?php
	}
}

function close_alternate_div_background()
{
		?>
		</div>
	<?php
}

	?>
	<main>
		<?php
		while (have_posts()) :
			the_post();
		
			get_template_part("template-parts/hero/hero");
			get_template_part('template-parts/single/image-large');
			$should_have_grey_background = true;
			get_template_part("template-parts/servizio/servizi-in-evidenza");
			get_template_part("template-parts/servizio/banner-secondario");
			get_template_part("template-parts/servizio/categorie");
			get_template_part("template-parts/servizio/tutti-servizi");
			get_template_part("template-parts/common/valuta-servizio"); 

            $visualizza_contatto = dci_get_option('visualizzaContatto', 'footer');
            if($visualizza_contatto == 'visible')
                get_template_part("template-parts/common/assistenza-contatti"); 


		
		endwhile; // End of the loop.
		?>
	</main>

	<?php
	get_footer();
