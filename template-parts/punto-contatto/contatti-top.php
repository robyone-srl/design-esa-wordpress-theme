<div class="bg-grey-card pt-4 pb-1">
    <div class="container">
        <div class="col-12 col-lg-10 mb-3">
        <h2 class="heading-title">Informazioni principali</h2>
            <div class="row">
                <div class="col">
                    <p class="info">
                        Denominazione: <?php echo dci_get_option("nome_comune"); ?>

                        <?php
                        if (dci_get_option("indirizzo", 'contatti')) { ?>
                            <br /> Indirizzo: <a href="https://www.openstreetmap.org/search?query=<?php echo urlencode(dci_get_option("indirizzo", 'contatti')); ?>" title="Mappa e indicazioni stradali"><?php echo dci_get_option("indirizzo", 'contatti'); ?></a> <?php
                        } ?>

                        <?php if (dci_get_option("SMS_Whatsapp", 'contatti')) echo '<br />SMS e WhatsApp: <a href="tel:' . preg_replace('/\s+/', '', dci_get_option("SMS_Whatsapp", 'contatti')) . '">' . dci_get_option("SMS_Whatsapp", 'contatti') . '</a>'; ?>

                        <?php if (dci_get_option("numero_verde", 'contatti')) echo '<br />Numero verde: <a href="tel:' . preg_replace('/\s+/', '', dci_get_option("numero_verde", 'contatti')) . '">' . dci_get_option("numero_verde", 'contatti') . '</a>'; ?>
                            
                        <?php
                        if (dci_get_option("PEC", 'contatti')) echo '<br />PEC: '; ?>
                        <a href="mailto:<?php echo dci_get_option("PEC", 'contatti'); ?>" class="list-item" title="PEC <?php echo dci_get_option("nome_comune"); ?>"><?php echo dci_get_option("PEC", 'contatti'); ?></a>
                        <?php if (dci_get_option("centralino_unico", 'contatti')) echo '<br />Centralino unico: <a href="' . preg_replace('/\s+/', '', dci_get_option("centralino_unico", 'contatti')) . '">' . dci_get_option("centralino_unico", 'contatti') . '</a>'; ?>
                        
                        <br />
                    </p>
                </div>
                <div class="col">
                    <p class="info">
                        <?php
                        $codice_fiscale = dci_get_option("CF", 'contatti');
                        $partita_iva = dci_get_option("PIVA", 'contatti');
                        if ($codice_fiscale && $codice_fiscale == $partita_iva) {
                            echo 'Codice fiscale / P.IVA: ' . $codice_fiscale;
                        } else {
                        ?>
                            <?php if ($codice_fiscale) echo 'Codice fiscale: ' . $codice_fiscale; ?>
                            <br /><?php if ($partita_iva) echo 'Partita IVA: ' . $partita_iva; ?>
                        <?php
                        }
                        ?>

                        <?php if(dci_get_option("cuf", 'contatti') || dci_get_option("cipa", 'contatti')) { ?>
                            <?php if (dci_get_option("cuf", 'contatti')) echo '<br />Codice univoco di fatturazione (CUF): ' . dci_get_option("cuf", 'contatti'); ?>
                            <?php if (dci_get_option("cipa", 'contatti')) echo '<br />Codice Indice delle Pubbliche Amministrazioni (IPA): ' . dci_get_option("cipa", 'contatti'); ?>
                        <?php } ?>

                        <?php
                        $ufficio_id = dci_get_option("scheda_URP", 'contatti');
                        $ufficio = get_post($ufficio_id);
                        if ($ufficio_id) { ?>
                            <br />Ufficio Relazioni con il Pubblico (URP): 
                            <a href="<?php echo get_post_permalink($ufficio_id); ?>" class="list-item" title="Vai alla pagina: URP">
                                <?php echo $ufficio->post_title ?>
                            </a>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>