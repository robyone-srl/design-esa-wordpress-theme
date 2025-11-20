document.addEventListener('DOMContentLoaded', function () {
    const saveButton = document.getElementById('save-selection');
    const orderModalElement = document.getElementById('OrderModal');

    if (!saveButton || !orderModalElement) {
        return;
    }

    const orderModalInstance = new bootstrap.Modal(orderModalElement);
    const orderRadioButtons = orderModalElement.querySelectorAll('input[name="order_by"]');
    const filterRadioButtons = orderModalElement.querySelectorAll('input[name="apply_filter"]');

    const flexContainer = document.querySelector('.d-flex.align-items-center.justify-content-between');
    const currentOrder = flexContainer ? flexContainer.dataset.currentOrder : 'post_title_asc';
    const currentFilter = flexContainer ? flexContainer.dataset.currentFilter : '';
	
    const loadingHtml = `<div id="loading-overlay" style="position: fixed; top: 0; left: 0; z-index: 1050; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.75); display: flex; justify-content: center; align-items: center;">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Caricamento...</span>
            </div>
            <p class="mt-2">Caricamento...</p>
        </div>
    </div>`;

    function updateSaveButtonState() {
        const selectedOrderOption = document.querySelector('input[name="order_by"]:checked');
        const selectedFilterOption = document.querySelector('input[name="apply_filter"]:checked');
				
        if ((selectedOrderOption && selectedOrderOption.value !== currentOrder)||(selectedFilterOption && selectedFilterOption.value !== currentFilter)) {
            saveButton.removeAttribute('disabled');
        } else {
            saveButton.setAttribute('disabled', 'true');
        }
    }

    orderRadioButtons.forEach(radio => {
        radio.addEventListener('change', updateSaveButtonState);
    });
    filterRadioButtons.forEach(radio => {
        radio.addEventListener('change', updateSaveButtonState);
    });

    orderModalElement.addEventListener('shown.bs.modal', function () {
        const currentOrderRadio = orderModalElement.querySelector(`input[value="${currentOrder}"]`);
        if (currentOrderRadio) {
            currentOrderRadio.checked = true;
        }
		
		const currentRadioFilter = orderModalElement.querySelector(`input[value="${currentFilter}"]`);
        if (currentRadioFilter) {
            currentRadioFilter.checked = true;
        }
		
        updateSaveButtonState();
    });

    saveButton.addEventListener('click', function () {
        const selectedOrderOption = document.querySelector('input[name="order_by"]:checked');
        const selectedFilterOption = document.querySelector('input[name="apply_filter"]:checked');

        if (selectedOrderOption || selectedFilterOption) {
            orderModalInstance.hide();
            document.body.insertAdjacentHTML('beforeend', loadingHtml);
        }
    });
});