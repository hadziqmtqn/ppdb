$(function () {
    const myTable = $('.myTable');

    if (myTable.length) {
        myTable.DataTable({
            // scroll ke kanan
            scrollCollapse: true,
            scrollX: true,
            scroller: true,
            searching: false,
            paging: false,
            info: false,
        });
    }

    // fixedColumn
    const fixedColumn = $('.fixedColumnProgramPlan');

    if (fixedColumn.length) {
        fixedColumn.DataTable({
            scrollCollapse: true,
            scrollX: true,
            scroller: true,
            searching: false,
            paging: false,
            info: false,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            }
        });
    }
});
