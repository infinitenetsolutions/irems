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
        $('#add-button').prop('disabled', true);
        $('#import-button').prop('disabled', true);
        $('#back-button').prop('disabled', true);
        $('#add-more-button').prop('disabled', true);
        $('#back-button').addClass('display-none');
        $('#add-more-button').addClass('display-none');
        topEndNotification("info", "Loading, Please Wait...");
        $('#view-section').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        if($("#projects_id").val() == ""){
            var formData = {"action":"fetchData"};
            $.ajax({
                url: 'application/view/admin/work-flow.php',
                type: 'POST',
                data: formData,
                success: function (data) {
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        topEndNotification("info", "Data loaded Successfully...");
                        $('#view-section').html(data);
                        $('#refresh-button').html('<i class="fas fa-sync-alt fa-sm"></i>');
                        $('#refresh-button').prop('disabled', false);
                        $('#add-button').attr('data-target', '#add-modal');
                        $('#import-button').attr('data-target', '#import-modal');
                        $('#export-button').attr('data-target', '#export-modal');
                        $('#delete-button').attr('data-target', '#delete-selected-modal');
                        $(".add-button, .edit-button, .delete-button, .import-button").prop("disabled", false);
                        $("#show-who").html("All Projects");
                    });
                }
            });
        }
        else{
            if($("#work_main_work_type_id").val() == ""){
                var formData = {"action":"fetchWorkFlow","id":$("#projects_id").val()};
                $.ajax({
                    url: 'application/view/admin/work-flow.php',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('#loading').fadeOut(500, function () {
                            $(this).remove();
                            topEndNotification("info", "Data loaded Successfully...");
                            $('#view-section').html(data);
                            $('#refresh-button').html('<i class="fas fa-sync-alt fa-sm"></i>');
                            $('#refresh-button').prop('disabled', false);
                            $('#add-button').prop('disabled', false);
                            $('#import-button').prop('disabled', false);
                            $('#export-button').prop('disabled', false);
                            $('#delete-button').prop('disabled', false);
                            $('#add-button').attr('data-target', '#add-modal');
                            $('#import-button').attr('data-target', '#import-modal');
                            $('#export-button').attr('data-target', '#export-modal');
                            $('#delete-button').attr('data-target', '#delete-selected-modal');
                            $('#back-button').prop('disabled', false);
                            $('#back-button').removeClass('display-none');
                            $(".add-button, .edit-button, .delete-button, .import-button").prop("disabled", false);
                            $("#show-who").html($("#show-who").data("pre"));
                        });
                    }
                });
            } else{
                var formData = {"action":"fetchWorkFlowFromMain","id":$("#work_main_work_type_id").val()};
                $.ajax({
                    url: 'application/view/admin/work-flow.php',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('#loading').fadeOut(500, function () {
                            $(this).remove();
                            $('#view-section').html(data);
                            $('#refresh-button').html('<i class="fas fa-sync-alt fa-sm"></i>');
                            $('#refresh-button').prop('disabled', false);
                            $('#add-button').prop('disabled', false);
                            $('#import-button').prop('disabled', false);
                            $('#export-button').prop('disabled', false);
                            $('#delete-button').prop('disabled', false);
                            $('#add-button').attr('data-target', '#add-work-modal');
                            $('#import-button').attr('data-target', '#import-work-modal');
                            $('#export-button').attr('data-target', '#export-work-modal');
                            $('#delete-button').attr('data-target', '#delete-selected-work-modal');
                            $('#back-button').prop('disabled', false);
                            $('#back-button').removeClass('display-none');
                            $('#add-more-button').prop('disabled', false);
                            $('#add-more-button').removeClass('display-none');
                            $(".add-button, .edit-button, .delete-button, .import-button").prop("disabled", false);
                        });
                    }
                });
            }
        }
        
    }
    // Fetch Data Section End ----------------------------------------------------------------------------------------------------------------------
    // Refresh Section Start -----------------------------------------------------------------------------------------------------------------------
    $(".refresh-button").click(function () {
        $('#refresh-button').prop('disabled', true);
        $('#refresh-button').html('<center id = "loading"><img width="16px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        fetchFn();
    });
    $(".back-button").click(function () {
        if($("#work_main_work_type_id").val() == "")
            $('#projects_id').val("");
        else
            $("#work_main_work_type_id").val("");
        $('#refresh-button').prop('disabled', true);
        $('#refresh-button').html('<center id = "loading"><img width="16px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        fetchFn();
    });
    // Refresh Section End -------------------------------------------------------------------------------------------------------------------------
    // Add Section Start ---------------------------------------------------------------------------------------------------------------------------
    $('form#addMainWorkForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#addButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#addButton').prop('disabled', true);
        var flag = 1;
        if($("#main_work_type").val() == null){
            $("#main_work_type").addClass("is-invalid");
            flag = 0;
        }else
            $("#main_work_type").removeClass("is-invalid");
        if($("#main_work_type_starting_date").val() == ""){
            $("#main_work_type_starting_date").addClass("is-invalid");
            flag = 0;
        }else
            $("#main_work_type_starting_date").removeClass("is-invalid");
        if($("#main_work_type_starting_time").val() == ""){
            $("#main_work_type_starting_time").addClass("is-invalid");
            flag = 0;
        }else
            $("#main_work_type_starting_time").removeClass("is-invalid");
        if($("#main_work_type_expected_ending_date").val() == ""){
            $("#main_work_type_expected_ending_date").addClass("is-invalid");
            flag = 0;
        }else
            $("#main_work_type_expected_ending_date").removeClass("is-invalid");
        if($("#main_work_type_expected_ending_time").val() == ""){
            $("#main_work_type_expected_ending_time").addClass("is-invalid");
            flag = 0;
        }else
            $("#main_work_type_expected_ending_time").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addMainWorkForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addMainWorkForm");
            $.ajax({
                url: 'application/controller/admin/work-flow.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        // $('#addMainWorkForm')[0].reset();
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
            topEndNotification("warning" , "Please fill out the required fields");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#addButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                $('#addButton').prop('disabled', false);
            });
        }
    });
    $('form#addWorkForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#addWorkButton').html('<center id = "loading-work"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#addWorkButton').prop('disabled', true);
        var flag = 1;
        if($("#work_type").val() == null){
            $("#work_type").addClass("is-invalid");
            flag = 0;
        }else
            $("#work_type").removeClass("is-invalid");
        if($("#work_type_starting_date").val() == ""){
            $("#work_type_starting_date").addClass("is-invalid");
            flag = 0;
        }else
            $("#work_type_starting_date").removeClass("is-invalid");
        if($("#work_type_starting_time").val() == ""){
            $("#work_type_starting_time").addClass("is-invalid");
            flag = 0;
        }else
            $("#work_type_starting_time").removeClass("is-invalid");
        if($("#work_type_expected_ending_date").val() == ""){
            $("#work_type_expected_ending_date").addClass("is-invalid");
            flag = 0;
        }else
            $("#work_type_expected_ending_date").removeClass("is-invalid");
        if($("#work_type_expected_ending_time").val() == ""){
            $("#work_type_expected_ending_time").addClass("is-invalid");
            flag = 0;
        }else
            $("#work_type_expected_ending_time").removeClass("is-invalid");
        for(j = 1; j <= Number($("#totalItemInfo").val()); j++){
            if($("#itemInfoItemType"+j).val() == null){
                $("#itemInfoItemType"+j).addClass("is-invalid");
                flag = 0;
            }else
                $("#itemInfoItemType"+j).removeClass("is-invalid");
            if($("#itemInfoUnitType"+j).val() == null){
                $("#itemInfoUnitType"+j).addClass("is-invalid");
                flag = 0;
            }else
                $("#itemInfoUnitType"+j).removeClass("is-invalid");
            if($("#itemInfoQuantity"+j).val() == ""){
                $("#itemInfoQuantity"+j).addClass("is-invalid");
                flag = 0;
            }else
                $("#itemInfoQuantity"+j).removeClass("is-invalid");
            if($("#itemInfoRate"+j).val() == ""){
                $("#itemInfoRate"+j).addClass("is-invalid");
                flag = 0;
            }else
                $("#itemInfoRate"+j).removeClass("is-invalid");
            if($("#itemInfoAmount"+j).val() == ""){
                $("#itemInfoAmount"+j).addClass("is-warning");
                flag = 0;
            }else
                $("#itemInfoAmount"+j).removeClass("is-warning");
            if($("#itemInfoMaterial"+j).val() == "" && $("#itemInfoLabour"+j).val() == ""){
                $("#itemInfoMaterial"+j).addClass("is-warning");
                $("#itemInfoLabour"+j).addClass("is-warning");
                flag = 0;
            }else{
                $("#itemInfoMaterial"+j).removeClass("is-warning");
                $("#itemInfoLabour"+j).removeClass("is-warning");
            } 
        }
        if(flag == 1){
            var formData = new FormData($('form#addWorkForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addWorkForm");
            $.ajax({
                url: 'application/controller/admin/work-flow.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        // $('#addWorkForm')[0].reset();
                        setTimeout(function(){
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading-work').fadeOut(500, function () {
                        $(this).remove();
                        $('#addWorkButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                        $('#addWorkButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please fill out the required fields");
            $('#loading-work').fadeOut(500, function () {
                $(this).remove();
                $('#addWorkButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                $('#addWorkButton').prop('disabled', false);
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
                url: 'application/controller/admin/work-flow.php',
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
        $('#editButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#editButton').prop('disabled', true);
        var flag = 1;
        if($("#edit_main_work_type_starting_date").val() == ""){
            $("#edit_main_work_type_starting_date").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_main_work_type_starting_date").removeClass("is-invalid");
        if($("#edit_main_work_type_starting_time").val() == ""){
            $("#edit_main_work_type_starting_time").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_main_work_type_starting_time").removeClass("is-invalid");
        if($("#edit_main_work_type_expected_ending_date").val() == ""){
            $("#edit_main_work_type_expected_ending_date").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_main_work_type_expected_ending_date").removeClass("is-invalid");
        if($("#edit_main_work_type_expected_ending_time").val() == ""){
            $("#edit_main_work_type_expected_ending_time").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_main_work_type_expected_ending_time").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#editForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editData");
            $.ajax({
                url: 'application/controller/admin/work-flow.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#editForm')[0].reset();
                        $('#edit-work-section').modal("hide");
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
            topEndNotification("warning" , "Please fill out the required fields");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#editButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                $('#editButton').prop('disabled', false);
            });
        }
    });
    $('form#editWorkForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#editWorkButton').html('<center id = "loading-edit"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#editWorkButton').prop('disabled', true);
        var flag = 1;
        if($("#edit_work_type").val() == null){
            $("#edit_work_type").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_work_type").removeClass("is-invalid");
        if($("#edit_work_type_starting_date").val() == ""){
            $("#edit_work_type_starting_date").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_work_type_starting_date").removeClass("is-invalid");
        if($("#edit_work_type_starting_time").val() == ""){
            $("#edit_work_type_starting_time").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_work_type_starting_time").removeClass("is-invalid");
        if($("#edit_work_type_expected_ending_date").val() == ""){
            $("#edit_work_type_expected_ending_date").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_work_type_expected_ending_date").removeClass("is-invalid");
        if($("#edit_work_type_expected_ending_time").val() == ""){
            $("#edit_work_type_expected_ending_time").addClass("is-invalid");
            flag = 0;
        }else
            $("#edit_work_type_expected_ending_time").removeClass("is-invalid");
        for(j = 1; j <= Number($("#editTotalItemInfo").val()); j++){
            if($("#editItemInfoItemType"+j).val() == null){
                $("#editItemInfoItemType"+j).addClass("is-invalid");
                flag = 0;
            }else
                $("#editItemInfoItemType"+j).removeClass("is-invalid");
            if($("#editItemInfoUnitType"+j).val() == null){
                $("#editItemInfoUnitType"+j).addClass("is-invalid");
                flag = 0;
            }else
                $("#editItemInfoUnitType"+j).removeClass("is-invalid");
            if($("#editItemInfoQuantity"+j).val() == ""){
                $("#editItemInfoQuantity"+j).addClass("is-invalid");
                flag = 0;
            }else
                $("#editItemInfoQuantity"+j).removeClass("is-invalid");
            if($("#editItemInfoRate"+j).val() == ""){
                $("#editItemInfoRate"+j).addClass("is-invalid");
                flag = 0;
            }else
                $("#editItemInfoRate"+j).removeClass("is-invalid");
            if($("#editItemInfoAmount"+j).val() == ""){
                $("#editItemInfoAmount"+j).addClass("is-warning");
                flag = 0;
            }else
                $("#editItemInfoAmount"+j).removeClass("is-warning");
            if($("#editItemInfoMaterial"+j).val() == "" && $("#editItemInfoLabour"+j).val() == ""){
                $("#editItemInfoMaterial"+j).addClass("is-warning");
                $("#editItemInfoLabour"+j).addClass("is-warning");
                flag = 0;
            }else{
                $("#editItemInfoMaterial"+j).removeClass("is-warning");
                $("#editItemInfoLabour"+j).removeClass("is-warning");
            } 
        }
        if(flag == 1){
            var formData = new FormData($('form#editWorkForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editWorkData");
            $.ajax({
                url: 'application/controller/admin/work-flow.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#editWorkForm')[0].reset();
                        $('#edit-work-modal').modal("hide");
                        setTimeout(function(){
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading-edit').fadeOut(500, function () {
                        $(this).remove();
                        $('#editWorkButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                        $('#editWorkButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please fill out the required fields");
            $('#loading-edit').fadeOut(500, function () {
                $(this).remove();
                $('#editWorkButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                $('#editWorkButton').prop('disabled', false);
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
                url: 'application/controller/admin/work-flow.php',
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
    $('form#deleteWorkForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#deleteWorkButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#deleteWorkButton').prop('disabled', true);
        var flag = 1;
        if($("#work_flow_id").val() == "" || $("#work_type_id").val() == "" || $("#tableName").val() == "")
            flag = 0;
        if(flag == 1){
            var formData = new FormData($('form#deleteWorkForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "deleteWorkData");
            $.ajax({
                url: 'application/controller/admin/work-flow.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#deleteWorkForm')[0].reset();
                        $('#delete-modal').modal("hide");
                        setTimeout(function(){
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#deleteWorkButton').html('<i class="fa fa-plus fa-sm"></i> Delete');
                        $('#deleteWorkButton').prop('disabled', false);
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
                $('#deleteWorkButton').html('<i class="fa fa-plus fa-sm"></i> Delete');
                $('#deleteWorkButton').prop('disabled', false);
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
            url: 'application/controller/admin/work-flow.php',
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
            url: 'application/controller/admin/work-flow.php',
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
    // Add Main Work Type Sections Start
    $('#main_work_type_add_button').click(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#main_work_type_add_button').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#main_work_type_add_button').prop('disabled', true);
        $('#main_work_type').prop('disabled', true);
        var flag = 1;
        if($("#main_work_type_add").val() == ""){
            $("#main_work_type_add").addClass("is-invalid");
            flag = 0;
        }else
            $("#main_work_type_add").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("main_work_type_add", $("#main_work_type_add").val());
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addMainWorkType");
            $.ajax({
                url: 'application/controller/admin/work-flow',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        topEndNotification("info", data.responseMessage);
                        var responseId = data.responseId;
                        $('#main_work_type_add').val("");
                        setTimeout(function(){
                            var formData = {"action":"fetchMainWorkType"};
                            $.ajax({
                                url: 'application/view/admin/work-flow',
                                type: 'POST',
                                data: formData,
                                success: function (data) {
                                    $('#loading').fadeOut(500, function () {
                                        $(this).remove();
                                        $('#main_work_type').html("<option disabled selected>Select</option>");
                                        $('#main_work_type').append(data);
                                        $('#main_work_type').val(responseId);
                                        $('#main_work_type_add_button').html(' <i class="fa fa-plus"></i>');
                                        $('#main_work_type_add_button').prop('disabled', false);
                                        $('#main_work_type').prop('disabled', false);
                                    });
                                }
                            });
                        }, 500);
                    }
                    else{
                        topEndNotification(data.responseType, data.responseMessage);
                        $('#loading').fadeOut(500, function () {
                            $(this).remove();
                            $('#main_work_type_add_button').html(' <i class="fa fa-plus"></i>');
                            $('#main_work_type_add_button').prop('disabled', false);
                            $('#main_work_type').prop('disabled', false);
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please Add Work Type!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#main_work_type_add_button').html(' <i class="fa fa-plus"></i>');
                $('#main_work_type_add_button').prop('disabled', false);
                $('#main_work_type').prop('disabled', false);
            });
        }
    });
    // Add Main Work Type Section End
    // Add Work Type Sections Start
    $('#work_type_add_button').click(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#work_type_add_button').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#work_type_add_button').prop('disabled', true);
        $('#work_type').prop('disabled', true);
        var flag = 1;
        if($("#work_type_add").val() == ""){
            $("#work_type_add").addClass("is-invalid");
            flag = 0;
        }else
            $("#work_type_add").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("work_type_add", $("#work_type_add").val());
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addWorkType");
            $.ajax({
                url: 'application/controller/admin/work-flow',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        topEndNotification("info", data.responseMessage);
                        var responseId = data.responseId;
                        $('#work_type_add').val("");
                        setTimeout(function(){
                            var formData = {"action":"fetchWorkType"};
                            $.ajax({
                                url: 'application/view/admin/work-flow',
                                type: 'POST',
                                data: formData,
                                success: function (data) {
                                    $('#loading').fadeOut(500, function () {
                                        $(this).remove();
                                        $('#work_type').html("<option disabled selected>Select</option>");
                                        $('#work_type').append(data);
                                        $('#work_type').val(responseId);
                                        $('#work_type_add_button').html(' <i class="fa fa-plus"></i>');
                                        $('#work_type_add_button').prop('disabled', false);
                                        $('#work_type').prop('disabled', false);
                                    });
                                }
                            });
                        }, 500);
                    }
                    else{
                        topEndNotification(data.responseType, data.responseMessage);
                        $('#loading').fadeOut(500, function () {
                            $(this).remove();
                            $('#work_type_add_button').html(' <i class="fa fa-plus"></i>');
                            $('#work_type_add_button').prop('disabled', false);
                            $('#work_type').prop('disabled', false);
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please Add Work Type!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#work_type_add_button').html(' <i class="fa fa-plus"></i>');
                $('#work_type_add_button').prop('disabled', false);
                $('#work_type').prop('disabled', false);
            });
        }
    });
    // Add Work Type Section End
    // Add Item Type Sections Start
    $('#item_type_add_button').click(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#item_type_add_button').html('<center id = "loading-item"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#item_type_add_button').prop('disabled', true);
        var flag = 1;
        if($("#item_type_add").val() == ""){
            $("#item_type_add").addClass("is-invalid");
            flag = 0;
        }else
            $("#item_type_add").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("item_type_ab_add", $("#item_type_ab_add").val());
            formData.append("item_type_add", $("#item_type_add").val());
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addItemType");
            $.ajax({
                url: 'application/controller/admin/work-flow',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        topEndNotification("info", data.responseMessage);
                        var responseId = data.responseId;
                        $('#item_type_add').val("");
                    }
                    else
                        topEndNotification(data.responseType, data.responseMessage);
                    $('#loading-item').fadeOut(500, function () {
                        $(this).remove();
                        $('#item_type_add_button').html(' <i class="fa fa-plus"></i>');
                        $('#item_type_add_button').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please Add Item Type!!!");
            $('#loading-item').fadeOut(500, function () {
                $(this).remove();
                $('#item_type_add_button').html(' <i class="fa fa-plus"></i>');
                $('#item_type_add_button').prop('disabled', false);
            });
        }
    });
    // Add Item Type Section End
    // Add Unit Sections Start
    $('#unit_type_add_button').click(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#unit_type_add_button').html('<center id = "loading-unit"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#unit_type_add_button').prop('disabled', true);
        var flag = 1;
        if($("#unit_type_add").val() == ""){
            $("#unit_type_add").addClass("is-invalid");
            flag = 0;
        }else
            $("#unit_type_add").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("unit_type_add", $("#unit_type_add").val());
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addUnitType");
            $.ajax({
                url: 'application/controller/admin/work-flow',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        topEndNotification("info", data.responseMessage);
                        var responseId = data.responseId;
                        $('#unit_type_add').val("");
                    }
                    else
                        topEndNotification(data.responseType, data.responseMessage);
                    $('#loading-unit').fadeOut(500, function () {
                        $(this).remove();
                        $('#unit_type_add_button').html(' <i class="fa fa-plus"></i>');
                        $('#unit_type_add_button').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please Add Unit!!!");
            $('#loading-unit').fadeOut(500, function () {
                $(this).remove();
                $('#unit_type_add_button').html(' <i class="fa fa-plus"></i>');
                $('#unit_type_add_button').prop('disabled', false);
            });
        }
    });
    // Add Unit Section End
    // Calculate Percentage Section Start -------------------------------------------------------------------- 
    calculateAmount = function() {
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
        var itemInfoTotalAmount = 0.00;
        var itemInfoTotalA = 0.00;
        var itemInfoTotalB = 0.00;
        var flag = 1;
        var totalRows = $("#totalItemInfo").val();
        for(i = 1; i <= totalRows; i++){
            var item_type_ab = $("#itemInfoItemType" + i).find(':selected').data('ab');
            var amount = Number($("#itemInfoQuantity" + i).val()) * Number($("#itemInfoRate" + i).val());
            $("#itemInfoAmount" + i).val(amount);
            itemInfoTotalAmount = itemInfoTotalAmount + amount;
            if(item_type_ab == "a"){
                $("#itemInfoMaterial" + i).val(amount);
                itemInfoTotalA = itemInfoTotalA + amount;
                $("#itemInfoLabour" + i).val("");
            } else{
                $("#itemInfoLabour" + i).val(amount);
                itemInfoTotalB = itemInfoTotalB + amount;
                $("#itemInfoMaterial" + i).val("");
            }
        }
        $("#itemInfoTotalAmount").val(parseFloat(itemInfoTotalAmount));
        $("#itemInfoTotalA").val(parseFloat(itemInfoTotalA));
        $("#itemInfoTotalB").val(parseFloat(itemInfoTotalB));
    }
    // Calculate Percentage Section End ----------------------------------------------------------------------
});