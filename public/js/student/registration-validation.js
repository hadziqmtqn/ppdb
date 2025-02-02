document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formValidation');
    const username = form.dataset.username;
    const btnSubmit = document.getElementById('btn-submit');

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
            const response = await axios.post(`/student-validation/${username}/store`, formData);
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
                for (const key in errors) {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.type === 'radio') {
                            // Temukan semua radio button dengan name yang sama
                            const radioGroup = form.querySelectorAll(`[name="${key}"]`);
                            if (radioGroup.length) {
                                // Tambahkan kelas is-invalid pada setiap radio button
                                radioGroup.forEach(radio => radio.classList.add('is-invalid'));

                                // Cek apakah sudah ada pesan error sebelumnya
                                let errorMessage = form.querySelector(`#${key}-error`);
                                if (!errorMessage) {
                                    // Buat elemen error baru
                                    errorMessage = document.createElement('div');
                                    errorMessage.classList.add('invalid-feedback', 'd-block');
                                    errorMessage.id = `${key}-error`;
                                    errorMessage.innerHTML = errors[key].join('<br>');

                                    // Sisipkan error setelah grup radio terakhir
                                    radioGroup[radioGroup.length - 1].parentNode.insertAdjacentElement('afterend', errorMessage);
                                }
                            }
                        } else {
                            // Tambahkan is-invalid untuk input biasa
                            input.classList.add('is-invalid');

                            // Buat error message element
                            const errorMessage = document.createElement('div');
                            errorMessage.classList.add('invalid-feedback');
                            errorMessage.innerHTML = errors[key].join('<br>');

                            if ($(input).hasClass('select2-hidden-accessible')) {
                                const select2Container = $(input).next('.select2-container');
                                if (select2Container.length) {
                                    select2Container.addClass('is-invalid');
                                    select2Container.after(errorMessage);
                                }
                            } else {
                                if (input.parentNode.classList.contains('form-floating')) {
                                    input.parentNode.appendChild(errorMessage);
                                } else {
                                    input.parentNode.insertBefore(errorMessage, input.nextSibling);
                                }
                            }
                        }
                    }
                }
            } else {
                toastr.error(error.response.data.message);
            }
            unBlockUi();
        }
    });
});
