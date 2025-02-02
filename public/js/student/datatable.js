$(function () {
    const table = '#datatable';
    const schoolYear = $('#select-school-year'),
        educationalInstitution = $('#select-educational-institution'),
        registrationCategory = $('#select-registration-category'),
        registrationPath = $('#select-registration-path'),
        registrationStatus = $('#registration-status');

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[1, 'asc']],
        ajax: {
            url: "/student/datatable",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function (d) {
                d.search = $(table + '_filter ' + 'input[type="search"]').val();
                d.school_year_id = schoolYear.val();
                d.educational_institution_id = educationalInstitution.val();
                d.registration_category_id = registrationCategory.val();
                d.registration_path_id = registrationPath.val();
                d.registration_status = registrationStatus.val();
                d.status = $('#userStatus').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'registrationNumber', name: 'registrationNumber'},
            {data: 'name', name: 'name'},
            {data: 'educationalInstitution', name: 'educationalInstitution'},
            {data: 'registrationCategory', name: 'registrationCategory'},
            {data: 'registrationStatus', name: 'registrationStatus'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        dom:
            '<"row mx-1"' +
            '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
            '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"user_status mb-3 mb-md-0">>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Cari data'
        },
        buttons: [
            {
                text: '<i class="mdi mdi-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Export</span>',
                className: 'btn btn-primary waves-effect waves-light',
                attr: {
                    'id': 'export',
                }
            }
        ],
        initComplete: function () {
            // Mengganti filter peran dengan pilihan manual
            $(
                '<select id="userStatus" class="form-select text-capitalize">' +
                '<option value="active">Aktif</option>' +
                '<option value="inactive">Tidak Aktif</option>' +
                '<option value="deleted">Terhapus</option>' +
                '</select>'
            )
                .appendTo('.user_status')
                .on('change', function () {
                    const val = $(this).val();
                    // Mengubah pencarian berdasarkan pilihan manual
                    dataTable.column(4).search(val ? '^' + val + '$' : '', true, false).draw();
                });
        },
    });

    function reloadTable() {
        const currentPage = dataTable.page();
        dataTable.ajax.reload();
        dataTable.page(currentPage).draw('page');
    }

    $('.filter').on('change', function () {
        dataTable.ajax.params({
            school_year_id: schoolYear.val(),
            educational_institution_id: educationalInstitution.val(),
            registration_path_id: registrationPath.val(),
            registration_category: registrationCategory.val(),
            registration_status: registrationStatus.val(),
        });

        dataTable.ajax.reload();
    });

    dataTable.off('click').on('click', '.delete', function () {
        let slug = $(this).data('slug');
        let url = '/student/' + slug + '/delete';
        let token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Peringatan!',
            text: "Apakah Anda ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!',
            customClass: {
                confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect'
            },
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                blockUi();

                axios.delete(url, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                }).then(function (response) {
                    toastr.success(response.data.message);
                    reloadTable();
                    unBlockUi();
                }).catch(function (error) {
                    unBlockUi();
                    toastr.error(error.response.data.message);
                });
            }
        });
    });
});