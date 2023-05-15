<?php
global $nomefile, $idfile;

$attach = get_post($idfile);
$filetocheck = get_attached_file($idfile);

if($nomefile == "") {
	$path_parts = pathinfo($attach->guid);
} else {
	$path_parts = pathinfo($nomefile);
}

$ext = $path_parts['extension'];


	$icon = "it-file";

	switch ($ext) {
		case "pdf":
			$icon = "it-file-pdf-ext";
			break;
	
		case "odp":
			$icon = "it-file-odp";
			break;

		case "slides":
			$icon = "it-file-slides";
			break;

		case "xml":
			$icon = "it-file-xml";
			break;

		case "csv":
			$icon = "it-file-csv";
			break;

		case "ods":
			$icon = "it-file-ods";
			break;

		case "txt":
			$icon = "it-file-txt";
			break;

		case "mp3":
			$icon = "it-file-xml";
			break;

		case "xml":
			$icon = "it-file-xml";
			break;

		case "xml":
			$icon = "it-file-xml";
			break;

		default:
			break;
		}


$filesize = filesize($filetocheck);
$fulltype = mime_content_type($filetocheck);
$arrtype = explode("/", $fulltype);
$arrtype_more = explode(".", $arrtype[count($arrtype)-1]);
if(is_array($arrtype_more)) {
    $arrtype = $arrtype_more;
}
$type = "file";
if(is_array($arrtype))
    $type = $arrtype[count($arrtype)-1];

$ptitle = $attach->post_title;
if(trim($ptitle) == ""){
    $ptitle = str_replace("-", " ", basename($filetocheck, $ext));
    $ptitle = str_replace("_", " ", $ptitle);
}
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
						<a target="_blank" href="<?php echo $attach->guid; ?>"><?php echo $ptitle; ?></a>
					</h3>

					<div class="card-text">
						<small><?php echo $type; ?> - <?php echo intval($filesize/1024); ?> kb</small>
					</div>
				</div>
		</div>
		</div>
	</div>