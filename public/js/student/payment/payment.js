document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[name="registration_fee_id[]"]');
    const form = document.getElementById('registration-fee-form');
    const payNow = document.getElementById('pay-now');
    const errorMessageContainer = document.getElementById('error-message');

    const username = payNow.dataset.username;

    if (!form || !payNow) {
        return;
    }

    payNow.addEventListener('click', async function(event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        errorMessageContainer.innerHTML = '';

        const formData = new FormData(form);

        checkboxes.forEach((checkbox) => {
            if (!checkbox.checked) {
                formData.delete(`registration_fee_id[${checkbox.value}]`);
                formData.delete(`paid_amount[${checkbox.value}]`);
            }
        });

        try {
            const response = await axios.post(`/payment/${username}/store`, formData);
            if (response.data.type === 'success') {
                toastr.success(response.data.message);
                unBlockUi();

                if (response.data.redirect) {
                    window.location.href = response.data.redirect;
                }
            }
        } catch (error) {
            if (error.response.status === 422) {
                errorMessageContainer.innerHTML = `
                    <div class="alert alert-solid-danger d-flex align-items-center" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        ${error.response.data.message}
                    </div>
                `;
            }else {
                toastr.error(error.response.data.message);
            }
            unBlockUi();
        }
    });
});
