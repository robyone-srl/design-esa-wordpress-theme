<?php 
    global $post;

    // metadata
    $last_edit = explode(' ', $post->post_modified);
    $last_edit_date = new DateTime($last_edit[0]);
    $last_edit_hour_arr = explode(':', $last_edit[1]);
    $last_edit_hour = $last_edit_hour_arr[0].":".$last_edit_hour_arr[1]; 

	$formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
	$formatter->setPattern('d LLLL yyyy');
?>

<article id="ultimo-aggiornamento" class="it-page-section mt-5">
    <h3 class="h6">Ultimo aggiornamento</h3>
    <span class="h6 fw-normal"><?php echo $formatter->format($last_edit_date).', '.$last_edit_hour; ?></span>
</article>