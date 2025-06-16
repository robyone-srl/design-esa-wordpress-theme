jQuery( document ).ready(function() {	
	jQuery(document).on('cmb2_add_row', function(event, groupWrap, newGroup) {
        console.log('Evento catturato!');
        console.log('Contenitore:', groupWrap);
        console.log('Nuovo gruppo:', newGroup);
        var $id = groupWrap[0].id;
		
		jQuery("#" + $id).find('div[data-fieldname$="[contenuto_evidenza]"]').each(function() {
			var $firstLi = jQuery(this).find('.attached li').first();
			var $removeBtn = $firstLi.find('.dashicons-minus.add-remove');

			if ($removeBtn.length) {
				$removeBtn.trigger('click');
			}
		});
		
    });
});