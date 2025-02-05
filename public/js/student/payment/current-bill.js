/**
 * app-ecommerce-order-details Script
 */

'use strict';

// Datatable (jquery)

$(function () {
    // Variable declaration for table

    const dt_details_table = $('.datatables-order-details');

    // E-commerce Products datatable
    if (dt_details_table.length) {
        const dt_products = dt_details_table.DataTable({
            ajax: assetsPath + 'json/ecommerce-order-details.json', // JSON file to add data
            columns: [
                // columns according to JSON
                {data: 'id'},
                {data: 'id'},
                {data: 'product_name'},
                {data: 'price'},
                {data: 'qty'},
                {data: ''}
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    searchable: false,
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">'
                    },
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input" >';
                    },
                    searchable: false
                },
                {
                    // Product name and product info
                    targets: 2,
                    responsivePriority: 1,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        let $output;
                        let $name = full['product_name'],
                            $product_brand = full['product_info'],
                            $image = full['image'];
                        if ($image) {
                            // For Product image
                            $output = '<img src="' +
                                assetsPath +
                                'img/products/' +
                                $image +
                                '" alt="product-' +
                                $name +
                                '" class="rounded-2">';
                        } else {
                            // For Product badge
                            var stateNum = Math.floor(Math.random() * 6);
                            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                            var $state = states[stateNum];
                            $name = full['product_name'];
                            var $initials = $name.match(/\b\w/g) || [];
                            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                            $output = '<span class="avatar-initial rounded-2 bg-label-' + $state + '">' + $initials + '</span>';
                        }
                        // Creates full output for Product name and product_brand
                        return '<div class="d-flex justify-content-start align-items-center product-name">' +
                            '<div class="avatar-wrapper me-3">' +
                            '<div class="avatar rounded-2 bg-label-secondary">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<span class="text-nowrap text-heading fw-medium">' +
                            $name +
                            '</span>' +
                            '<small class="text-truncate d-none d-sm-block">' +
                            $product_brand +
                            '</small>' +
                            '</div>' +
                            '</div>';
                    }
                },
                {
                    // For Price
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        const $price = full['price'];
                        return '<span>$' + $price + '</span>';
                    }
                },
                {
                    // For Qty
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        const $qty = full['qty'];
                        return '<span>' + $qty + '</span>';
                    }
                },
                {
                    // Total
                    targets: 5,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        const $total = full['qty'] * full['price'];
                        return '<span>$' + $total + '</span>';
                    }
                }
            ],
            order: [2, ''], //set any columns order asc/desc
            dom: 't',
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['full_name'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        const data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            }
        });
    }
    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
});