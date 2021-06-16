<?php
    include 'includes/session.php';
    if(check()){
       header('location:dashboard.php');

    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Hospital | Login</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <style>
      .card-body{
        padding: 5px 15px 5px 15px !important;
      }
      .card-footer{
        padding: 0px 15px 10px 15px !important;
      }
    </style>
</head>

<body>
    <div class="wrapper wrapper-full-page">
        <div class="full-page  section-image" data-color="black" data-image="../assets/img/full-screen-image-2.jpg" ;>
            <div class="content">
              <center>
                <img src="../assets/img/logo.png" style="width:11%; margin-bottom:1%"/>
              </center>
                <div class="container">
                    <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                        <form class="form" id="loginForm" action="functions/login.php">
                            <div class="card card-login card-hidden">
                                <div class="card-header ">
                                    <h3 class="header text-center">Billing Login</h3>
                                </div>
                                <div class="card-body ">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" placeholder="Enter Username" name="username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" placeholder="Enter Password" name="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" id="submit" class="btn btn-default btn-wd">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../assets/js/plugins/bootstrap-switch.js"></script>
<!--  Chartist Plugin  -->
<script src="../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!--  jVector Map  -->
<script src="../assets/js/plugins/jquery-jvectormap.js" type="text/javascript"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="../assets/js/plugins/moment.min.js"></script>
<!--  DatetimePicker   -->
<script src="../assets/js/plugins/bootstrap-datetimepicker.js"></script>
<!--  Sweet Alert  -->
<script src="../assets/js/plugins/sweetalert2.min.js" type="text/javascript"></script>
<!--  Tags Input  -->
<script src="../assets/js/plugins/bootstrap-tagsinput.js" type="text/javascript"></script>
<!--  Sliders  -->
<script src="../assets/js/plugins/nouislider.js" type="text/javascript"></script>
<!--  Bootstrap Select  -->
<script src="../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
<!--  jQueryValidate  -->
<script src="../assets/js/plugins/jquery.validate.min.js" type="text/javascript"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--  Bootstrap Table Plugin -->
<script src="../assets/js/plugins/bootstrap-table.js"></script>
<!--  DataTable Plugin -->
<script src="../assets/js/plugins/jquery.dataTables.min.js"></script>
<!--  Full Calendar   -->
<script src="../assets/js/plugins/fullcalendar.min.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="../assets/js/demo.js"></script>

<script>
    $(document).ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            $('.card').removeClass('card-hidden');
            <?php
                if(isset($_GET['msg'])){
                    $msg = $_GET['msg'];
                    echo "showNotification('$msg')";
                }
            ?>
        }, 700);

        function showNotification(msg){
            $.notify({
                icon: "nc-icon nc-notification-70",
                message: msg
            },{
                type: "danger",
                delay: 2000,
                placement: {
                    from: "bottom",
                    align: "center"
                }
            });
        }

        $("#loginForm").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $("#submit").attr("disabled", true);
            $.ajax({
                   type: "POST",
                   url: url,
                   data: form.serialize(),
                   success: function(data)
                   {
                    console.log(data);
                    try{
                      var obj = JSON.parse(data);
                      if(obj.success){
                        window.location = "dashboard.php";
                      }else{
                        showNotification(obj.msg);
                      }
                      $("#submit").attr("disabled", false);
                    }catch(err){
                        showNotification("There was a problem");
                        $("#submit").attr("disabled", false);
                    }
                   },
                    error: function (data) {
                       $("#submit").attr("disabled", false);
                        showNotification(data.status+": "+data.statusText);
                    }
                 });

        });

    });
</script>

</html>
