$(function () {
    const table = '#datatable';

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[1, 'asc']],
        ajax: {
            url: "/payment-setting/datatable",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function (d) {
                d.search = $(table + '_filter ' + 'input[type="search"]').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'educationalInstitution', name: 'educationalInstitution'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    });

    function reloadTable() {
        const currentPage = dataTable.page();
        dataTable.ajax.reload();
        dataTable.page(currentPage).draw('page');
    }

    $('#modalEdit').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const slug = button.data('slug');
        const paymentMethod = button.data('payment-method');

        // Pilih radio button sesuai nilai active
        if (paymentMethod === 'MANUAL_PAYMENT') {
            $('#manual').prop('checked', true);
        } else {
            $('#gateway').prop('checked', true);
        }

        // Atur event handler untuk tombol "Simpan"
        $('#btn-edit').off('click').on('click', function() {
            blockUi();
            toastrOption();

            // Clear previous errors
            const form = document.getElementById('formEdit');
            form.querySelectorAll('.is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(element => {
                element.remove();
            });

            // menggunakan axios
            axios.put(`/payment-setting/${slug}/update`, $('#formEdit').serialize())
                .then(response => {
                    unBlockUi();
                    $('#modalEdit').modal('hide');
                    toastr.success(response.data.message);
                    reloadTable();
                })
                .catch(error => {
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

                                // Append error message after the input field
                                if (input.parentNode.classList.contains('form-floating')) {
                                    input.parentNode.appendChild(errorMessage);
                                } else {
                                    input.parentNode.insertBefore(errorMessage, input.nextSibling);
                                }
                            }
                        }
                    } else {
                        toastr.error(error.response.data.message);
                    }
                    unBlockUi();
                });
        });
    });
});