$(function () {
    const table = '#datatable';

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[1, 'asc']],
        ajax: {
            url: "/registration-setting/datatable",
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
            {data: 'accepted_with_school_report', name: 'accepted_with_school_report'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        dom:
            '<"row mx-2"' +
            '<"col-md-2"<"me-3"l>>' +
            '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0 gap-3"fB>>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        buttons: [
            {
                text: '<i class="mdi mdi-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Baru</span>',
                className: 'btn btn-primary waves-effect waves-light',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#modalCreate',
                }
            }
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
        const educationalInstitution = button.data('educational-institution');
        const accepted = button.data('accepted');

        $('#editEducationalInstitution').val(educationalInstitution);

        // Pilih radio button sesuai nilai active
        if (accepted === 1) {
            $('#editYes').prop('checked', true);
        } else {
            $('#editNo').prop('checked', true);
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
            axios.put(`/registration-setting/${slug}/update`, $('#formEdit').serialize())
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