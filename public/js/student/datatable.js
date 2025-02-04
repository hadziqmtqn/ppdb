$(function () {
    const table = '#datatable';
    const schoolYear = $('#select-school-year'),
        educationalInstitution = $('#select-educational-institution-0'),
        registrationCategory = $('#select-registration-category'),
        registrationPath = $('#select-registration-path');

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[2, 'asc']],
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
                d.registration_status = $('#registrationStatus').val();
                d.status = $('#userStatus').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'registrationNumber', name: 'registrationNumber'},
            {data: 'name', name: 'name'},
            {data: 'educationalInstitution', name: 'educationalInstitution'},
            {data: 'registrationCategory', name: 'registrationCategory'},
            {data: 'allCompleted', name: 'allCompleted', orderable: false, searchable: false},
            {data: 'registrationValidation', name: 'registrationValidation', orderable: false, searchable: false},
            {data: 'registrationStatus', name: 'registrationStatus', orderable: false, searchable: false},
        ],
        dom:
            '<"row mx-1"' +
            '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
            '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"' +
            'f' + // Input pencarian DataTable
            '<"filters d-flex gap-2">' + // Container untuk filter tambahan
            '>' +
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
                text: '<i class="mdi mdi-download me-1"></i>Export',
                className: 'btn btn-primary btn-sm waves-effect waves-light',
                attr: {
                    'id': 'exportExcelButton',
                }
            }
        ],
        initComplete: function () {
            // Pastikan filter berada di dalam `.filters` yang sudah didefinisikan dalam `dom`
            $('<select id="userStatus" class="form-select text-capitalize">' +
                '<option value="">Semua Status Akun</option>' +
                '<option value="active">Aktif</option>' +
                '<option value="inactive">Tidak Aktif</option>' +
                '<option value="deleted">Terhapus</option>' +
                '</select>'
            )
                .appendTo('.filters')
                .on('change', function () {
                    const val = $(this).val();
                    dataTable.column(4).search(val ? '^' + val + '$' : '', true, false).draw();
                });

            $('<select id="registrationStatus" class="form-select text-capitalize">' +
                '<option value="">Semua Status Registrasi</option>' +
                '<option value="belum_diterima">Belum Diterima</option>' +
                '<option value="diterima">Diterima</option>' +
                '<option value="ditolak">Ditolak</option>' +
                '</select>'
            )
                .appendTo('.filters')
                .on('change', function () {
                    const val = $(this).val();
                    dataTable.column(5).search(val ? '^' + val + '$' : '', true, false).draw();
                });
        },
    });

    dataTable.on('draw.dt', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body
            });
        });
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
            registration_category_id: registrationCategory.val()
        });

        dataTable.ajax.reload();
    });

    dataTable.off('click.delete').on('click', '.delete', function () {
        let username = $(this).data('username');
        let url = '/student/' + username + '/delete';
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
                }).then(async function (response) {
                    toastr.success(response.data.message);
                    reloadTable();
                    await fetchData();
                    unBlockUi();
                }).catch(function (error) {
                    unBlockUi();
                    toastr.error(error.response.data.message);
                });
            }
        });
    });

    dataTable.off('click.restore').on('click.restore', '.restore', function () {
        let username = $(this).data('username');
        let url = '/student/' + username + '/restore';
        let token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Peringatan!',
            text: "Apakah Anda ingin mengembalikan data ini?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA!',
            customClass: {
                confirmButton: 'btn btn-warning me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect'
            },
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                blockUi();

                axios.put(url, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                }).then(async function (response) {
                    toastr.success(response.data.message);
                    reloadTable();
                    await fetchData();
                    unBlockUi();
                }).catch(function (error) {
                    unBlockUi();
                    toastr.error(error.response.data.message);
                });
            }
        });
    });

    dataTable.off('click.force-delete').on('click.force-delete', '.force-delete', function () {
        let username = $(this).data('username');
        let url = '/student/' + username + '/permanently-delete';
        let token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Peringatan!',
            text: "Data tidak bisa dikembalikan, termasuk data Registrasi Siswa yang berkaitan dengan data ini! Apakah Anda ingin menghapus permanen data ini?",
            icon: 'warning',
            input: 'password', // Menambahkan input password
            inputAttributes: {
                autocapitalize: 'off',
                placeholder: 'Masukkan kata sandi Anda'
            },
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS PERMANEN!',
            customClass: {
                confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect'
            },
            buttonsStyling: false,
            reverseButtons: true,
            preConfirm: (password) => {
                if (!password) {
                    Swal.showValidationMessage('Password wajib diisi!');
                    return false;
                }

                return axios.post('/password-validation', { password: password }, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                }).then(response => {
                    if (!response.data.success) {
                        throw new Error('Password salah!');
                    }
                }).catch(error => {
                    Swal.showValidationMessage(error.response.data.message || 'Terjadi kesalahan pada server.');
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                blockUi();

                axios.delete(url, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                }).then(async function (response) {
                    toastr.success(response.data.message);
                    reloadTable();
                    await fetchData();
                    unBlockUi();
                }).catch(function (error) {
                    unBlockUi();
                    toastr.error(error.response.data.message);
                });
            }
        });
    });

    // export excel
    exportExcelHandler();
});