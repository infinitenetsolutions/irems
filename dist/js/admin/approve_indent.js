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

    //Toast Setting Section Start ------------------------------------------------------------------------------------------------------------------
    //Aos creation

    AOS.init();

    

    // Approve Section Start --------------------------------------------------------------------------------------------------------------------------

    $('form#editForm').submit(function (event) {

       
        event.preventDefault(); //Prevent Default the Events

        $('#editButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        $('#editButton').prop('disabled', true);
         var flag = 1;
        if($("#employee_approval_po").val() == ""){
            $("#employee_approval_po").addClass("is-invalid");
            flag = 0;
        }else
            $("#employee_approval_po").removeClass("is-invalid");
         if(flag == 1){
            var formData = new FormData($('form#editForm')[0]);

            formData.append("checkLocation", $("#checkLocation").val());

            formData.append("checkIp", $("#checkIp").val());

            // formData.append("action", "approveIndent");
            // for (var pair of formData.entries()) {
            //     console.log(pair[0]+ ' - ' + pair[1]); 
            // }

            $.ajax({

                url: 'application/controller/admin/indent.php',

                type: 'POST',

                data: formData,

                dataType: "json",

                success: function (data) {
                    if(data.response == "success"){
                        $('#editForm')[0].reset();
                           topEndNotification(data.responseType, data.responseMessage);
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $('#editButton').html('<i class="fa fa-upload fa-sm"></i>Approve Indent');
                                $('#editButton').prop('disabled', false);
                            });
                    } else{
                          topEndNotification("warning" , "Please fill out the required fields");
                          $('#loading').fadeOut(500, function () {
                              $(this).remove();
                              $('#editButton').html('<i class="fa fa-upload fa-sm"></i> Save Changes');
                              $('#editButton').prop('disabled', false);
                          });
                      }

                    // topEndNotification(data.responseType, data.responseMessage);

                

                },

                cache: false,

                contentType: false,

                processData: false

            });
            }else{
            topEndNotification("warning" , "Please fill out the required fields");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#editButton').html('<i class="fa fa-plus fa-sm"></i> Save Changes');
                $('#editButton').prop('disabled', false);
            });
        }

    });


    // Edit Section End ----------------------------------------------------------------------------------------------------------------------------

    // Delete Section Start ------------------------------------------------------------------------------------------------------------------------

    // $('form#deleteForm').submit(function (event) {

    //     event.preventDefault(); //Prevent Default the Events

    //     $('#deleteButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

    //     $('#deleteButton').prop('disabled', true);

    //     var flag = 1;

    //     if($("#tableId").val() == "" || $("#tableName").val() == "")

    //         flag = 0;

    //     if(flag == 1){

    //         var formData = new FormData($('form#deleteForm')[0]);

    //         formData.append("checkLocation", $("#checkLocation").val());

    //         formData.append("checkIp", $("#checkIp").val());

    //         formData.append("action", "deleteData");

    //         $.ajax({

    //             url: 'application/controller/admin/receive-indent.php',

    //             type: 'POST',

    //             data: formData,

    //             dataType: "json",

    //             success: function (data) {

    //                 if(data.response == "success"){

    //                     $('#deleteForm')[0].reset();

    //                     $('#delete-modal').modal("hide");

    //                     setTimeout(function(){

    //                         fetchFn();

    //                     }, 1000);

    //                 }

    //                 topEndNotification(data.responseType, data.responseMessage);

    //                 $('#loading').fadeOut(500, function () {

    //                     $(this).remove();

    //                     $('#deleteButton').html('<i class="fa fa-plus fa-sm"></i> Delete');

    //                     $('#deleteButton').prop('disabled', false);

    //                 });

    //             },

    //             cache: false,

    //             contentType: false,

    //             processData: false

    //         });

    //     } else{

    //         topEndNotification("error" , "Something went wrong, please try again or refresh!!!");

    //         $('#loading').fadeOut(500, function () {

    //             $(this).remove();

    //             $('#deleteButton').html('<i class="fa fa-plus fa-sm"></i> Delete');

    //             $('#deleteButton').prop('disabled', false);

    //         });

    //     }

    // });

    // Delete Section End --------------------------------------------------------------------------------------------------------------------------

    // Export Selected Section Start ---------------------------------------------------------------------------------------------------------------

    // $("#exportSelectedButton").click(function () {

    //     $('#exportSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

    //     $('#exportSelectedButton').prop('disabled', true);

    //     var formData = new FormData($('form#selectForm')[0]);

    //     formData.append("checkLocation", $("#checkLocation").val());

    //     formData.append("checkIp", $("#checkIp").val());

    //     formData.append("action", "exportData");

    //     $.ajax({

    //         url: 'application/controller/admin/receive-indent.php',

    //         type: 'POST',

    //         data: formData,

    //         dataType: "json",

    //         success: function (data) {

    //             if(data.response == "success"){

    //                 $('#export-modal').modal("hide");

    //                 $('#selectForm').submit();

    //                 setTimeout(function(){

    //                     fetchFn();

    //                 }, 1000);

    //             }

    //             topEndNotification(data.responseType, data.responseMessage);

    //             $('#loading').fadeOut(500, function () {

    //                 $(this).remove();

    //                 $('#exportSelectedButton').html('<i class="fas fa-download fa-sm"></i> Export Selected');

    //                 $('#exportSelectedButton').prop('disabled', false);

    //             });

    //         },

    //         cache: false,

    //         contentType: false,

    //         processData: false

    //     });

    // });
     // Export Selected Section End -----------------------------------------------------------------------------------------------------------------

             
               

   

    // Delete Selected Section Start ---------------------------------------------------------------------------------------------------------------

    // $("#deleteSelectedButton").click(function () {

    //     $('#deleteSelectedButton').html('<center id = "loading"><img width="18px" src = "assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

    //     $('#deleteSelectedButton').prop('disabled', true);

    //     var formData = new FormData($('form#selectForm')[0]);

    //     formData.append("checkLocation", $("#checkLocation").val());

    //     formData.append("checkIp", $("#checkIp").val());

    //     formData.append("action", "deleteSelectedData");

    //     $.ajax({

    //         url: 'application/controller/admin/receive-indent.php',

    //         type: 'POST',

    //         data: formData,

    //         dataType: "json",

    //         success: function (data) {

    //             if(data.response == "success"){

    //                 $('#delete-selected-modal').modal("hide");

    //                 setTimeout(function(){

    //                     fetchFn();

    //                 }, 1000);

    //             }

    //             topEndNotification(data.responseType, data.responseMessage);

    //             $('#loading').fadeOut(500, function () {

    //                 $(this).remove();

    //                 $('#deleteSelectedButton').html('<i class="fas fa-trash fa-sm"></i> Delete Selected');

    //                 $('#deleteSelectedButton').prop('disabled', false);

    //             });

    //         },

    //         cache: false,

    //         contentType: false,

    //         processData: false

    //     });

    // });

    // Delete Selected Section End -----------------------------------------------------------------------------------------------------------------
     $('#employee_approval_po').on('change', function( event ) {
                   
                  $.ajax({
                    url: 'getinformationsemployeeapprovalpo.php',
                    type: 'POST',
                    data: {"employee_approval_po":$(this).val()},
                    success: function(result) {
                          
                             $('#viewdetails').remove();
                             $('#employee_sec').html('<div id="viewdetails" >' + result + '</div>');
                         }
                     });
                     event.preventDefault();
                 }); 
});

