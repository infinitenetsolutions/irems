$("#check-all").change(function () {
    if ($("#check-all").is(":checked"))
        $('.check-table').prop("checked", true);
    else
        $('.check-table').prop("checked", false);
    if ($('.check-table:checked').length >= 1) {
        $("#export-button").removeClass("display-none");
        $('#export-button').prop('disabled', false);
        $("#delete-button").removeClass("display-none");
        $('#delete-button').prop('disabled', false);
        $('#order-button').prop('disabled', false);
    } else {
        $("#export-button").addClass("display-none");
        $('#export-button').prop('disabled', true);
        $("#delete-button").addClass("display-none");
        $('#delete-button').prop('disabled', true);
        $('#order-button').prop('disabled', true);
    }
});
$(".check-table").change(function () {
    if ($('.check-table:checked').length == $('.check-table').length)
        $('#check-all').prop("checked", true);
    else
        $('#check-all').prop("checked", false);
    if ($('.check-table:checked').length >= 1) {
        $("#export-button").removeClass("display-none");
        $('#export-button').prop('disabled', false);
        $("#delete-button").removeClass("display-none");
        $('#delete-button').prop('disabled', false);
        $('#order-button').prop('disabled', false);
    } else {
        $("#export-button").addClass("display-none");
        $('#export-button').prop('disabled', true);
        $("#delete-button").addClass("display-none");
        $('#delete-button').prop('disabled', true);
        $('#order-button').prop('disabled', true);
    }
});
//CKEDITOR.instances.nameOfTextarea.getData(); 
$(function () {
    CKEDITOR.replace('description'); 
//    $("#example1").DataTable();
    $('#example1').dataTable({
        "lengthMenu": [[5, 10, 25, 50, 75, 100, 250, 500, 750, 1000, 2500, 5000, 7500, 10000, -1], [5, 10, 25, 50, 75, 100, 250, 500, 750, 1000, 2500, 5000, 7500, 10000, "All"]],
        "language": {
            "paginate": {
                "previous": "<i class='fas fa-angle-double-left'></i>",
                "next": "<i class='fas fa-angle-double-right'></i>"
            }
        }
    });
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
});
