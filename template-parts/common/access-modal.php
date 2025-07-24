<?php 
$nascondi_login = dci_get_option('nascondi_pulsante_login', 'grafica');

if (!$nascondi_login) { ?>
<!-- Access Modal -->
<div class="modal fade" id="access-modal" tabindex="-1" role="dialog" aria-labelledby="accessModal" aria-hidden="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content perfect-scrollbar">
            <div class="modal-body">
                <form class="access-main-wrapper" name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
                    <div class="container-md">
						<div class="modal-header">
        					<div class="h2 d-inline" id="accessModal">
										<?php _e("Accedi ai servizi", "design_comuni_italia"); ?>
                            </div>
							<button type="button" class="close dismiss" data-bs-toggle="modal" data-bs-target="#access-modal" data-dismiss="modal" aria-label="Chiudi e torna alla pagina precedente" data-focus-mouse="false">
                                        	<svg class="icon icon-md">
                                            	<use href="#it-close-big"></use>
                                        	</svg>
                                    	</button>
      					</div>

                        <div class="row variable-gutters mb-0 mb-lg-4 mb-xl-5">
                            <div class="col">
                                    
                            </div>
                        </div>
                        <div class="row variable-gutters justify-content-center pt-4 pt-xl-5">
                            <div class="col-lg-4">
                                <p class="text-intro"><?php echo dci_get_option("login_messaggio", "servizi"); ?></p>
                                <div class="access-buttons">
                                    <?php
                                    $link_esterni = dci_get_option("link_esterni", "servizi");
                                    if(isset($link_esterni) && is_array($link_esterni) && count($link_esterni)>0) {
                                        foreach ($link_esterni as $item) {
                                            ?>
                                            <a class="btn btn-primary d-block btn-lg rounded mb-3"
                                               href="<?php echo $item["url_link"]; ?>"><?php echo $item["nome_link"]; ?></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 offset-lg-2 access-mobile-bg">
                                <div class="access-login p-4 p-lg-0">
                                    <div class="h3"><?php _e("Personale dell'Ente", "design_comuni_italia"); ?></div>
                                    <p class="text-large"><?php _e("Entra nel sito della casa di riposo con le tue credenziali per gestire i contenuti e altre funzionalità.", "design_comuni_italia"); ?></p>
                                    <?php if(in_array('wp-spid-italia/wp-spid-italia.php', apply_filters('active_plugins', get_option('active_plugins')))){?>
                                        <div class="col text-center pt-4">
                                            <?php echo do_shortcode("[spid_login_button]"); ?>
                                        </div>
                                    <?php }?>
                                    <div class="access-login-form">
                                        <div class="form-group">
                                            <label for="login-email-field">Email address</label>
                                            <input type="email" name="log" autocomplete="email" title="Indirizzo email" id="login-email-field" class="input form-control" value="" size="20" autocapitalize="off" aria-describedby="loginform" placeholder="La tua email">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="login-password-field">Password</label>
                                            <input type="password" name="pwd" title="Password" autocomplete="current-password" id="login-password-field" class="form-control" value="" size="20" aria-describedby="loginform" placeholder="Password">
                                        </div>

                                        <div class="row variable-gutters mb-4">
                                            <div class="col text-right text-underline">
                                                <p><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?' ); ?></a></p>
                                            </div>
                                        </div>

                                        <div class="row variable-gutters">
                                            <div class="col-lg-6 mb-4">
                                                <div class="form-check form-check-inline">
                                                    <input name="rememberme" type="checkbox" id="rememberme" value="forever" />
                                                    <label for="rememberme"><?php esc_html_e( 'Remember Me' ); ?></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-4">
                                                <button type="submit" class="btn btn-white d-block rounded" name="login" value="Accedi"><?php _e("Accedi", "design_comuni_italia"); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Access Modal -->
<?php } ?>
