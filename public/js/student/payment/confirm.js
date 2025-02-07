document.addEventListener('DOMContentLoaded', function () {
    const formPaymentConfirm = document.getElementById('formPaymentConfirm');
    const btnBillConfirm = document.getElementById('btn-bill-confirm');
    const slug = formPaymentConfirm.dataset.slug;

    if (!formPaymentConfirm || !btnBillConfirm) {
        return;
    }

    btnBillConfirm.addEventListener('click', function(event) {
        event.preventDefault();
        blockUi();
        toastrOption();

        const formData = new FormData();
        const fileInput = document.getElementById('file');
        const file = fileInput.files[0];

        if (!file) {
            toastr.error('Harap upload bukti pembayaran.');
            unBlockUi();
            return;
        }

        formData.append('file', file);

        axios.put(`/payment-transaction/${slug}/confirmation`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
            .then(function(response) {
                toastr.success(response.data.message);
                unBlockUi();

                if (response.data.redirect) {
                    window.location.href = response.data.redirect;
                }
            })
            .catch(function(error) {
                if (error.response && error.response.data && error.response.data.message) {
                    toastr.error(error.response.data.message);
                } else {
                    toastr.error('An error occurred while uploading the file.');
                }
                unBlockUi();
            });
    });
});
