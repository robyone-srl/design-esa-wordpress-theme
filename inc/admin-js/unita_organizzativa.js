jQuery( document ).ready(function() {

    let input = jQuery('input[name^="_dci_unita_organizzativa_argomenti"]');
    input.each(function() {
        jQuery(this).click(function(){
            dci_remove_highlight_missing_field('.cmb2-id--dci-evento-argomenti');
        });
    });

    jQuery( 'form[name="post"]' ).on('submit', function(e) {
        /**
         * controllo compilazione campo Argomenti
         */
        if(document.activeElement.id === 'publish' && jQuery('input[name^="_dci_unita_organizzativa_argomenti"]:checked').length == 0){
            dci_highlight_missing_field('.cmb2-id--dci-evento-argomenti');
            return false;
        }
        
        /**
         * controllo compilazione campo GPS
         */
        if(document.activeElement.id === 'publish' && (jQuery('input[name^="_dci_unita_organizzativa_posizione_gps_sede_principale_custom[lat]"][required]').attr('value') === '' || jQuery('input[name^="_dci_unita_organizzativa_posizione_gps_sede_principale_custom[lng]"][required]').attr('value') === '')) {
            dci_highlight_missing_field('.cmb2-id--dci-evento-posizione-gps-sede-principale-custom');
            return false;
        }
        return true;
    });

    if(jQuery('input:radio[name="_dci_unita_organizzativa_is_sede_principale_esa"]:checked').val() == "true"){
        dci_enable_luogo_esa();
    }else{
        dci_disable_luogo_esa();
    }
    jQuery('input:radio[name="_dci_unita_organizzativa_is_sede_principale_esa"]').change( function(){
        if (jQuery(this).is(':checked') && jQuery(this).val() == 'true') {
            dci_enable_luogo_esa();
        }else{
            dci_disable_luogo_esa();
        }
    });
});

function dci_enable_luogo_esa(){
    jQuery(".cmb2-id--dci-unita-organizzativa-posizione-gps-sede-principale-custom").hide();

    jQuery("#_dci_unita_organizzativa_sede_principale").attr("required", true);
    jQuery("#_dci_unita_organizzativa_nome_sede_principale_custom").removeAttr('required');
    jQuery("#_dci_unita_organizzativa_indirizzo_sede_principale_custom").removeAttr('required');
    jQuery("#_dci_unita_organizzativa_posizione_gps_sede_principale_custom_lat").removeAttr('required');
    jQuery("#_dci_unita_organizzativa_posizione_gps_sede_principale_custom_lng").removeAttr('required');
}

function dci_disable_luogo_esa(){
    jQuery(".cmb2-id--dci-unita-organizzativa-posizione-gps-sede-principale-custom").show();

    jQuery("#_dci_unita_organizzativa_sede_principale").removeAttr('required');
    jQuery("#_dci_unita_organizzativa_nome_sede_principale_custom").attr("required", true);
    jQuery("#_dci_unita_organizzativa_indirizzo_sede_principale_custom").attr("required", true);
    jQuery("#_dci_unita_organizzativa_posizione_gps_sede_principale_custom_lat").attr("required", true);
    jQuery("#_dci_unita_organizzativa_posizione_gps_sede_principale_custom_lng").attr("required", true);
}



function dci_highlight_missing_field(fieldClass) {
    jQuery(fieldClass).addClass("highlighted_missing_field")
        .append('<div id ="field-required-msg" class="field-required-msg"><em>Campo obbligatorio</em></div>')
    ;
    jQuery('html,body').animate({
        scrollTop: jQuery("#field-required-msg").parent().offset().top - 100
    }, 'slow');

}


function dci_remove_highlight_missing_field(fieldClass) {
    jQuery(fieldClass).removeClass("highlighted_missing_field");
    jQuery('.field-required-msg').remove();
}
