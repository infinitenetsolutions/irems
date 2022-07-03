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
    //Aos creationx
    AOS.init();
    fetchFn();
    var fullPercentage = (100).toFixed(2);
    // Fetch Data Section Start --------------------------------------------------------------------------------------------------------------------
    function fetchFn() {
        topEndNotification("info", "Loading, Please Wait...");
        $('#view-section').html('<center id = "loading"><img width="80px" src = "assets/loader/pre-loader.gif" alt="Loading..." /></center>');
        var formData = {"action":"fetchData"};
        $.ajax({
            url: 'application/view/admin/customers.php',
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
        var addedPercentage = (0).toFixed(2);
        var errorMessage = "Please fill out the required fields";
        var gotoThere = "add-modal";
        //Second Applicant Validation
        // if($("#secondApplicantName").val() == ""){
        //     $("#secondApplicantName").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicantName").removeClass("is-invalid");
        // if($("#secondApplicantParentOf").val() == ""){
        //     $("#secondApplicantParentOf").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicantParentOf").removeClass("is-invalid");
        // if($("#secondApplicantPhoneNumber").val() == ""){
        //     $("#secondApplicantPhoneNumber").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicantPhoneNumber").removeClass("is-invalid");
        // if($("#secondApplicantEmailId").val() == ""){
        //     $("#secondApplicantEmailId").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicantEmailId").removeClass("is-invalid");
        // if($("#secondApplicantDateOfBirth").val() == ""){
        //     $("#secondApplicantDateOfBirth").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicantDateOfBirth").removeClass("is-invalid");
        // if($("#secondApplicantAge").val() == ""){
        //     $("#secondApplicantAge").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicantAge").removeClass("is-invalid");
        // if($("#secondApplicantReligion").val() == ""){
        //     $("#secondApplicantReligion").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicantReligion").removeClass("is-invalid");
        // if($("#secondApplicantMaritalStatus").val() != "Single"){
        //     if($("#secondApplicantDateOfAnniversary").val() == ""){
        //         $("#secondApplicantDateOfAnniversary").addClass("is-invalid");
        //         flag = 0;
        //         errorMessage = "Please fill out Second Applicant Information!!!";
        //         gotoThere = "secondApplicantDiv";
        //     }else
        //         $("#secondApplicantDateOfAnniversary").removeClass("is-invalid");
        //     if($("#secondApplicantNoOfChild").val() == ""){
        //         $("#secondApplicantNoOfChild").addClass("is-invalid");
        //         flag = 0;
        //         errorMessage = "Please fill out Second Applicant Information!!!";
        //         gotoThere = "secondApplicantDiv";
        //     }else
        //         $("#secondApplicantNoOfChild").removeClass("is-invalid");
        // }
        // if($("#secondApplicanPanNumber").val() == ""){
        //     $("#secondApplicanPanNumber").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicanPanNumber").removeClass("is-invalid");
        // if($("#secondApplicanAadharNumber").val() == ""){
        //     $("#secondApplicanAadharNumber").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicanAadharNumber").removeClass("is-invalid");
        // if($("#secondApplicanPermanentAddress").val() == ""){
        //     $("#secondApplicanPermanentAddress").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicanPermanentAddress").removeClass("is-invalid");
        // if($("#secondApplicanCorrespondenceAddress").val() == ""){
        //     $("#secondApplicanCorrespondenceAddress").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Second Applicant Information!!!";
        //     gotoThere = "secondApplicantDiv";
        // }else
        //     $("#secondApplicanCorrespondenceAddress").removeClass("is-invalid");
        //First Applicant Validation
        if($("#firstApplicantName").val() == ""){
            $("#firstApplicantName").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#firstApplicantName").removeClass("is-invalid");
        if($("#firstApplicantParentOf").val() == ""){
            $("#firstApplicantParentOf").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#firstApplicantParentOf").removeClass("is-invalid");
        if($("#firstApplicantPhoneNumber").val() == ""){
            $("#firstApplicantPhoneNumber").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#firstApplicantPhoneNumber").removeClass("is-invalid");
        if($("#firstApplicantUsername").val() == ""){
            $("#firstApplicantUsername").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#firstApplicantUsername").removeClass("is-invalid");
        if($("#logPass").val() == ""){
            $("#logPass").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#logPass").removeClass("is-invalid");
        // if($("#firstApplicantEmailId").val() == ""){
        //     $("#firstApplicantEmailId").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out First Applicant Information!!!";
        //     gotoThere = "firstApplicantDiv";
        // }else
        //     $("#firstApplicantEmailId").removeClass("is-invalid");
        if($("#firstApplicantDateOfBirth").val() == ""){
            $("#firstApplicantDateOfBirth").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#firstApplicantDateOfBirth").removeClass("is-invalid");
        if($("#firstApplicantAge").val() == ""){
            $("#firstApplicantAge").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#firstApplicantAge").removeClass("is-invalid");
        // if($("#firstApplicantReligion").val() == ""){
        //     $("#firstApplicantReligion").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out First Applicant Information!!!";
        //     gotoThere = "firstApplicantDiv";
        // }else
        //     $("#firstApplicantReligion").removeClass("is-invalid");
        // if($("#firstApplicantMaritalStatus").val() != "Single"){
        //     if($("#firstApplicantDateOfAnniversary").val() == ""){
        //         $("#firstApplicantDateOfAnniversary").addClass("is-invalid");
        //         flag = 0;
        //         errorMessage = "Please fill out First Applicant Information!!!";
        //         gotoThere = "firstApplicantDiv";
        //     }else
        //         $("#firstApplicantDateOfAnniversary").removeClass("is-invalid");
        //     if($("#firstApplicantNoOfChild").val() == ""){
        //         $("#firstApplicantNoOfChild").addClass("is-invalid");
        //         flag = 0;
        //         errorMessage = "Please fill out First Applicant Information!!!";
        //         gotoThere = "firstApplicantDiv";
        //     }else
        //         $("#firstApplicantNoOfChild").removeClass("is-invalid");
        // }
        if($("#firstApplicanPanNumber").val() == ""){
            $("#firstApplicanPanNumber").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#firstApplicanPanNumber").removeClass("is-invalid");
        if($("#firstApplicanAadharNumber").val() == ""){
            $("#firstApplicanAadharNumber").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else
            $("#firstApplicanAadharNumber").removeClass("is-invalid");
        if($("#firstApplicanPermanentAddress").val() == "" && $("#firstApplicanCorrespondenceAddress").val() == ""){
            $("#firstApplicanPermanentAddress").addClass("is-invalid");
            $("#firstApplicanCorrespondenceAddress").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out First Applicant Information!!!";
            gotoThere = "firstApplicantDiv";
        }else{
            $("#firstApplicanPermanentAddress").removeClass("is-invalid");
            $("#firstApplicanCorrespondenceAddress").removeClass("is-invalid");
        }  
        //Payment Structure Validation
        for(j = 1; j <= Number($("#totalNumberOfDivision").val()); j++){
            if($("#paymentStuctureCompletion"+j).val() == ""){
                $("#paymentStuctureCompletion"+j).addClass("is-invalid");
                flag = 0;
                errorMessage = "Please fill out Payment Structure Information";
                gotoThere = "paymentStructureDiv";
            }else
                $("#paymentStuctureCompletion"+j).removeClass("is-invalid");
            if($("#paymentStuctureAmount"+j).val() == ""){
                $("#paymentStuctureAmount"+j).addClass("is-invalid");
                flag = 0;
                errorMessage = "Please fill out Payment Structure Information";
                gotoThere = "paymentStructureDiv";
            }else
                $("#paymentStuctureAmount"+j).removeClass("is-invalid");
            if($("#paymentStuctureRemark"+j).val() == ""){
                $("#paymentStuctureRemark"+j).addClass("is-invalid");
                flag = 0;
                errorMessage = "Please fill out Payment Structure Information";
                gotoThere = "paymentStructureDiv";
            }else
                $("#paymentStuctureRemark"+j).removeClass("is-invalid");
            if($("#paymentStuctureDate"+j).val() == ""){
                $("#paymentStuctureDate"+j).addClass("is-invalid");
                flag = 0;
                errorMessage = "Please fill out Payment Structure Information";
                gotoThere = "paymentStructureDiv";
            }else
                $("#paymentStuctureDate"+j).removeClass("is-invalid");
            addedPercentage = Number(addedPercentage) + Number($("#paymentStuctureCompletion"+j).val());
        }
        // if(Number(addedPercentage) != Number(100)){
        //     flag = 0;
        //     errorMessage = "Payment structure should be equal to 100% only!!!";
        //     gotoThere = "paymentStructureDiv";
        // }
        //Payment Validation
        if($("#paymentAmount").val() != "" && Number($("#paymentAmount").val()) > 0){
            // if($("#paymentAmountNumber").val() == ""){
            //     $("#paymentAmountNumber").addClass("is-invalid");
            //     flag = 0;
            //     errorMessage = "Please fill out Booking Information";
            //     gotoThere = "paymentInformationDiv";
            // }else
            //     $("#paymentAmountNumber").removeClass("is-invalid");
            if($("#paymentAmountDate").val() == ""){
                $("#paymentAmountDate").addClass("is-invalid");
                flag = 0;
                errorMessage = "Please fill out Booking Information";
                gotoThere = "paymentInformationDiv";
            }else
                $("#paymentAmountDate").removeClass("is-invalid");
        } else{
            // $("#paymentAmountNumber").removeClass("is-invalid");
            $("#paymentAmountDate").removeClass("is-invalid");
        }
        if($("#projectName").val() == ""){
            $("#projectName").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out Property Information";
            gotoThere = "propertyInformationDiv";
        }else
        //     $("#projectName").removeClass("is-invalid");
        // if($("#propertyType").val() == ""){
        //     $("#propertyType").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Property Information";
        //     gotoThere = "propertyInformationDiv";
        // }else
        //     $("#propertyType").removeClass("is-invalid");
        // if($("#accommodationType").val() == ""){
        //     $("#accommodationType").addClass("is-invalid");
        //     flag = 0;
        //     errorMessage = "Please fill out Property Information";
        //     gotoThere = "propertyInformationDiv";
        // }else
        //     $("#accommodationType").removeClass("is-invalid");
        if($("#squareFeet").val() == ""){
            $("#squareFeet").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out Property Information";
            gotoThere = "propertyInformationDiv";
        }else
            $("#squareFeet").removeClass("is-invalid");
        if($("#pricePerSquare").val() == ""){
            $("#pricePerSquare").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out Property Information";
            gotoThere = "propertyInformationDiv";
        }else
            $("#pricePerSquare").removeClass("is-invalid");
        if($("#propertyPrice").val() == ""){
            $("#propertyPrice").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out Property Information";
            gotoThere = "propertyInformationDiv";
        }else
            $("#propertyPrice").removeClass("is-invalid");
        if($("#propertyPriceDeal").val() == ""){
            $("#propertyPriceDeal").addClass("is-invalid");
            flag = 0;
            errorMessage = "Please fill out Property Information";
            gotoThere = "propertyInformationDiv";
        }else
            $("#propertyPriceDeal").removeClass("is-invalid");
//        if($("#propertyLocation").val() == ""){
//            $("#propertyLocation").addClass("is-invalid");
//            flag = 0;
//            errorMessage = "Please fill out Property Information";
//            gotoThere = "propertyInformationDiv";
//        }else
//            $("#propertyLocation").removeClass("is-invalid");
        if(flag == 1){
            var formData = new FormData($('form#addForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "addData");
            $.ajax({
                url: 'application/controller/admin/customers.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#addForm')[0].reset();
                         $('#add-modal').modal("hide");
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
            topEndNotification("warning" , errorMessage);
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#addButton').html('<i class="fa fa-plus fa-sm"></i> Add this');
                $('#addButton').prop('disabled', false);
                $('html, body, div').animate({
                    scrollTop: $("#"+gotoThere).offset().top
                }, 2000);
            });
        }
    });
    // Add Section End -----------------------------------------------------------------------------------------------------------------------------
    // Edit Payment Structure Section Start --------------------------------------------------------------------------------------------------------
    $('form#paymentStructureForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#paymentStructureButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#paymentStructureButton').prop('disabled', true);
        var flag = 1;
        var i = 1;
        var j = 1;
        var addedPercentage = (0).toFixed(2);
        var errorMessage = "Please fill out the required fields!!!";
        var uniqueId = $("#editTableId").val();
        //Payment Structure Validation
        for(j = 1; j <= Number($("#editTotalNumberOfDivision").val()); j++){
            if($("#paymentStuctureCompletion"+j+"_"+uniqueId).val() == ""){
                $("#paymentStuctureCompletion"+j+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
                errorMessage = "Please fill out Payment Structure Information!!!";
            }else
                $("#paymentStuctureCompletion"+j+"_"+uniqueId).removeClass("is-invalid");
            if($("#paymentStuctureAmount"+j+"_"+uniqueId).val() == ""){
                $("#paymentStuctureAmount"+j+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
                errorMessage = "Please fill out Payment Structure Information!!!";
            }else
                $("#paymentStuctureAmount"+j).removeClass("is-invalid");
            addedPercentage = Number(addedPercentage) + Number($("#paymentStuctureCompletion"+j+"_"+uniqueId).val());
        }
        if(Number(addedPercentage) != Number(100)){
            flag = 0;
            errorMessage = "Payment structure should be equal to 100% only!!!";
        }
        if(flag == 1){
            // alert("flag1");
            var formData = new FormData($('form#paymentStructureForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editPaymentStructure");
            $.ajax({
                url: 'application/controller/admin/customers.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.response == "success"){
                        $('#paymentStructureForm')[0].reset();
                        $('#payment-structure-modal').modal("hide");
                        setTimeout(function(){
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#paymentStructureButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                        $('#paymentStructureButton').prop('disabled', false);
                    });
                }
                
            });
        } else{
             // alert("flag0");
            topEndNotification("warning" , errorMessage);
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#paymentStructureButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                $('#paymentStructureButton').prop('disabled', false);
            });
        }
    });
    // Edit Payment Structure Section End ----------------------------------------------------------------------------------------------------------
    // Edit First Applicant Section Start --------------------------------------------------------------------------------------------------------------------------
    $('form#editForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#editButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#editButton').prop('disabled', true);
        var flag = 1;
        if($("#editfirstApplicantName").val() == ""){
            $("#editfirstApplicantName").addClass("is-invalid");
            flag = 0;
        }else
            $("#editfirstApplicantName").removeClass("is-invalid");
        if($("#editfirstApplicantParentOf").val() == ""){
            $("#editfirstApplicantParentOf").addClass("is-invalid");
            flag = 0;
        }else
            $("#editfirstApplicantParentOf").removeClass("is-invalid");
        if($("#editfirstApplicantPhoneNumber").val() == ""){
            $("#editfirstApplicantPhoneNumber").addClass("is-invalid");
            flag = 0;
        }else
            $("#editfirstApplicantPhoneNumber").removeClass("is-invalid");
        if($("#editfirstApplicantEmailId").val() == ""){
            $("#editfirstApplicantEmailId").addClass("is-invalid");
            flag = 0;
        }else
            $("#editfirstApplicantEmailId").removeClass("is-invalid");
        if($("#editfirstApplicantDateOfBirth").val() == ""){
            $("#editfirstApplicantDateOfBirth").addClass("is-invalid");
            flag = 0;
        }else
            $("#editfirstApplicantDateOfBirth").removeClass("is-invalid");
        if($("#editfirstApplicantAge").val() == ""){
            $("#editfirstApplicantAge").addClass("is-invalid");
            flag = 0;
        }else
            $("#editfirstApplicantAge").removeClass("is-invalid");
        // if($("#editfirstApplicantReligion").val() == ""){
        //     $("#editfirstApplicantReligion").addClass("is-invalid");
        //     flag = 0;
        // }else
        //     $("#editfirstApplicantReligion").removeClass("is-invalid");
        if($("#editfirstApplicanPanNumber").val() == ""){
            $("#editfirstApplicanPanNumber").addClass("is-invalid");
            flag = 0;
        }else
            $("#editfirstApplicanPanNumber").removeClass("is-invalid");
        if($("#editfirstApplicanAadharNumber").val() == ""){
            $("#editfirstApplicanAadharNumber").addClass("is-invalid");
            flag = 0;
        }else
            $("#editfirstApplicanAadharNumber").removeClass("is-invalid");
        if($("#editfirstApplicanPermanentAddress").val() == "" && $("#editfirstApplicanCorrespondenceAddress").val() == ""){
            $("#editfirstApplicanPermanentAddress").addClass("is-invalid");
            $("#editfirstApplicanCorrespondenceAddress").addClass("is-invalid");
            flag = 0;
        }else{
            $("#editfirstApplicanPermanentAddress").removeClass("is-invalid");
            $("#editfirstApplicanCorrespondenceAddress").removeClass("is-invalid");
        }  
        if(flag == 1){
            var formData = new FormData($('form#editForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editData");
            $.ajax({
                url: 'application/controller/admin/customers.php',
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
    // Edit First Applicant Section End ----------------------------------------------------------------------------------------------------------------------------
    // Edit Second Applicant Section Start --------------------------------------------------------------------------------------------------------------------------
    $('form#secondeditForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#secondeditButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#secondeditButton').prop('disabled', true);
        var flag = 1;
        if($("#editsecondApplicantName").val() == ""){
            $("#editsecondApplicantName").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicantName").removeClass("is-invalid");
        if($("#editsecondApplicantParentOf").val() == ""){
            $("#editsecondApplicantParentOf").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicantParentOf").removeClass("is-invalid");
        if($("#editsecondApplicantPhoneNumber").val() == ""){
            $("#editsecondApplicantPhoneNumber").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicantPhoneNumber").removeClass("is-invalid");
        if($("#editsecondApplicantEmailId").val() == ""){
            $("#editsecondApplicantEmailId").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicantEmailId").removeClass("is-invalid");
        if($("#editsecondApplicantDateOfBirth").val() == ""){
            $("#editsecondApplicantDateOfBirth").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicantDateOfBirth").removeClass("is-invalid");
        if($("#editsecondApplicantAge").val() == ""){
            $("#editsecondApplicantAge").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicantAge").removeClass("is-invalid");
        if($("#editsecondApplicantReligion").val() == ""){
            $("#editsecondApplicantReligion").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicantReligion").removeClass("is-invalid");
        if($("#editsecondApplicanPanNumber").val() == ""){
            $("#editsecondApplicanPanNumber").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicanPanNumber").removeClass("is-invalid");
        if($("#editsecondApplicanAadharNumber").val() == ""){
            $("#editsecondApplicanAadharNumber").addClass("is-invalid");
            flag = 0;
        }else
            $("#editsecondApplicanAadharNumber").removeClass("is-invalid");
        if($("#editsecondApplicanPermanentAddress").val() == "" && $("#editsecondApplicanCorrespondenceAddress").val() == ""){
            $("#editsecondApplicanPermanentAddress").addClass("is-invalid");
            $("#editsecondApplicanCorrespondenceAddress").addClass("is-invalid");
            flag = 0;
        }else{
            $("#editsecondApplicanPermanentAddress").removeClass("is-invalid");
            $("#editsecondApplicanCorrespondenceAddress").removeClass("is-invalid");
        }   
        if(flag == 1){
            var formData = new FormData($('form#secondeditForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "secondeditData");
            $.ajax({
                url: 'application/controller/admin/customers.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.response == "success"){
                        $('#secondeditForm')[0].reset();
                        $('#edit-second-modal').modal("hide");
                        setTimeout(function(){
                            fetchFn();
                        }, 1000);
                    }
                    topEndNotification(data.responseType, data.responseMessage);
                    $('#loading').fadeOut(500, function () {
                        $(this).remove();
                        $('#secondeditButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                        $('#secondeditButton').prop('disabled', false);
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
                $('#secondeditButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                $('#secondeditButton').prop('disabled', false);
            });
        }
    });
    // Edit Second Applicant Section End ----------------------------------------------------------------------------------------------------------------------------
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
                url: 'application/controller/admin/customers.php',
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
        var uniqueId = $("#editTableId").val();
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
        for(i = 1; i<=$("#editTotalProperty").val(); i++){
            if($("#propertyType"+i+"_"+uniqueId).val() == ""){
                $("#propertyType"+i+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
            }else
                $("#propertyType"+i+"_"+uniqueId).removeClass("is-invalid");
            if($("#accommodationType"+i+"_"+uniqueId).val() == ""){
                $("#accommodationType"+i+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
            }else
                $("#accommodationType"+i+"_"+uniqueId).removeClass("is-invalid");
            if($("#squareFeet"+i+"_"+uniqueId).val() == ""){
                $("#squareFeet"+i+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
            }else
                $("#squareFeet"+i+"_"+uniqueId).removeClass("is-invalid");
            if($("#price"+i+"_"+uniqueId).val() == ""){
                $("#price"+i+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
            }else
                $("#price"+i+"_"+uniqueId).removeClass("is-invalid");
            if($("#availablility"+i+"_"+uniqueId).val() == ""){
                $("#availablility"+i+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
            }else
                $("#availablility"+i+"_"+uniqueId).removeClass("is-invalid");
            if($("#StartingDate"+i+"_"+uniqueId).val() == ""){
                $("#StartingDate"+i+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
            }else
                $("#StartingDate"+i+"_"+uniqueId).removeClass("is-invalid");
            if($("#ExpectedEndingDate"+i+"_"+uniqueId).val() == ""){
                $("#ExpectedEndingDate"+i+"_"+uniqueId).addClass("is-invalid");
                flag = 0;
            }else
                $("#ExpectedEndingDate"+i+"_"+uniqueId).removeClass("is-invalid");
        }
        if(flag == 1){
            var formData = new FormData($('form#editForm')[0]);
            formData.append("checkLocation", $("#checkLocation").val());
            formData.append("checkIp", $("#checkIp").val());
            formData.append("action", "editData");
            $.ajax({
                url: 'application/controller/admin/customers.php',
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
                url: 'application/controller/admin/customers.php',
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
            url: 'application/controller/admin/customers.php',
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
            url: 'application/controller/admin/customers.php',
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
    // On Selection Of Project Section Start -------------------------------------------------------------------------------------------------------
    $("#projectName").change(function () {
        topEndNotification("info", "Please Wait...");
        $('#projectName').prop("disabled", true);
        $('#phase').prop("disabled", true);
        $('#building').prop("disabled", true);
        $('#floors').prop("disabled", true);
        $('#flat_no').prop("disabled", true);
        $('#phase').val("");
        $('#building').val("");
        $('#floors').val("");
        $('#flat_no').val("");
        disableTruePrices();
        var formData = {"action":"fetchPhaseFromProjectId","id":$("#projectName").val()};
        $.ajax({
            url: 'application/view/admin/customers',
            type: 'POST',
            data: formData,
            success: function (data) {
                setTimeout( function() {
                    topEndNotification("info", "Please Select Phase!!!");
                    $('#phase').html("");
                    $('#phase').html(data);
                    $('#building').html("");
                    $('#building').html('<option value="" selected disabled>Select Block</option>');
                    $('#floors').html("");
                    $('#floors').html('<option value="" selected disabled>Select Floor Number</option>');
                    $('#flat_no').html("");
                    $('#flat_no').html('<option value="" selected disabled>Select Flat Number</option>');
                    $('#projectName').prop("disabled", false);
                    $('#phase').prop("disabled", false);
                    disableFalsePrices();
                }, 500);
            }
        });
    });
    $("#phase").change(function () {
        topEndNotification("info", "Please Wait...");
        $('#projectName').prop("disabled", true);
        $('#phase').prop("disabled", true);
        $('#building').prop("disabled", true);
        $('#floors').prop("disabled", true);
        $('#flat_no').prop("disabled", true);
        $('#building').val("");
        $('#floors').val("");
        $('#flat_no').val("");
        disableTruePrices();
        var formData = {"action":"fetchBlockFromProjectId","id":$("#projectName").val(),"phase_id":$("#phase").val()};
        $.ajax({
            url: 'application/view/admin/customers',
            type: 'POST',
            data: formData,
            success: function (data) {
                setTimeout( function() {
                    topEndNotification("info", "Please Select Block!!!");
                    $('#building').html("");
                    $('#building').html(data);
                    $('#floors').html("");
                    $('#floors').html('<option value="" selected disabled>Select Floor Number</option>');
                    $('#flat_no').html("");
                    $('#flat_no').html('<option value="" selected disabled>Select Flat Number</option>');
                    $('#projectName').prop("disabled", false);
                    $('#phase').prop("disabled", false);
                    $('#building').prop("disabled", false);
                    disableFalsePrices();
                }, 500);
            }
        });
    });
    $("#building").change(function () {
        topEndNotification("info", "Please Wait...");
        $('#projectName').prop("disabled", true);
        $('#phase').prop("disabled", true);
        $('#building').prop("disabled", true);
        $('#floors').prop("disabled", true);
        $('#flat_no').prop("disabled", true);
        $('#floors').val("");
        $('#flat_no').val("");
        disableTruePrices();
        var formData = {"action":"fetchFloorFromProjectId","id":$("#projectName").val(),"phase_id":$("#phase").val(),"building_id":$("#building").val()};
        $.ajax({
            url: 'application/view/admin/customers',
            type: 'POST',
            data: formData,
            success: function (data) {
                setTimeout( function() {
                    topEndNotification("info", "Please Select Block!!!");
                    $('#floors').html("");
                    $('#floors').html(data);
                    $('#flat_no').html("");
                    $('#flat_no').html('<option value="" selected disabled>Select Flat Number</option>');
                    $('#projectName').prop("disabled", false);
                    $('#phase').prop("disabled", false);
                    $('#building').prop("disabled", false);
                    $('#floors').prop("disabled", false);
                    disableFalsePrices();
                }, 500);
            }
        });
    });
    $("#floors").change(function () {
        topEndNotification("info", "Please Wait...");
        $('#projectName').prop("disabled", true);
        $('#phase').prop("disabled", true);
        $('#building').prop("disabled", true);
        $('#floors').prop("disabled", true);
        $('#flat_no').prop("disabled", true);
        $('#flat_no').val("");
        disableTruePrices();
        var formData = {"action":"fetchFlatFromProjectId","id":$("#projectName").val(),"phase_id":$("#phase").val(),"building_id":$("#building").val(),"floors":$("#floors").val()};
        $.ajax({
            url: 'application/view/admin/customers',
            type: 'POST',
            data: formData,
            success: function (data) {
                setTimeout( function() {
                    topEndNotification("info", "Please Select Block!!!");
                    $('#flat_no').html("");
                    $('#flat_no').html(data);
                    $('#projectName').prop("disabled", false);
                    $('#phase').prop("disabled", false);
                    $('#building').prop("disabled", false);
                    $('#floors').prop("disabled", false);
                    $('#flat_no').prop("disabled", false);
                    disableFalsePrices();
                }, 500);
            }
        });
    });
    $("#flat_no").change(function () {
        $('#squareFeet').val($(this).find(":selected").data("square-feet"));
        $('#pricePerSquare').val($(this).find(":selected").data("price-per-square"));
        $('#propertyPrice').val($(this).find(":selected").data("price-total"));
    });
    disableTruePrices = function(){
        $('#squareFeet').val("");
        $('#pricePerSquare').val("");
        $('#propertyPrice').val("");
        $('#squareFeet').prop("disabled", true);
        $('#pricePerSquare').prop("disabled", true);
        $('#propertyPrice').prop("disabled", true);
        $('#propertyPriceDeal').prop("disabled", true);
    }
    disableFalsePrices = function(){
        $('#propertyPriceDeal').prop("disabled", false);
    }
    // On Selection Of Project Section End --------------------------------------------------------------------------------------------------------- 
    // On Selection Of Project Section Start ------------------------------------------------------------------------------------------------------- 
    $("#propertyType").change(function () {
        topEndNotification("info", "Please Wait...");
        $('#projectName').prop("disabled", true);
        $('#propertyType').prop("disabled", true);
        $('#propertyNumber').val("");
        var formData = {"action":"fetchPriceAndLocation","id":$("#projectName").val(),"val":$("#propertyType").val()};
        $.ajax({
            url: 'application/view/admin/customers.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                var comData = data.split("|||-|||");
                if(comData[0] == "success"){
                    setTimeout( function() {
                        $('#propertyLocation').val(comData[1]);
                        $('#propertyPrice').val(comData[2]);
                        $('#propertyPriceDeal').prop("placeholder", comData[2]);
                        $('#projectName').prop("disabled", false);
                        $('#propertyType').prop("disabled", false);
                    }, 500);
                } else
                    topEndNotification("error", "Something went wrong, Please try again!!!");
            }
        });
    });
    $("#propertyPriceDeal").on("click keyup change", function () {
        if($('#propertyPrice').val() == ""){
            $("#propertyPriceDeal").val("");
            topEndNotification("warning", "Please select Property first!!!");
        } else{
            $("#paymentAmount").val("");
            $("#paymentStuctureRemark1").val("");
            $("#paymentStuctureDate1").val("");
            $("#paymentStuctureCompletion1").val("");
            $("#paymentStuctureAmount1").val("");
            $("#paymentStuctureDate1").removeAttr("readonly");
            $("#paymentStuctureRemark1").removeAttr("readonly");
            $("#paymentStuctureCompletion1").removeAttr("readonly");
            $("#paymentStuctureAmount1").removeAttr("readonly");
            $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
            calculateAmount();
        }
    });
    // On Selection Of Project Section End --------------------------------------------------------------------------------------------------------- 
    // Number In Words Section Start --------------------------------------------------------------------------------------------------------------- 
    $("#paymentAmount").on("click keyup change", function () {
        calculateAmount();
        fullPercentage = (100).toFixed(2);
        var totalPriceOfProperty=Number($("#propertyPriceDeal").val())+Number($("#CarParkingAmount").val())+Number($("#ScooterParkingAmount").val());
        var bookingDate=$('#paymentAmountDate').val();
        if($('#propertyPriceDeal').val() == ""){
            topEndNotification("warning", "Please mention Dealing price first!!!");
            $("#paymentAmount").val(0);
        } else{
            $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
            if($("#paymentAmount").val() > 0 && $("#propertyPriceDeal").val() > 0){
                if(Number($("#paymentAmount").val()) > Number(totalPriceOfProperty)){
                    fullPercentage = (fullPercentage) - ((100).toFixed(2));
                    topEndNotification("warning", "You are not able to Pay more that the property price!!!");
                    $("#paymentAmount").val(totalPriceOfProperty);
                    $("#paymentStuctureRemark1").val("Booking Amount");
                    $("#paymentStuctureCompletion1").val((100).toFixed(2));
                    $("#paymentStuctureAmount1").val(Number(totalPriceOfProperty).toFixed(2));
                    $("#paymentStuctureRemark1").attr("readonly", "readonly");
                    $("#paymentStuctureCompletion1").attr("readonly", "readonly");
                    $("#paymentStuctureAmount1").attr("readonly", "readonly");
                    $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
                } else{
                    var priceOfProperty = totalPriceOfProperty;
                    var percentageOfOne = priceOfProperty/100;
                    var downPaymentPercentage = $("#paymentAmount").val()/percentageOfOne;
                    fullPercentage = (fullPercentage) - (downPaymentPercentage.toFixed(2));
                    $("#paymentStuctureRemark1").val("Booking Amount");
                    $("#paymentStuctureCompletion1").val(downPaymentPercentage.toFixed(2));
                    $("#paymentStuctureAmount1").val(Number($("#paymentAmount").val()).toFixed(2));
                    $("#paymentStuctureRemark1").attr("readonly", "readonly");
                    $("#paymentStuctureCompletion1").attr("readonly", "readonly");
                    $("#paymentStuctureAmount1").attr("readonly", "readonly");
                    $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
                }
            } else{
                fullPercentage = (100).toFixed(2);
                $("#paymentStuctureRemark1").val("");
                $("#paymentStuctureDate1").val("");
                $("#paymentStuctureCompletion1").val("");
                $("#paymentStuctureAmount1").val("");
                $("#paymentStuctureRemark1").removeAttr("readonly");
                $("#paymentStuctureDate1").removeAttr("readonly");
                $("#paymentStuctureCompletion1").removeAttr("readonly");
                $("#paymentStuctureAmount1").removeAttr("readonly");
                $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
            }
        }
    });
    // Number In Words Section End -----------------------------------------------------------------------------------------------------------------
   // Number In Words Section Start --------------------------------------------------------------------------------------------------------------- 
    $("#paymentAmount").on("click keyup change", function () {
        $("#paymentStuctureRemark1").val("Booking Amount");
        calculateAmount();
        fullPercentage = (100).toFixed(2);
        var totalPriceOfProperty=Number($("#propertyPriceDeal").val())+Number($("#CarParkingAmount").val())+Number($("#ScooterParkingAmount").val());
        var bookingDate=$('#paymentAmountDate').val();
        console.log(bookingDate);
        if($('#propertyPriceDeal').val() == ""){
            topEndNotification("warning", "Please mention Dealing price first!!!");
            $("#paymentAmount").val(0);
        } else{
            $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
            if($("#paymentAmount").val() > 0 && $("#propertyPriceDeal").val() > 0){
                if(Number($("#paymentAmount").val()) > Number(totalPriceOfProperty)){
                    fullPercentage = (fullPercentage) - ((100).toFixed(2));
                    topEndNotification("warning", "You are not able to Pay more that the property price!!!");
                    $("#paymentAmount").val(totalPriceOfProperty);
                    $("#paymentStuctureRemark1").val("Booking Amount");
                    $("#paymentStuctureCompletion1").val((100).toFixed(2));
                    $("#paymentStuctureAmount1").val(Number(totalPriceOfProperty).toFixed(2));
                    $("#paymentStuctureRemark1").attr("readonly", "readonly");
                    $("#paymentStuctureCompletion1").attr("readonly", "readonly");
                    $("#paymentStuctureAmount1").attr("readonly", "readonly");
                    $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
                } else{
                    var priceOfProperty = totalPriceOfProperty;
                    var percentageOfOne = priceOfProperty/100;
                    var downPaymentPercentage = $("#paymentAmount").val()/percentageOfOne;
                    fullPercentage = (fullPercentage) - (downPaymentPercentage.toFixed(2));
                    $("#paymentStuctureRemark1").val("Booking Amount");
                    $("#paymentStuctureDate1").val(bookingDate);
                    $("#paymentStuctureCompletion1").val(downPaymentPercentage.toFixed(2));
                    $("#paymentStuctureAmount1").val(Number($("#paymentAmount").val()).toFixed(2));
                    $("#paymentStuctureRemark1").attr("readonly", "readonly");
                    $("#paymentStuctureCompletion1").attr("readonly", "readonly");
                    $("#paymentStuctureAmount1").attr("readonly", "readonly");
                    $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
                }
            }else{
                fullPercentage = (100).toFixed(2);
                $("#paymentStuctureRemark1").val("");
                $("#paymentStuctureDate1").val("");
                $("#paymentStuctureCompletion1").val("");
                $("#paymentStuctureAmount1").val("");
                $("#paymentStuctureRemark1").removeAttr("readonly");
                $("#paymentStuctureDate1").removeAttr("readonly");
                $("#paymentStuctureCompletion1").removeAttr("readonly");
                $("#paymentStuctureAmount1").removeAttr("readonly");
                $("#paymentAmountInRupees").val(convertNumberToWords($("#paymentAmount").val()));
            } 
        }
    });
    // Number In Words Section End -----------------------------------------------------------------------------------------------------------------
   
    // Number In Words Section Start --------------------------------------------------------------------------------------------------------------- 
    $("#paymentAmountDate").on("click keyup change", function () {
           var bookingDate=$('#paymentAmountDate').val();
            console.log(bookingDate);
            $("#paymentStuctureDate1").attr("readonly", "readonly");
            $("#paymentStuctureDate1").val(bookingDate);
    });
    // Number In Words Section End -----------------------------------------------------------------------------------------------------------------
   

    // First Applicant Find Age Section Start ------------------------------------------------------------------------------------------------------
    $('#firstApplicantCalculateAge').click( function () {
        topEndNotification("info", "Calculating Age...");
        $('#firstApplicantAge').attr("readonly", "readonly");
        var formData = {"action":"fetchFirstApplicantCalculatedAge","dateOfBirth":$("#firstApplicantDateOfBirth").val()};
        $.ajax({
            url: 'application/view/admin/customers.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                setTimeout( function() {
                    topEndNotification("info", data);
                    $('#firstApplicantAge').val(data);
                }, 500);
            }
        });
    });
    // First Applicant Find Age Section End --------------------------------------------------------------------------------------------------------
    // First Applicant On Selection Of Marital Status Section Start -------------------------------------------------------------------------------- 
    $("#firstApplicantMaritalStatus").change(function () {
        if($("#firstApplicantMaritalStatus").val() == "Single"){
            $("#divFirstApplicantDateOfAnniversary").addClass("display-none");
            $("#divFirstApplicantNoOfChild").addClass("display-none");
        } else{
            $("#divFirstApplicantDateOfAnniversary").removeClass("display-none");
            $("#divFirstApplicantNoOfChild").removeClass("display-none");
        }
    });
    // First Applicant On Selection Of Marital Status Section End ---------------------------------------------------------------------------------- 
    // Edit First Applicant On Selection Of Marital Status Section Start -------------------------------------------------------------------------------- 
    $("#editfirstApplicantMaritalStatus").change(function () {
        if($("#editfirstApplicantMaritalStatus").val() == "Single"){
            $("#editdivFirstApplicantDateOfAnniversary").addClass("display-none");
            $("#editdivFirstApplicantNoOfChild").addClass("display-none");
        } else{
            $("#editdivFirstApplicantDateOfAnniversary").removeClass("display-none");
            $("#editdivFirstApplicantNoOfChild").removeClass("display-none");
        }
    });
    //Edit First Applicant On Selection Of Marital Status Section End ---------------------------------------------------------------------------------- 
    
    // Second Applicant Find Age Section Start -----------------------------------------------------------------------------------------------------
    $('#secondApplicantCalculateAge').click( function () {
        topEndNotification("info", "Calculating Age...");
        $('#secondApplicantAge').attr("readonly", "readonly");
        var formData = {"action":"fetchSecondApplicantCalculatedAge","dateOfBirth":$("#secondApplicantDateOfBirth").val()};
        $.ajax({
            url: 'application/view/admin/customers.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                setTimeout( function() {
                    topEndNotification("info", data);
                    $('#secondApplicantAge').val(data);
                }, 500);
            }
        });
    });
    // Second Applicant Find Age Section End -------------------------------------------------------------------------------------------------------
    // Second Applicant On Selection Of Marital Status Section Start -------------------------------------------------------------------------------
    $("#secondApplicantMaritalStatus").change(function () {
        if($("#secondApplicantMaritalStatus").val() == "Single"){
            $("#divSecondApplicantDateOfAnniversary").addClass("display-none");
            $("#divSecondApplicantNoOfChild").addClass("display-none");
        } else{
            $("#divSecondApplicantDateOfAnniversary").removeClass("display-none");
            $("#divSecondApplicantNoOfChild").removeClass("display-none");
        }
    });
    // Second Applicant On Selection Of Marital Status Section End ---------------------------------------------------------------------------------
});
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
    $('#add').click(function(){
        var addedPercentage = (0).toFixed(2);
        var check = "";
        var checkExceed = "";  
        var totalRows = $("#totalNumberOfDivision").val();
        for(j = 1; j <= totalRows; j++){
            if($("#paymentStuctureCompletion"+j).val() == ""){
                $("#paymentStuctureCompletion"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#paymentStuctureCompletion"+j).removeClass("is-invalid");
            if($("#paymentStuctureAmount"+j).val() == ""){
                $("#paymentStuctureAmount"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#paymentStuctureAmount"+j).removeClass("is-invalid");
            if($("#paymentStuctureRemark"+j).val() == ""){
                $("#paymentStuctureRemark"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#paymentStuctureRemark"+j).removeClass("is-invalid");
            if($("#paymentStuctureDate"+j).val() == ""){
                $("#paymentStuctureDate"+j).addClass("is-invalid");
                check = "emptyRows";
            }else
                $("#paymentStuctureDate"+j).removeClass("is-invalid");
            addedPercentage = Number(addedPercentage) + Number($("#paymentStuctureCompletion"+j).val());
//            console.log(addedPercentage);
            if(Number(addedPercentage) >= Number(100))
                checkExceed = "exceedPercentage";
        }
        if(check != "emptyRows" && checkExceed != "exceedPercentage"){
            i++; 
            $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+i+'.</span></td> <td> <div class="form-group mb-0">  <input id="paymentStuctureDate'+i+'" name="paymentStuctureDate[]" type="date" class="form-control form-control-sm" data-row-id='+i+' /> </div> </td> <td><div class="form-group mb-0"><input id="paymentStuctureRemark'+i+'" name="paymentStuctureRemark[]" type="text" class="form-control form-control-sm" data-row-id='+i+' style="width:200px;"/></div></td><td><div class="form-group mb-0"><div class="input-group" style="width:150px;"><input id="paymentStuctureCompletion'+i+'" name="paymentStuctureCompletion[]" type="number" min="0.00" step=any class="form-control form-control-sm calculate-this" data-row-id='+i+' /><div class="input-group-prepend"><button type="button" class="btn btn-danger btn-sm">%</button></div></div></div></td><td><div class="form-group mb-0"><div class="input-group" style="width:200px;"><div class="input-group-prepend"><button type="button" class="btn btn-danger btn-sm">&#8377;</button></div><input id="paymentStuctureAmount'+i+'" name="paymentStuctureAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm calculate-this" data-row-id='+i+'  /></div></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-sm btn_remove ">X</button></td></tr>');
            $("#totalNumberOfDivision").val(i);
        } else if(checkExceed == "exceedPercentage")
            topEndNotification("warning", "100% completed! You are not able to add more rows!!!");
        else
            topEndNotification("warning", "Please first complete existing rows");
    });
    $(document).on('click', '.btn_remove', function(){  
       var button_id = $(this).attr("id");   
       $('#row'+button_id+'').remove(); 
       i--;
       $("#totalNumberOfDivision").val(i);
    }); 
    //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
});
//Add Dynamic Payment Structure Section End --------------------------------------------------------------------------------------------------------
// Calculate Percentage Section Start ---------------------------------------------------------------------------------------------------------- 
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
    
    fullPercentage = (100).toFixed(2);
    if($('#propertyPriceDeal').val() == ""){
        topEndNotification("warning", "Please mention Dealing price first!!!");
        $("#paymentAmount").val(0);
    } else{
        var addedPercentage = (0).toFixed(2);
        var addedPercentageOld = (0).toFixed(2);
        var addedAmount = (0).toFixed(2);
        var addedAmountOld = (0).toFixed(2);
        var check = "";
        var totalRows = $("#totalNumberOfDivision").val();
        for(i = 1; i <= totalRows; i++){
            //Checking empty and filled up rows Section Start
            if($("#paymentStuctureCompletion"+i).val() == "" && $("#paymentStuctureCompletion"+i).val() == ""){
                $("#paymentStuctureCompletion"+i).addClass("is-invalid");
                $("#paymentStuctureAmount"+i).addClass("is-invalid");
                $("#paymentStuctureAmount"+i).val("");
                $("#paymentStuctureCompletion"+i).val("");
            }else{
                $("#paymentStuctureCompletion"+i).removeClass("is-invalid");
                $("#paymentStuctureAmount"+i).removeClass("is-invalid");
                var propertyPrice=$("#propertyPriceDeal").val();
                var carParkingPrice=$("#CarParkingAmount").val();
                var scooterParkingPrice=$("#ScooterParkingAmount").val();
                var priceOfProperty=Number(propertyPrice)+Number(carParkingPrice)+Number(scooterParkingPrice);
                fullAmount = priceOfProperty.toFixed(2);
                //console.log(priceOfProperty);
                //var priceOfProperty = $("#propertyPriceDeal").val();
                var percentageOfOne = priceOfProperty/100;
                addedPercentage = Number(addedPercentage) + Number($("#paymentStuctureCompletion"+i).val());
                if(Number(addedPercentage) > Number(100)){
                    $("#paymentStuctureCompletion"+i).addClass("is-invalid");
                    $("#paymentStuctureAmount"+i).addClass("is-invalid");
                    $("#paymentStuctureCompletion"+i).val("");
                    $("#paymentStuctureCompletion"+i).prop("placeholder", (100.00 - addedPercentageOld).toFixed(2));
                    $("#paymentStuctureAmount"+i).val("");
                    check = "exceedPercentage";
                } else{
                    var thisAmount = Number(percentageOfOne) * Number($("#paymentStuctureCompletion"+i).val());
                    $("#paymentStuctureAmount"+i).val((thisAmount).toFixed(2));
                    // $("#paymentStuctureRemark"+i).val((Number($("#paymentStuctureAmount"+i).val()) / Number(priceOfProperty)) * 100);
                }
            }
            addedPercentageOld = addedPercentage;
            //Checking empty and filled up rows Section End
        }
        // switch(check){
        //     case "exceedPercentage":
        //         topEndNotification("warning", "The addition of Completeion % should be equal to 100%!!!");
        //         break;
        // }
    }
}


$(document).on("click change keyup", ".calculate-this", function(){
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
    if($('#propertyPriceDeal').val() == "") {
        topEndNotification("warning", "Please mention Dealing price first!!!");
        $(this).val(0);
        $("#paymentAmount").val(0);
    } else {
        if($("#paymentStuctureCompletion"+ row_id).val() == "" && $("#paymentStuctureCompletion"+ row_id).val() == "") {
            $("#paymentStuctureCompletion"+ row_id).addClass("is-invalid");
            $("#paymentStuctureAmount"+ row_id).addClass("is-invalid");
            $("#paymentStuctureAmount"+ row_id).val("");
            $("#paymentStuctureCompletion"+ row_id).val("");
        } else {
            var row_id = $(this).data("row-id");
            var fullAmount = Number($("#propertyPriceDeal").val()) + Number($("#CarParkingAmount").val()) + Number($("#ScooterParkingAmount").val());
            var fullPercentage = (100).toFixed(2);
            var addedPercentage = (0).toFixed(2);
            // var addedPercentageOld = (0).toFixed();
            var addedAmount = (0).toFixed(2);
            // var addedAmountOld = (0).toFixed(2);
            var percentageOfOne = fullAmount/100;
            var check = "";
            var totalRows = $("#totalNumberOfDivision").val();
            for(i = 1; i <= totalRows; i++){
                addedPercentage = Number(addedPercentage) + Number($("#paymentStuctureCompletion"+ i).val());
                addedAmount = Number(addedAmount) + Number($("#paymentStuctureAmount"+ i).val());
            }
            // console.log(percentageOfOne);
            // console.log(fullAmount);
            // console.log(addedAmount);
            if($(this).attr("id") == "paymentStuctureCompletion"+ row_id) {
                if(Number(addedPercentage) > Number(100)){
                    $("#paymentStuctureCompletion"+ row_id).addClass("is-invalid");
                    $("#paymentStuctureAmount"+ row_id).addClass("is-invalid");
                    $("#paymentStuctureCompletion"+ row_id).prop("placeholder", (100.00 - (Number(addedPercentage) - $(this).val())).toFixed(2));
                    $("#paymentStuctureCompletion"+ row_id).val("");
                    $("#paymentStuctureAmount"+ row_id).val("");
                    check = "exceedPercentage";
                } else{
                    var thisAmount = Number(percentageOfOne) * Number($("#paymentStuctureCompletion"+row_id).val());
                    $("#paymentStuctureAmount"+row_id).val((thisAmount).toFixed(2));                }
            } else {
                if(Number(addedAmount) > Number(fullAmount)){
                    $("#paymentStuctureCompletion"+ row_id).addClass("is-invalid");
                    $("#paymentStuctureAmount"+ row_id).addClass("is-invalid");
                    $("#paymentStuctureAmount"+ row_id).prop("placeholder", (fullAmount - (Number(addedAmount) - $(this).val())).toFixed(2));
                    $("#paymentStuctureCompletion"+ row_id).val("");
                    $("#paymentStuctureAmount"+ row_id).val("");
                    check = "exceedAmount";
                } else{
                    // var thisAmount = Number(percentageOfOne) * Number($("#paymentStuctureCompletion"+row_id).val());
                    // $("#paymentStuctureAmount"+row_id).val((thisAmount).toFixed(2));
                    $("#paymentStuctureCompletion"+row_id).val(((Number($("#paymentStuctureAmount"+row_id).val()) / Number(fullAmount)) * 100).toFixed(2));
                }
            }
        }
    }
    switch(check) {
        case "exceedPercentage":
            topEndNotification("warning", "The addition of Completion % should be equal to 100%!!!");
            break;
        case "exceedAmount":
            topEndNotification("warning", "Amount exceeded, it should be equal to "+ fullAmount +"!!!");
            break;
    }
});
// Calculate Percentage Section End ------------------------------------------------------------------------------------------------------------
// Car parking On Selection Of Amount Section Start -------------------------------------------------------------------------------- 
    $("#propertyCarParkings").change(function () {
        if($("#propertyCarParkings").val() == "No"){
            $("#divCarParkingAmount").addClass("display-none");
        } else{
            $("#divCarParkingArea").removeClass("display-none");
        }
    });


    $("#propertyCarArea").change(function () {

        $("#divCarParkingAmount").removeClass("display-none");  
        // if($("#propertyCarParkings").val() == "No"){
        //     $("#divCarParkingAmount").addClass("display-none");
        // } else{
        //     $("#divCarParkingArea").removeClass("display-none");
        // }
    });
// Car parking On Selection Of Amount Section End ---------------------------------------------------------------------------------- 
// Scooter parking On Selection Of Amount Section Start -------------------------------------------------------------------------------- 
    $("#propertyScooterParkings").change(function () {
        if($("#propertyScooterParkings").val() == "No"){
            $("#divScooterParkingAmount").addClass("display-none");
        } else{
            $("#divScooterParkingAmount").removeClass("display-none");
        }
    });
// Scooter parking On Selection Of Amount Section End ---------------------------------------------------------------------------------- 



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
    var k=1;  
    $('#extraamountadd').click(function(){
    var addedExtraAmount = (0).toFixed(2);
    var checkAmt = "";
    var totalRow = $("#totalextraamount").val();
     for(l = 1; l <= totalRow; l++){
    if($("#ExtraAmount"+l).val() == ""){
        $("#ExtraAmount"+l).addClass("is-invalid");
        checkAmt = "emptyRows";
    }else
        $("#ExtraAmount"+l).removeClass("is-invalid");
    if($("#ExtraAmountRemarks"+l).val() == ""){
        $("#ExtraAmountRemarks"+l).addClass("is-invalid");
        checkAmt = "emptyRows";
    }else
        $("#ExtraAmountRemarks"+l).removeClass("is-invalid");           
}
    if(checkAmt != "emptyRows"){
    k++; 
    //console.log("K="+k);
    $('#dynamic_field1').append('<tr id="extraAmtRow'+k+'" class="dynamic-added" ><td><span class="p-3 mt-2">'+k+'.</span></td><td><input id="ExtraAmountRemarks'+k+'" name="ExtraAmountRemarks[]" type="text" class="form-control form-control-sm" /></td><td><input id="ExtraAmount'+k+'" name="ExtraAmount[]" type="number" min="0.00" step=any class="form-control form-control-sm" /></td><td><button type="button" name="remove'+k+'" id="'+k+'" class="btn btn-danger btn-sm btn_removeExt">X</button></td></tr>');
    $("#totalextraamount").val(k);
} else {
    topEndNotification("warning", "Please first complete existing rows");
}
     
});
    $("#ExtraAmount"+k).addClass("calculate-amount");
    $("#ExtraAmountRemarks"+k).addClass("calculate-amount");      
    
    $(document).on('click', '.btn_removeExt', function(){  
       var button_id1 = $(this).attr("id");   
       $('#extraAmtRow'+button_id1+'').remove(); 
       k--;
      //  console.log("K="+k);
       $("#totalextraamount").val(k);
    }); 

});
    //Multiple Rows Section End -------------------------------------------------------------------------------------------------------------------- 
//});

$("#paymentAmountMode").change(function(){
    if($(this).val() == "Cash")
        $(".other-mode").addClass("display-none");
    else
        $(".other-mode").removeClass("display-none");
});
