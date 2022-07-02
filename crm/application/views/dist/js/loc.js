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
    function topEndNotificationFifteen(theme, message){
        ToastFifteen.fire({
          icon: theme,
          title: message
        })
    }
    //Aos creation
    AOS.init();
    //Toast Setting Section End --------------------------------------------------------------------------------------------------------------------
    getLocation();
    getIp();
    //Get Location Section Start -------------------------------------------------------------------------------------------------------------------
    function getLocation(){
        if ("geolocation" in navigator){ 
	        navigator.geolocation.getCurrentPosition(function(position){ 
                $("#logLocation").val("Lat:"+ position.coords.latitude +",Lang:"+ position.coords.longitude);
                $("#lockLocation").val("Lat:"+ position.coords.latitude +",Lang:"+ position.coords.longitude);
                $("#checkLocation").val("Lat:"+ position.coords.latitude +",Lang:"+ position.coords.longitude);
                if(typeof position === 'undefined'){
                    $("#logLocation").val("");
                    $("#lockLocation").val("");
                    $("#checkLocation").val("");
                }
            });
        } else{
            topEndNotification("error", "This System does not support this software!!!");
            return 0;
        }
    }
    //Get Location Section End ---------------------------------------------------------------------------------------------------------------------
    //Get Ip Section Start -------------------------------------------------------------------------------------------------------------------------
    function getIp(){
        $.getJSON("https://jsonip.com?callback=?", function (dataIp) {
            $("#logIp").val(dataIp.ip);
            $("#lockIp").val(dataIp.ip);
            $("#checkIp").val(dataIp.ip);
            if(typeof dataIp.ip === 'undefined'){
                $("#logIp").val("");
                $("#lockIp").val("");
                $("#checkIp").val("");
            }
        });
    }
    //Get Ip Section End ---------------------------------------------------------------------------------------------------------------------------
});