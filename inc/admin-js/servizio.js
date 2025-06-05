jQuery(document).ready(function ($) { 

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
    var incaricoServiziField = jQuery('#_dci_servizio_incarico_servizi'); 
    var puntiContattoField = jQuery('#_dci_servizio_punti_contatto');

    var unitaResponsabileContainerClass = '.cmb2-id--dci-servizio-unita-responsabile';
    var incaricoServiziContainerClass = '.cmb2-id--dci-servizio-incarico-servizi'; 
    var puntiContattoContainerClass = '.cmb2-id--dci-servizio-punti-contatto';

    function checkAndRemoveHighlightForGroup(fieldValue, containerClass) {
        var isFieldFilled = ($.isArray(fieldValue)) ? (fieldValue !== null && fieldValue.length > 0) : (fieldValue !== '' && fieldValue !== null);
        if (isFieldFilled) {
            dci_remove_highlight_missing_field(containerClass);

            var urVal = unitaResponsabileField.val();
            var isVal = incaricoServiziField.val();
            var pcVal = puntiContattoField.val();

            var isUrEmpty = (urVal === null || urVal === '');
            var isIsEmpy = (isVal === null || !isVal || isVal.length === 0); 
            var isPcEmpty = (pcVal === null || !pcVal || pcVal.length === 0);

            if (!isUrEmpty || !isIsEmpy || !isPcEmpty) {
                dci_remove_highlight_missing_field(unitaResponsabileContainerClass);
                dci_remove_highlight_missing_field(incaricoServiziContainerClass);
                dci_remove_highlight_missing_field(puntiContattoContainerClass);
            }
        }
    }

    unitaResponsabileField.on('change', function () {
        checkAndRemoveHighlightForGroup(jQuery(this).val(), unitaResponsabileContainerClass);
    });

    incaricoServiziField.on('change', function () {
        checkAndRemoveHighlightForGroup(jQuery(this).val(), incaricoServiziContainerClass);
    });

    puntiContattoField.on('change', function () {
        checkAndRemoveHighlightForGroup(jQuery(this).val(), puntiContattoContainerClass);
    });

    jQuery('form[name="post"]').on('submit', function (e) {

        var activeElementId = document.activeElement.id;
        var activeElementName = document.activeElement.name;
        var isPublishOrSave = (activeElementId === 'publish' || activeElementName === 'save');

        if (isPublishOrSave && jQuery('input[name^="_dci_servizio_categorie"]:checked').length === 0) {
            dci_highlight_missing_field('.cmb2-id--dci-servizio-categorie', 'Il campo Categorie Servizio &egrave; obbligatorio.');
            e.preventDefault(); return false;
        }

        if (isPublishOrSave &&
            (jQuery('select[name^="_dci_servizio_servizi_richiesti[]"]').val() === null || jQuery('select[name^="_dci_servizio_servizi_richiesti[]"]').val().length === 0) && 
            typeof tinymce !== 'undefined' && tinymce.get('_dci_servizio_a_chi_e_rivolto') && 
            tinymce.get('_dci_servizio_a_chi_e_rivolto').getContent() === "") {
            dci_highlight_missing_field('.cmb2-id--dci-servizio-a-chi-e-rivolto', 'Il campo "A chi &egrave; rivolto" &egrave; obbligatorio se non sono specificati "Servizi richiesti".');
            if (tinymce.get('_dci_servizio_a_chi_e_rivolto')) {
                tinymce.get('_dci_servizio_a_chi_e_rivolto').off('change keyup paste');
                tinymce.get('_dci_servizio_a_chi_e_rivolto').on('change keyup paste', function () {
                    dci_remove_highlight_missing_field('.cmb2-id--dci-servizio-a-chi-e-rivolto');
                });
            }
            e.preventDefault(); return false;
        }

        if (isPublishOrSave && jQuery('input[name^="_dci_servizio_argomenti"]:checked').length === 0) { 
            dci_highlight_missing_field('.cmb2-id--dci-servizio-argomenti', 'Il campo Argomenti &egrave; obbligatorio.');
            e.preventDefault(); return false;
        }

        if (isPublishOrSave && jQuery('input[name^="_dci_servizio_stato"]:checked').val() === 'false' && !jQuery('textarea[name^="_dci_servizio_motivo_stato"]').val()) {
            dci_highlight_missing_field('.cmb2-id--dci-servizio-motivo_stato', 'Il campo "Motivo dello stato" &egrave; obbligatorio se lo stato &egrave; Disattivo.');
            e.preventDefault(); return false;
        }

        if (isPublishOrSave && (jQuery('select[name^="_dci_servizio_servizi_richiesti[]"]').val() === null || jQuery('select[name^="_dci_servizio_servizi_richiesti[]"]').val().length === 0)) {
            if (typeof controlla_che_wysiwyg_sia_compilato === "function") { 
                if (!controlla_che_wysiwyg_sia_compilato('_dci_servizio_come_fare', '.cmb2-id--dci-servizio-come-fare')) { e.preventDefault(); return false; }
                if (!controlla_che_wysiwyg_sia_compilato('_dci_servizio_cosa_serve_introduzione', '.cmb2-id--dci-servizio-cosa-serve-introduzione')) { e.preventDefault(); return false; }
                if (!controlla_che_wysiwyg_sia_compilato('_dci_servizio_tempi_text', '.cmb2-id--dci-servizio-tempi-text')) { e.preventDefault(); return false; }
            }
        }

        if (isPublishOrSave) {
            var unitaResponsabileValue = unitaResponsabileField.val();
            var incaricoServiziValue = incaricoServiziField.val();
            var puntiContattoValue = puntiContattoField.val();

            var isUnitaResponsabileEmpty = (unitaResponsabileValue === null || unitaResponsabileValue === '');
            var isIncaricoServiziEmpty = (incaricoServiziValue === null || !incaricoServiziValue || incaricoServiziValue.length === 0);
            var isPuntiContattoEmpty = (puntiContattoValue === null || !puntiContattoValue || puntiContattoValue.length === 0); 

            dci_remove_highlight_missing_field(unitaResponsabileContainerClass);
            dci_remove_highlight_missing_field(incaricoServiziContainerClass);
            dci_remove_highlight_missing_field(puntiContattoContainerClass);

            if (isUnitaResponsabileEmpty && isIncaricoServiziEmpty && isPuntiContattoEmpty) {
                var errorMessageContacts = "&Egrave; necessario compilare almeno uno tra 'Unit&agrave; Organizzativa responsabile', 'Persone incaricate' o 'Contatti dedicati'.";
                dci_highlight_missing_field(unitaResponsabileContainerClass, errorMessageContacts);
                e.preventDefault();
                return false;
            }
        }
        return true;
    });

    function dci_highlight_missing_field(fieldClass, customMessage) {
        var message = customMessage || 'Campo obbligatorio'; 
        var $fieldContainer = jQuery(fieldClass);

        $fieldContainer.find('.field-required-msg').remove();
        $fieldContainer.addClass("highlighted_missing_field")
            .append('<div class="field-required-msg"><em>' + message + '</em></div>');

        var $firstHighlightedField = jQuery(".highlighted_missing_field:first");
        if ($firstHighlightedField.length && $firstHighlightedField.is(":visible")) {
            var rect = $firstHighlightedField[0].getBoundingClientRect();
            var isVisible = (
                rect.top >= 0 && rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
            if (!isVisible) {
                jQuery('html,body').animate({
                    scrollTop: $firstHighlightedField.offset().top - 100
                }, 'slow');
            }
        }
    }

    function dci_remove_highlight_missing_field(fieldClass) {
        jQuery(fieldClass).removeClass("highlighted_missing_field");
        jQuery(fieldClass).find('.field-required-msg').remove(); 
    }
});
