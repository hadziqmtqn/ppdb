$(function () {
    const table = '#datatable';
    const schoolYear = $('#select-school-year');
    const educationalInstitution = $('#select-educational-institution-0');

    const dataTable = $(table).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        order: [[4, 'desc']],
        ajax: {
            url: "/previous-school-reference-datatable",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function (d) {
                d.search = $(table + '_filter ' + 'input[type="search"]').val();
                d.school_year_id = schoolYear.val();
                d.educational_institution_id = educationalInstitution.val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'npsn', name: 'npsn', searchable: false, orderable: false},
            {data: 'name', name: 'name'},
            {data: 'educationalGroup', name: 'educationalGroup'},
            {data: 'previous_schools_count', name: 'previous_schools_count'},
        ],
        dom:
            '<"card-header d-flex rounded-0 flex-wrap py-md-0"' +
            '<"me-5 pe-5"f>' +
            '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center mb-3 mb-sm-0 gap-3"lB>>' +
            '>t' +
            '<"row mx-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Search..'
        },
        // Buttons with Dropdown
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-label-primary dropdown-toggle me-w waves-effect waves-light',
                text: '<i class="mdi mdi-export-variant me-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="mdi mdi-printer-outline me-1" ></i>Print',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                        },
                    },
                    {
                        extend: 'csv',
                        text: '<i class="mdi mdi-file-document-outline me-1" ></i>Csv',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                ]
            }
        ],
    });

    $('.filter').on('change', function () {
        dataTable.ajax.params({
            school_year_id: schoolYear.val(),
            educational_institution_id: educationalInstitution.val()
        });

        dataTable.ajax.reload();
    });
});