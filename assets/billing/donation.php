<?php
include 'includes/session.php';
include '../includes/db.php';
$title = "Donate";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png">
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

                                    <div class="card stacked-form">
                                        <div class="card-header"><h4 class="card-title">Donation Form</h4></div>
                                        <div class="card-body">
                                            <form action="functions/donation.php" id="donationForm" method="POST">

                                                <div class="form-group">
                                                    <label>Type of Donor</label>
                                                    
                                                    <select required="" data-title="Select Type Of Donor" id="donor" name="donor" class="selectpicker" data-style="btn-info btn-fill" data-menu-style="dropdown-blue">
                                                        <option value="patient">Patient</option>
                                                        <option value="organization">Organization</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                                
                                                <div id="patient" class="form-group">
                                                <label>Patient</label>
                                                    <select required="" data-title="Select Patient" id="p_id" name="p_id" class="selectpicker patient" data-style="btn-info btn-fill" data-menu-style="dropdown-blue">
                                                        <?php
                                                            $query = "SELECT p.id,p.lname,p.fname,d.amount FROM donations d, patients p WHERE d.p_id=p.id AND d.paid=b'0'";
                                                            $res = mysqli_query($conn,$query);
                                                            while($row = mysqli_fetch_assoc($res)){
                                                        ?>
                                                        <option value="<?php echo $row['id']?>" data-amount="<?php echo $row['amount']?>"><?php echo $row['fname']." ".$row['lname']?></option>
                                                            <?php }?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Donation Amount</label>
                                                    <input type="number" required="" id="donation" name="donation" min="0" class="form-control" >
                                                </div>

                                                <div class="form-group">
                                                    <label>Donor Name</label>
                                                    <input type="text" required="" id="name" name="name" class="form-control cheque" >
                                                </div>

                                                <div class="form-group">
                                                    <label>Mode Of Payment</label>
                                                    
                                                    <select required="" data-title="Select Payment Mode" id="mode" name="mode" class="selectpicker" data-style="btn-info btn-fill" data-menu-style="dropdown-blue">
                                                        <option value="cash">Cash</option>
                                                        <option value="cheque">Cheque</option>
                                                        <option value="card">Credit/Debit Card</option>
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
                                                <div id="card">
                                                    <div class="form-group">
                                                        <label>Card No.</label>
                                                        <input type="text" required="" name="card_no" class="form-control ccard" >
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
<?php/* <script src="../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
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
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script> */?>
     <!--   Core JS Files  -->
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

	<script src="../assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>

	<!--  Checkbox, Radio, Switch and Tags Input Plugins -->
		<script src="../assets/js/bootstrap-switch-tags.min.js"></script>

	<!--  Charts Plugin -->
	<script src="../assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <!--<script src="../assets/js/bootstrap-notify.js"></script> -->
	<script src="../assets/js/plugins/bootstrap-notify.js"></script>

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
        <script src="../assets/js/demo.js"></script> 
		
        <script>
        $("#nav-donation").addClass("active");
            var card = $("#card");
            var cheque = $("#cheque");
            card.hide();
            cheque.hide();
            $("#patient").hide();
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
            $("#donor").change(function(){
                var val = $(this).val();
                if(val=="patient"){        
                    $("#patient").show();
                    $(".patient").attr("required","required");
                    $("#donation").attr("disabled","disabled");
                    $("#name").attr("disabled","disabled");
                    $("#name").val("");
                    $("#donation").val("");
                }else{
                    $("#patient").hide();
                    $(".patient").val("").selectpicker("refresh");
                    $(".patient").removeAttr("required");
                    $("#donation").removeAttr("disabled");
                    $("#name").removeAttr("disabled");
                }
            });
            
            $("#p_id").change(function(){
                var p = $(this).children("option:selected");
                $("#donation").val(p.data("amount"));
                $("#name").val(p.html());
            });
        $("#donationForm1").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                   type: "POST",
                   url: url,
                   data: form.serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                    console.log(data);
                    swal(data).then(function(){
                        location.reload();
                    });
                   }
                 });

        });
        </script>
		<script type="text/javascript">

    $("#donationForm").submit(function(e) {
		var selected = $(this).find('option:selected', this);
		var s=selected.val();
	
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        $("#submit").attr("disabled", true);
        $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    console.log(data);
                    var obj = JSON.parse(data);
                    $("#submit").attr("disabled", false);
                    var color = "danger";
                    var icon = "nc-notification-70";
                    var func = undefined;
                    if(obj.success){
                        color = "success";
                        icon = "nc-check-2";
                        func = function(){
                               window.location.href = 'donation.php'; 
								//$("#print1").attr("disabled", false);
								//$("#print1").css("cursor", 'pointer');
                            }
                    }
                    showNotification(color, icon, obj.msg, func);
                },
                error: function (data) {
                    $("#submit").attr("disabled", false);
                    showNotification("danger", "nc-notification-70", data.status+": "+data.statusText);
                }
                });

    });
    
    function showNotification(color, icon, msg, func=undefined){
        $.notify({
            icon: "nc-icon " + icon,
            message: msg
        },{
            type: color,
            delay: 1000,
            placement: {
                from: "bottom",
                align: "center"
            },
            onClose: func
        });
    }
</script>

</html>
