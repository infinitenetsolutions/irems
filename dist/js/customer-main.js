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
            topEndNotification("error", "This System does not support this application!!!");
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
    //Login Section Start --------------------------------------------------------------------------------------------------------------------------
    $("#passShow").click(function(){
        $("#passShow").addClass("display-none");
        $("#passHide").removeClass("display-none");
        $("#logPass").attr('type', 'password');
    });
    $("#passHide").click(function(){
        $("#passHide").addClass("display-none");
        $("#passShow").removeClass("display-none");
        $("#logPass").attr('type', 'text');
    });
    $('form#logForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        getLocation(); //Get User's Location
        getIp(); //Get User's IP
        $('#logUser').prop( "readonly", true );
        $('#logPass').prop( "readonly", true );
        $("#primaryText").hide();
        $('#primaryLoader').append('<center id = "loading"><img width="18px" src = "../assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#logButton').prop('disabled', true);
        if($("#logLocation").val() != ""){
            //Delay the exicution for two seconds
            setTimeout(function(){
                var formData = new FormData($('form#logForm')[0]);
                formData.append("logDate", getDate());
                formData.append("logTime", getTime());
                formData.append("action", "logTry");
                $.ajax({
                    url: '../application/controller/customer/login.php',
                    type: 'POST',
                    data: formData,
                    dataType: "json",
                    success: function (data) {
                        //If the User gets Log In Access with Primary Log
                        if(data.success) {
                            topEndNotificationFifteen("success", data.message);
                            $('#logUser').removeClass("is-invalid");
                            $('#logPass').removeClass("is-invalid");
                            $('#logUser').prop( "readonly", true );
                            $('#logPass').prop( "readonly", true );
                            $('#logForm')[0].reset();
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $("#logCheckOTPButton").html("Login...");
                                location.replace(data.redirect);
                            });
                        //If some Error presents
                        } else {
                            if($('#logUser').val() == "")
                                $('#logUser').addClass("is-invalid");
                            else
                                $('#logUser').removeClass("is-invalid");
                            if($('#logPass').val() == "")
                                $('#logPass').addClass("is-invalid");
                            else
                                $('#logPass').removeClass("is-invalid");
                            //If Both the Log In Fields Are Empty
                            if(data.error == "empty")
                               $("#logDiv").effect("shake");
                            //If User enters Wrong Username
                            if(data.wrongUser)
                                $('#logUser').addClass("is-invalid");
                            //If User enters wrong Password
                            if(data.wrongPass)
                                $('#logPass').addClass("is-invalid");
                            //If User enters wrong Username more than 5 times
                            if(data.wrongUserReached){
                                $('#logForm')[0].reset();
                                $('#logUser').removeClass("is-invalid");
                            }
                            //If User enters wrong Password more than 5 times
                            if(data.wrongPassReached){
                                $('#logForm')[0].reset();
                                $('#logPass').removeClass("is-invalid");
                            }
                            //If secondry User's request already send
                            if(data.error == "alreadySend"){
                                $("#logDiv").addClass("display-none");
                                $("#secondaryDiv").removeClass("display-none");
                            }
                            //If User Logged in more than 30 times
                            if(data.error == "todayMaxReached")
                               console.log('30 Reached');
                            //If two Users already Logged In
                            if(data.error == "twoLogInReached")
                               console.log('Two Logged In Reached');
                            //If reuest Rejected from Primary User
                            if(data.error == "rejectRequest")
                               $('#logForm')[0].reset();
                            if(data.error == "error")
                               $('#logForm')[0].reset();
                            //If this Panel is already Logged In
                            if(data.error == "alreadyLogged"){
                                topEndNotificationFifteen(data.errorType, data.message);
                                $("#logDiv").addClass("display-none");
                                $("#secondaryDiv").removeClass("display-none");
                            }
                            else
                                topEndNotification(data.errorType, data.message);
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $('#logButton').prop('disabled', false);
                                $("#primaryText").show();
                                $('#logUser').prop( "readonly", false );
                                $('#logPass').prop( "readonly", false );
                            });
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }, 2000);
        } else{
            topEndNotification("info", "Please allow your location, or check your Internet Connection and reopen the application!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#logButton').prop('disabled', false);
                $("#primaryText").show();
            });
        }
    });
    $('#logCheckPhoneButton').click(function (event) {
        event.preventDefault(); //Prevent Default the Events
        getLocation(); //Get User's Location
        getIp(); //Get User's IP
        $('#logUser').prop( "readonly", true );
        $('#logPass').prop( "readonly", true );
        $('#logCheckPhoneButton').html('<center id = "loading"><img width="18px" src = "../assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#logCheckPhoneButton').prop('disabled', true);
        if($("#logLocation").val() != ""){
            //Delay the exicution for two seconds
            setTimeout(function(){
                var formData = new FormData($('form#logForm')[0]);
                formData.append("logDate", getDate());
                formData.append("logTime", getTime());
                formData.append("action", "logSendOtpTry");
                $.ajax({
                    url: '../application/controller/customer/login.php',
                    type: 'POST',
                    data: formData,
                    dataType: "json",
                    success: function (data) {
                        //If the User gets Log In Access with Primary Log
                        if(data.success) {
                            topEndNotification("warning", data.message);
                            $('#logUser').removeClass("is-invalid");
                            $('#logPass').removeClass("is-invalid");
                            $('#logUser').prop( "readonly", true );
                            $('#logPass').prop( "readonly", true );
                            // $('#logForm')[0].reset();
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $("#logCheckPhoneButton").html('Verify OTP');
                                // location.replace(data.redirect);
                                $("#logCheckPhoneDiv").addClass("display-none");
                                $("#logCheckOTPDiv").removeClass("display-none");
                            });
                        //If some Error presents
                        } else {
                            if($('#logUser').val() == "")
                                $('#logUser').addClass("is-invalid");
                            else
                                $('#logUser').removeClass("is-invalid");
                            if($('#logPass').val() == "")
                                $('#logPass').addClass("is-invalid");
                            else
                                $('#logPass').removeClass("is-invalid");
                            //If Both the Log In Fields Are Empty
                            if(data.error == "empty")
                               $("#logDiv").effect("shake");
                            //If User enters Wrong Username
                            if(data.wrongUser)
                                $('#logUser').addClass("is-invalid");
                            //If User enters wrong Password
                            if(data.wrongPass)
                                $('#logPass').addClass("is-invalid");
                            //If User enters wrong Username more than 5 times
                            if(data.wrongUserReached){
                                $('#logForm')[0].reset();
                                $('#logUser').removeClass("is-invalid");
                            }
                            //If User enters wrong Password more than 5 times
                            if(data.wrongPassReached){
                                $('#logForm')[0].reset();
                                $('#logPass').removeClass("is-invalid");
                            }
                            //If secondry User's request already send
                            if(data.error == "alreadySend"){
                                $("#logDiv").addClass("display-none");
                                $("#secondaryDiv").removeClass("display-none");
                            }
                            //If User Logged in more than 30 times
                            if(data.error == "todayMaxReached")
                               console.log('30 Reached');
                            //If two Users already Logged In
                            if(data.error == "twoLogInReached")
                               console.log('Two Logged In Reached');
                            //If reuest Rejected from Primary User
                            if(data.error == "rejectRequest")
                               $('#logForm')[0].reset();
                            if(data.error == "error")
                               $('#logForm')[0].reset();
                            //If this Panel is already Logged In
                            if(data.error == "alreadyLogged"){
                                topEndNotificationFifteen(data.errorType, data.message);
                                $("#logDiv").addClass("display-none");
                                $("#secondaryDiv").removeClass("display-none");
                            }
                            else
                                topEndNotification(data.errorType, data.message);
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $('#logCheckPhoneButton').prop('disabled', false);
                                $("#logCheckPhoneButton").html('Send OTP <i class="fas fa-paper-plane"></i>');
                                $('#logUser').prop( "readonly", false );
                                $('#logPass').prop( "readonly", false );
                            });
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }, 2000);
        } else{
            topEndNotification("info", "Please allow your location, or check your Internet Connection and reopen the application!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#logCheckPhoneButton').prop('disabled', false);
                $("#logCheckPhoneButton").html('Send OTP <i class="fas fa-paper-plane"></i>');
            });
        }
    });
    $('#logCheckOTPButton').click(function (event) {
        event.preventDefault(); //Prevent Default the Events
        getLocation(); //Get User's Location
        getIp(); //Get User's IP
        $('#logUser').prop( "readonly", true );
        $('#logPass').prop( "readonly", true );
        $('#logCheckOTPOrg').prop( "readonly", true );
        $('#logCheckOTPButton').html('<center id = "loading"><img width="18px" src = "../assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#logButton').prop('disabled', true);
        if($("#logLocation").val() != ""){
            //Delay the exicution for two seconds
            setTimeout(function(){
                var formData = new FormData($('form#logForm')[0]);
                formData.append("logDate", getDate());
                formData.append("logTime", getTime());
                formData.append("logOtp", $("#logCheckOTPOrg").val());
                formData.append("action", "logCheckOtpTry");
                $.ajax({
                    url: '../application/controller/customer/login.php',
                    type: 'POST',
                    data: formData,
                    dataType: "json",
                    success: function (data) {
                        //If the User gets Log In Access with Primary Log
                        if(data.success) {
                            topEndNotification("success", data.message);
                            $('#logUser').removeClass("is-invalid");
                            $('#logPass').removeClass("is-invalid");
                            $('#logCheckOTPOrg').removeClass("is-invalid");
                            $('#logUser').prop( "disabled", true );
                            $('#logPass').prop( "disabled", true );
                            $('#logCheckOTPOrg').prop( "disabled", true );
                            $('#logForm')[0].reset();
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $("#logCheckOTPButton").html("Login...");
                                location.replace(data.redirect);
                            });
                        //If some Error presents
                        } else {
                            if($('#logUser').val() == "")
                                $('#logUser').addClass("is-invalid");
                            else
                                $('#logUser').removeClass("is-invalid");
                            if($('#logPass').val() == "")
                                $('#logPass').addClass("is-invalid");
                            else
                                $('#logPass').removeClass("is-invalid");
                            if($('#logCheckOTPOrg').val() == "")
                                $('#logCheckOTPOrg').addClass("is-invalid");
                            else
                                $('#logCheckOTPOrg').removeClass("is-invalid");
                            //If Both the Log In Fields Are Empty
                            // if(data.error == "empty")
                            //    $("#logDiv").effect("shake");
                            //If Both the Log In Fields Are Empty
                            if(data.error == "empty")
                               $("#logCheckOTPDiv").effect("shake");
                            //If User enters Wrong Username
                            if(data.wrongUser)
                                $('#logUser').addClass("is-invalid");
                            //If User enters Wrong Username
                            if(data.incorrectOtp)
                                $('#logCheckOTPOrg').addClass("is-invalid");
                            //If User enters wrong Password
                            if(data.wrongPass)
                                $('#logPass').addClass("is-invalid");
                            //If User enters wrong Username more than 5 times
                            if(data.wrongUserReached){
                                $('#logForm')[0].reset();
                                $('#logUser').removeClass("is-invalid");
                            }
                            //If User enters wrong Password more than 5 times
                            if(data.wrongPassReached){
                                $('#logForm')[0].reset();
                                $('#logPass').removeClass("is-invalid");
                            }
                            //If secondry User's request already send
                            if(data.error == "alreadySend"){
                                $("#logDiv").addClass("display-none");
                                $("#secondaryDiv").removeClass("display-none");
                            }
                            //If User Logged in more than 30 times
                            if(data.error == "todayMaxReached")
                               console.log('30 Reached');
                            //If two Users already Logged In
                            if(data.error == "twoLogInReached")
                               console.log('Two Logged In Reached');
                            //If reuest Rejected from Primary User
                            if(data.error == "rejectRequest")
                               $('#logForm')[0].reset();
                            //If this Panel is already Logged In
                            if(data.error == "alreadyLogged"){
                                topEndNotificationFifteen(data.errorType, data.message);
                                $("#logDiv").addClass("display-none");
                                $("#secondaryDiv").removeClass("display-none");
                            }
                            else
                                topEndNotification(data.errorType, data.message);
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $('#logCheckOTPButton').prop('disabled', false);
                                $("#logCheckOTPButton").html("Verify OTP");
                                $('#logUser').prop( "readonly", false );
                                $('#logPass').prop( "readonly", false );
                                $('#logCheckOTPOrg').prop( "readonly", false );
                            });
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }, 2000);
        } else{
            topEndNotification("info", "Please allow your location, or check your Internet Connection and reopen the application!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#logCheckOTPButton').prop('disabled', false);
                $("#logCheckOTPButton").html("Verify OTP");
            });
        }
    });
    //Login Section End ----------------------------------------------------------------------------------------------------------------------------
    //Unlock Section Start -------------------------------------------------------------------------------------------------------------------------
    $('form#lockForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        getLocation(); //Get User's Location
        getIp(); //Get User's IP
        $("#lockText").hide();
        $('#lockLoader').append('<center id = "loading"><img width="18px" src = "../assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#lockButton').prop('disabled', true);
        $('#lockPass').prop( "readonly", true );
        if($("#lockLocation").val() != ""){
            //Delay the exicution for two seconds
            setTimeout(function(){
                var formData = new FormData($('form#lockForm')[0]);
                formData.append("lockDate", getDate());
                formData.append("lockTime", getTime());
                $.ajax({
                    url: '../application/controller/customer/login.php',
                    type: 'POST',
                    data: formData,
                    dataType: "json",
                    success: function (data) {
                        //If the User gets Log In Access
                        if(data.success) {
                            topEndNotification("success", data.message);
                            $('#lockPass').removeClass("is-invalid");
                            $('#lockPass').prop( "disabled", true );
                            $('#lockForm')[0].reset();
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $("#lockText").show();
                                $("#lockText").html("Unlocking...");
                                location.replace(data.redirect);
                            });
                        //If some Error presents
                        } else {
                            if($('#lockPass').val() == "")
                                $('#lockPass').addClass("is-invalid");
                            else
                                $('#lockPass').removeClass("is-invalid");
                            //If Both the Log In Fields Are Empty
                            if(data.error == "empty")
                               $("#lockDiv").effect("shake");
                            //If User enters wrong Password
                            if(data.wrongPass)
                                $('#lockPass').addClass("is-invalid");
                            //If User enters wrong Password more than 5 times
                            if(data.wrongPassReached){
                                $('#lockForm')[0].reset();
                                $('#lockPass').removeClass("is-invalid");
                            }
                            if(data.error == "error")
                               $('#lockForm')[0].reset();
                            if(data.error == "emptyCookie"){
                               $('#lockForm')[0].reset();
                               $("#lockDiv").effect("drop", 1000);
                               $("#lockDiv").addClass("display-none", 3000);
                               $("#logDiv").removeClass("display-none", 1000); 
                               $("#logDiv").show(1000); 
                            }
                            //Error Message Will Be Displayed Here
                            topEndNotification(data.errorType, data.message);
                            $('#loading').fadeOut(500, function () {
                                $(this).remove();
                                $('#lockButton').prop('disabled', false);
                                $('#lockPass').prop( "readonly", false );
                                $("#lockText").show();
                            });
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }, 2000);
        } else{
            topEndNotification("info", "Please allow your location, or check your Internet Connection and reopen the application!!!");
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#lockButton').prop('disabled', false);
                $("#lockText").show();
            });
        }
    });
    //Unlock Section End ---------------------------------------------------------------------------------------------------------------------------
    //Lock Application Section Start ---------------------------------------------------------------------------------------------------------------
    $(".lock-application").click(function(){
        disabledAll();
        $('.lock-application').html('<center id = "loading"><img width="20px" src = "../assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        var formData = {"action":"lockApp"};
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
                        location.replace("index");
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
        var formData = {"action":"logOutApp"};
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
                        location.replace("index");
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
    //Log In As A New User Section Start -----------------------------------------------------------------------------------------------------------
    $("#logNew").click(function(){
        $("#lockDiv").effect("drop", 1000);
        $("#lockDiv").addClass("display-none", 3000);
        $("#logDiv").removeClass("display-none", 1000); 
        $("#logDiv").show(1000);
    });
    //Log In As A New User Section End -------------------------------------------------------------------------------------------------------------
    //Request For Number Change Section Start ------------------------------------------------------------------------------------------------------
    $("#requestForChangeNumberViewButton").click(function(){
        $('[rel="tooltip"]').tooltip("hide");
    });
    // Add Section Start ---------------------------------------------------------------------------------------------------------------------------
    $('form#requestChangeNumberForm').submit(function (event) {
        event.preventDefault(); //Prevent Default the Events
        $('#requestChangeNumberButton').html('<center id = "loading"><img width="18px" src = "../assets/loader/ajax-loader.gif" alt="Loading..." /></center>');
        $('#requestChangeNumberButton').prop('disabled', true);
        var flag = 1;
        var errorMessage = "Please fill out the required fields!!!";
        if($("#requestChangeRequestMessage").val() == ""){
            $("#requestChangeRequestMessage").addClass("is-invalid");
            errorMessage = "Please Write a Small Request (Greater then 15 Characters)!!!";
            flag = 0;
        }else
            $("#requestChangeRequestMessage").removeClass("is-invalid");
        if($("#requestChangeNewNumber").val() == ""){
            $("#requestChangeNewNumber").addClass("is-invalid");
            errorMessage = "Please Enter new Number!!!";
            flag = 0;
        }else
            $("#requestChangeNewNumber").removeClass("is-invalid");
        if($("#requestChangeUser").val() == ""){
            $("#requestChangeUser").addClass("is-invalid");
            errorMessage = "Please Enter your Registration Number!!!";
            flag = 0;
        }else
            $("#requestChangeUser").removeClass("is-invalid");
        //------------------------------------------------------------------------------------------------------------------
        // When All Set ----------------------------------------------------------------------------------------------------
        //------------------------------------------------------------------------------------------------------------------
        if(flag == 1){
            var formData = new FormData($('form#requestChangeNumberForm')[0]);
            formData.append("checkLocation", $("#logLocation").val());
            formData.append("checkIp", $("#logIp").val());
            formData.append("logDate", getDate());
            formData.append("logTime", getTime());
            formData.append("action", "requestChangeNumber");
            $.ajax({
                url: '../application/controller/customer/login.php',
                type: 'POST',
                data: formData,
                dataType: "json",
                success: function (data) {
                    if(data.success){
                        $('#requestChangeNumberForm')[0].reset();
                        topEndNotificationFifteen("info", "Your Request Has Been Send, We will get back to you ASAP...");
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else{
                        topEndNotificationFifteen(data.responseType, data.responseMessage);
                        $('#loading').fadeOut(500, function () {
                            $(this).remove();
                            $('#requestChangeNumberButton').html('Send Request <i class="fas fa-paper-plane fa-sm"></i>');
                            $('#requestChangeNumberButton').prop('disabled', false);
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else{
            topEndNotificationFifteen("warning" , errorMessage);
            $('#loading').fadeOut(500, function () {
                $(this).remove();
                $('#requestChangeNumberButton').html('Send Request <i class="fas fa-paper-plane fa-sm"></i>');
                $('#requestChangeNumberButton').prop('disabled', false);
                $('#request-change-number-modal').animate({
                    scrollTop: $("#request-change-number-modal").offset().top
                }, 1000);
            });
        }
    });
    //Request For Number Change Section End --------------------------------------------------------------------------------------------------------
});