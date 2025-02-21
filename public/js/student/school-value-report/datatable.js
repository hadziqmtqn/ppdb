$(function () {
    const table = '#datatable';
    const schoolYear = $('#select-school-year');
    const educationalInstitution = $('#select-educational-institution');
    const educationalGroup = $('#select-educational-group');

    const dataTable = $(table).DataTable({
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
                d.school_year_id = schoolYear.val();
                d.educational_institution_id = educationalInstitution.val();
                d.educational_group_id = educationalGroup.val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'educationalInstitution', name: 'educationalInstitution'},
            {data: 'previousSchool', name: 'previousSchool'},
            {data: 'totalScore', name: 'totalScore'},
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
                text: '<i class="mdi mdi-file-excel-outline me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Export</span>',
                className: 'btn btn-primary waves-effect waves-light',
                attr: {
                    'id': 'exportExcelButton',
                }
            }
        ],
    });

    $('.filter').on('change', function () {
        dataTable.ajax.params({
            school_year_id: schoolYear.val(),
            educational_institution_id: educationalInstitution.val(),
            educational_group_id: educationalGroup.val()
        });

        dataTable.ajax.reload();
    });

    exportExcelHandler();
});
