document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationScheduleForm');
    const btnCreate = document.getElementById('btn-submit-registration-schedule');

    if (!form || !btnCreate) {
        return;
    }

    btnCreate.addEventListener('click', async function(event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        const formData = new FormData(form);
        try {
            const response = await axios.post('/registration-schedule/store', formData);
            if (response.data.type === 'success') {
                toastr.success(response.data.message);
                unBlockUi();
                form.reset();
                $('#datatable-registration-schedule').DataTable().ajax.reload();
                $('#modalCreateRegistrationSchedule').modal('hide');
                return;
            }

            const errors = response.data.errors;
            let message = '';
            for (const key in errors) {
                message += errors[key].join(', ') + '<br>';
            }
            toastr.error(message);
            unBlockUi();
        }catch (error) {
            toastr.error(error.response.data.message);
            unBlockUi();
        }
    });
});
