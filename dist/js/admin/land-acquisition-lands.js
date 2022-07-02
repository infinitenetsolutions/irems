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
    //Find Rupees In Words
    function convertNumberToWords(amount) {
        var words = new Array();
        words[0] = '';
        words[1] = 'One';
        words[2] = 'Two';
        words[3] = 'Three';
        words[4] = 'Four';
        words[5] = 'Five';
        words[6] = 'Six';
        words[7] = 'Seven';
        words[8] = 'Eight';
        words[9] = 'Nine';
        words[10] = 'Ten';
        words[11] = 'Eleven';
        words[12] = 'Twelve';
        words[13] = 'Thirteen';
        words[14] = 'Fourteen';
        words[15] = 'Fifteen';
        words[16] = 'Sixteen';
        words[17] = 'Seventeen';
        words[18] = 'Eighteen';
        words[19] = 'Nineteen';
        words[20] = 'Twenty';
        words[30] = 'Thirty';
        words[40] = 'Forty';
        words[50] = 'Fifty';
        words[60] = 'Sixty';
        words[70] = 'Seventy';
        words[80] = 'Eighty';
        words[90] = 'Ninety';
        amount = amount.toString();
        var atemp = amount.split(".");
        var number = atemp[0].split(",").join("");
        var n_length = number.length;
        var words_string = "";
        if (n_length <= 9) {
            var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
            var received_n_array = new Array();
            for (var i = 0; i < n_length; i++) {
                received_n_array[i] = number.substr(i, 1);
            }
            for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                n_array[i] = received_n_array[j];
            }
            for (var i = 0, j = 1; i < 9; i++, j++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    if (n_array[i] == 1) {
                        n_array[j] = 10 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    }
                }
            }
            value = "";
            for (var i = 0; i < 9; i++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    value = n_array[i] * 10;
                } else {
                    value = n_array[i];
                }
                if (value != 0) {
                    words_string += words[value] + " ";
                }
                if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Crores ";
                }
                if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Lakhs ";
                }
                if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Thousand ";
                }
                if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                    words_string += "Hundred and ";
                } else if (i == 6 && value != 0) {
                    words_string += "Hundred ";
                }
            }
            words_string = words_string.split("  ").join(" ");
        }
        return words_string;
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
            url: 'application/view/admin/land-acquisition-lands',
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
    // Fetch Owner Informations Section Start --------------------------------------------------------------------------------------------------------------------
    $("#ownerName").change(function () {
        topEndNotification("info", "Loading Owner Informations, Please Wait...");
        $('#owner-informations').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        $('#ownerName').prop('disabled', true);
        var formData = {"action":"fetchOwnerInformations","id":$("#ownerName").val()};
        $.ajax({
            url: 'application/view/admin/land-acquisition-lands',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#loading').fadeOut(500, function () {
                    $(this).remove();
                     topEndNotification("info", "Informations Fetched...");
                    $('#owner-informations').html(data);
                    $('#ownerName').prop('disabled', false);
                });
            }
        });
    });
    // Fetch Owner Informations Section End ----------------------------------------------------------------------------------------------------------------------
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
         //console.log("val"+ $("select#ownerName option:selected").val());
         console.log("val"+ $("select#landPurchaseCondition option:selected").val());

        if($("select#ownerName option:selected").val() == "Select Owner"){
            $("select#ownerName").addClass("is-invalid");
            error_message_show = "Please Select Owner Name";
            flag = 0;
        }else
           $("select#ownerName").removeClass("is-invalid");

         if($("select#landPurchaseCondition option:selected").val() == "Select"){
            $("select#landPurchaseCondition").addClass("is-invalid");
            error_message_show = "Please Select Purchase Condition";
            flag = 0;
        }else
           $("select#landPurchaseCondition").removeClass("is-invalid");


        if($("select#landState option:selected").val() == "Select"){
            $("select#landState").addClass("is-invalid");
            error_message_show = "Please Select State";
            flag = 0;
        }else
           $("select#landState").removeClass("is-invalid");

        if($("select#landCity option:selected").val() == "Select"){
            $("select#landCity").addClass("is-invalid");
            error_message_show = "Please Select City";
            flag = 0;
        }else
           $("select#landCity").removeClass("is-invalid");

        if($("#landUnit").val() == ""){
            $("#landUnit").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landUnit").removeClass("is-invalid");

        if($("#landSubUnit").val() == ""){
            $("#landSubUnit").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landSubUnit").removeClass("is-invalid");
        if($("#landStreetName").val() == ""){
            $("#landStreetName").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landStreetName").removeClass("is-invalid");
         if($("#landLandMark").val() == ""){
            $("#landLandMark").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landLandMark").removeClass("is-invalid");
        if($("#landLineNo").val() == ""){
            $("#landLineNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landLineNo").removeClass("is-invalid");
        if($("#landPincode").val() == ""){
            $("#landPincode").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landPincode").removeClass("is-invalid");
        if($("#landContactNumber").val() == ""){
            $("#landContactNumber").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landContactNumber").removeClass("is-invalid");
        if($("#landOfficeNumber").val() == ""){
            $("#landOfficeNumber").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landOfficeNumber").removeClass("is-invalid");
        if($("#landEmail").val() == ""){
            $("#landEmail").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landEmail").removeClass("is-invalid");
        if($("#landAddress").val() == ""){
            $("#landAddress").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landAddress").removeClass("is-invalid");
        if($("#landPanNo").val() == ""){
            $("#landPanNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landPanNo").removeClass("is-invalid");
        if($("#landAadharNo").val() == ""){
            $("#landAadharNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#landAadharNo").removeClass("is-invalid");
            //Land Information validation
                    for(j = 1; j <= Number($("#totalLandInfo").val()); j++){
                    if($("#landInfoType"+j).val() == ""){
                        $("#landInfoType"+j).addClass("is-invalid");
                        flag = 0;
                    }else
                        $("#landInfoType"+j).removeClass("is-invalid");
                    if($("#landInfoArea"+j).val() == ""){
                        $("#landInfoArea"+j).addClass("is-invalid");
                        flag = 0;
                    }else
                        $("#landInfoArea"+j).removeClass("is-invalid");
                    if($("#landInfoUOM"+j).val() == ""){
                        $("#landInfoUOM"+j).addClass("is-invalid");
                       flag = 0;
                    }else
                        $("#landInfoUOM"+j).removeClass("is-invalid");
                    if($("#landInfoPricePerUOM"+j).val() == ""){
                        $("#landInfoPricePerUOM"+j).addClass("is-invalid");
                        flag = 0;
                    }else
                        $("#landInfoPricePerUOM"+j).removeClass("is-invalid");
                    if($("#landInfoTotalPrice"+j).val() == ""){
                        $("#landInfoTotalPrice"+j).addClass("is-invalid");
                      flag = 0;
                    }else
                        $("#landInfoTotalPrice"+j).removeClass("is-invalid");      
                }
                if($('#landPurchaseDealingPrice').val() == ""){
                $("#landPurchaseDealingPrice").addClass("is-invalid");
                }else
                    $("#landPurchaseDealingPrice").removeClass("is-invalid");  

            //Purchase Information and Payment Structure validation
                for(i = 1; i <= $("#totalNumberOfDivision").val(); i++){
                    //Checking empty and filled up rows Section Start
                    if($("#landPurchasePaymentStuctureWhen"+i).val() == ""){
                        $("#landPurchasePaymentStuctureWhen"+i).addClass("is-invalid");
                        flag = 0;
                    }else
                        $("#landPurchasePaymentStuctureWhen"+i).removeClass("is-invalid");
                    if($("#landPurchasePaymentStuctureDate"+i).val() == ""){
                        $("#landPurchasePaymentStuctureDate"+i).addClass("is-invalid");
                        flag = 0;
                    }else
                        $("#landPurchasePaymentStuctureDate"+i).removeClass("is-invalid");

                    if($("#landPurchasePaymentStuctureCompletion"+i).val() == ""){
                        $("#landPurchasePaymentStuctureCompletion"+i).addClass("is-invalid");
                        $("#landPurchasePaymentStuctureAmount"+i).addClass("is-invalid");
                        $("#landPurchasePaymentStuctureAmount"+i).val("");
                    }else{
                            $("#landPurchasePaymentStuctureCompletion"+i).removeClass("is-invalid");
                            $("#landPurchasePaymentStuctureAmount"+i).removeClass("is-invalid");   
                        }
                    }
                    
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("landOwnerName", $("select#ownerName option:selected").html());
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addData");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-lands',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#addForm')[0].reset();
                        $('#add-modal').modal("hide");
                        $('#totalLandInfo').val("");
                  
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
                     location.reload(true);
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
                $('html, body, div').animate({
                    scrollTop: $("#add-modal").offset().top
                }, 2000);
            });
        }
    });

    // Add Conditions Sections Start
    $('#landPurchaseConditionAddButton').click(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#landPurchaseConditionAddButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#landPurchaseConditionAddButton').prop('disabled', true);
        $('#landPurchaseCondition').prop('disabled', true);
        var flag = 1;
        if($("#landPurchaseConditionAdd").val() == ""){
            $("#landPurchaseConditionAdd").addClass("is-invalid");
            flag = 0;
        }else
            $("#landPurchaseConditionAdd").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("landPurchaseConditionAdd", $("#landPurchaseConditionAdd").val());
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addLandPurchaseCondition");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-lands',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        topEndNotification("info", data.responseMessage);
                        var responseId = data.responseId;
                        $('#landPurchaseConditionAdd').val("");
                        setTimeout(function(){
                            var formData = {"action":"fetchLandPurchaseCondition"};
                            $.ajax({
                                url: 'application/view/admin/land-acquisition-lands',
                                type: 'POST',
                                data: formData,
                                success: function (data) {
                                    $('#loading').fadeOut(500, function () {
                                        $(this).remove();
                                        $('#landPurchaseCondition').html("<option disabled selected>Select</option>");
                                        $('#landPurchaseCondition').append(data);
                                        $('#landPurchaseCondition').val(responseId);
                                        $('#landPurchaseConditionAddButton').html(' <i class="fa fa-plus"></i>');
                                        $('#landPurchaseConditionAddButton').prop('disabled', false);
                                        $('#landPurchaseCondition').prop('disabled', false);
                                    });
                                }
                            });
                        }, 500);
                    }
                    else{
                        topEndNotification(data.responseType, data.responseMessage);
                        $('#loading').fadeOut(500, function () {
                            $(this).remove();
                            $('#landPurchaseConditionAddButton').html(' <i class="fa fa-plus"></i>');
                            $('#landPurchaseConditionAddButton').prop('disabled', false);
                            $('#landPurchaseCondition').prop('disabled', false);
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please give Condition!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#landPurchaseConditionAddButton').html(' <i class="fa fa-plus"></i>');
                $('#landPurchaseConditionAddButton').prop('disabled', false);
                $('#landPurchaseCondition').prop('disabled', false);
            });
        }
    });
    // Add Conditions Section End

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
                url: 'application/controller/admin/land-acquisition-lands',
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
        if($("#editLandName").val() == ""){
            $("#editLandName").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editLandName").removeClass("is-invalid");
        if($("#editLandCity").val() == ""){
            $("#editLandCity").addClass("is-invalid");
            error_message_show = "Please select City And State";
            flag = 0;
        }else
            $("#editLandCity").removeClass("is-invalid");
        if($("#editLandState").val() == ""){
            $("#editLandState").addClass("is-invalid");
            error_message_show = "Please select City And State";
            flag = 0;
        }else
            $("#editLandState").removeClass("is-invalid");
        if($("#editLandPincode").val() == ""){
            $("#editLandPincode").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editLandPincode").removeClass("is-invalid");
        if($("#editLandContactNumber").val() == ""){
            $("#editLandContactNumber").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editLandContactNumber").removeClass("is-invalid");
        if($("#editLandOfficeNumber").val() == ""){
            $("#editLandOfficeNumber").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editLandOfficeNumber").removeClass("is-invalid");
        if($("#editLandEmail").val() == ""){
            $("#editLandEmail").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editLandEmail").removeClass("is-invalid");
        if($("#editLandAddress").val() == ""){
            $("#editLandAddress").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editLandAddress").removeClass("is-invalid");
        if($("#editLandPanNo").val() == ""){
            $("#editLandPanNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editLandPanNo").removeClass("is-invalid");
        if($("#editLandAadharNo").val() == ""){
            $("#editLandAadharNo").addClass("is-invalid");
            error_message_show = "Please fill out the required fields";
            flag = 0;
        }else
            $("#editLandAadharNo").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#editForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editData");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-lands',
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
                url: 'application/controller/admin/land-acquisition-lands',
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
                $('#deleteButton').html('<i class="fas fa-trash fa-sm"></i> Delete');
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
            url: 'application/controller/admin/land-acquisition-lands',
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
            url: 'application/controller/admin/land-acquisition-lands',
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
    $("#landState").html("<option>Please Wait...</option>");
    $("#landState").prop("disabled", true);
    $("#landCity").prop("disabled", true);
    var formData = '{"request": "fetch","request_for": "states","country_name": "india"}';
    $.ajax({
        url: 'https://et-azad.com/api/country-api/states.php',
        type: 'POST',
        data: formData,
        dataType: "json",
        success: function (data) {
            $("#landState").html("<option>Select</option>");
            //Store All Start
            data.response_data.forEach(appendAll);
            function appendAll(name, val) {
              $("#landState").append('<option value="'+ name +'">'+ name +'</option>');
            }
            //Store All End
            setTimeout(function(){
                $("#landState").prop("disabled", false);
                $("#landCity").prop("disabled", false);
            }, 1000);
        },
        error: function (data) {
            $("#landState").html("<option>Unable to find States...</option>");
        },
        cache: false,
        contentType: false,
        processData: false
    });
    $("#landState").change(function(){
        $("#landCity").html("<option>Please Wait...</option>");
        $("#landState").prop("disabled", true);
        $("#landCity").prop("disabled", true);
        var formData = '{"request": "fetch","request_for": "cities","country_name": "india","state_name": "'+ $("#landState").val() +'"}';
        $.ajax({
            url: 'https://et-azad.com/api/country-api/cities.php',
            type: 'POST',
            data: formData,
            dataType: "json",
            success: function (data) {
                $("#landCity").html("<option>Select</option>");
                //Store All Start
                data.response_data.forEach(appendAll);
                function appendAll(name, val) {
                  $("#landCity").append('<option value="'+ name +'">'+ name +'</option>');
                }
                //Store All End
                setTimeout(function(){
                    $("#landState").prop("disabled", false);
                    $("#landCity").prop("disabled", false);
                }, 1000);
            },
            error: function (data) {
                $("#landCity").html("<option>Unable to find Cities...</option>");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    $("#landPurchaseDealingPrice").on("click keyup change", function () {
        if($('#landPurchaseTotalPrice').val() == ""){
            $("#landPurchaseTotalPrice").val("");
            topEndNotification("warning", "Please select complete above informations first!!!");
        } else{
            $("#landPurchaseDealingPriceInWords").val(convertNumberToWords($("#landPurchaseDealingPrice").val()));
        }
    });
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //************************************* File Upload Section Starts Here *****************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    // Images Upload Section Start ---------------------------------------------------------------------------------------------------------------
    $("#landPurchaseAttacmentsImagesUploadButton").click(function () {
        $('#landPurchaseAttacmentsImagesUploadButton').html('<center id = "loadingFileImagesSec"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Uploading..." /></center>');
        $('#landPurchaseAttacmentsImagesUploadButton').prop('disabled', true);
        var flag = 1;
        if($("#landPurchaseAttacmentsImages").val() == ""){
            $("#landPurchaseAttacmentsImages").addClass("is-invalid");
            flag = 0;
        }else
            $("#landPurchaseAttacmentsImages").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "landPurchaseAttacmentsImagesUploadNow");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-lands',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#landPurchaseAttacmentsImagesPreview').removeClass("display-none");
                        $('#add-modal').animate({
                            scrollTop: $("#landPurchaseAttacmentsImagesPreview").offset().bottom
                        }, 1000);
                        $("#landPurchaseAttacmentsImages").val("");
                        var allFiles = $("#landPurchaseAttacmentsImagesAll").val();
                        if(allFiles != ""){
                            $("#landPurchaseAttacmentsImagesAll").val(allFiles + "," + data.responseAre);
                            var sliptedFilesTemp = data.responseAre.split(",");
                            for (var i = 0; i < sliptedFilesTemp.length; i++)
                                $('#landPurchaseAttacmentsImagesPreviewRow').prepend('<div class="col-md-3 mt-5 mb-5"><center><img width="30px" src = "assets/loader/ajax-loader.gif" alt="Previewing..." /></center></div>');
                        }
                        else{
                            $("#landPurchaseAttacmentsImagesAll").val(data.responseAre)
                            $('#landPurchaseAttacmentsImagesPreviewRow').html('<div class="col-md-12 mt-3"><center><img width="80px" src = "assets/loader/pre-loader.gif" alt="Previewing..." /></center></div>');
                        }
                        setTimeout(function(){
                            $('#landPurchaseAttacmentsImagesPreviewRow').html("");
                            var sliptedFiles = $("#landPurchaseAttacmentsImagesAll").val().split(",");
                            for (var i = 0; i < sliptedFiles.length; i++) {
                                if(sliptedFiles[i] == "default")
                                    $('#landPurchaseAttacmentsImagesPreviewRow').prepend('<div class="col-md-3 mt-3" id="removeImagesId_'+ i +'"><a href="#" target="_blank"><img src="assets/dp/default.png" class="img-rounded" width="100%"></a><button onclick="removeThisImagesPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
                                else
                                    $('#landPurchaseAttacmentsImagesPreviewRow').prepend('<div class="col-md-3 mt-3" id="removeImagesId_'+ i +'"><a href="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" target="_blank"><img src="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" class="img-rounded" width="100%"></a><button onclick="removeThisImagesPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
                            }
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loadingFileImagesSec').fadeOut(500, function () {
                        $(this).remove();
                        $('#landPurchaseAttacmentsImagesUploadButton').html('<i class="fas fa-upload"></i> Upload');
                        $('#landPurchaseAttacmentsImagesUploadButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please select atleast one image!!!");
                $('#loadingFileImagesSec').fadeOut(500, function () {
                $(this).remove();
                $('#landPurchaseAttacmentsImagesUploadButton').html('<i class="fas fa-upload"></i> Upload');
                $('#landPurchaseAttacmentsImagesUploadButton').prop('disabled', false);
            });
        }
        setTimeout(function(){
            $("#landPurchaseAttacmentsImages").removeClass("is-invalid");
        }, 5000);
    });
    // Images Upload Section End -----------------------------------------------------------------------------------------------------------------
    // Documents Upload Section Start ---------------------------------------------------------------------------------------------------------------
    $("#landPurchaseAttacmentsDocumentsUploadButton").click(function () {
        $('#landPurchaseAttacmentsDocumentsUploadButton').html('<center id = "loadingFileDocumentsSec"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Uploading..." /></center>');
        $('#landPurchaseAttacmentsDocumentsUploadButton').prop('disabled', true);
        var flag = 1;
        if($("#landPurchaseAttacmentsDocuments").val() == ""){
            $("#landPurchaseAttacmentsDocuments").addClass("is-invalid");
            flag = 0;
        }else
            $("#landPurchaseAttacmentsDocuments").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "landPurchaseAttacmentsDocumentsUploadNow");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-lands',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#landPurchaseAttacmentsDocumentsPreview').removeClass("display-none");
                        $('#add-modal').animate({
                            scrollTop: $("#landPurchaseAttacmentsDocumentsPreview").offset().bottom
                        }, 1000);
                        $("#landPurchaseAttacmentsDocuments").val("");
                        var allFiles = $("#landPurchaseAttacmentsDocumentsAll").val();
                        if(allFiles != ""){
                            $("#landPurchaseAttacmentsDocumentsAll").val(allFiles + "," + data.responseAre);
                            var sliptedFilesTemp = data.responseAre.split(",");
                            for (var i = 0; i < sliptedFilesTemp.length; i++)
                                $('#landPurchaseAttacmentsDocumentsPreviewRow').prepend('<div class="col-md-3 mt-2 mb-2"><center><img width="30px" src = "assets/loader/ajax-loader.gif" alt="Previewing..." /></center></div>');
                        }
                        else{
                            $("#landPurchaseAttacmentsDocumentsAll").val(data.responseAre)
                            $('#landPurchaseAttacmentsDocumentsPreviewRow').html('<div class="col-md-12 mt-3"><center><img width="80px" src = "assets/loader/pre-loader.gif" alt="Previewing..." /></center></div>');
                        }
                        setTimeout(function(){
                            $('#landPurchaseAttacmentsDocumentsPreviewRow').html("");
                            var sliptedFiles = $("#landPurchaseAttacmentsDocumentsAll").val().split(",");
                            for (var i = 0; i < sliptedFiles.length; i++) {
                                var fileName = Number(i)+1;
                                if(sliptedFiles[i] == "default")
                                    $('#landPurchaseAttacmentsDocumentsPreviewRow').prepend('<div class="col-md-3 mt-2" id="removeDocumentsId_'+ i +'"><a href="#" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file"></i> Doc '+ fileName +'</button></a><button onclick="removeThisDocumentsPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
                                else
                                    $('#landPurchaseAttacmentsDocumentsPreviewRow').prepend('<div class="col-md-3 mt-2" id="removeDocumentsId_'+ i +'"><a href="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file"></i> Doc '+ fileName +'</button></a><button onclick="removeThisDocumentsPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
                            }
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loadingFileDocumentsSec').fadeOut(500, function () {
                        $(this).remove();
                        $('#landPurchaseAttacmentsDocumentsUploadButton').html('<i class="fas fa-upload"></i> Upload');
                        $('#landPurchaseAttacmentsDocumentsUploadButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please select atleast one Document!!!");
                $('#loadingFileDocumentsSec').fadeOut(500, function () {
                $(this).remove();
                $('#landPurchaseAttacmentsDocumentsUploadButton').html('<i class="fas fa-upload"></i> Upload');
                $('#landPurchaseAttacmentsDocumentsUploadButton').prop('disabled', false);
            });
        }
        setTimeout(function(){
            $("#landPurchaseAttacmentsDocuments").removeClass("is-invalid");
        }, 5000);
    });
    // Documents Upload Section End -----------------------------------------------------------------------------------------------------------------
    // Pdf Upload Section Start ---------------------------------------------------------------------------------------------------------------
    $("#landPurchaseAttacmentsPdfUploadButton").click(function () {
        $('#landPurchaseAttacmentsPdfUploadButton').html('<center id = "loadingFilePdfSec"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Uploading..." /></center>');
        $('#landPurchaseAttacmentsPdfUploadButton').prop('disabled', true);
        var flag = 1;
        if($("#landPurchaseAttacmentsPdf").val() == ""){
            $("#landPurchaseAttacmentsPdf").addClass("is-invalid");
            flag = 0;
        }else
            $("#landPurchaseAttacmentsPdf").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "landPurchaseAttacmentsPdfUploadNow");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-lands',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#landPurchaseAttacmentsPdfPreview').removeClass("display-none");
                        $('#add-modal').animate({
                            scrollTop: $("#landPurchaseAttacmentsPdfPreview").offset().bottom
                        }, 1000);
                        $("#landPurchaseAttacmentsPdf").val("");
                        var allFiles = $("#landPurchaseAttacmentsPdfAll").val();
                        if(allFiles != ""){
                            $("#landPurchaseAttacmentsPdfAll").val(allFiles + "," + data.responseAre);
                            var sliptedFilesTemp = data.responseAre.split(",");
                            for (var i = 0; i < sliptedFilesTemp.length; i++)
                                $('#landPurchaseAttacmentsPdfPreviewRow').prepend('<div class="col-md-3 mt-2 mb-2"><center><img width="30px" src = "assets/loader/ajax-loader.gif" alt="Previewing..." /></center></div>');
                        }
                        else{
                            $("#landPurchaseAttacmentsPdfAll").val(data.responseAre)
                            $('#landPurchaseAttacmentsPdfPreviewRow').html('<div class="col-md-12 mt-3"><center><img width="80px" src = "assets/loader/pre-loader.gif" alt="Previewing..." /></center></div>');
                        }
                        setTimeout(function(){
                            $('#landPurchaseAttacmentsPdfPreviewRow').html("");
                            var sliptedFiles = $("#landPurchaseAttacmentsPdfAll").val().split(",");
                            for (var i = 0; i < sliptedFiles.length; i++) {
                                var fileName = Number(i)+1;
                                if(sliptedFiles[i] == "default")
                                    $('#landPurchaseAttacmentsPdfPreviewRow').prepend('<div class="col-md-3 mt-2" id="removePdfId_'+ i +'"><a href="#" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file-pdf"></i> Pdf '+ fileName +'</button></a><button onclick="removeThisPdfPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
                                else
                                    $('#landPurchaseAttacmentsPdfPreviewRow').prepend('<div class="col-md-3 mt-2" id="removePdfId_'+ i +'"><a href="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file-pdf"></i> Pdf '+ fileName +'</button></a><button onclick="removeThisPdfPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
                            }
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loadingFilePdfSec').fadeOut(500, function () {
                        $(this).remove();
                        $('#landPurchaseAttacmentsPdfUploadButton').html('<i class="fas fa-upload"></i> Upload');
                        $('#landPurchaseAttacmentsPdfUploadButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please select atleast one Document!!!");
                $('#loadingFilePdfSec').fadeOut(500, function () {
                $(this).remove();
                $('#landPurchaseAttacmentsPdfUploadButton').html('<i class="fas fa-upload"></i> Upload');
                $('#landPurchaseAttacmentsPdfUploadButton').prop('disabled', false);
            });
        }
        setTimeout(function(){
            $("#landPurchaseAttacmentsPdf").removeClass("is-invalid");
        }, 5000);
    });
    // Pdf Upload Section End -----------------------------------------------------------------------------------------------------------------
    // Excel Upload Section Start ---------------------------------------------------------------------------------------------------------------
    $("#landPurchaseAttacmentsExcelUploadButton").click(function () {
        $('#landPurchaseAttacmentsExcelUploadButton').html('<center id = "loadingFileExcelSec"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Uploading..." /></center>');
        $('#landPurchaseAttacmentsExcelUploadButton').prop('disabled', true);
        var flag = 1;
        if($("#landPurchaseAttacmentsExcel").val() == ""){
            $("#landPurchaseAttacmentsExcel").addClass("is-invalid");
            flag = 0;
        }else
            $("#landPurchaseAttacmentsExcel").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "landPurchaseAttacmentsExcelUploadNow");
            $.ajax({
                url: 'application/controller/admin/land-acquisition-lands',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#landPurchaseAttacmentsExcelPreview').removeClass("display-none");
                        $('#add-modal').animate({
                            scrollTop: $("#landPurchaseAttacmentsExcelPreview").offset().bottom
                        }, 1000);
                        $("#landPurchaseAttacmentsExcel").val("");
                        var allFiles = $("#landPurchaseAttacmentsExcelAll").val();
                        if(allFiles != ""){
                            $("#landPurchaseAttacmentsExcelAll").val(allFiles + "," + data.responseAre);
                            var sliptedFilesTemp = data.responseAre.split(",");
                            for (var i = 0; i < sliptedFilesTemp.length; i++)
                                $('#landPurchaseAttacmentsExcelPreviewRow').prepend('<div class="col-md-3 mt-2 mb-2"><center><img width="30px" src = "assets/loader/ajax-loader.gif" alt="Previewing..." /></center></div>');
                        }
                        else{
                            $("#landPurchaseAttacmentsExcelAll").val(data.responseAre)
                            $('#landPurchaseAttacmentsExcelPreviewRow').html('<div class="col-md-12 mt-3"><center><img width="80px" src = "assets/loader/pre-loader.gif" alt="Previewing..." /></center></div>');
                        }
                        setTimeout(function(){
                            $('#landPurchaseAttacmentsExcelPreviewRow').html("");
                            var sliptedFiles = $("#landPurchaseAttacmentsExcelAll").val().split(",");
                            for (var i = 0; i < sliptedFiles.length; i++) {
                                var fileName = Number(i)+1;
                                if(sliptedFiles[i] == "default")
                                    $('#landPurchaseAttacmentsExcelPreviewRow').prepend('<div class="col-md-3 mt-2" id="removeExcelId_'+ i +'"><a href="#" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file-excel"></i> Excel '+ fileName +'</button></a><button onclick="removeThisExcelPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
                                else
                                    $('#landPurchaseAttacmentsExcelPreviewRow').prepend('<div class="col-md-3 mt-2" id="removeExcelId_'+ i +'"><a href="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file-excel"></i> Excel '+ fileName +'</button></a><button onclick="removeThisExcelPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
                            }
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loadingFileExcelSec').fadeOut(500, function () {
                        $(this).remove();
                        $('#landPurchaseAttacmentsExcelUploadButton').html('<i class="fas fa-upload"></i> Upload');
                        $('#landPurchaseAttacmentsExcelUploadButton').prop('disabled', false);
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotification("warning" , "Please select atleast one Document!!!");
                $('#loadingFileExcelSec').fadeOut(500, function () {
                $(this).remove();
                $('#landPurchaseAttacmentsExcelUploadButton').html('<i class="fas fa-upload"></i> Upload');
                $('#landPurchaseAttacmentsExcelUploadButton').prop('disabled', false);
            });
        }
        setTimeout(function(){
            $("#landPurchaseAttacmentsExcel").removeClass("is-invalid");
        }, 5000);
    });
    // Excel Upload Section End -----------------------------------------------------------------------------------------------------------------
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //*************************************** File Upload End Starts Here *******************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
    //***************************************************************************************************************************
});
// Calculate Amount Section Start ---------------------------------------------------------------------------------------------------------- 
function calculate_amount() {
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

    var check = "";
    var landInfoTotalCompletePrice = 0;
    for(j = 1; j <= Number($("#totalLandInfo").val()); j++){
        if($("#landInfoType"+j).val() == ""){
            $("#landInfoType"+j).addClass("is-invalid");
            temp_flag = 0;
            check = "emptyRows";
        }else
            $("#landInfoType"+j).removeClass("is-invalid");
        if($("#landInfoArea"+j).val() == ""){
            $("#landInfoArea"+j).addClass("is-invalid");
            temp_flag = 0;
            check = "emptyRows";
        }else
            $("#landInfoArea"+j).removeClass("is-invalid");
        if($("#landInfoUOM"+j).val() == ""){
            $("#landInfoUOM"+j).addClass("is-invalid");
            temp_flag = 0;
            check = "emptyRows";
        }else
            $("#landInfoUOM"+j).removeClass("is-invalid");
        if($("#landInfoPricePerUOM"+j).val() == ""){
            $("#landInfoPricePerUOM"+j).addClass("is-invalid");
            temp_flag = 0;
            check = "emptyRows";
        }else
            $("#landInfoPricePerUOM"+j).removeClass("is-invalid");
        if($("#landInfoTotalPrice"+j).val() == ""){
            $("#landInfoTotalPrice"+j).addClass("is-invalid");
            temp_flag = 0;
            check = "emptyRows";
        }else
            $("#landInfoTotalPrice"+j).removeClass("is-invalid");

        var areaTotal = Number($("#landInfoArea"+j).val());
        var pricePerUOM = Number($("#landInfoPricePerUOM"+j).val());
        var priceTotal = 0; 
        $("#landInfoTotalPrice"+j).val(areaTotal*pricePerUOM);
        landInfoTotalCompletePrice = landInfoTotalCompletePrice + (areaTotal*pricePerUOM);
        //Change  Header Name 
        if($("#landInfoUOM"+j).find(":selected").text() == "Select"){
            $("#landInfoPricePerUOM"+j).attr("placeholder", "Price / UOM");
            $("#landInfoPricePerUOMShow"+j).html(" / UOM");
        }
        else{
            $("#landInfoPricePerUOM"+j).attr("placeholder", "Price / "+ $("#landInfoUOM"+j).find(":selected").text());
            $("#landInfoPricePerUOMShow"+j).html(" / "+ $("#landInfoUOM"+j).find(":selected").text());
        }
    }
    $("#landInfoTotalCompletePrice").val(landInfoTotalCompletePrice);
    $("#landPurchaseTotalPrice").val(landInfoTotalCompletePrice);
    switch(check){
        case "exceedPercentage":
            topEndNotification("warning", "The addition of Completeion % should be equal to 100%!!!");
            break;
    }
}
// Calculate Amount Section End ------------------------------------------------------------------------------------------------------------
// Calculate Percentage Section Start ---------------------------------------------------------------------------------------------------------- 
function calculateAmount() {
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
    
    fullPercentage = (100).toFixed(2);
    if($('#landPurchaseDealingPrice').val() == ""){
        topEndNotification("warning", "Please mention Dealing price first!!!");
    } else{
        var addedPercentage = (0).toFixed(2);
        var addedPercentageOld = (0).toFixed(2);
        var check = "";
        var flag = 1;
        var totalRows = $("#totalNumberOfDivision").val();
        for(i = 1; i <= totalRows; i++){
            //Checking empty and filled up rows Section Start
            if($("#landPurchasePaymentStuctureWhen"+i).val() == ""){
                $("#landPurchasePaymentStuctureWhen"+i).addClass("is-invalid");
                flag = 0;
            }else
                $("#landPurchasePaymentStuctureWhen"+i).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureDate"+i).val() == ""){
                $("#landPurchasePaymentStuctureDate"+i).addClass("is-invalid");
                flag = 0;
            }else
                $("#landPurchasePaymentStuctureDate"+i).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureCompletion"+i).val() == ""){
                $("#landPurchasePaymentStuctureCompletion"+i).addClass("is-invalid");
                $("#landPurchasePaymentStuctureAmount"+i).addClass("is-invalid");
                $("#landPurchasePaymentStuctureAmount"+i).val("");
            }else{
                if(flag == 1){
                    $("#landPurchasePaymentStuctureCompletion"+i).removeClass("is-invalid");
                    $("#landPurchasePaymentStuctureAmount"+i).removeClass("is-invalid");
                    var priceOfProperty = $("#landPurchaseDealingPrice").val();
                    var percentageOfOne = priceOfProperty/100;
                    addedPercentage = Number(addedPercentage) + Number($("#landPurchasePaymentStuctureCompletion"+i).val());
                    if(Number(addedPercentage) > Number(100)){
                        $("#landPurchasePaymentStuctureCompletion"+i).addClass("is-invalid");
                        $("#landPurchasePaymentStuctureAmount"+i).addClass("is-invalid");
                        $("#landPurchasePaymentStuctureCompletion"+i).val("");
                        $("#landPurchasePaymentStuctureCompletion"+i).prop("placeholder", (100.00 - addedPercentageOld).toFixed(2));
                        $("#landPurchasePaymentStuctureAmount"+i).val("");
                        check = "exceedPercentage";
                    } else{
                        var thisAmount = Number(percentageOfOne) * Number($("#landPurchasePaymentStuctureCompletion"+i).val());
                        $("#landPurchasePaymentStuctureAmount"+i).val((thisAmount).toFixed(2));
                    }
                } else{
                    check = "emptyData";
                }
            }
            addedPercentageOld = addedPercentage;
            //Checking empty and filled up rows Section End
        }
        switch(check){
            case "exceedPercentage":
                topEndNotification("warning", "The addition of Completeion % should be equal to 100%!!!");
                break;
            case "emptyData":
                topEndNotification("warning", "Please fill out required fields!!!");
                break;
        }
    }
}
// Calculate Percentage Section End ------------------------------------------------------------------------------------------------------------
//Add Dynamic Payment Structure Section Start ------------------------------------------------------------------------------------------------------
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
    //Multiple Rows Section Start ------------------------------------------------------------------------------------------------------------------   
    var i=1;  
    $('#add_2').click(function(){
        var addedPercentage = (0).toFixed(2);
        var check = "";
        var checkExceed = "";  
        var totalRows = $("#totalNumberOfDivision").val();
        for(j = 1; j <= totalRows; j++){
            if($("#landPurchasePaymentStuctureWhen"+j).val() == ""){
                $("#landPurchasePaymentStuctureWhen"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#landPurchasePaymentStuctureWhen"+j).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureDate"+j).val() == ""){
                $("#landPurchasePaymentStuctureDate"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#landPurchasePaymentStuctureDate"+j).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureCompletion"+j).val() == ""){
                $("#landPurchasePaymentStuctureCompletion"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#landPurchasePaymentStuctureCompletion"+j).removeClass("is-invalid");
            if($("#landPurchasePaymentStuctureAmount"+j).val() == ""){
                $("#landPurchasePaymentStuctureAmount"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#landPurchasePaymentStuctureAmount"+j).removeClass("is-invalid");
            addedPercentage = Number(addedPercentage) + Number($("#landPurchasePaymentStuctureCompletion"+j).val());
//            console.log(addedPercentage);
            if(Number(addedPercentage) >= Number(100))
                checkExceed = "exceedPercentage";
        }
        if(check != "emptyRows" && checkExceed != "exceedPercentage"){
            i++; 
            $('#dynamic_field_2').append('<tr id="row_2_'+i+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+i+'.</span></td> <td>  <div class="form-group mb-0"> <input id="landPurchasePaymentStuctureWhen'+i+'" name="landPurchasePaymentStuctureWhen[]" type="text" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" />  </div> </td> <td> <div class="form-group mb-0"> <input id="landPurchasePaymentStuctureDate'+i+'" name="landPurchasePaymentStuctureDate[]" type="date" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" /> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:150px;"> <input id="landPurchasePaymentStuctureCompletion'+i+'" name="landPurchasePaymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();"/> <div class="input-group-prepend"> <button type="button" class="btn btn-danger">%</button> </div> </div> </div> </td> <td> <div class="form-group mb-0"> <div class="input-group" style="width:300px;"> <div class="input-group-prepend"> <button type="button" class="btn btn-danger">&#8377;</button> </div> <input id="landPurchasePaymentStuctureAmount'+i+'" name="landPurchasePaymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" readonly/> </div> </div> </td> <td> <div class="form-group mb-0"> <input id="landPurchasePaymentStuctureRemark'+i+'" name="landPurchasePaymentStuctureRemark[]" type="text" class="form-control " onclick="calculateAmount();" onkeyup="calculateAmount();" style="width:200px;" /> </div> </td> <td><button type="button" name="remove" id="_2_'+i+'" class="btn btn-danger btn_remove_2 " onclick="calculateAmount();" onkeyup="calculateAmount();">X</button></td></tr>');
            $("#totalNumberOfDivision").val(i);
        } else if(checkExceed == "exceedPercentage")
            topEndNotification("warning", "100% completed! You are not able to add more rows!!!");
        else
            topEndNotification("warning", "Please first complete existing rows");
    });
    $(document).on('click', '.btn_remove_2', function(){  
       var button_id = $(this).attr("id");   
       $('#row'+button_id+'').remove(); 
       i--;
       $("#totalNumberOfDivision").val(i);
    }); 
    //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
});
//Add Dynamic Payment Structure Section End --------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
//Remove Previews Section Start ----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------

//Remove Images  Section Start ------------------------------------------------------------------------------------------
function removeThisImagesPreview(removeId){
    var sliptedFiles = $("#landPurchaseAttacmentsImagesAll").val().split(",");
    var allFilesHere = "";
    for (var i = 0; i < sliptedFiles.length; i++) {
        if(i == removeId){
            $("#removeImagesId_" + removeId).remove();
            continue;
        } else{
            if(allFilesHere == "")
                if(i < sliptedFiles.length - 1)
                    allFilesHere = sliptedFiles[i];
                else
                    allFilesHere = sliptedFiles[i];
            else
                if(i < sliptedFiles.length - 1)
                    allFilesHere = allFilesHere + "," + sliptedFiles[i];
                else
                    allFilesHere = allFilesHere + "," + sliptedFiles[i];
        }
    }
    $("#landPurchaseAttacmentsImagesAll").val(allFilesHere);
    $('#landPurchaseAttacmentsImagesPreviewRow').html("");
    if($("#landPurchaseAttacmentsImagesAll").val() == "")
        $('#landPurchaseAttacmentsImagesPreview').addClass("display-none");
    else{
        var sliptedFiles = $("#landPurchaseAttacmentsImagesAll").val().split(",");
        for (var i = 0; i < sliptedFiles.length; i++) {
            if(sliptedFiles[i] == "default")
                $('#landPurchaseAttacmentsImagesPreviewRow').prepend('<div class="col-md-3 mt-3" id="removeImagesId_'+ i +'"><a href="#" target="_blank"><img src="assets/dp/default.png" class="img-rounded" width="100%"></a><button onclick="removeThisImagesPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
            else
                $('#landPurchaseAttacmentsImagesPreviewRow').prepend('<div class="col-md-3 mt-3" id="removeImagesId_'+ i +'"><a href="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" target="_blank"><img src="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" class="img-rounded" width="100%"></a><button onclick="removeThisImagesPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
        }
    }
}
//Remove Images  Section End ------------------------------------------------------------------------------------------
//Remove Documents  Section Start ------------------------------------------------------------------------------------------
function removeThisDocumentsPreview(removeId){
    var sliptedFiles = $("#landPurchaseAttacmentsDocumentsAll").val().split(",");
    var allFilesHere = "";
    for (var i = 0; i < sliptedFiles.length; i++) {
        if(i == removeId){
            $("#removeDocumentsId_" + removeId).remove();
            continue;
        } else{
            if(allFilesHere == "")
                if(i < sliptedFiles.length - 1)
                    allFilesHere = sliptedFiles[i];
                else
                    allFilesHere = sliptedFiles[i];
            else
                if(i < sliptedFiles.length - 1)
                    allFilesHere = allFilesHere + "," + sliptedFiles[i];
                else
                    allFilesHere = allFilesHere + "," + sliptedFiles[i];
        }
    }
    $("#landPurchaseAttacmentsDocumentsAll").val(allFilesHere);
    $('#landPurchaseAttacmentsDocumentsPreviewRow').html("");
    if($("#landPurchaseAttacmentsDocumentsAll").val() == "")
        $('#landPurchaseAttacmentsDocumentsPreview').addClass("display-none");
    else{
        var sliptedFiles = $("#landPurchaseAttacmentsDocumentsAll").val().split(",");
        for (var i = 0; i < sliptedFiles.length; i++) {
            var fileName = Number(i)+1;
            if(sliptedFiles[i] == "default")
                $('#landPurchaseAttacmentsDocumentsPreviewRow').prepend('<div class="col-md-3 mt-2" id="removeDocumentsId_'+ i +'"><a href="#" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file"></i> Doc '+ fileName +'</button></a><button onclick="removeThisDocumentsPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
            else
                $('#landPurchaseAttacmentsDocumentsPreviewRow').prepend('<div class="col-md-3 mt-2" id="removeDocumentsId_'+ i +'"><a href="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file"></i> Doc '+ fileName +'</button></a><button onclick="removeThisDocumentsPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
        }
    }
}
//Remove Documents  Section End ------------------------------------------------------------------------------------------
//Remove Pdf  Section Start ------------------------------------------------------------------------------------------
function removeThisPdfPreview(removeId){
    var sliptedFiles = $("#landPurchaseAttacmentsPdfAll").val().split(",");
    var allFilesHere = "";
    for (var i = 0; i < sliptedFiles.length; i++) {
        if(i == removeId){
            $("#removePdfId_" + removeId).remove();
            continue;
        } else{
            if(allFilesHere == "")
                if(i < sliptedFiles.length - 1)
                    allFilesHere = sliptedFiles[i];
                else
                    allFilesHere = sliptedFiles[i];
            else
                if(i < sliptedFiles.length - 1)
                    allFilesHere = allFilesHere + "," + sliptedFiles[i];
                else
                    allFilesHere = allFilesHere + "," + sliptedFiles[i];
        }
    }
    $("#landPurchaseAttacmentsPdfAll").val(allFilesHere);
    $('#landPurchaseAttacmentsPdfPreviewRow').html("");
    if($("#landPurchaseAttacmentsPdfAll").val() == "")
        $('#landPurchaseAttacmentsPdfPreview').addClass("display-none");
    else{
        var sliptedFiles = $("#landPurchaseAttacmentsPdfAll").val().split(",");
        for (var i = 0; i < sliptedFiles.length; i++) {
            var fileName = Number(i)+1;
            if(sliptedFiles[i] == "default")
                $('#landPurchaseAttacmentsPdfPreviewRow').prepend('<div class="col-md-3 mt-2" id="removePdfId_'+ i +'"><a href="#" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file-pdf"></i> Pdf '+ fileName +'</button></a><button onclick="removeThisPdfPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
            else
                $('#landPurchaseAttacmentsPdfPreviewRow').prepend('<div class="col-md-3 mt-2" id="removePdfId_'+ i +'"><a href="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file-pdf"></i> Pdf '+ fileName +'</button></a><button onclick="removeThisPdfPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
        }
    }
}
//Remove Pdf  Section End ------------------------------------------------------------------------------------------
//Remove Excel  Section Start ------------------------------------------------------------------------------------------
function removeThisExcelPreview(removeId){
    var sliptedFiles = $("#landPurchaseAttacmentsExcelAll").val().split(",");
    var allFilesHere = "";
    for (var i = 0; i < sliptedFiles.length; i++) {
        if(i == removeId){
            $("#removeExcelId_" + removeId).remove();
            continue;
        } else{
            if(allFilesHere == "")
                if(i < sliptedFiles.length - 1)
                    allFilesHere = sliptedFiles[i];
                else
                    allFilesHere = sliptedFiles[i];
            else
                if(i < sliptedFiles.length - 1)
                    allFilesHere = allFilesHere + "," + sliptedFiles[i];
                else
                    allFilesHere = allFilesHere + "," + sliptedFiles[i];
        }
    }
    $("#landPurchaseAttacmentsExcelAll").val(allFilesHere);
    $('#landPurchaseAttacmentsExcelPreviewRow').html("");
    if($("#landPurchaseAttacmentsExcelAll").val() == "")
        $('#landPurchaseAttacmentsExcelPreview').addClass("display-none");
    else{
        var sliptedFiles = $("#landPurchaseAttacmentsExcelAll").val().split(",");
        for (var i = 0; i < sliptedFiles.length; i++) {
            var fileName = Number(i)+1;
            if(sliptedFiles[i] == "default")
                $('#landPurchaseAttacmentsExcelPreviewRow').prepend('<div class="col-md-3 mt-2" id="removeExcelId_'+ i +'"><a href="#" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file-excel"></i> Excel '+ fileName +'</button></a><button onclick="removeThisExcelPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
            else
                $('#landPurchaseAttacmentsExcelPreviewRow').prepend('<div class="col-md-3 mt-2" id="removeExcelId_'+ i +'"><a href="assets/admin/land-acquisition-lands/temp/'+ sliptedFiles[i] +'" target="_blank"><button class="btn btn-info btn-block" type="button"><i class="fa fa-file-excel"></i> Excel '+ fileName +'</button></a><button onclick="removeThisExcelPreview('+ i +')" type="button" class="btn btn-danger btn-block mt-1" title="remove"> <i class="fa fa-times"></i> </button></div>');
        }
    }
}
//Remove Excel  Section End ------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
//Remove Previews Section Start ----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------