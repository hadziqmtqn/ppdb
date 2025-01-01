$(function () {
    const table = '#datatable-registration-schedule';

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[1, 'asc']],
        ajax: {
            url: "/registration-schedule/datatable",
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
            {data: 'schoolYear', name: 'schoolYear'},
            {data: 'date', name: 'date'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
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
                    'data-bs-target': '#modalCreateRegistrationSchedule',
                }
            }
        ],
    });
});
