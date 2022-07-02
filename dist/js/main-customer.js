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

    checkingInternet();

    getLocation();

    getIp();

    checkOut();

    //Current Timing Section Start -----------------------------------------------------------------------------------------------------------------

    function getDate(){

        var d = new Date();

        var monthOrg = parseInt(d.getMonth());

        monthOrg++;

        return d.getDate() + '-' + monthOrg + '-' + d.getFullYear();

    }

    function getTime(){

        var d = new Date();

        return d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();

    }

    //Current Timing Section End -------------------------------------------------------------------------------------------------------------------

    //Get Location Section Start -------------------------------------------------------------------------------------------------------------------

    function getLocation(){

        if ("geolocation" in navigator){ 

	        navigator.geolocation.getCurrentPosition(function(position){ 

                $("#logLocation").val("Lat:"+ position.coords.latitude +",Lang:"+ position.coords.longitude);

                $("#secondaryLocation").val("Lat:"+ position.coords.latitude +",Lang:"+ position.coords.longitude);

                if(typeof position === 'undefined'){

                    $("#logLocation").val("");

                    $("#secondaryLocation").val("");

                }

                $("#lockLocation").val("Lat:"+ position.coords.latitude +",Lang:"+ position.coords.longitude);

                $("#secondaryLocation").val("Lat:"+ position.coords.latitude +",Lang:"+ position.coords.longitude);

                if(typeof position === 'undefined'){

                    $("#lockLocation").val("");

                    $("#secondaryLocation").val("");

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

            $("#secondaryIp").val(dataIp.ip);

            if(typeof dataIp.ip === 'undefined'){

                $("#logIp").val("");

                $("#secondaryIp").val("");

            }

            $("#lockIp").val(dataIp.ip);

            $("#secondaryIp").val(dataIp.ip);

            if(typeof dataIp.ip === 'undefined'){

                $("#lockIp").val("");

                $("#secondaryIp").val("");

            }

        });

    }

    //Get Ip Section End ---------------------------------------------------------------------------------------------------------------------------

    //Disabled All Section Start -------------------------------------------------------------------------------------------------------------------

    function disabledAll(){

        $("#logDiv").addClass("disableAll");

        $("#lockDiv").addClass("disableAll");

        $("#secondaryDiv").addClass("disableAll");

        $("#logOutFromAllDiv").addClass("disableAll");

        $("#wrapper").addClass("disableAll");

    }

    function enabledAll(){

        $("#logDiv").removeClass("disableAll");

        $("#lockDiv").removeClass("disableAll");

        $("#secondaryDiv").removeClass("disableAll");

        $("#logOutFromAllDiv").removeClass("disableAll");

        $("#wrapper").removeClass("disableAll");

    }

    //Disabled All Section End ---------------------------------------------------------------------------------------------------------------------

    //Checking Internet Connection Section Start ---------------------------------------------------------------------------------------------------

    function checkingInternet(){

        setTimeout(function(){ 

             if(navigator.onLine){

                 setTimeout(function(){ 

                    checkingInternet();

                }, 1000);

                enabledAll();

             }

             else{

                topEndNotification("error", "You Are Not ONLINE, Please Check Your Internet Connection!!!");

                setTimeout(function(){ 

                    checkingInternet();

                }, 5000);

                disabledAll();

             }

        }, 1000);

    }

    //Checking Internet Connection Section End -----------------------------------------------------------------------------------------------------

    //Checking Out Section Start -------------------------------------------------------------------------------------------------------------------

    function checkOut(){

        $.ajax({

            url: '../application/controller/customer/ajax.php',

            type: 'POST',

            data: "action=checkOut",

            dataType: "json",

            success: function (data) {

                //Checking Out from Database

                if(data.errorType == "emptySession")

                    location.reload();

                if(data.errorType == "emptyCookies")

                    location.reload();

            },

            cache: false,

            processData: false

        });

        //Call the same function after 5 sec

        setTimeout(function(){

            checkOut();

        }, 5000);

    }

    //Checking Out Section End ---------------------------------------------------------------------------------------------------------------------

    //Lock Application Section Start ---------------------------------------------------------------------------------------------------------------

    $(".lock-application").click(function(){

        disabledAll();

        $('.lock-application').html('<center id = "loading"><img width="20px" src = "../assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        var formData = {"action":"lockAppCustomer"};

        $.ajax({

            url: '../application/controller/customer/login.php',

            type: 'POST',

            data: formData,

            dataType: "json",

            success: function (data) {

                //If the User gets locked

                if(data.success) {

                    topEndNotification("info", "Locking your panel...");

                    

                    $('#loading').fadeOut(500, function () {

                        $(this).remove();

                        $(".lock-application").html("Locking...");

                        location.replace("../index");

                    });

                //If some Error presents

                } else {

                    topEndNotification("info", "Somthing went wrong, Please try again!!!");

                    $('#loading').fadeOut(500, function () {

                        $(this).remove();

                        $(".lock-application").html("Refreshing...");

                        location.reload();

                    });

                }

            }

        });

    });

    //Lock Application Section End -----------------------------------------------------------------------------------------------------------------

    //Log Out Application Section Start ------------------------------------------------------------------------------------------------------------

    $(".logOut-application").click(function(){

        disabledAll();

        $('.logOut-application').html('<center id = "loading"><img width="20px" src = "../assets/loader/ajax-loader.gif" alt="Loading..." /></center>');

        var formData = {"action":"logOutAppCustomer"};

        $.ajax({

            url: '../application/controller/customer/login.php',

            type: 'POST',

            data: formData,

            dataType: "json",

            success: function (data) {

                //If the User gets locked

                if(data.success) {

                    topEndNotification("info", "You have successfully logged out...");

                    $('#loading').fadeOut(500, function () {

                        $(this).remove();

                        $(".logOut-application").html("Redirecting...");

                        location.replace("../index");

                    });

                //If some Error presents

                } else {

                    topEndNotification("error", "Somthing went wrong, Please try again!!!");

                    $('#loading').fadeOut(500, function () {

                        $(this).remove();

                        $(".logOut-application").html('<i class="nav-icon fas fa-power-off"></i><p>Log Out</p>');

                    });

                }

            }

        });

    });

    //Log Out Application Section End --------------------------------------------------------------------------------------------------------------

});