document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-create');
    const btnCreate = document.getElementById('btn-create');

    if (!form || !btnCreate) {
        return;
    }

    btnCreate.addEventListener('click', async function(event) {
        event.preventDefault();
        toastrOption();
        blockUi();

        const formData = new FormData(form);
        try {
            const response = await axios.post('/school-year/store', formData);
            if (response.data.type === 'success') {
                toastr.success(response.data.message);
                unBlockUi();
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
