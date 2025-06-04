jQuery(document).ready(function () {

    let input = jQuery('input[name^="_dci_servizio_argomenti"]');
    input.each(function () {
        jQuery(this).click(function () {
            dci_remove_highlight_missing_field('.cmb2-id--dci-servizio-argomenti');
        });
    });

    let inputCategorie = jQuery('input[name^="_dci_servizio_categorie"]');
    inputCategorie.each(function () {
        jQuery(this).click(function () {
            dci_remove_highlight_missing_field('.cmb2-id--dci-servizio-categorie');
        });
    });

    let inputMotivo = jQuery('textarea[name^="_dci_servizio_motivo_stato"]');
    inputMotivo.each(function () {
        jQuery(this).on('change keyup paste', function () {
            dci_remove_highlight_missing_field('.cmb2-id--dci-servizio-motivo-stato');
        });
    });

    var unitaResponsabileField = jQuery('#_dci_servizio_unita_responsabile');
    var puntiContattoField = jQuery('#_dci_servizio_punti_contatto');

    var unitaResponsabileContainerClass = '.cmb2-id--dci-servizio-unita-responsabile';
    var puntiContattoContainerClass = '.cmb2-id--dci-servizio-punti-contatto';
    var commonContactsContainerClass = '.cmb-type-pw-select, .cmb-type-pw-multiselect';

    unitaResponsabileField.on('change', function () {
        if (jQuery(this).val() !== '' && jQuery(this).val() !== null) {
            dci_remove_highlight_missing_field(unitaResponsabileContainerClass);
        }
    });

    puntiContattoField.on('change', function () {
        var selectedPuntiContatto = jQuery(this).val();
        if (selectedPuntiContatto !== null && selectedPuntiContatto.length > 0) {
            dci_remove_highlight_missing_field(puntiContattoContainerClass);
        }
    });

    jQuery('form[name="post"]').on('submit', function (e) {

        /**
         * controllo compilazione campo Categorie Servizio
         */
        if (document.activeElement.id === 'publish' && jQuery('input[name^="_dci_servizio_categorie"]:checked').length === 0) {
            dci_highlight_missing_field('.cmb2-id--dci-servizio-categorie');
            return false;
        }

        /**
         * controllo compilazione campo A chi è rivolto
         */
        if (document.activeElement.id === 'publish' &&
            jQuery('select[name^="_dci_servizio_servizi_richiesti[]"]>option:selected').length === 0 &&
            tinymce.get('_dci_servizio_a_chi_e_rivolto') !== undefined &&
            tinymce.get('_dci_servizio_a_chi_e_rivolto').getContent() == "") {

            dci_highlight_missing_field('.cmb2-id--dci-servizio-a-chi-e-rivolto');

            tinymce.get('_dci_servizio_a_chi_e_rivolto').off('change keyup paste');
            tinymce.get('_dci_servizio_a_chi_e_rivolto').on('change keyup paste', function (e) {
                dci_remove_highlight_missing_field('.cmb2-id--dci-servizio-a-chi-e-rivolto');
            });

            return false;
        }

        /**
         * controllo compilazione campo Argomenti
         */
        if (document.activeElement.id === 'publish' && jQuery('input[name^="_dci_servizio_argomenti"]').length === 0) {
            dci_highlight_missing_field('.cmb2-id--dci-servizio-argomenti');
            return false;
        }

        /**
         * controllo compilazione campo Motivo dello stato
         */
        if (document.activeElement.id === 'publish' && jQuery('input[name^="_dci_servizio_stato"]:checked').val() === 'false' && !jQuery('textarea[name^="_dci_servizio_motivo_stato"]').val()) {
            dci_highlight_missing_field('.cmb2-id--dci-servizio-motivo-stato');
            return false;
        }

        /**
         * controllo che se il servizio non ha servizi richiesti allora abbia come fare, cosa serve e tempi e scadenze
         */
        if (document.activeElement.id === 'publish' && jQuery('select[name^="_dci_servizio_servizi_richiesti[]"]>option:selected').length === 0) {
            if (!controlla_che_wysiwyg_sia_compilato('_dci_servizio_come_fare'))
                return false

            if (!controlla_che_wysiwyg_sia_compilato('_dci_servizio_cosa_serve_introduzione'))
                return false

            if (!controlla_che_wysiwyg_sia_compilato('_dci_servizio_tempi_text'))
                return false
        }  

        if (document.activeElement.id !== 'publish' && document.activeElement.name !== 'save') {
            return true;
        }

        var unitaResponsabileValue = unitaResponsabileField.val();
        var puntiContattoValue = puntiContattoField.val();

        var isUnitaResponsabileEmpty = (unitaResponsabileValue === null || unitaResponsabileValue === '');
        var isPuntiContattoEmpty = (puntiContattoValue === null || puntiContattoValue.length === 0);

        dci_remove_highlight_missing_field(unitaResponsabileContainerClass);
        dci_remove_highlight_missing_field(puntiContattoContainerClass);

        if (isUnitaResponsabileEmpty && isPuntiContattoEmpty) {
            dci_highlight_missing_field(unitaResponsabileContainerClass, "È necessario compilare almeno uno tra 'Unità Organizzativa responsabile' o 'Contatti dedicati'.");
            e.preventDefault();
            return false;
        }

        return true;
    });
});

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
