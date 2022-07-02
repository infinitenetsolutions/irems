$(function(){
    //Toast Setting Section Start ------------------------------------------------------------------------------------------------------------------
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 10000,
      timerProgressBar: false,
      onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
    const ToastFifteen = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 20000,
      timerProgressBar: false,
      onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
    const ToastAlways = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 600000,
      timerProgressBar: false,
      onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
    const ToastFive = Swal.mixin({
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
    function topEndNotificationFifteen(theme, message){
        ToastFifteen.fire({
          icon: theme,
          title: message
        })
    }
    function topEndNotificationFive(theme, message){
        ToastFive.fire({
          icon: theme,
          title: message
        })
    }
    function topEndNotificationAlways(theme, message){
        ToastAlways.fire({
          icon: theme,
          title: message
        })
    }
    //Aos creation
    AOS.init();
    //Toast Setting Section End --------------------------------------------------------------------------------------------------------------------
    //Function Callings Start ----------------------------------------------------------------------------------------------------------------------
    checkingCookieAndSession();
    //Function Callings End ------------------------------------------------------------------------------------------------------------------------
    //Checking Cookies And Sessions Section Start --------------------------------------------------------------------------------------------------
    function checkingCookieAndSession(){
        $.ajax({
            url: '../application/controller/customer/ajax.php',
            type: 'POST',
            data: "action=checkCookiesAndSessions",
            dataType: "json",
            success: function (data) {
                //Checking the Cookies And Sessions
                if(data.success) {
                    location.replace("dashboard");
                } else{
                    if(data.errorType == "emptySession"){
                        $("#lockDiv").removeClass("display-none");
                        $("#lockDp").attr("src", data.logDp);
                        $("#lockDp").attr("alt", data.logName);
                        $("#lockName").html("~ " + data.logName + " ~");
                        $("#loggerNameShow").html(data.logName);
                    }
                    if(data.errorType == "emptyCookies") 
                        $("#logDiv").removeClass("display-none");
                    if(data.errorType == "userNotFound") 
                        $("#logDiv").removeClass("display-none");
                }
            },
            cache: false,
            processData: false
        });
    }
    //Checking Cookies And Sessions Section End ----------------------------------------------------------------------------------------------------
});