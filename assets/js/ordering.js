document.addEventListener('DOMContentLoaded', function () {
    const saveButton = document.getElementById('save-selection');
    const orderModalElement = document.getElementById('OrderModal');

    if (!saveButton || !orderModalElement) {
        return;
    }

    const orderModalInstance = new bootstrap.Modal(orderModalElement);
    const radioButtons = orderModalElement.querySelectorAll('input[name="order_by"]');

    const flexContainer = document.querySelector('.d-flex.align-items-center.justify-content-between');
    const currentOrder = flexContainer ? flexContainer.dataset.currentOrder : 'post_title_asc';

    const loadingHtml = `<div id="loading-overlay" style="position: fixed; top: 0; left: 0; z-index: 1050; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.75); display: flex; justify-content: center; align-items: center;">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Caricamento...</span>
            </div>
            <p class="mt-2">Caricamento...</p>
        </div>
    </div>`;

    function updateSaveButtonState() {
        const selectedOption = document.querySelector('input[name="order_by"]:checked');
        if (selectedOption && selectedOption.value !== currentOrder) {
            saveButton.removeAttribute('disabled');
        } else {
            saveButton.setAttribute('disabled', 'true');
        }
    }

    radioButtons.forEach(radio => {
        radio.addEventListener('change', updateSaveButtonState);
    });

    orderModalElement.addEventListener('shown.bs.modal', function () {
        const currentRadio = orderModalElement.querySelector(`input[value="${currentOrder}"]`);
        if (currentRadio) {
            currentRadio.checked = true;
        }
        updateSaveButtonState();
    });

    saveButton.addEventListener('click', function () {
        const selectedOption = document.querySelector('input[name="order_by"]:checked');

        if (selectedOption) {
            orderModalInstance.hide();
            document.body.insertAdjacentHTML('beforeend', loadingHtml);
        }
    });
});