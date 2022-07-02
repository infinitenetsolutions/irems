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
        $('#view-section').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {"action":"fetchData"};
        $.ajax({
            url: 'application/view/admin/profile.php',
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
    // fetch project details start
                                           
    
    // fetch project details end                                   
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
        $("#edit-section").html("");
        $('#addButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#addButton').prop('disabled', true);
        var flag = 1;
        var error_message = "Please fill out the required fields!!!";
        var temp_flag = 0;
        $(".menu-checkbox").each(function(){
            if($(this).is(":checked"))
                temp_flag = 1;
        });
        if(temp_flag == 0){
            error_message = "Please select atlest one Menu and Submenu!!!";
            flag = 0;
        }
        if($("#roleName").val() == ""){
            $("#roleName").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#roleName").removeClass("is-invalid");
        if($("#roleContactNumber").val() == ""){
            $("#roleContactNumber").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#roleContactNumber").removeClass("is-invalid");
        if($("#roleEmail").val() == ""){
            $("#roleEmail").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#roleEmail").removeClass("is-invalid");
        if($("#roleGender").val() == ""){
            $("#roleGender").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#roleGender").removeClass("is-invalid");
        //      if($("#roleProject").val() == ""){
        //     $("#roleProject").addClass("is-invalid");
        //     error_message = "Please fill out the required fields!!!";
        //     flag = 0;
        // }else
        //     $("#roleProject").removeClass("is-invalid");
        if($("#rolePassword").val() == ""){
            $("#rolePassword").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#rolePassword").removeClass("is-invalid");
        if($("#roleRePassword").val() == ""){
            $("#roleRePassword").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#roleRePassword").removeClass("is-invalid");
        if($("#rolePassword").val() != "" && $("#roleRePassword").val() != ""){
            if($("#rolePassword").val() != $("#roleRePassword").val()){
                error_message = "Password did'n match!!!";
                flag = 0;
                $("#rolePassword").addClass("is-invalid");
                $("#roleRePassword").addClass("is-invalid");
            } else{
                $("#rolePassword").removeClass("is-invalid");
                $("#roleRePassword").removeClass("is-invalid");
            }
        }
        if($("#roleUsername").val() == ""){
            $("#roleUsername").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else{
            if($("#roleUsername").data("check-user") == "incorrect"){
                $("#roleUsername").addClass("is-invalid");
                error_message = "Username already exists, Please change and try again!!!";
                flag = 0;
            } else
                $("#roleUsername").removeClass("is-invalid");
        }
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addData");
            $.ajax({
                url: 'application/controller/admin/profile.php',
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
            topEndNotification("warning" , error_message);
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#addButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                $('#addButton').prop('disabled', false);
                $('html, body, div').animate({
                    scrollTop: $("#add-modal").offset().top
                }, 2000);
            });
        }
    });
    // Add Section End -----------------------------------------------------------------------------------------------------------------------------
    // Edit Section Start --------------------------------------------------------------------------------------------------------------------------
    $('form#editForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#editButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#editButton').prop('disabled', true);
        var flag = 1;
        var error_message = "Please fill out the required fields!!!";
        var temp_flag = 0;
        $(".menu-checkbox").each(function(){
            if($(this).is(":checked"))
                temp_flag = 1;
        });
        if(temp_flag == 0){
            error_message = "Please select atlest one Menu and Submenu!!!";
            flag = 0;
        }
        if($("#editRoleName").val() == ""){
            $("#editRoleName").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#editRoleName").removeClass("is-invalid");
        if($("#editRoleContactNumber").val() == ""){
            $("#editRoleContactNumber").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#editRoleContactNumber").removeClass("is-invalid");
        if($("#editRoleEmail").val() == ""){
            $("#editRoleEmail").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#editRoleEmail").removeClass("is-invalid");
        if($("#editRoleGender").val() == ""){
            $("#editRoleGender").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else
            $("#editRoleGender").removeClass("is-invalid");
        //      if($("#editRoleProject").val() == ""){
        //     $("#editRoleProject").addClass("is-invalid");
        //     error_message = "Please fill out the required fields!!!";
        //     flag = 0;
        // }else
        //     $("#editRoleProject").removeClass("is-invalid");
        if($("#editRolePassword").val() != "" && $("#editRoleRePassword").val() != ""){
            if($("#editRolePassword").val() != $("#editRoleRePassword").val()){
                error_message = "Password did'n match!!!";
                flag = 0;
                $("#editRolePassword").addClass("is-invalid");
                $("#editRoleRePassword").addClass("is-invalid");
            } else{
                $("#editRolePassword").removeClass("is-invalid");
                $("#editRoleRePassword").removeClass("is-invalid");
            }
        }
        if($("#editRoleUsername").val() == ""){
            $("#editRoleUsername").addClass("is-invalid");
            error_message = "Please fill out the required fields!!!";
            flag = 0;
        }else{
            if($("#editRoleUsername").data("check-user") == "incorrect"){
                $("#editRoleUsername").addClass("is-invalid");
                error_message = "Username already exists, Please change and try again!!!";
                flag = 0;
            } else
                $("#editRoleUsername").removeClass("is-invalid");
        }
        if(flag == 1){
            var formData = new FormData($('form#editForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editData");
            $.ajax({
                url: 'application/controller/admin/profile.php',
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
            topEndNotification("warning" , error_message);
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#editButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                $('#editButton').prop('disabled', false);
                $('html, body, div').animate({
                    scrollTop: $("#edit-modal").offset().top
                }, 2000);
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
                url: 'application/controller/admin/profile.php',
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
            url: 'application/controller/admin/profile.php',
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
            url: 'application/controller/admin/profile.php',
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
    // Recheck Password Section Start --------------------------------------------------------------------------------------------------------------
    $("#roleRePassword").on("blur change", function(){
        if($("#rolePassword").val() != ""){
            if($("#rolePassword").val() != $("#roleRePassword").val()){
                topEndNotification("question", "Password did'n match!!!");
                $("#rolePassword").addClass("is-invalid");
                $("#roleRePassword").addClass("is-invalid");
            } else{
                $("#rolePassword").removeClass("is-invalid");
                $("#roleRePassword").removeClass("is-invalid");
            }
        } else{
            $("#rolePassword").removeClass("is-invalid");
            $("#roleRePassword").removeClass("is-invalid");
        }
    });
    $(document).on("blur change", "#editRoleRePassword", function(){
        if($("#editRolePassword").val() != ""){
            if($("#editRolePassword").val() != $("#editRoleRePassword").val()){
                topEndNotification("question", "Password did'n match!!!");
                $("#editRolePassword").addClass("is-invalid");
                $("#editRoleRePassword").addClass("is-invalid");
            } else{
                $("#editRolePassword").removeClass("is-invalid");
                $("#editRoleRePassword").removeClass("is-invalid");
            }
        } else{
            $("#editRolePassword").removeClass("is-invalid");
            $("#editRoleRePassword").removeClass("is-invalid");
        }
    });
    // Recheck Password Section End ----------------------------------------------------------------------------------------------------------------
    // Password Open Close Section Start -----------------------------------------------------------------------------------------------------------
    $(document).on("click", ".open-close", function(){
        if($(this).data("open-close") == "close"){
            $(this).html('<i class="fa fa-eye"></i>');
            $(this).data('open-close', 'open');
            $(this).closest(".input-group").find("input[type=password]").attr("type", "text");
        } else{
            $(this).html('<i class="fa fa-eye-slash"></i>');
            $(this).data('open-close', 'close');
            $(this).closest(".input-group").find("input[type=text]").attr("type", "password");
        }
    });
    // Password Open Close Section End -------------------------------------------------------------------------------------------------------------
    // Check Username Section Start ----------------------------------------------------------------------------------------------------------------
    $("#roleUsername").on("change", function(){
        if($(this).val() != "" && $(this).val() != $(this).data("pre-user")){
            var formData = new FormData();
            formData.append("user", $(this).val());
            formData.append("action", "checkUsername");
            $.ajax({
                url: 'application/controller/admin/profile.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response != "ok")
                        topEndNotification(data.responseType, data.responseMessage);
                    if(data.response == "exists"){
                        $("#roleUsername").addClass("is-invalid");
                        $("#roleUsername").data("check-user", "incorrect");
                        $("#roleUsername").data("pre-user", $("#roleUsername").val());
                        $('html, body, div').animate({
                            scrollTop: $("#add-modal").offset().top
                        }, 2000);
                    } else{
                        $("#roleUsername").removeClass("is-invalid");
                        $("#roleUsername").data("check-user", "correct");
                        $("#roleUsername").data("pre-user", $("#roleUsername").val());
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
    $(document).on("change", "#editRoleUsername", function(){
        if($(this).val() != "" && $(this).val() != $(this).data("pre-user") && $(this).val() != $(this).data("already-user")){
            var formData = new FormData();
            formData.append("user", $(this).val());
            formData.append("action", "checkUsername");
            $.ajax({
                url: 'application/controller/admin/profile.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response != "ok")
                        topEndNotification(data.responseType, data.responseMessage);
                    if(data.response == "exists"){
                        $("#editRoleUsername").addClass("is-invalid");
                        $("#editRoleUsername").data("check-user", "incorrect");
                        $("#editRoleUsername").data("pre-user", $("#editRoleUsername").val());
                        $('html, body, div').animate({
                            scrollTop: $("#add-modal").offset().top
                        }, 2000);
                    } else{
                        $("#editRoleUsername").removeClass("is-invalid");
                        $("#editRoleUsername").data("check-user", "correct");
                        $("#editRoleUsername").data("pre-user", $("#editRoleUsername").val());
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        if($(this).val() == $(this).data("already-user")){
            $("#editRoleUsername").removeClass("is-invalid");
            $("#editRoleUsername").data("check-user", "correct");
        }
    });
    // Check Username Section End ------------------------------------------------------------------------------------------------------------------
    // Menu/Submenu Auto Selection Section Start ---------------------------------------------------------------------------------------------------
    $(document).on("click", ".sub-menu-checkbox", function(){
        var check_flag = 0;
        $(this).closest(".card").find(".sub-menu-checkbox").each(function(){
            if($(this).is(":checked"))
                check_flag = 1;
        });
        if(check_flag == 1){
            $(this).closest(".card").find(".menu-checkbox").prop("checked", true);
            var check_flag = 0;
            $(this).closest("tr").find(".sub-menu-checkbox").each(function(){
                if($(this).is(":checked"))
                    check_flag = 1;
            });
            if(check_flag == 1)
                $(this).closest("tr").find(".auth-checkbox").prop("checked", true);
        }
        else{
            $(this).closest(".card").find(".menu-checkbox").prop("checked", false);
            $(this).closest("tr").find(".auth-checkbox").prop("checked", false);
        }
    });
    $(document).on("click", ".menu-checkbox", function(){
        if(!$(this).is(":checked")){
            $(this).closest(".card").find(".sub-menu-checkbox").each(function(){
                $(this).prop("checked", false);
            });
        } else{
            $(this).closest(".card").find(".auth-checkbox:first").prop("checked", true);
        }
    });
    // Menu/Submenu Auto Selection Section End -----------------------------------------------------------------------------------------------------
    $("#roleName").change(function(){
        // alert("sweta");
        $("#roleEmpId").val($(this).find(":selected").data("row-id"));
        $("#roleContactNumber").val($(this).find(":selected").data("contact-number"));
        $("#roleEmail").val($(this).find(":selected").data("email"));
        $("#roleGender").val($(this).find(":selected").data("gender"));
        $("#roleAddress").val($(this).find(":selected").data("address"));
        $("#roleProject").val($(this).find(":selected").data("project"));
        // $("#roleProject").val($(this).find(":selected").data("project"));
        // alert($(this).find(":selected").data("project"));
    });
});

 
        function run(input) {

        var formData = new FormData();

        formData.append("action", "fetchProject");
        formData.append("roleProject", $(input).find(':selected').data('project'));

       

        $.ajax({

            url: 'application/controller/admin/profile.php',

            type: 'POST',

            data: formData,

            success: function(result) {
               
               
                response=JSON.parse(result);
                if(response.projects_name !== null && response.projects_name !== ''){
                    $("#projectName").val(response.projects_name);
                }else{
                     $("#projectName").val("Project Not Allocated");
                }
                $('#commit_edit option[value='+response.commit_edit+']').attr('selected','selected').change();
                $('#commit_delete option[value='+response.commit_delete+']').attr('selected','selected').change();

                 setTimeout(function(){
                      $("#roleProject").prop("disabled", false);
                 }, 500);

            },

            cache: false,

            contentType: false,

            processData: false

        });

        event.preventDefault();

     }
           // $('#edt_commit_edit').on('change', function( event ) {
        // alert($("#edit_commit_edit").val());
       // alert("sweta");
       //  var formData = new FormData();

       //  formData.append("action", "addCommitEdit");
       //  formData.append("commit_edit", $("#commit_edit").val());
       //  formData.append("empid", $("#roleEmpId").val());
       // // formData.append("project", $("#roleProject").val($(this).find(":selected").data("project")));
       //  // $("#designation").prop("disabled", true);

       //  $.ajax({

       //      url: 'application/controller/admin/profile.php',

       //      type: 'POST',

       //      data: formData,

       //      success: function(result) {
       //           // alert(result);

       //              if(data.response != "ok")
       //                  topEndNotification(data.responseType, data.responseMessage);
                    
       //          },

       //      cache: false,

       //      contentType: false,

       //      processData: false

       //  });

       //  event.preventDefault();

    // });
     $('#commit_edit').on('change', function( event ) {
       

        var formData = new FormData();

        formData.append("action", "addCommitEdit");
        formData.append("commit_edit", $("#commit_edit").val());
        formData.append("empid", $("#roleEmpId").val());
       // formData.append("project", $("#roleProject").val($(this).find(":selected").data("project")));
        // $("#designation").prop("disabled", true);

        $.ajax({

            url: 'application/controller/admin/profile.php',

            type: 'POST',

            data: formData,

            success: function(result) {
                 alert(result);

                    
                },

            cache: false,

            contentType: false,

            processData: false

        });

        event.preventDefault();

    });

     $('#commit_delete').on('change', function( event ) {
        // alert($("#commit_edit").val());

        var formData = new FormData();

        formData.append("action", "addCommitDelete");
        formData.append("commit_delete", $("#commit_delete").val());
        formData.append("empid", $("#roleEmpId").val());
       // formData.append("project", $("#roleProject").val($(this).find(":selected").data("project")));
        // $("#designation").prop("disabled", true);

        $.ajax({

            url: 'application/controller/admin/profile.php',

            type: 'POST',

            data: formData,

            success: function(result) {
                 // alert(result);

                    
                    
                },

            cache: false,

            contentType: false,

            processData: false

        });

        event.preventDefault();

    });