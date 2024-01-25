<?php 
    global $post;

    // metadata
    $last_edit = explode(' ', $post->post_modified);
    $last_edit_date = new DateTime($last_edit[0]);

	$formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
	$formatter->setPattern('d LLLL yyyy');
?>

<p class="text-paragraph-small mb-0">Pagina aggiornata il <?php echo $formatter->format($last_edit_date); ?></p>