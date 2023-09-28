function controlla_campo(field_id) {
    if (jQuery("#" + field_id).val() !== undefined && !jQuery("#" + field_id).val()) {
        // Show the alert
        var alertid = field_id + "-required-msj"
        if (!jQuery("#" + alertid).length) {
            jQuery("#wp-" + field_id + "-wrap")
                .append('<div id="' + alertid + '"><em>Campo obbligatorio</em></div>')
                .addClass("highlighted_missing_field")
            setTimeout(function () {
                jQuery("#wp-" + field_id + "-wrap").removeClass("highlighted_missing_field");
                jQuery("#" + alertid).remove()
            }, 3000);
        }
        // Focus on the field.
        //jQuery( "#"+field_id).focus();
        jQuery('html,body').animate({
            scrollTop: jQuery("#" + field_id).parent().offset().top - 100
        }, 'slow')

        return false
    }
    return true
}

function controlla_form(e) {
    let ci_sono_servizi_richiesti = document.getElementById("_dci_servizio_servizi_richiesti").options['selectedIndex'] != -1;

    if (ci_sono_servizi_richiesti)
        return

    let campi_facoltativi = [
        '_dci_servizio_come_fare',
        '_dci_servizio_cosa_serve_introduzione',
        '_dci_servizio_tempi_text',
    ]

    if(campi_facoltativi.find(element => !controlla_campo(element))) //se qualche campo non passa il controllo, ferma il submit
        e.preventDefault();
}

document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById('post')
    form.addEventListener("submit", controlla_form, false)
}); 