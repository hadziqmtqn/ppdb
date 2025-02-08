document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('paymentValidationForm');
    const slug = form.dataset.slug;
    const btnSubmit = document.getElementById('btn-submit-validation');

    if (!form || !btnSubmit) {
        return;
    }

    // Function to clear specific field errors
    const clearFieldError = (input) => {
        if (input.classList.contains('is-invalid')) {
            input.classList.remove('is-invalid');
            const errorFeedback = input.parentNode.querySelector('.invalid-feedback');
            if (errorFeedback) {
                errorFeedback.remove();
            }
        }
    };

    // Attach input or change event to all inputs
    form.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('input', () => clearFieldError(input));
        input.addEventListener('change', () => clearFieldError(input));
    });

    btnSubmit.addEventListener('click', async function (event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        // Clear previous errors
        form.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });

        form.querySelectorAll('.invalid-feedback').forEach(element => {
            element.remove();
        });

        form.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const radioGroup = form.querySelectorAll(`[name="${this.name}"]`);
                radioGroup.forEach(r => r.classList.remove('is-invalid'));

                const errorMessage = document.getElementById(`${this.name}-error`);
                if (errorMessage) {
                    errorMessage.remove();
                }
            });
        });

        const formData = new FormData(form);

        try {
            const response = await axios.post(`/payment-transaction/${slug}/validation`, formData);
            if (response.data.type === 'success') {
                toastr.success(response.data.message);
                unBlockUi();

                if (response.data.redirect) {
                    window.location.href = response.data.redirect;
                }

                return;
            }

            const errors = response.data.errors;
            let message = '';
            for (const key in errors) {
                message += errors[key].join(', ') + '<br>';
            }
            toastr.error(message);
            unBlockUi();
        } catch (error) {
            if (error.response.status === 422) {
                const errors = error.response.data.message;

                // Bersihkan pesan error lama sebelum menampilkan yang baru
                let errorContainer = form.querySelector('.select-valid-option-error');
                if (errorContainer) {
                    errorContainer.remove();
                }

                // Buat container untuk menampilkan pesan error di bawah .select-valid-option
                errorContainer = document.createElement('div');
                errorContainer.classList.add('alert', 'alert-danger', 'mt-2', 'select-valid-option-error');

                let message = '';
                for (const key in errors) {
                    message += `<strong>${key.replace('_', ' ').toUpperCase()}:</strong> ${errors[key].join(', ')} <br>`;
                }

                errorContainer.innerHTML = message;

                // Sisipkan errorContainer setelah .select-valid-option
                const selectStatusOption = form.querySelector('.select-valid-option');
                if (selectStatusOption) {
                    selectStatusOption.insertAdjacentElement('afterend', errorContainer);
                }
            } else {
                toastr.error(error.response.data.message);
            }
            unBlockUi();
        }
    });
});
