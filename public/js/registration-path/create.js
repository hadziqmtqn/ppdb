document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formCreate');
    const btnCreate = document.getElementById('btn-submit');

    if (!form || !btnCreate) {
        return;
    }

    btnCreate.addEventListener('click', async function(event) {
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
        try {
            const response = await axios.post('/registration-path/store', formData);
            if (response.data.type === 'success') {
                toastr.success(response.data.message);
                unBlockUi();
                form.reset();
                $('#datatable').DataTable().ajax.reload();
                $('#modalCreate').modal('hide');
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
                        // Add is-invalid class to the input field
                        input.classList.add('is-invalid');

                        // Create error message element
                        const errorMessage = document.createElement('div');
                        errorMessage.classList.add('invalid-feedback');
                        errorMessage.innerHTML = errors[key].join('<br>');

                        // Check if the input is a select2 element
                        if ($(input).hasClass('select2-hidden-accessible')) {
                            const select2Container = $(input).next('.select2-container');
                            if (select2Container.length) {
                                select2Container.addClass('is-invalid');
                                select2Container.after(errorMessage);
                            }
                        } else {
                            // Append error message after the input field
                            if (input.parentNode.classList.contains('form-floating')) {
                                input.parentNode.appendChild(errorMessage);
                            } else {
                                input.parentNode.insertBefore(errorMessage, input.nextSibling);
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
