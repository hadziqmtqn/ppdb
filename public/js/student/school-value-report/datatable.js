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
            {data: 'name', name: 'name', orderable: false, searchable: false},
            {data: 'educationalInstitution', name: 'educationalInstitution', orderable: false, searchable: false},
            {data: 'previousSchool', name: 'previousSchool', orderable: false, searchable: false},
            {data: 'totalScore', name: 'totalScore', orderable: false, searchable: false},
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
                text: '<i class="mdi mdi-download me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Export</span>',
                className: 'btn btn-primary waves-effect waves-light me-2',
                attr: {
                    'id': 'exportExcelButton',
                    'data-bs-toggle': 'tooltip',
                    'title': 'Unduh Rincian'
                }
            },
            {
                extend: 'collection',
                className: 'btn btn-secondary dropdown-toggle me-w waves-effect waves-light',
                text: '<i class="mdi mdi-export-variant me-1"></i> <span class="d-none d-sm-inline-block">Unduh Rekap</span>',
                attr: {
                    'data-bs-toggle': 'tooltip',
                    'title': 'Unduh Rekap Nilai'
                },
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
            educational_institution_id: educationalInstitution.val(),
            educational_group_id: educationalGroup.val()
        });

        dataTable.ajax.reload();
    });

    dataTable.on('draw.dt', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body
            });
        });
    });

    exportExcelHandler();
});
