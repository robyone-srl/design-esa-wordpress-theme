<?php
$current_user = wp_get_current_user();
# use get_user_meta to all data

$last_notification = get_user_meta($current_user->ID,"_dci_last_notification", true);

// $link_notification = get_permalink($last_notification);

// if($last_notification){
    ?>
    <!-- <div class="header-notification-alert has-notifications">
        <a href="<?#php echo $link_notification; ?>" aria-label="Notifiche">
            <svg class="svg-bell-solid"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-bell-solid"></use></svg>
        </a>
    </div>
    /header-notification-alert -->

<?php
// }

?>

<div class="it-user-wrapper nav-item dropdown">
    <a aria-expanded="false" class="btn btn-primary btn-icon py-sm-2" data-bs-toggle="dropdown" href="#">
        <span class="rounded-icon">
            <img src="<?php echo dci_get_user_avatar($current_user); ?>" class="border rounded-circle icon-white" alt="<?php echo dci_get_display_name($current_user->ID); ?>" style="max-width:20px;"/>
        </span>
        <span class="d-none d-lg-block">
            <?php echo dci_get_display_name($current_user->ID); ?>
        </span>
        <svg class="icon icon-white d-none d-lg-block">
        <use xlink:href="#it-expand"></use>
        </svg>
    </a>
    <div class="dropdown-menu">
        <div class="row">
            <div class="col-12">
                <div class="link-list-wrapper">
                <ul class="link-list">
                    <li class="active">
                        <a href="<?php echo admin_url(); ?>">
                            <svg class="icon icon-primary icon-sm left" aria-hidden="true"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-list"></use></svg>
                            <span><?php _e("Area personale", "design_comuni_italia"); ?></span>
                        </a>
                    </li>
                    <?php
                    if($last_notification) {
                        ?>
                        <li class="has-notifications">
                            <a href="<?php echo $link_notification; ?>">
                                <svg class="icon icon-primary icon-sm left" aria-hidden="true">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-info-circle"></use>
                                </svg>
                                <span><?php _e("Notifiche", "design_comuni_italia"); ?></span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <li>
                    <a class="list-item left-icon" href="<?php echo wp_logout_url(); ?>">
                        <svg class="icon icon-primary icon-sm left" aria-hidden="true">
                            <use xlink:href="#it-external-link"></use>
                        </svg>
                        <span class="fw-bold">Esci</span>
                    </a>
                    </li>
                </ul>
                </div>
            </div>
        </div>
    </div>
</div>