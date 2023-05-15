<?php
global $documento;

$excerpt =  dci_get_meta("descrizione", "", $documento->ID);

?>

<div class="card card-bg card-teaser rounded">
    <a href="<?php echo get_permalink($documento); ?>">
        <div class="card-body">
        <div class="row">
				<div class="col-auto">
                    <svg class="icon"><use xlink:href="#it-file"></use></svg>
				</div>
				<div class="col">
                        <p><strong><?php echo $documento->post_title; ?></strong></p>
                        <small><?php echo $excerpt; ?></small>
				</div>
			</div>
        </div><!-- /card-body -->
    </a>
</div>