$(function(){
    //Toast Setting Section Start ------------------------------------------------------------------------------------------------------------------
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
    function topEndNotification(theme, message){
        Toast.fire({
          icon: theme,
          title: message
        })
    }
    //Aos creation
    AOS.init();
    fetchFn();
    // Fetch Data Section Start --------------------------------------------------------------------------------------------------------------------
    function fetchFn() {
        topEndNotification("info", "Loading, Please Wait...");
        $('#refresh-icon').addClass('fa-spin');
        $('#refresh-icon').addClass('fast-spin');
        $('#view-section').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {"action":"fetchData"};
        $.ajax({
            url: 'application/view/admin/land-acquisition-owners',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#loading').fadeOut(500, function () {
                    $(this).remove();
                     topEndNotification("info", "Data loaded Successfully...");
                    $('#view-section').html(data);
                    $('#refresh-button').html('<i class="fas fa-sync-alt fa-sm" id="refresh-icon"></i>');
                    $('#refresh-button').prop('disabled', false);
                });
            }
        });
    }
    // Fetch Data Section End ----------------------------------------------------------------------------------------------------------------------
    // Refresh Section Start -----------------------------------------------------------------------------------------------------------------------
    $(".refresh-button").click(function () {
        $('#refresh-button').prop('disabled', true);
        $('#refresh-icon').addClass('fa-spin');
        $('#refresh-icon').addClass('fast-spin');
        topEndNotification("info", "Refreshing, Please Wait...");
        setTimeout(function(){
//        $('#refresh-button').html('<center id = "loading"><img width="16px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
            fetchFn();  
        }, 1000);
    });
    // Refresh Section End -------------------------------------------------------------------------------------------------------------------------
    // Add Section Start ---------------------------------------------------------------------------------------------------------------------------
    $('form#addForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        var error_message_show = "Please fill out the required fields";
        $('#addButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#addButton').prop('disabled', true);
        var flag = 1;
        if($("#ownerName").val() == ""){
            $("#ownerName").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#ownerName").removeClass("is-invalid");
        if($("#ownerCity").val() == ""){
            $("#ownerCity").addClass("is-invalid");
            error_message_show = "Please select City And State";
            flag = 0;
        }else
            $("#ownerCity").removeClass("is-invalid");
        if($("#ownerState").val() == ""){
            $("#ownerState").addClass("is-invalid");
            error_message_show = "Please select City And State";
            flag = 0;
        }else
            $("#ownerState").removeClass("is-invalid");
        if($("#ownerPincode").val() == ""){
            $("#ownerPincode").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#ownerPincode").removeClass("is-invalid");
        if($("#ownerContactNumber").val() == ""){
            $("#ownerContactNumber").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#ownerContactNumber").removeClass("is-invalid");
        if($("#ownerOfficeNumber").val() == ""){
            $("#ownerOfficeNumber").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#ownerOfficeNumber").removeClass("is-invalid");
        if($("#ownerEmail").val() == ""){
            $("#ownerEmail").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#ownerEmail").removeClass("is-invalid");
        if($("#ownerAddress").val() == ""){
            $("#ownerAddress").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#ownerAddress").removeClass("is-invalid");
        if($("#ownerPanNo").val() == ""){
            $("#ownerPanNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#ownerPanNo").removeClass("is-invalid");
        if($("#ownerAadharNo").val() == ""){
            $("#ownerAadharNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#ownerAadharNo").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addData");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-owners',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#addForm')[0].reset();
                        setTimeout(function(){
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
        } else{
            topEndNotification("warning" , error_message_show);
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
        var error_message_show = "Please fill out the required fields";
        $('#importButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#importButton').prop('disabled', true);
        var flag = 1;
        if($("#importedExcel").val() == ""){
            $("#importedExcel").addClass("is-invalid");
            flag = 0;
        }else
            $("#importedExcel").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#importForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "importData");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-owners',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#importForm')[0].reset();
                        setTimeout(function(){
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
        } else{
            topEndNotification("warning" , "Please select an Excel File!!!");
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
        var error_message_show = "Please fill out the required fields";
        $('#editButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#editButton').prop('disabled', true);
        var flag = 1;
        if($("#editOwnerName").val() == ""){
            $("#editOwnerName").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editOwnerName").removeClass("is-invalid");
        if($("#editOwnerCity").val() == ""){
            $("#editOwnerCity").addClass("is-invalid");
            error_message_show = "Please select City And State";
            flag = 0;
        }else
            $("#editOwnerCity").removeClass("is-invalid");
        if($("#editOwnerState").val() == ""){
            $("#editOwnerState").addClass("is-invalid");
            error_message_show = "Please select City And State";
            flag = 0;
        }else
            $("#editOwnerState").removeClass("is-invalid");
        if($("#editOwnerPincode").val() == ""){
            $("#editOwnerPincode").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editOwnerPincode").removeClass("is-invalid");
        if($("#editOwnerContactNumber").val() == ""){
            $("#editOwnerContactNumber").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editOwnerContactNumber").removeClass("is-invalid");
        if($("#editOwnerOfficeNumber").val() == ""){
            $("#editOwnerOfficeNumber").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editOwnerOfficeNumber").removeClass("is-invalid");
        if($("#editOwnerEmail").val() == ""){
            $("#editOwnerEmail").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editOwnerEmail").removeClass("is-invalid");
        if($("#editOwnerAddress").val() == ""){
            $("#editOwnerAddress").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editOwnerAddress").removeClass("is-invalid");
        if($("#editOwnerPanNo").val() == ""){
            $("#editOwnerPanNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editOwnerPanNo").removeClass("is-invalid");
        if($("#editOwnerAadharNo").val() == ""){
            $("#editOwnerAadharNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editOwnerAadharNo").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#editForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editData");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-owners',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#editForm')[0].reset();
                        $('#edit-modal').modal("hide");
                        setTimeout(function(){
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
        } else{
            topEndNotification("warning" , error_message_show);
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
        if($("#tableId").val() == "" || $("#tableName").val() == "")
            flag = 0;
        if(flag == 1){
            var formData = new FormData($('form#deleteForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "deleteData");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-owners',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#deleteForm')[0].reset();
                        $('#delete-modal').modal("hide");
                        setTimeout(function(){
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
        } else{
            topEndNotification("error" , "Something went wrong, please try again or refresh!!!");
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
            url: 'application/controller/admin/land-acquisition-owners',
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (data) {
                if(data.response == "success"){
                    $('#export-modal').modal("hide");
                    $('#selectForm').submit();
                    setTimeout(function(){
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
    // Delete Selected Section Start ---------------------------------------------------------------------------------------------------------------
    $("#deleteSelectedButton").click(function () {
        $('#deleteSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#deleteSelectedButton').prop('disabled', true);
        var formData = new FormData($('form#selectForm')[0]);
        formData.append("checkLocation", $("#checkLocation").val());
        formData.append("checkIp", $("#checkIp").val());
        formData.append("action", "deleteSelectedData");
        $.ajax({
            url: 'application/controller/admin/land-acquisition-owners',
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (data) {
                if(data.response == "success"){
                    $('#delete-selected-modal').modal("hide");
                    setTimeout(function(){
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
    // City And State Section Start ----------------------------------------------------------------------------------------------------------------
    $("#ownerState").html("<option>Please Wait...</option>");
    $("#ownerState").prop("disabled", true);
    $("#ownerCity").prop("disabled", true);
    var formData = '{"request": "fetch","request_for": "states","country_name": "india"}';
    $.ajax({
        url: 'https://et-azad.com/api/country-api/states.php',
        type: 'POST',
        data: formData,
        dataType: "json",
        success: function (data) {
            $("#ownerState").html("<option>Select</option>");
            //Store All Start
            data.response_data.forEach(appendAll);
            function appendAll(name, val) {
              $("#ownerState").append('<option value="'+ name +'">'+ name +'</option>');
            }
            //Store All End
            setTimeout(function(){
                $("#ownerState").prop("disabled", false);
                $("#ownerCity").prop("disabled", false);
            }, 1000);
        },
        error: function (data) {
            $("#ownerState").html("<option>Unable to find States...</option>");
        },
        cache: false,
        contentType: false,
        processData: false
    });
    $("#ownerState").change(function(){
        $("#ownerCity").html("<option>Please Wait...</option>");
        $("#ownerState").prop("disabled", true);
        $("#ownerCity").prop("disabled", true);
        var formData = '{"request": "fetch","request_for": "cities","country_name": "india","state_name": "'+ $("#ownerState").val() +'"}';
        $.ajax({
            url: 'https://et-azad.com/api/country-api/cities.php',
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (data) {
                $("#ownerCity").html("<option>Select</option>");
                //Store All Start
                data.response_data.forEach(appendAll);
                function appendAll(name, val) {
                  $("#ownerCity").append('<option value="'+ name +'">'+ name +'</option>');
                }
                //Store All End
                setTimeout(function(){
                    $("#ownerState").prop("disabled", false);
                    $("#ownerCity").prop("disabled", false);
                }, 1000);
            },
            error: function (data) {
                $("#ownerCity").html("<option>Unable to find Cities...</option>");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});