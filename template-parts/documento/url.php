<?php
global $url, $url_label;

$icon = "it-link";

$urlparts = parse_url($url);

if(isset($urlparts["host"])){
	$urlhost = $urlparts["host"];
}else{
	$urlhost = NULL;
}



$siteurl = get_site_url();
$siteurlparts = parse_url($siteurl);
$siteurlhost = $siteurlparts["host"];

if($url_label == NULL || $url_label == "")
$url_label = $url;

?>
	<div class="card card-teaser rounded shadow">
		<div class="card-body">

			<div class="row">
				<div class="col-auto">
					<svg class="icon" aria-hidden="true">
						<use xlink:href="#<?php echo $icon; ?>"></use>
					</svg>
				</div>
				<div class="col">
					<h3 class="card-title h5 ">
						<a target="_blank" href="<?php echo $url; ?>">
						<?php 
							echo $url_label;
						?>
					</a>
					</h3>


					<div class="card-text">
						<small>Collegamento ipertestuale <?php
						if($urlhost != $siteurlhost) {
							echo "<strong>esterno</strong>";
						}
						?></small>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php

