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

            url: 'application/view/admin/mystock.php',

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

        if($("#itemName").val() == ""){

            $("#itemName").addClass("is-invalid");

            flag = 0;

        }else

            $("#itemName").removeClass("is-invalid");

        if($("#itemCode").val() == ""){

            $("#itemCode").addClass("is-invalid");

            flag = 0;

        }else

            $("#itemCode").removeClass("is-invalid");

        if($("#itemCategory").val() == ""){

            $("#itemCategory").addClass("is-invalid");

            flag = 0;

        }else

            $("#itemCategory").removeClass("is-invalid");

        if($("#Uom").val() == ""){

            $("#Uom").addClass("is-invalid");

            flag = 0;

        }else

            $("#Uom").removeClass("is-invalid");

        if($("#Price").val() == ""){

            $("#Price").addClass("is-invalid");

            flag = 0;

        }else

            $("#Price").removeClass("is-invalid");

        if($("#Qty").val() == ""){

            $("#Qty").addClass("is-invalid");

            flag = 0;

        }else

            $("#Qty").removeClass("is-invalid");

        if($("#ReOrder").val() == ""){

            $("#ReOrder").addClass("is-invalid");

            flag = 0;

        }else

            $("#ReOrder").removeClass("is-invalid");

        if(flag == 1){

            var formData = new FormData($('form#addForm')[0]);

            formData.append("checkLocation", $("#checkLocation").val());

            formData.append("checkIp", $("#checkIp").val());

            formData.append("action", "addData");

            $.ajax({

                url: 'application/controller/admin/mystock.php',

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

                url: 'application/controller/admin/mystock.php',

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

    $("#order-button").click(function(){

        $("#selectForm").attr("action", "indent");

        $("#selectForm").submit();

    });

    // Edit Section Start --------------------------------------------------------------------------------------------------------------------------

    $('form#editForm').submit(function (event) {


        event.preventDefault(); //Prevent Default the Events

        $('#editButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        $('#editButton').prop('disabled', true);

        var flag = 1;

        if($("#editItemCode").val() == ""){

            $("#editItemCode").addClass("is-invalid");

            flag = 0;

        }else

            $("#editItemCode").removeClass("is-invalid");

        if($("#editItemName").val() == ""){

            $("#editItemName").addClass("is-invalid");

            flag = 0;

        }else

            $("#editItemName").removeClass("is-invalid");

        if($("#editItemCategory").val() == ""){

            $("#editItemCategory").addClass("is-invalid");

            flag = 0;

        }else

            $("#editItemCategory").removeClass("is-invalid");

        if($("#editUom").val() == ""){

            $("#editUom").addClass("is-invalid");

            flag = 0;

        }else

            $("#editUom").removeClass("is-invalid");

        if($("#editItemPrice").val() == ""){

            $("#editItemPrice").addClass("is-invalid");

            flag = 0;

        }else

            $("#editItemPrice").removeClass("is-invalid");

        if($("#editQty").val() == ""){

            $("#editQty").addClass("is-invalid");

            flag = 0;

        }else

            $("#editQty").removeClass("is-invalid");

        if($("#editReOrder").val() == ""){

            $("#editReOrder").addClass("is-invalid");

            flag = 0;

        }else

            $("#editReOrder").removeClass("is-invalid");

        if(flag == 1){

            var formData = new FormData($('form#editForm')[0]);

            formData.append("checkLocation", $("#checkLocation").val());

            formData.append("checkIp", $("#checkIp").val());

            formData.append("action", "editData");
            // console.log("abc");
            $.ajax({

                url: 'application/controller/admin/mystock.php',

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
        // alert("abc");
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

                url: 'application/controller/admin/mystock.php',

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
    // Commit Section Start--------------------------------------------------------------------------------------------------------------------------
    $('form#commitForm').submit(function (event) {
        

        event.preventDefault(); //Prevent Default the Events

        $('#commitButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        $('#commitButton').prop('disabled', true);


        var flag = 1;

        // if($("#tableId").val() == "" || $("#tableName").val() == "")

        //     flag = 0;

        if(flag == 1){

            var formData = new FormData($('form#commitForm')[0]);

            formData.append("checkLocation", $("#checkLocation").val());

            formData.append("checkIp", $("#checkIp").val());

            formData.append("action", "commitData");
             // formData.append("action", "editfetchDesignationDetails");
            


            $.ajax({

                url: 'application/controller/admin/mystock.php',

                type: 'POST',

                data: formData,

                dataType: "json",

                success: function (data) {

                    if(data.response == "success"){

                        $('#commitForm')[0].reset();

                        $('#commit-modal').modal("hide");

                        setTimeout(function(){

                            fetchFn();

                        }, 1000);

                    }

                    topEndNotification(data.responseType, data.responseMessage);

                    $('#loading').fadeOut(500, function () {

                        $(this).remove();

                        $('#commitButton').html('<i class="fa fa-plus fa-sm"></i> Commit');

                        $('#commitButton').prop('disabled', true);
                        $('##commit-modal').prop('disabled', true);

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

                $('#commitButton').html('<i class="fa fa-plus fa-sm"></i> Commit');

                $('#commitButton').prop('disabled', false);

            });

        }

    });

    // Export Selected Section Start ---------------------------------------------------------------------------------------------------------------

    $("#exportSelectedButton").click(function () {
        alert(sweta);

        $('#exportSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        $('#exportSelectedButton').prop('disabled', true);

        var formData = new FormData($('form#selectForm')[0]);

        formData.append("checkLocation", $("#checkLocation").val());

        formData.append("checkIp", $("#checkIp").val());

        formData.append("action", "exportData");

        $.ajax({

            url: 'application/controller/admin/mystock.php',

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
    $(document).on("click", ".check-project-id", function(){
        var project_id = $(this).data("project-id");
        if($(this).is(":checked")){
            $(".check-project-id").each(function(){
                if(Number($(this).data("project-id")) != Number(project_id))
                    $(this).prop("disabled", true);
            });
        } else{
            var temp_flag = 1;
            $(".check-project-id").each(function(){
                if(Number($(this).data("project-id")) == Number(project_id))
                    temp_flag = 0;
            });
            if(temp_flag == 1){
                $(".check-project-id").each(function(){
                    $(this).prop("disabled", false);
                });
            }
        }
    });


    // Delete Selected Section Start ---------------------------------------------------------------------------------------------------------------

    $("#deleteSelectedButton").click(function () {
        alert(abc);

        $('#deleteSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        $('#deleteSelectedButton').prop('disabled', true);

        var formData = new FormData($('form#selectForm')[0]);

        formData.append("checkLocation", $("#checkLocation").val());

        formData.append("checkIp", $("#checkIp").val());

        formData.append("action", "deleteSelectedData");

        $.ajax({

            url: 'application/controller/admin/mystock.php',

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

});

