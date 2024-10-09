<?php 
    global $luoghi;

    if ($luoghi && is_array($luoghi) && count($luoghi)>0) { ?>
        <ul class="d-flex flex-wrap gap-1 mt-2">
            <?php foreach ($luoghi as $luogo_id) { 
                $luogoObj = get_post($luogo_id);
                ?>
                <li>
                    <a class="chip chip-simple" href="<?php echo get_permalink($luogo_id); ?>">
                        <span class="chip-label"><?php echo $luogoObj->post_title; ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php }
?>