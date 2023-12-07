jQuery(document).ready(function() {
    var $ = jQuery;
    if ($('.set_custom_image').length > 0) {
        if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            $('.set_custom_image').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var input = $('[id="'+button[0].id.replace('_button', ''+'"]'));
                var image = $('[id="'+button[0].id.replace('_button', ''+'_image"]'));
                var remove_button = $('[id="'+button[0].id.replace('_button', ''+'_remove_button"]'));
                wp.media.editor.send.attachment = function(props, attachment) {
                    input.val(attachment.id);
                    image.attr('src', attachment.url);
                    image.show();
                    remove_button.show();
                };
                wp.media.editor.open(button);
                return false;
            });

            $('.remove_custom_image').on('click', function(e) {
                e.preventDefault();
                var remove_button = $(this);
                var input = $('[id="'+remove_button[0].id.replace('_remove_button', ''+'"]'));
                var image = $('[id="'+remove_button[0].id.replace('_remove_button', ''+'_image"]'));

                input.val('');
                image.hide()
                remove_button.hide();
                return false;
            });
        }
    }
});

