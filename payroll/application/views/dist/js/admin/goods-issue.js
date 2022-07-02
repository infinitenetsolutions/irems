$(function () {
    //Toast Setting Section Start ------------------------------------------------------------------------------------------------------------------
    $('#add-button').prop('disabled', false);
    $('#import-button').prop('disabled', false);
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: false,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    function topEndNotification(theme, message) {
        Toast.fire({
            icon: theme,
            title: message
        })
    }
    //Aos creationx
    AOS.init();
    fetchFn();
    // Fetch Data Section Start --------------------------------------------------------------------------------------------------------------------
    function fetchFn() {
        topEndNotification("info", "Loading, Please Wait...");
        $('#view-section').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {
            "action": "fetchData"
        };
        $.ajax({
            url: 'application/view/admin/goods-issue.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#loading').fadeOut(500, function () {
                    $(this).remove();
                    topEndNotification("info", "Data loaded Successfully...");
                    $('#view-section').html(data);
                    $('#refresh-button').html('<i class="fas fa-sync-alt fa-sm"></i>');
                    $('#refresh-button').prop('disabled', false);
                });
            }
        });
    }
    // Fetch Data Section End ----------------------------------------------------------------------------------------------------------------------
    // Refresh Section Start -----------------------------------------------------------------------------------------------------------------------
    $(".refresh-button").click(function () {
        $('#refresh-button').prop('disabled', true);
        $('#refresh-button').html('<center id = "loading"><img width="16px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        fetchFn();
    });
    // Refresh Section End -------------------------------------------------------------------------------------------------------------------------
    // Add Section Start ---------------------------------------------------------------------------------------------------------------------------
    $('form#addForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#addButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#addButton').prop('disabled', true);
        var flag = 1;
        var i = 1;
        if ($("#ginNo").val() == "") {
            $("#ginNo").addClass("is-invalid");
            flag = 0;
        } else
            $("#ginNo").removeClass("is-invalid");
        if ($("#ginDate").val() == "") {
            $("#ginDate").addClass("is-invalid");
            flag = 0;
        } else
            $("#ginDate").removeClass("is-invalid");
        if ($("#project").val() == "") {
            $("#project").addClass("is-invalid");
            flag = 0;
        } else
            $("#project").removeClass("is-invalid");
        if ($("#property").val() == "") {
            $("#property").addClass("is-invalid");
            flag = 0;
        } else
            $("#property").removeClass("is-invalid");
        if ($("#projectLocation").val() == "") {
            $("#projectLocation").addClass("is-invalid");
            flag = 0;
        } else
            $("#projectLocation").removeClass("is-invalid");
        if ($("#issueTo").val() == "") {
            $("#issueTo").addClass("is-invalid");
            flag = 0;
        } else
            $("#issueTo").removeClass("is-invalid");
        if ($("#issueBy").val() == "") {
            $("#issueBy").addClass("is-invalid");
            flag = 0;
        } else
            $("#issueBy").removeClass("is-invalid");
        if ($("#inventoryType").val() == "") {
            $("#inventoryType").addClass("is-invalid");
            flag = 0;
        } else
            $("#inventoryType").removeClass("is-invalid");
        //        if ($("#description").val() == "") {
        //            $("#description").addClass("is-invalid");
        //            flag = 0;
        //        } else
        //            $("#description").removeClass("is-invalid");
        for (i = 1; i <= $("#totalItem").val(); i++) {
            if ($("#itemCode" + i).val() == "") {
                $("#itemCode" + i).addClass("is-invalid");
                flag = 0;
            } else
                $("#itemCode" + i).removeClass("is-invalid");
            if ($("#itemName" + i).val() == "") {
                $("#itemName" + i).addClass("is-invalid");
                flag = 0;
            } else
                $("#itemName" + i).removeClass("is-invalid");
            if ($("#uom" + i).val() == "") {
                $("#uom" + i).addClass("is-invalid");
                flag = 0;
            } else
                $("#uom" + i).removeClass("is-invalid");
            if ($("#quantity" + i).val() == "") {
                $("#quantity" + i).addClass("is-invalid");
                flag = 0;
            } else
                $("#quantity" + i).removeClass("is-invalid");
            if ($("#remarks" + i).val() == "") {
                $("#remarks" + i).addClass("is-invalid");
                flag = 0;
            } else
                $("#remarks" + i).removeClass("is-invalid");
        }
        if (flag == 1) {
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("description", CKEDITOR.instances.description.getData());
            formData.append("action", "addData");
            $.ajax({
                url: 'application/controller/admin/goods-issue.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if (data.response == "success") {
                        $('#addForm')[0].reset();
                        setTimeout(function () {
                            location.reload();
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#addButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                        $('#addButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            topEndNotification("warning", "Please fill out the required fields");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#addButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                $('#addButton').prop('disabled', false);
            });
        }
    });
    // Add Section End -----------------------------------------------------------------------------------------------------------------------------
    // Import Section Start ------------------------------------------------------------------------------------------------------------------------
    $('form#importForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#importButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#importButton').prop('disabled', true);
        var flag = 1;
        if ($("#importedExcel").val() == "") {
            $("#importedExcel").addClass("is-invalid");
            flag = 0;
        } else
            $("#importedExcel").removeClass("is-invalid");
        if (flag == 1) {
            var formData = new FormData($('form#importForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "importData");
            $.ajax({
                url: 'application/controller/admin/goods-issue.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if (data.response == "success") {
                        $('#importForm')[0].reset();
                        setTimeout(function () {
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#importButton').html('<i class="fa fa-upload fa-sm"></i> Import this');
                        $('#importButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            topEndNotification("warning", "Please select an Excel File!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#importButton').html('<i class="fa fa-upload fa-sm"></i> Import this');
                $('#importButton').prop('disabled', false);
            });
        }
    });
    // Import Section End --------------------------------------------------------------------------------------------------------------------------
    // Edit Section Start --------------------------------------------------------------------------------------------------------------------------
    $('form#editForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#editButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#editButton').prop('disabled', true);
        var flag = 1;
        var i = 1;
        var uniqueId = $("#editTableId").val();
        if ($("#editProjectName").val() == "") {
            $("#editProjectName").addClass("is-invalid");
            flag = 0;
        } else
            $("#editProjectName").removeClass("is-invalid");
        if ($("#editProjectLocation").val() == "") {
            $("#editProjectLocation").addClass("is-invalid");
            flag = 0;
        } else
            $("#editProjectLocation").removeClass("is-invalid");
        if ($("#editProjectStartingDate").val() == "") {
            $("#editProjectStartingDate").addClass("is-invalid");
            flag = 0;
        } else
            $("#editProjectStartingDate").removeClass("is-invalid");
        if ($("#editProjectExpectedEndingDate").val() == "") {
            $("#editProjectExpectedEndingDate").addClass("is-invalid");
            flag = 0;
        } else
            $("#editProjectExpectedEndingDate").removeClass("is-invalid");
        for (i = 1; i <= $("#editTotalProperty").val(); i++) {
            if ($("#propertyType" + i + "_" + uniqueId).val() == "") {
                $("#propertyType" + i + "_" + uniqueId).addClass("is-invalid");
                flag = 0;
            } else
                $("#propertyType" + i + "_" + uniqueId).removeClass("is-invalid");
            if ($("#accommodationType" + i + "_" + uniqueId).val() == "") {
                $("#accommodationType" + i + "_" + uniqueId).addClass("is-invalid");
                flag = 0;
            } else
                $("#accommodationType" + i + "_" + uniqueId).removeClass("is-invalid");
            if ($("#squareFeet" + i + "_" + uniqueId).val() == "") {
                $("#squareFeet" + i + "_" + uniqueId).addClass("is-invalid");
                flag = 0;
            } else
                $("#squareFeet" + i + "_" + uniqueId).removeClass("is-invalid");
            if ($("#price" + i + "_" + uniqueId).val() == "") {
                $("#price" + i + "_" + uniqueId).addClass("is-invalid");
                flag = 0;
            } else
                $("#price" + i + "_" + uniqueId).removeClass("is-invalid");
            if ($("#availablility" + i + "_" + uniqueId).val() == "") {
                $("#availablility" + i + "_" + uniqueId).addClass("is-invalid");
                flag = 0;
            } else
                $("#availablility" + i + "_" + uniqueId).removeClass("is-invalid");
            if ($("#StartingDate" + i + "_" + uniqueId).val() == "") {
                $("#StartingDate" + i + "_" + uniqueId).addClass("is-invalid");
                flag = 0;
            } else
                $("#StartingDate" + i + "_" + uniqueId).removeClass("is-invalid");
            if ($("#ExpectedEndingDate" + i + "_" + uniqueId).val() == "") {
                $("#ExpectedEndingDate" + i + "_" + uniqueId).addClass("is-invalid");
                flag = 0;
            } else
                $("#ExpectedEndingDate" + i + "_" + uniqueId).removeClass("is-invalid");
        }
        if (flag == 1) {
            var formData = new FormData($('form#editForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editData");
            $.ajax({
                url: 'application/controller/admin/goods-issue.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if (data.response == "success") {
                        $('#editForm')[0].reset();
                        $('#edit-modal').modal("hide");
                        setTimeout(function () {
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#editButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                        $('#editButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            topEndNotification("warning", "Please fill out the required fields");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#editButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                $('#editButton').prop('disabled', false);
            });
        }
    });
    // Edit Section End ----------------------------------------------------------------------------------------------------------------------------
    // Delete Section Start ------------------------------------------------------------------------------------------------------------------------
    $('form#deleteForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#deleteButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#deleteButton').prop('disabled', true);
        var flag = 1;
        if ($("#tableId").val() == "" || $("#tableName").val() == "")
            flag = 0;
        if (flag == 1) {
            var formData = new FormData($('form#deleteForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "deleteData");
            $.ajax({
                url: 'application/controller/admin/goods-issue.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if (data.response == "success") {
                        $('#deleteForm')[0].reset();
                        $('#delete-modal').modal("hide");
                        setTimeout(function () {
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#deleteButton').html('<i class="fa fa-plus fa-sm"></i> Delete');
                        $('#deleteButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            topEndNotification("error", "Something went wrong, please try again or refresh!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#deleteButton').html('<i class="fa fa-plus fa-sm"></i> Delete');
                $('#deleteButton').prop('disabled', false);
            });
        }
    });
    // Delete Section End --------------------------------------------------------------------------------------------------------------------------
    // Export Selected Section Start ---------------------------------------------------------------------------------------------------------------
    $("#exportSelectedButton").click(function () {
        $('#exportSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#exportSelectedButton').prop('disabled', true);
        var formData = new FormData($('form#selectForm')[0]);
        formData.append("checkLocation", $("#checkLocation").val());
        formData.append("checkIp", $("#checkIp").val());
        formData.append("action", "exportData");
        $.ajax({
            url: 'application/controller/admin/goods-issue.php',
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (data) {
                if (data.response == "success") {
                    $('#export-modal').modal("hide");
                    $('#export-button').addClass("display-none");
                    $('#delete-button').addClass("display-none");
                    $('#selectForm').submit();
                    setTimeout(function () {
                        fetchFn();
                    }, 1000);
                }
                topEndNotification(data.responseType, data.responseMessage);
                $('#loading').fadeOut(500, function () {
                    $(this).remove();
                    $('#exportSelectedButton').html('<i class="fas fa-download fa-sm"></i> Export Selected');
                    $('#exportSelectedButton').prop('disabled', false);
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    // Export Selected Section End -----------------------------------------------------------------------------------------------------------------
    //Fetch Property Type
    $('#project').on('change', function (event) {
        var formData = new FormData($('form#addForm')[0]);
        formData.append("action", "fetchProjectDetails");
        $("#property").prop("disabled", true);
        $.ajax({
            url: 'application/view/admin/goods-issue.php',
            type: 'POST',
            data: formData,
            success: function (result) {
                $("#property").html(result);
                setTimeout(function () {
                    $("#property").prop("disabled", false);
                }, 500);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        event.preventDefault();
    });
    //Fetch project location Type
    $('#project').on('change', function (event) {
        var formData = new FormData($('form#addForm')[0]);
        formData.append("action", "fetchProjectlocationDetails");
        $("#projectLocation").prop("disabled", true);
        $.ajax({
            url: 'application/view/admin/goods-issue.php',
            type: 'POST',
            data: formData,
            success: function (result) {
                $("#projectLocation").val(result);
                setTimeout(function () {
                    $("#projectLocation").prop("disabled", false);
                }, 500);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        event.preventDefault();
    });
    // Delete Selected Section Start ---------------------------------------------------------------------------------------------------------------
    $("#deleteSelectedButton").click(function () {
        $('#deleteSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#deleteSelectedButton').prop('disabled', true);
        var formData = new FormData($('form#selectForm')[0]);
        formData.append("checkLocation", $("#checkLocation").val());
        formData.append("checkIp", $("#checkIp").val());
        formData.append("action", "deleteSelectedData");
        $.ajax({
            url: 'application/controller/admin/goods-issue.php',
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (data) {
                if (data.response == "success") {
                    $('#delete-selected-modal').modal("hide");
                    $('#export-button').addClass("display-none");
                    $('#delete-button').addClass("display-none");
                    setTimeout(function () {
                        fetchFn();
                    }, 1000);
                }
                topEndNotification(data.responseType, data.responseMessage);
                $('#loading').fadeOut(500, function () {
                    $(this).remove();
                    $('#deleteSelectedButton').html('<i class="fas fa-trash fa-sm"></i> Delete Selected');
                    $('#deleteSelectedButton').prop('disabled', false);
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    // Delete Selected Section End ----------------------------------------------------------------------------------------------------------------- 
    // Fetch Data Section Start --------------------------------------------------------------------------------------------------------------------
    function fetchFn() {
        topEndNotification("info", "Loading, Please Wait...");
        $('#view-sectionn').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {
            "action": "fetchData"
        };
        $.ajax({
            url: 'application/view/admin/goods-issue.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#loading').fadeOut(500, function () {
                    $(this).remove();
                    topEndNotification("info", "Data loaded Successfully...");
                    $('#view-sectionn').html(data);
                    $('#refresh-button').html('<i class="fas fa-sync-alt fa-sm"></i>');
                    $('#refresh-button').prop('disabled', false);
                });
            }
        });
    }
    // Fetch Data Section End ----------------------------------------------------------------------------------------------------------------------

});
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: false,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function topEndNotification(theme, message) {
    Toast.fire({
        icon: theme,
        title: message
    })
}