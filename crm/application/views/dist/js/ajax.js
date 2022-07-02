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
    setTimeout(function(){
            checkingCookieAndSession();
    }, 5000);
    //Function Callings End ------------------------------------------------------------------------------------------------------------------------
    //Checking Cookies And Sessions Section Start --------------------------------------------------------------------------------------------------
    function checkingCookieAndSession(){
        $.ajax({
            url: 'application/controller/admin/ajax.php',
            type: 'POST',
            data: "action=checkCookiesAndSessionsInner",
            dataType: "json",
            success: function (data) {
                //Checking the Cookies And Sessions
                if(data.errorType == "emptySession"){
                    $("#wrapper").remove();
                    location.replace("index");
                }
                if(data.errorType == "emptyCookies"){
                    $("#wrapper").remove();
                    location.replace("index");
                }
            },
            cache: false,
            processData: false
        });
    }
    //Checking Cookies And Sessions Section End ----------------------------------------------------------------------------------------------------
});