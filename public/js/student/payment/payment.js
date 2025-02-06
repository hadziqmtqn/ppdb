document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[name="registration_fee_id[]"]');
    const form = document.getElementById('registration-fee-form');
    const payNow = document.getElementById('pay-now');
    const username = payNow.dataset.username;

    if (!form || !payNow) {
        return;
    }

    payNow.addEventListener('click', async function(event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        const formData = new FormData(form);

        /*checkboxes.forEach((checkbox) => {
            if (!checkbox.checked) {
                formData.delete('registration_fee_id[]', checkbox.value);
                formData.delete('paid_amount[' + checkbox.value + ']');
            }
        });*/
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
            }
        } catch (error) {
            toastr.error(error.response.data.message);
            unBlockUi();
        }
    });
});
