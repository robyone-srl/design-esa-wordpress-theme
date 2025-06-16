(function ($) {
    $(document).ready(function () {
		
		
		var $buttons = $(".start-bulk-migration-button");
        var $spinner = $('#dci-bulk-migration-spinner');
        var $feedbackDiv = $('#dci-migration-feedback');
        var $resultsContent = $('#dci-migration-results-content');

		$(".migrations").on("click", ".start-bulk-migration-button", function () {
			
			var $type = $(this).attr("data-type");
			
			var $params = dci_bulk_migration_params[$type];
		
            if (!confirm($params.text_confirm_migration || 'Sei sicuro di voler avviare la migrazione massiva? Questa operazione potrebbe richiedere del tempo su siti con molti post. Si consiglia un backup.')) {
                return;
            }

            $buttons.prop('disabled', true);
            $spinner.css('visibility', 'visible');
            $feedbackDiv.hide();
            $resultsContent.html($params.text_processing || 'Elaborazione in corso...');
            $feedbackDiv.removeClass('notice-success notice-error').show();


            $.ajax({
                url: $params.ajax_url,
                type: 'POST',
                data: {
                    action: $params.action, // Azione per la migrazione effettiva
                    nonce: $params.nonce    // Nonce per la migrazione effettiva
                },
                success: function (response) {
                    $resultsContent.html('<p style="color: green;">' + response.data.message.replace(/\n/g, '<br>') + '</p>');
                    $feedbackDiv.removeClass('notice-error').addClass('notice notice-success is-dismissible').show();

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var errorText = $params.text_error;
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
                    $buttons.prop('disabled', false);
                    $spinner.css('visibility', 'hidden');
                }
            });
        });

        $feedbackDiv.on('click', '.notice-dismiss', function () {
            $(this).closest('.is-dismissible').hide();
        });
    });
})(jQuery);
