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
    //Aos creationx
    AOS.init();
    fetchFn();
    // Fetch Data Section Start --------------------------------------------------------------------------------------------------------------------
    function fetchFn() {
        topEndNotification("info", "Loading, Please Wait...");
        $('#view-section').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {"action":"fetchData"};
        $.ajax({
            url: 'application/view/admin/projects.php',
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
        if($("#firmName").val() == null){
            $("#firmName").addClass("is-invalid");
            flag = 0;
        }else
            $("#firmName").removeClass("is-invalid");
        if($("#projectName").val() == ""){
            $("#projectName").addClass("is-invalid");
            flag = 0;
        }else
            $("#projectName").removeClass("is-invalid");
        if($("#projectLocation").val() == ""){
            $("#projectLocation").addClass("is-invalid");
            flag = 0;
        }else
            $("#projectLocation").removeClass("is-invalid");
        if($("#projectStartingDate").val() == ""){
            $("#projectStartingDate").addClass("is-invalid");
            flag = 0;
        }else
            $("#projectStartingDate").removeClass("is-invalid");
        if($("#projectExpectedEndingDate").val() == ""){
            $("#projectExpectedEndingDate").addClass("is-invalid");
            flag = 0;
        }else
            $("#projectExpectedEndingDate").removeClass("is-invalid");
        // $(".main-rows").each(function(){
        //     if($(this).val() == "" || $(this).val() == null){
        //         flag = 0;
        //         $(this).addClass("is-invalid");
        //     } else
        //         $(this).removeClass("is-invalid");
        // });
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addData");
            $.ajax({
                url: 'application/controller/admin/projects.php',
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
            topEndNotification("warning" , "Please fill out the required fields");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#addButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                $('#addButton').prop('disabled', false);
            });
        }
    });
    // Add Section End -----------------------------------------------------------------------------------------------------------------------------
    // Add Property Section Start ------------------------------------------------------------------------------------------------------------------
    $('form#addPropertiesForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#addPropertiesButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#addPropertiesButton').prop('disabled', true);
        var flag = 1;
        var i = 1;
        $(".main-rows").each(function(){
            if($(this).val() == "" || $(this).val() == null){
                flag = 0;
                $(this).addClass("is-invalid");
            } else
                $(this).removeClass("is-invalid");
        });
        if(flag == 1){
            var formData = new FormData($('form#addPropertiesForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addPropertiesData");
            $.ajax({
                url: 'application/controller/admin/projects.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#addPropertiesForm')[0].reset();
                        $("#add-properties-modal").modal('hide');
                        setTimeout(function(){
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#addPropertiesButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                        $('#addPropertiesButton').prop('disabled', false);
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
                $('#addPropertiesButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                $('#addPropertiesButton').prop('disabled', false);
            });
        }
    });
    // Add Property Section End --------------------------------------------------------------------------------------------------------------------
     // Edit Property Section Start ------------------------------------------------------------------------------------------------------------------
    $('form#editPropertiesForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#editPropertiesButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#editPropertiesButton').prop('disabled', true);
        var flag = 1;
        var i = 1;
        $(".edit-main-rows").each(function(){
            if($(this).val() == "" || $(this).val() == null){
                flag = 0;
                $(this).addClass("is-invalid");
            } else
                $(this).removeClass("is-invalid");
        });
        if(flag == 1){
            var formData = new FormData($('form#editPropertiesForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editPropertiesData");
            $.ajax({
                url: 'application/controller/admin/projects.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#editPropertiesForm')[0].reset();
                        $("#properties-modal").modal('hide');
                        setTimeout(function(){
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#editPropertiesButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                        $('#editPropertiesButton').prop('disabled', false);
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
                $('#editPropertiesButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                $('#editPropertiesButton').prop('disabled', false);
            });
        }
    });
    // Edit Property Section End --------------------------------------------------------------------------------------------------------------------
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
                url: 'application/controller/admin/projects.php',
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
        var i = 1;
        if($("#editFirmName").val() == null){
            $("#editFirmName").addClass("is-invalid");
            flag = 0;
        }else
            $("#editFirmName").removeClass("is-invalid");
        if($("#editProjectName").val() == ""){
            $("#editProjectName").addClass("is-invalid");
            flag = 0;
        }else
            $("#editProjectName").removeClass("is-invalid");
        if($("#editProjectLocation").val() == ""){
            $("#editProjectLocation").addClass("is-invalid");
            flag = 0;
        }else
            $("#editProjectLocation").removeClass("is-invalid");
        if($("#editProjectStartingDate").val() == ""){
            $("#editProjectStartingDate").addClass("is-invalid");
            flag = 0;
        }else
            $("#editProjectStartingDate").removeClass("is-invalid");
        if($("#editProjectExpectedEndingDate").val() == ""){
            $("#editProjectExpectedEndingDate").addClass("is-invalid");
            flag = 0;
        }else
            $("#editProjectExpectedEndingDate").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#editForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editData");
            $.ajax({
                url: 'application/controller/admin/projects.php',
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
                    // topEndNotification(data.responseType, data.responseMessage);
                    topEndNotification("success" , "Data Edited Successfully");
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
                url: 'application/controller/admin/projects.php',
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
    // Delete Property Section Start ---------------------------------------------------------------------------------------------------------------
    $('form#deletePropertiesForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#deletePropertiesButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#deletePropertiesButton').prop('disabled', true);
        var flag = 1;
        if($("#tableId").val() == "" || $("#tableName").val() == "")
            flag = 0;
        if(flag == 1){
            var formData = new FormData($('form#deletePropertiesForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "deletePropertiesData");
            $.ajax({
                url: 'application/controller/admin/projects.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        // $('#deletePropertiesForm')[0].reset();
                        $('#delete-properties-modal').modal("hide");
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#deletePropertiesButton').html('<i class="fa fa-trash fa-sm"></i> Delete');
                        $('#deletePropertiesButton').prop('disabled', false);
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
                $('#deletePropertiesButton').html('<i class="fa fa-plus fa-sm"></i> Delete');
                $('#deletePropertiesButton').prop('disabled', false);
            });
        }
    });
    // Delete Property Section End -----------------------------------------------------------------------------------------------------------------
    // Export Selected Section Start ---------------------------------------------------------------------------------------------------------------
    $("#exportSelectedButton").click(function () {
        $('#exportSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#exportSelectedButton').prop('disabled', true);
        var formData = new FormData($('form#selectForm')[0]);
        formData.append("checkLocation", $("#checkLocation").val());
        formData.append("checkIp", $("#checkIp").val());
        formData.append("action", "exportData");
        $.ajax({
            url: 'application/controller/admin/projects.php',
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (data) {
                if(data.response == "success"){
                    $('#export-modal').modal("hide");
                    $('#export-button').addClass("display-none");
                    $('#delete-button').addClass("display-none");
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
            url: 'application/controller/admin/projects.php',
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (data) {
                if(data.response == "success"){
                    $('#delete-selected-modal').modal("hide");
                    $('#export-button').addClass("display-none");
                    $('#delete-button').addClass("display-none");
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
    // Calculate Amount Section Start ------------------------------------------------------------------------------------------------------------
    $(document).on("click keyup change blur", ".calculate-amount-now", function(){
        var row_id = $(this).attr("data-flat-row-id");
        var floor_row_id = $(this).attr("data-floor-row-id");
        $("#price_total_"+ floor_row_id +"_"+ row_id).val(Number($("#square_feet_"+ floor_row_id +"_"+ row_id).val()) * Number($("#price_per_square_"+ floor_row_id +"_"+ row_id).val()));
    });
    $(document).on("click keyup change blur", ".edit-calculate-amount-now", function(){
        var row_id = $(this).attr("data-flat-row-id");
        var floor_row_id = $(this).attr("data-floor-row-id");
        $("#edit_price_total_"+ floor_row_id +"_"+ row_id).val(Number($("#edit_square_feet_"+ floor_row_id +"_"+ row_id).val()) * Number($("#edit_price_per_square_"+ floor_row_id +"_"+ row_id).val()));
    });
    // Calculate Amount Section End ------------------------------------------------------------------------------------------------------------
    // Check Percentage Section Start ------------------------------------------------------------------------------------------------------------
    $(document).on("click keyup change blur", ".input-percentage", function(){
        if(Number($(this).val()) > 100){
            topEndNotification("warning", "% should be less than and equal to 100...");
            $(this).val(100);
        }
    });
    // Check Percentage Section End ------------------------------------------------------------------------------------------------------------
    // Check Validation Section Start ------------------------------------------------------------------------------------------------------------
    $(document).on("click keyup change blur", ".main-rows", function(){
        if($(this).val() == "" || $(this).val() == null){
            flag = 0;
            $(this).addClass("is-invalid");
        } else
            $(this).removeClass("is-invalid");
    });
    $(document).on("click keyup change blur", ".edit-main-rows", function(){
        if($(this).val() == "" || $(this).val() == null){
            flag = 0;
            $(this).addClass("is-invalid");
        } else
            $(this).removeClass("is-invalid");
    });
    // Check Validation Section End ------------------------------------------------------------------------------------------------------------
    // Add Projects Section Start ---------------------------------------------------------------
    $(document).on("click", ".add-properties-button", function () {
        $("#show-project-name").html($("#projects-name-"+ $(this).data("projects-id")).text());
        $("#properties_project_id").val($(this).data("projects-id"));
        $("#add-properties-modal").modal('show');
        $('#add-properties-section').html('<center id = "add-properties-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {"action":"fetchAddProperty","id":$(this).data("projects-id")};
        $.ajax({
            url: 'application/view/admin/projects.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#add-properties-loading').fadeOut(500, function () {
                    $(this).remove();
                    $('#add-properties-section').html(data);
                });
            }
        });
    });
    // Add Projects Section End -----------------------------------------------------------------
    // Edit Projects Section Start ---------------------------------------------------------------
    $(document).on("click", ".properties-button", function () {
        $("#edit-show-project-name").html($("#projects-name-"+ $(this).data("projects-id")).text());
        $("#delete-property-button").attr("data-properties-id", $(this).data("properties-id"));
        $("#properties-modal").modal('show');
        $('#properties-section').html('<center id = "properties-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {"action":"fetchEditProperty","id":$(this).data("properties-id")};
        $.ajax({
            url: 'application/view/admin/projects.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#properties-loading').fadeOut(500, function () {
                    $(this).remove();
                    $('#properties-section').html(data);
                });
            }
        });
    });
    // Edit Projects Section End -----------------------------------------------------------------
    // Edit Projects Section Start ---------------------------------------------------------------
    $(document).on("click", ".delete-property-button", function () {
        $("#properties-modal").modal('hide');
        $("#delete-properties-modal").modal('show');
        $('#delete-properties-section').html('<center id = "delete-properties-loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {"action":"fetchDeleteProperty","id":$(this).data("properties-id")};
        $.ajax({
            url: 'application/view/admin/projects.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#delete-properties-loading').fadeOut(500, function () {
                    $(this).remove();
                    $('#delete-properties-section').html(data);
                });
            }
        });
    });
    // Edit Projects Section End -----------------------------------------------------------------
});