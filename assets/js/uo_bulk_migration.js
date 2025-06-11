(function ($) {
    $(document).ready(function () {
        var $button = $('#dci-start-bulk-migration-button');
        var $spinner = $('#dci-bulk-migration-spinner');
        var $feedbackDiv = $('#dci-migration-feedback');
        var $resultsContent = $('#dci-migration-results-content');

        $button.on('click', function () {
            if (!confirm(dci_bulk_migration_params.text_confirm_migration || 'Sei sicuro di voler avviare la migrazione massiva? Questa operazione &agreve; i dati dei post. Si consiglia un backup.')) {
                return;
            }

            $button.prop('disabled', true);
            $spinner.css('visibility', 'visible');
            $feedbackDiv.hide();
            $resultsContent.html(dci_bulk_migration_params.text_processing || 'Elaborazione in corso...');
            $feedbackDiv.removeClass('notice-success notice-error').show();


            $.ajax({
                url: dci_bulk_migration_params.ajax_url,
                type: 'POST',
                data: {
                    action: dci_bulk_migration_params.action, // Azione per la migrazione effettiva
                    nonce: dci_bulk_migration_params.nonce    // Nonce per la migrazione effettiva
                },
                success: function (response) {
                    $resultsContent.html('<p style="color: green;">' + response.data.message.replace(/\n/g, '<br>') + '</p>');
                    $feedbackDiv.removeClass('notice-error').addClass('notice notice-success is-dismissible').show();

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var errorText = dci_bulk_migration_params.text_error;
                    if (jqXHR.responseJSON && jqXHR.responseJSON.data && jqXHR.responseJSON.data.message) {
                        errorText = jqXHR.responseJSON.data.message;
                    } else if (jqXHR.responseText) {
                        try {
                            var errResponse = JSON.parse(jqXHR.responseText);
                            if (errResponse.data && errResponse.data.message) {
                                errorText = errResponse.data.message;
                            }
                        } catch (e) {
                            errorText = jqXHR.responseText.substring(0, 200) + "... (controlla la console per l'errore completo)";
                        }
                    }
                    $resultsContent.html('<p style="color: red;">' + errorText.replace(/\n/g, '<br>') + '</p>');
                    $feedbackDiv.removeClass('notice-success').addClass('notice notice-error is-dismissible').show();
                },
                complete: function () {
                    $button.prop('disabled', false);
                    $spinner.css('visibility', 'hidden');
                }
            });
        });

        $feedbackDiv.on('click', '.notice-dismiss', function () {
            $(this).closest('.is-dismissible').hide();
        });
    });
})(jQuery);
