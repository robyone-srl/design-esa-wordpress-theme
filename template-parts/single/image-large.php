<?php
global $post, $img_url, $img_alt, $img_caption;

$has_thumbnail = has_post_thumbnail();


if($has_thumbnail){    
	
    $img_url = get_the_post_thumbnail_url($post, 'post-thumbnail');

    $img = get_post(attachment_url_to_postid( $img_url ));
	
    $img_title = $img->post_title;

    $img_alt = get_post_meta( $img->ID, '_wp_attachment_image_alt', true) ?? '';
	
    $img_caption = $img->post_excerpt;
}

if($img_url != "") {
    ?>
    <div class="container-fluid my-3">
        <div class="row">
			<div class="figure px-0 pb-2 img-full">
				<div class="img-bg-full" style="background-image:url('<?php echo $img_url; ?>');"></div>
			</div>
        </div>
    </div> <?php 
}
?>