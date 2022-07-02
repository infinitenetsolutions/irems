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

            url: 'application/view/admin/manage-employees.php',

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

        if($("#firstName").val() == ""){

            $("#firstName").addClass("is-invalid");

            flag = 0;

        }else

            $("#firstName").removeClass("is-invalid");

        // if($("#designationName").val() == ""){

        //     $("#designationName").addClass("is-invalid");

        //     flag = 0;

        // }else

        //     $("#designationName").removeClass("is-invalid");

        if(flag == 1){

            var formData = new FormData($('form#addForm')[0]);

            formData.append("checkLocation", $("#checkLocation").val());

            formData.append("checkIp", $("#checkIp").val());

            formData.append("action", "addData");

            $.ajax({

                url: 'application/controller/admin/manage-employees.php',

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













//     $('form#addForm').submit(function (event) {

//         event.preventDefault(); //Prevent Default the Events

//         $('#addButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

//         $('#addButton').prop('disabled', true);

//         var flag = 1;

//         if($("#firstName").val() == ""){

//             $("#firstName").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#firstName").removeClass("is-invalid");

//         if($("#employeeId").val() == ""){

//             $("#employeeId").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#employeeId").removeClass("is-invalid");

//         if($("#mobile").val() == ""){

//             $("#mobile").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#mobile").removeClass("is-invalid");

//         if($("#dob").val() == ""){

//             $("#dob").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#dob").removeClass("is-invalid");

        

//          if($("#department").val() == ""){

//             $("#department").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#department").removeClass("is-invalid");
        
//          if($("#designation").val() == ""){

//             $("#designation").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#designation").removeClass("is-invalid");

        

        

//         if($("#date_of_joining").val() == ""){

//             $("#date_of_joining").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#date_of_joining").removeClass("is-invalid");

        

//         if($("#empStatus").val() == ""){

//             $("#empStatus").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#empStatus").removeClass("is-invalid");
        
        

//         if($("#empStatus").val() == ""){

//             $("#empStatus").addClass("is-invalid");

//             flag = 0;

//         }else

//             $("#empStatus").removeClass("is-invalid");


//         if($("#totalSalary").val() == ""){
//             $("#totalSalary").addClass("is-invalid");
//             flag = 0;
//         }else
//             $("#totalSalary").removeClass("is-invalid");
//         // if($("#grossSalary").val() == ""){
//         //     $("#grossSalary").addClass("is-invalid");
//         //     flag = 0;
//         // }else
//         //     $("#grossSalary").removeClass("is-invalid");
//         if($("#netSalary").val() == ""){
//             $("#netSalary").addClass("is-invalid");
//             flag = 0;
//         }else
//             $("#netSalary").removeClass("is-invalid");
        

//         if(flag == 1){

//             var formData = new FormData($('form#addForm')[0]);

//             formData.append("checkLocation", $("#checkLocation").val());

//             formData.append("checkIp", $("#checkIp").val());

//             formData.append("action", "addData");

//             $.ajax({

//                 url: 'application/controller/admin/manage-employees.php',

//                 type: 'POST',

//                 data: formData,

//                 dataType: "json",

//                 success: function (data) {

//                     if(data.response == "success"){

//                         $('#addForm')[0].reset();

//                         setTimeout(function(){

//                             fetchFn();

//                         }, 1000);

//                     }

//                     topEndNotification(data.responseType, data.responseMessage);

//                     $('#loading').fadeOut(500, function () {

//                         $(this).remove();

//                         $('#addButton').html('<i class="fa fa-plus fa-sm"></i> Add this');

//                         $('#addButton').prop('disabled', false);

//                     });

//                 },

//                 cache: false,

//                 contentType: false,

//                 processData: false

//             });

//         } else{

//             topEndNotification("warning" , "Please fill out the required fields");

//             $('#loading').fadeOut(500, function () {

//                 $(this).remove();

//                 $('#addButton').html('<i class="fa fa-plus fa-sm"></i> Add this');

//                 $('#addButton').prop('disabled', false);

//             });

//         }

//     });


// $(document).on('change', '#editDepartment', function( event ) {

//         var formData = new FormData();

//         formData.append("action", "editfetchDesignationDetails");
//         formData.append("editDepartment", $("#editDepartment").val());

//         $("#editDesignation").prop("disabled", true);

//         $.ajax({

//             url: 'application/view/admin/manage-employees.php',

//             type: 'POST',

//             data: formData,

//             success: function(result) {

//                  $("#editDesignation").html(result);

//                  setTimeout(function(){

//                       $("#editDesignation").prop("disabled", false);

//                  }, 500);

//             },

//             cache: false,

//             contentType: false,

//             processData: false

//         });

//         event.preventDefault();

//     });
    // Add Section End -----------------------------------------------------------------------------------------------------------------------------
$("#MaritalStatus").change(function () {
                if($("#MaritalStatus").val() == "Single"){
                    $("#AnniversaryDiv").addClass("display-none");
                    
                } else{
                    $("#AnniversaryDiv").removeClass("display-none");
                    
                }
            });
    $("#department").change(function () {
        if($("#department").find(":selected").text() == "Back Office")
            $('#project').prop("disabled", true);
        else
            $("#project").prop("disabled", false);  
    });
    
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

                url: 'application/controller/admin/manage-company.php',

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

        if($("#editDepartment").val() == ""){

            $("#editDepartment").addClass("is-invalid");

            flag = 0;

        }else

            $("#editDepartment").removeClass("is-invalid");

        // if($("#editCompanyCity").val() == ""){

        //     $("#editCompanyCity").addClass("is-invalid");

        //     flag = 0;

        // }else

        //     $("#editCompanyCity").removeClass("is-invalid");

        // if($("#editCompanyState").val() == ""){

        //     $("#editCompanyState").addClass("is-invalid");

        //     flag = 0;

        // }else

        //     $("#editCompanyState").removeClass("is-invalid");

        // if($("#editCompanyPincode").val() == ""){

        //     $("#editCompanyPincode").addClass("is-invalid");

        //     flag = 0;

        // }else

        //     $("#editCompanyPincode").removeClass("is-invalid");

        if(flag == 1){

            var formData = new FormData($('form#editForm')[0]);

            formData.append("checkLocation", $("#checkLocation").val());

            formData.append("checkIp", $("#checkIp").val());

            formData.append("action", "editData");

            $.ajax({

                url: 'application/controller/admin/manage-employees.php',

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
    $("#EditMaritalStatus").change(function () {
                if($("#EditMaritalStatus").val() == "Single"){
                    $("#editAnniversaryDiv").addClass("display-none");
                    
                } else{
                    $("#editAnniversaryDiv").removeClass("display-none");
                    
                }
            });
    $("#department").change(function () {
        if($("#department").find(":selected").text() == "Back Office")
            $('#project').prop("disabled", true);
        else
            $("#project").prop("disabled", false);  
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

                url: 'application/controller/admin/manage-employees.php',

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

            url: 'application/controller/admin/manage-company.php',

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

    // // Export Selected Section End -----------------------------------------------------------------------------------------------------------------
    // $(document).ready(function(){
    //     $("#department").change(function(){
    //         var des_id= $("#department").val();
    //         alert(des_id);
    //         $.ajax({
    //             url:  'application/view/admin/manage-employees.php',
    //             method : 'POST',
    //              data: {'des_id': des_id},

    //         }).done(function(designation){
    //             console.log(designation);
    //         })
    //     })
    // })
    // Delete Selected Section Start ---------------------------------------------------------------------------------------------------------------

    $("#deleteSelectedButton").click(function () {

        $('#deleteSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        $('#deleteSelectedButton').prop('disabled', true);

        var formData = new FormData($('form#selectForm')[0]);

        formData.append("checkLocation", $("#checkLocation").val());

        formData.append("checkIp", $("#checkIp").val());

        formData.append("action", "deleteSelectedData");

        $.ajax({

            url: 'application/controller/admin/manage-employees.php',

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

    

    //Fetch Property Type

    $('#project').on('change', function( event ) {

        var formData = new FormData($('form#addForm')[0]);

        formData.append("action", "fetchProjectDetails");

        $("#property").prop("disabled", true);

        $.ajax({

            url: 'application/view/admin/manage-employees.php',

            type: 'POST',

            data: formData,

            success: function(result) {

                 $("#property").html(result);

                 setTimeout(function(){

                      $("#property").prop("disabled", false);

                 }, 500);

            },

            cache: false,

            contentType: false,

            processData: false

        });

        event.preventDefault();

    });

});

$('#department').on('change', function( event ) {

        var formData = new FormData();

        formData.append("action", "fetchDesignationDetails");
        formData.append("department", $("#department").val());

        $("#designation").prop("disabled", true);

        $.ajax({

            url: 'application/view/admin/manage-employees.php',

            type: 'POST',

            data: formData,

            success: function(result) {

                 $("#designation").html(result);

                 setTimeout(function(){

                      $("#designation").prop("disabled", false);

                 }, 500);

            },

            cache: false,

            contentType: false,

            processData: false

        });

        event.preventDefault();

    });

$('#editDepartment').on('change', function( event ) {

        var formData = new FormData();

        formData.append("action", "editfetchDesignationDetails");
        formData.append("editDepartment", $("#editDepartment").val());

        $("#designation").prop("disabled", true);

        $.ajax({

            url: 'application/view/admin/manage-employees.php',

            type: 'POST',

            data: formData,

            success: function(result) {

                 $("#designation").html(result);

                 setTimeout(function(){

                      $("#designation").prop("disabled", false);

                 }, 500);

            },

            cache: false,

            contentType: false,

            processData: false

        });

        event.preventDefault();

    });


    

// function cal() {

//       var txtFirstNumberValue = document.getElementById('basicSalary').value;

//       var txtSecondNumberValue = document.getElementById('hra').value;

//       var txtThirdNumberValue = document.getElementById('pf').value;

// //    var txtFourthNumberValue = document.getElementById('monthly_tax_deduc').value

//       //var txtFourthNumberValue = document.getElementById('fooding_allowance').value;

//     //  var txtFifthNumberValue = document.getElementById('transbortation_allowance').value;

//      // var txtSixthNumberValue = document.getElementById('accomodation').value;

//     //   var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue) -  parseInt(txtFourthNumberValue);

//     var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue);

//       if (!isNaN(result)) {

//         document.getElementById('totalSalary').value = result;

//       }

// }
// function cal1() {

//       var txtFirstNumberValue = document.getElementById('editBasicSalary').value;

//       var txtSecondNumberValue = document.getElementById('editHRA').value;

//       var txtThirdNumberValue = document.getElementById('editPf').value;



//     var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue) + parseInt(txtThirdNumberValue);

//       if (!isNaN(result)) {

//          document.getElementById('editTotalSalary').value = result;

//       }

// }

// $(document).on("click change keyup blur", ".salary", function(){
//     salary();
//     totals($(this).attr("id"));
// });
// $(document).on("click change keyup blur", ".deduction", function(){
//     deduction();
//     totals($(this).attr("id"));
// });
// salary = function(){
//     var sumSal = 0.00;
//     $(".salary").each(function(){
//         sumSal += Number($(this).val());
//     });
//     $("#totalSalary").val(sumSal);
// }
// deduction = function(){
//     var sumDed = 0.00;
//     $(".deduction").each(function(){
//         sumDed += Number($(this).val());
//     });
//     $("#totalDeduction").val(sumDed);
// }
// totals = function(currentId){
//     if((Number($("#totalSalary").val()) - Number($("#totalDeduction").val())) < 0 || Number($("#totalSalary").val()) < 0 || Number($("#totalDeduction").val()) < 0){
//         $("#"+ currentId).val(0);
//         salary();
//         deduction();
//     }
//     $("#grossSalary").val(Number($("#totalSalary").val()));
//     $("#netSalary").val(Number($("#totalSalary").val()) - Number($("#totalDeduction").val()));
//     if(Number($("#netSalary").val()) < 0){
//         $(".deduction").each(function(){
//             $(this).val(0);
//         });
//         salary();
//         deduction();
//         $("#netSalary").val(0);
//     }
// }
$(document).ready(function(){
    $("#basicSalary").keyup(function(){
    alert("The text has been changed.");
    });
});

