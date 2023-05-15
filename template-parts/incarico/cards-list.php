<?php
	global $post;

	$pp_id = dci_get_meta('persona','_dci_incarico_',$post->ID);
	
    $post = get_post($pp_id);
		
    get_template_part( 'template-parts/persona_pubblica/cards-list' );
?>
