<?php
global $post;

$has_thumbnail = has_post_thumbnail();

if(!$has_thumbnail = has_post_thumbnail()){
    $img_url = dci_get_meta('immagine');
    $img = get_post( attachment_url_to_postid($img_url) );
    $image_alt = get_post_meta( $img->ID, '_wp_attachment_image_alt', true);
}

if ($has_thumbnail || $img_url) {
?>

<div class="container-fluid my-3">
    <div class="row">
        <figure class="figure px-0 img-full">
            <?php if(!$has_thumbnail){ ?>
            <img
                src="<?php echo $img_url; ?>"
                class="figure-img img-fluid"
                alt="<?php echo $image_alt; ?>"
            />
            <?php if ($img->post_excerpt)  {?>
            <figcaption class="figure-caption text-center pt-3">
                <?php echo $img->post_excerpt; ?>
            </figcaption>
            <?php } ?>
            <?php } else { 
                the_post_thumbnail('post-thumbnail', $attr = array('class' => 'figure-img img-fluid'));
            } ?>
        </figure>
    </div>
</div>
<?php } ?>