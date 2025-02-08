$(function () {
    const table = '#datatable';
    const educationalInstitution = $('#select-educational-institution, #select-educational-institution-0');
    const status = $('#select-status');

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[1, 'asc']],
        ajax: {
            url: "/payment-transaction/datatable",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function (d) {
                d.search = $(table + '_filter ' + 'input[type="search"]').val();
                d.educational_institution_id = educationalInstitution.val();
                d.status = status.val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'user', name: 'user'},
            {data: 'educationalInstitution', name: 'educationalInstitution'},
            {data: 'code', name: 'code'},
            {data: 'amount', name: 'amount'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    });

    function reloadTable() {
        const currentPage = dataTable.page();
        dataTable.ajax.reload();
        dataTable.page(currentPage).draw('page');
    }

    $('.filter').on('change', function () {
        console.log(educationalInstitution.val());
        dataTable.ajax.params({
            educational_institution_id: educationalInstitution.val(),
            status: status.val()
        });

        dataTable.ajax.reload();
    });

    dataTable.off('click').on('click', '.delete', function () {
        let slug = $(this).data('slug');
        let url = '/payment-transaction/' + slug + '/delete';
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