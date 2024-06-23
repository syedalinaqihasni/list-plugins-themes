jQuery(document).ready(function ($) {
    $('.sortable th').on('click', function () {
        var table = $(this).parents('table');
        var rows = table.find('tbody > tr').toArray();
        var index = $(this).index();
        var isAsc = !$(this).hasClass('sorted-asc');

        rows.sort(function (rowA, rowB) {
            var cellA = $(rowA).children('td').eq(index).text();
            var cellB = $(rowB).children('td').eq(index).text();

            if ($.isNumeric(cellA) && $.isNumeric(cellB)) {
                cellA = parseFloat(cellA);
                cellB = parseFloat(cellB);
            }

            if (cellA < cellB) return isAsc ? -1 : 1;
            if (cellA > cellB) return isAsc ? 1 : -1;
            return 0;
        });

        $(this).siblings().removeClass('sorted-asc sorted-desc');
        $(this).toggleClass('sorted-asc', isAsc);
        $(this).toggleClass('sorted-desc', !isAsc);

        $.each(rows, function (index, row) {
            table.children('tbody').append(row);
        });
    });
});
