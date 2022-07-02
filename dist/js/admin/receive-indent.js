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
                        url: 'application/view/admin/receive-indent.php',
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
                
    // Delete Selected Section End -----------------------------------------------------------------------------------------------------------------
 
})