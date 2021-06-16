<?php
include 'includes/session.php';
include '../includes/db.php';
$title = "Payment Details";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM consultant WHERE id=$id AND paid=b'0'";
    $res = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)<=0){
        header("location:dashboard.php");
    }
    $row = mysqli_fetch_assoc($res);
  }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Hospital Portal | <?php echo $title?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Light Bootstrap Dashboard core CSS    -->
    <link href="../assets/css/light-bootstrap-dashboard.css?v=1.4.1" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

    <div class="wrapper">

            <?php
                include 'includes/side-panel.php'
            ?>

        <div class="main-panel">

            <?php include 'includes/header.php' ?>



               <div class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="card">
                                        <center><div class="header" style="padding:24px;">Reciept</div></center>
                                        <div class="content">
                                            <form action="con_pay.php?id=<?php echo $id?>" method="POST">
                                                <label>Report ID: <?php echo $id?></label>
                                                <br>
                                                <label>Amount: <?php echo $row['cost']+25;?></label>

                                                <div class="form-group">
                                                    <label>Mode Of Payment</label>

                                                    <select required="" data-title="Select Payment Mode" id="mode" name="mode" class="selectpicker" data-style="btn-info btn-fill" data-menu-style="dropdown-blue">
                                                        <option value="cash">Cash</option>
                                                        <option value="cheque">Cheque</option>
                                                    </select>
                                                </div>
                                                <div id="cheque">
                                                    <div class="form-group">
                                                        <label>Bank Name</label>
                                                        <input type="text" required="" name="bname" class="form-control cheque" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cheque No.</label>
                                                        <input type="text" required="" name="cheque_no" class="form-control cheque" >
                                                    </div>
                                                </div>




                                                <br>

                                                <center><button id="submit" type="submit" class="btn btn-fill btn-secondary">Submit</button></center>
                                            </form>
                                        </div>
                                    </div> <!-- end card -->

                                </div> <!--  end col-md-6  -->

                             </div>

                        </div>

                </div>

         </div>

    </div>

</body>
<script src="../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../assets/js/plugins/bootstrap-switch.js"></script>
<!--  Chartist Plugin  -->
<script src="../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
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

<?php  /*    <!--   Core JS Files  -->
<script src="../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
	<script src="../assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>


	<!--  Forms Validations Plugin -->
	<script src="../assets/js/jquery.validate.min.js"></script>

	<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
	<script src="../assets/js/moment.min.js"></script>

    <!--  Date Time Picker Plugin is included in this js file -->
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <!--  Select Picker Plugin -->
    <script src="../assets/js/bootstrap-selectpicker.js"></script>
	<script src="../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>

	<!--  Checkbox, Radio, Switch and Tags Input Plugins -->
		<script src="../assets/js/bootstrap-switch-tags.min.js"></script>

	<!--  Charts Plugin -->
	<script src="../assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/bootstrap-notify.js"></script>

    <!-- Sweet Alert 2 plugin -->
	<script src="../assets/js/sweetalert2.js"></script>

    <!-- Vector Map plugin -->
	<script src="../assets/js/jquery-jvectormap.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

	<!-- Wizard Plugin    -->
    <script src="../assets/js/jquery.bootstrap.wizard.min.js"></script>

    <!--  bootstrap Table Plugin    -->
    <script src="../assets/js/bootstrap-table.js"></script>

	<!--  Plugin for DataTables.net  -->
    <script src="../assets/js/jquery.datatables.js"></script>


    <!--  Full Calendar Plugin    -->
    <script src="../assets/js/fullcalendar.min.js"></script>

    <!-- Light Bootstrap Dashboard Core javascript and methods -->
	<script src="../assets/js/light-bootstrap-dashboard.js?v=1.4.1"></script>

	<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
        <script src="../assets/js/demo.js"></script>*/?>
        <script>
            var card = $("#card");
            var cheque = $("#cheque");
            card.hide();
            cheque.hide();
            $("#mode").change(function(){
                var val = $(this).val();
                if(val=="cash"){
                    card.hide();
                    $(".ccard").removeAttr("required");
                    cheque.hide();
                    $(".cheque").removeAttr("required");
                }else if(val=="cheque"){
                    card.hide();
                    $(".ccard").removeAttr("required");
                    cheque.show();
                    $(".cheque").attr("required","required");
                }else{
                    cheque.hide();
                    $(".cheque").removeAttr("required");
                    card.show();
                    $(".ccard").attr("required","required");
                }
            });
        </script>
</html>
