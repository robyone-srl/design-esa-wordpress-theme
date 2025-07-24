<?php
	global $post, $card_wrapper, $title_level;
		
	echo '<div class="col-12 col-md-6 col-lg-4">';
	$card_wrapper = true;
    get_template_part( 'template-parts/incarico/card' );
	echo '</div>';
?>