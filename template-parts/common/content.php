<?php 
    global $content;
    $content = get_the_content();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
             <div class="pt-4 pb-4">
                <?php
                if($content != '')
                    echo $content; 
                ?>
            </div>
        </div>
    </div>
</div>
