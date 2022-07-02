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

            url: 'application/view/admin/purchase-order.php',

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

    // $(".refresh-button").click(function () {

    //     $('#refresh-button').prop('disabled', true);

    //     $('#refresh-button').html('<center id = "loading"><img width="16px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

    //     fetchFn();

    // });

    // Refresh Section End -------------------------------------------------------------------------------------------------------------------------

    // Add Section Start ---------------------------------------------------------------------------------------------------------------------------

    $('form#selectForm').submit(function (event) {
        

        event.preventDefault(); //Prevent Default the Events

        $('#addButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        $('#addButton').prop('disabled', true);
            var formData = new FormData($('form#selectForm')[0]);

            formData.append("checkLocation", $("#checkLocation").val());

            formData.append("checkIp", $("#checkIp").val());

            formData.append("action", "addPO");

            $.ajax({

                url: 'application/controller/admin/purchase-order.php',

                type: 'POST',

                data: formData,

                dataType: "json",

                success: function (data) {
                     console.log(data);
                    //  alert("aa");
                    if(data.response == "success"){
                        $('#selectForm')[0].reset();
                           topEndNotification(data.responseType, data.responseMessage);
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $('#addButton').html('<i class="fa fa-upload fa-sm"></i>PO Created');
                                $('#addButton').prop('disabled', false);
                            });
                    setTimeout(function(){ window.location.href = "https://srinathhomes.in/irems/dashboard"; }, 3000);
                    } else{
                          topEndNotification("warning" , "Please fill out the required fields");
                          $('#loading').fadeOut(500, function () {
                              $(this).remove();
                              $('#addButton').html('<i class="fa fa-upload fa-sm"></i>Create PO');
                              $('#addButton').prop('disabled', false);
                          });
                      }                
                    

                },

                cache: false,

                contentType: false,

                processData: false

            });

        
    });

    // Add Section End -----------------------------------------------------------------------------------------------------------------------------

    // Import Section Start ------------------------------------------------------------------------------------------------------------------------

    // $('form#importForm').submit(function (event) {

    //     event.preventDefault(); //Prevent Default the Events

    //     $('#importButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

    //     $('#importButton').prop('disabled', true);

    //     var flag = 1;

    //     if($("#importedExcel").val() == ""){

    //         $("#importedExcel").addClass("is-invalid");

    //         flag = 0;

    //     }else

    //         $("#importedExcel").removeClass("is-invalid");

    //     if(flag == 1){

    //         var formData = new FormData($('form#importForm')[0]);

    //         formData.append("checkLocation", $("#checkLocation").val());

    //         formData.append("checkIp", $("#checkIp").val());

    //         formData.append("action", "importData");

    //         $.ajax({

    //             url: 'application/controller/admin/manage-company.php',

    //             type: 'POST',

    //             data: formData,

    //             dataType: "json",

    //             success: function (data) {

    //                  if(data.response == "success"){
    //                     $('#editForm')[0].reset();
    //                        topEndNotification(data.responseType, data.responseMessage);
    //                         $('#loading').fadeOut(500, function () {
    //                             $(this).remove();
    //                             $('#editButton').html('<i class="fa fa-upload fa-sm"></i>Approve Indent');
    //                             $('#editButton').prop('disabled', false);
    //                         });
    //                 } else{
    //                       topEndNotification("warning" , "Please fill out the required fields");
    //                       $('#loading').fadeOut(500, function () {
    //                           $(this).remove();
    //                           $('#editButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
    //                           $('#editButton').prop('disabled', false);
    //                       });
    //                   }
    //                 location.href = "https://srinathhomes.in/irems/dashboard";
    //                 topEndNotification(data.responseType, data.responseMessage);

    //             },

    //             cache: false,

    //             contentType: false,

    //             processData: false

    //         });

    //     } else{

    //         topEndNotification("warning" , "Please select an Excel File!!!");

    //         $('#loading').fadeOut(500, function () {

    //             $(this).remove();

    //             $('#importButton').html('<i class="fa fa-upload fa-sm"></i> Import this');

    //             $('#importButton').prop('disabled', false);

    //         });

    //     }

    // });

    // Import Section End --------------------------------------------------------------------------------------------------------------------------

    // Edit Section Start --------------------------------------------------------------------------------------------------------------------------

    // $('form#editForm').submit(function (event) {

    //     event.preventDefault(); //Prevent Default the Events

    //     $('#editButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

    //     $('#editButton').prop('disabled', true);

    //     var flag = 1;

    //     if($("#editCompanyName").val() == ""){

    //         $("#editCompanyName").addClass("is-invalid");

    //         flag = 0;

    //     }else

    //         $("#editCompanyName").removeClass("is-invalid");

    //     if($("#editCompanyCity").val() == ""){

    //         $("#editCompanyCity").addClass("is-invalid");

    //         flag = 0;

    //     }else

    //         $("#editCompanyCity").removeClass("is-invalid");

    //     if($("#editCompanyState").val() == ""){

    //         $("#editCompanyState").addClass("is-invalid");

    //         flag = 0;

    //     }else

    //         $("#editCompanyState").removeClass("is-invalid");

    //     if($("#editCompanyPincode").val() == ""){

    //         $("#editCompanyPincode").addClass("is-invalid");

    //         flag = 0;

    //     }else

    //         $("#editCompanyPincode").removeClass("is-invalid");

    //     if(flag == 1){

    //         var formData = new FormData($('form#editForm')[0]);

    //         formData.append("checkLocation", $("#checkLocation").val());

    //         formData.append("checkIp", $("#checkIp").val());

    //         formData.append("action", "editData");

    //         $.ajax({

    //             url: 'application/controller/admin/manage-company.php',

    //             type: 'POST',

    //             data: formData,

    //             dataType: "json",

    //             success: function (data) {

    //                 if(data.response == "success"){

    //                     $('#editForm')[0].reset();

    //                     $('#edit-modal').modal("hide");

    //                     setTimeout(function(){

    //                         fetchFn();

    //                     }, 1000);

    //                 }

    //                 topEndNotification(data.responseType, data.responseMessage);

    //                 $('#loading').fadeOut(500, function () {

    //                     $(this).remove();

    //                     $('#editButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');

    //                     $('#editButton').prop('disabled', false);

    //                 });

    //             },

    //             cache: false,

    //             contentType: false,

    //             processData: false

    //         });

    //     } else{

    //         topEndNotification("warning" , "Please fill out the required fields");

    //         $('#loading').fadeOut(500, function () {

    //             $(this).remove();

    //             $('#editButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');

    //             $('#editButton').prop('disabled', false);

    //         });

    //     }

    // });

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

                url: 'application/controller/admin/purchase-order.php',

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

            url: 'application/controller/admin/purchase-order.php',

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
     function onSelection(id, val)
                        {
                            var code_id = "item_code_po[" +id+ "]";
                            var name_id = "item_name_po[" +id+ "]";
                            var uom_id =  "uom_po[" +id+ "]";

                            console.log(code_id+ " " +name_id+ " "+uom_id);
                            document.getElementById(code_id).value = val;
                            document.getElementById(name_id).value = val;
                            document.getElementById(uom_id).value =  val;
                        }

                 function cal(si){
                  
                  
                   if(document.getElementById('tonne_id_po['+si+'][tonne]').value!="" && document.getElementById('rate_id_po['+si+'][rate]').value!=""){
                     document.getElementById('amount_id_po['+si+'][amount]').value = document.getElementById('tonne_id_po['+si+'][tonne]').value*document.getElementById('rate_id_po['+si+'][rate]').value;
                     var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                     var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);                      
                     var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value)
                     var total = amt+camt+samt+iamt;
                     // var t_camt= amt * (camt/100);
                     // var t_samt=  amt * (samt/100);
                     // var t_iamt=  amt * (iamt/100);
                     // var total = amt+t_camt+t_samt+t_iamt;
                     total = total.toFixed(2);
                     
                     document.getElementById('total_id_po['+si+'][total]').value = total;
                   } else{
                     document.getElementById('amount_id_po['+si+'][amount]').value = "";
                     var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                     var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                     var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                    
                     document.getElementById('total_id_po['+si+'][total]').value = total;
                   }
                 }
                 function cal_cgst(si){
                   if(document.getElementById('cgst_id_po['+si+'][cgstrate]').value!=""){
                     var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                     var cgstr = tamount*document.getElementById('cgst_id_po['+si+'][cgstrate]').value;
                     cgstr = cgstr.toFixed(2);
                     document.getElementById('cgst_id_po['+si+'][cgstrate]').value = cgstr;
                     var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                     var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                     var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id_po['+si+'][total]').value = total;
                   } else{
                     document.getElementById('cgst_id_po['+si+'][cgstrate]').value = "";
                     var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                     var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                     var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id_po['+si+'][total]').value = total;
                   }
                 }
                 function cal_sgst(si){
                   if(document.getElementById('sgst_id_po['+si+'][sgstrate]').value!=""){
                     var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                     var sgstr = tamount*document.getElementById('sgst_id_po['+si+'][sgstrate]').value;
                     sgstr = sgstr.toFixed(2);
                     document.getElementById('sgst_id_po['+si+'][sgstamt]').value = sgstr;
                     var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                     var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                     var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id_po['+si+'][total]').value = total;
                   } else{
                     document.getElementById('sgst_id_po['+si+'][sgstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                     var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                     var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id_po['+si+'][total]').value = total;
                   }
                 }
                 function cal_igst(si){
                   if(document.getElementById('igst_id_po['+si+'][igstrate]').value!=""){
                     var tamount = document.getElementById('amount_id_po['+si+'][amount]').value/100;
                     var igstr = tamount*document.getElementById('igst_id_po['+si+'][igstrate]').value;
                     igstr = igstr.toFixed(2);
                     document.getElementById('igst_id_po['+si+'][igstamt]').value = igstr;
                     var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                     var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                     var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id_po['+si+'][total]').value = total;
                   } else{
                     document.getElementById('igst_id_po['+si+'][igstamt]').value = "";
                     var amt = Number(document.getElementById('amount_id_po['+si+'][amount]').value);
                     var camt = Number(document.getElementById('cgst_id_po['+si+'][cgstrate]').value);
                     var samt = Number(document.getElementById('sgst_id_po['+si+'][sgstrate]').value);
                     var iamt = Number(document.getElementById('igst_id_po['+si+'][igstrate]').value);
                     var total = amt+camt+samt+iamt;
                     total = total.toFixed(2);
                     document.getElementById('total_id_po['+si+'][total]').value = total;
                   }
                 }
             
                
                   
 $('#vendor_name').on('change', function( event ) {
                       $.ajax({
                       url: 'getInformationsvendor.php',
                       type: 'POST',
                       data: {"vendor_name":$(this).val()},
                       success: function(result) {
                           $('#viewbranch').remove();
                           $('#branchName').html('<div id="view" >' + result + '</div>');
                       }
                   });
                   event.preventDefault();
               });
              $('#company_name').on('change', function( event ) {
                   $.ajax({
                       url: 'getinformationscompany.php',
                       type: 'POST',
                       data: {"company_name":$(this).val()},
                       success: function(result) {
                           $('#viewcompany').remove();
                           $('#company').html('<div id="viewcompany" >' + result + '</div>');
                         
                       }
                   });
                   event.preventDefault();
               });
              $('#billing_contact_person').on('change', function( event ) {
                         
                       $.ajax({

                           url: 'getInformationbillingcontactDesignation.php',
                           type: 'POST',

                           data: {"billing_contact_person": $(this).val()},
                           
                           success: function(result) {
                             

                               // $('#viewdesignation').remove();
                               $('#contactPerson').html('<div id="viewdesignation" >' + result + '</div>');
                           }
                       });
                       event.preventDefault();
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

            url: 'application/controller/admin/purchase-order.php',

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

})
    
    // Fetch Data Section End ----------------------------------------------------------------------------------------------------------------------
    // Refresh Section Start -----------------------------------------------------------------------------------------------------------------------
   
    
     // $('#project').on('change', function( event ) {
     //               $.ajax({
     //                   url: 'getinformationsproject.php',
     //                   type: 'POST',
     //                   data: {"project":$(this).val()},
     //                   success: function(result) {
                        
     //                       $('#project_sec_div1').html('<div id="viewproject456" >' + result + '</div>');                    
     //                   }
     //               });
     //               event.preventDefault();
     //           });    
        //Fetch Property Type
    // $('#project').on('change', function (event) {
    //     var formData = new FormData($('form#addForm')[0]);
    //     formData.append("action", "fetchProjectDetails");
    //     $("#property").prop("disabled", true);
    //     $.ajax({
    //         url: 'application/view/admin/purchase_order.php',
    //         type: 'POST',
    //         data: formData,
    //         success: function (result) {
    //             $("#property").html(result);
    //             setTimeout(function () {
    //                 $("#property").prop("disabled", false);
    //             }, 500);
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    //     event.preventDefault();
    // });
    // //Fetch project location Type
    // $('#project').on('change', function (event) {
    //     var formData = new FormData($('form#addForm')[0]);
    //     formData.append("action", "fetchProjectlocationDetails");
    //     $("#projectLocation").prop("disabled", true);
    //     $.ajax({
    //         url: 'application/view/admin/purchase_order.php',
    //         type: 'POST',
    //         data: formData,
    //         success: function (result) {
    //             $("#projectLocation").val(result);
    //             setTimeout(function () {
    //                 $("#projectLocation").prop("disabled", false);
    //             }, 500);
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    //     event.preventDefault();
    // });
    
    
    




