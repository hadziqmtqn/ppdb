document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formChangePassword');
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

        const formData = new FormData(form);

        // Menambahkan _method untuk PUT request
        formData.append('_method', 'PUT');

        try {
            const response = await axios.post(`/student-security/${username}/store`, formData);
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
                    // Cari elemen input berdasarkan nama
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        // Tambahkan kelas is-invalid
                        input.classList.add('is-invalid');

                        // Cari input-group jika ada
                        const inputGroup = input.closest('.input-group.input-group-merge');

                        // Hapus error sebelumnya
                        let existingError = inputGroup ? inputGroup.querySelector('.invalid-feedback') : input.parentNode.querySelector('.invalid-feedback');
                        if (existingError) {
                            existingError.remove();
                        }

                        // Buat elemen pesan error baru
                        const errorMessage = document.createElement('div');
                        errorMessage.classList.add('invalid-feedback', 'd-block');
                        errorMessage.innerHTML = errors[key].join('<br>');

                        // Tempatkan error di bawah input-group jika ada, jika tidak di bawah input
                        if (inputGroup) {
                            inputGroup.insertAdjacentElement('afterend', errorMessage);
                        } else {
                            input.parentNode.insertBefore(errorMessage, input.nextSibling);
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

