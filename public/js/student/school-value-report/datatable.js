$(function () {
    const table = '#datatable';

    $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[1, 'asc']],
        ajax: {
            url: "/school-value-report/datatable",
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
            {data: 'name', name: 'name'},
            {data: 'educationalInstitution', name: 'educationalInstitution'},
            {data: 'totalScore', name: 'totalScore'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});
