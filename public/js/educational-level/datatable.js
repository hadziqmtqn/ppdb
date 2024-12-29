$(function () {
    const table = '#datatable';

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[1, 'asc']],
        ajax: {
            url: "/educational-level/datatable",
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
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });


    // Menyimpan halaman saat ini sebelum reload
    function reloadTable() {
        const currentPage = dataTable.page();
        dataTable.ajax.reload();
        dataTable.page(currentPage).draw('page');
    }

    $('#modalEdit').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const slug = button.data('slug');
        const name = button.data('name');

        // Isi nilai modal
        $('#editName').val(name);

        // Atur event handler untuk tombol "Simpan"
        $('#btn-submit').off('click').on('click', function() {
            blockUi();
            toastrOption();

            // menggunakan axios
            axios.put(`/educational-level/${slug}/store`, $('#form').serialize())
                .then(response => {
                    unBlockUi();
                    $('#modalEdit').modal('hide');
                    toastr.success(response.data.message);
                    reloadTable();
                })
                .catch(error => {
                    unBlockUi();
                    toastr.error(error.response.data.message);
                });
        });
    });
});
