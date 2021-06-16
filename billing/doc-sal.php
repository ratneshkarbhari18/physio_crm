

<?php
include 'includes/session.php';
include '../includes/db.php';
$title = "Vouchers";

$query="select id from vouchers order by id DESC;";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);

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

    <link href="../assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <style>
    /* Styles for wrapping the search box */

.main {
    width: 50%;
    margin: 50px auto;
}

/* Bootstrap 4 text input with search icon */

.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
.mt-60{
    margin-top:60px;
}
    </style>
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
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bootstrap-table">
                                <div class="card-body table-full-width">
                                               <div class="container-fluid">
                <!--<div class="row">-->
                <!--    <div class="col-md-8">-->
                <!--        <h4>Voucher No: 	<?php echo $row['id']+1;?></h4>-->
                <!--    </div>-->
                <!--    <div class="col-md-4">-->
                <!--    <h4>Voucher Date: <?php echo date('d/m/Y');?></h4>-->
                <!--    </div>-->
                <!--    <div class="col-md-2">-->
                        
                <!--    </div>-->
                <!--    <div class="col-md-2">-->
                
                <!--    </div>-->
                <!--    <div class="col-md-2">-->

                <!--    </div>-->
                <!--    <div class="col-md-2">-->

                <!--    </div>-->
                <!--</div>-->
            </div>

    <div class="container-fluid">
	

                <div class="container-fluid mt-60" id="doc">
   <div class="container-fluid">
    <div class="row">        
        <div class="col-md-7">
     
                            
                            
                                <div class="card-body">
                                    <form class="form-horizontal " action="functions/add-docsal.php" id="addDocsalForm">
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label"> Doctor's Name</label>
                                                <div class="col-md-9">
												<select  style="margin-top:1%;" id="dd1" name="name" class="selectpicker" data-style="btn-info btn-fill btn-block" data-menu-style="dropdown-blue" style="width:29%!important;"> 
												<option value="none">Select Option</option>
												<?php
                                                $query = "SELECT id, name FROM users WHERE type='doctor' or type='consultant'";
                                                $res = mysqli_query($conn,$query);
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $id = $row['id'];
                                                    // $q = "SELECT * FROM reports WHERE doc_id=$id AND paid=1";
                                                    // $r = mysqli_query($conn, $q);
                                                    // $count = mysqli_num_rows($r);
                                                    // $amount = 0;
                                                    // while($rw = mysqli_fetch_assoc($r)){
                                                      //  $amount+=calculate($rw['id'],$rw['p_id'],$rw['base_treatment'],$rw['treatments']);
                                                    // }
                                            ?>
														
												<?php
												echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                                }
                                            ?>
                                                        
                        </select>
                                                </div>
                                            </div>
											 </div>
             <!--                               <div class="form-group">-->
             <!--                               <div class="row">-->
             <!--                                   <label class="col-md-3 control-label ">Total No of Patient Treated</label>-->
             <!--                                   <div class="col-md-9">-->
													<!--<input type="number" name="nop" placeholder="No of patients" required="" class="form-control" style="margin-top:9px;">-->
             <!--                                   </div>-->
             <!--                               </div>-->
             <!--                           </div>-->
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Doctor's Renumeration</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="amount" placeholder="Renumeration" required="" class="form-control">
                                                </div>
                                            </div>
                                       </div>
									   <div class="form-group">
											<div class="row">
                                                    <label class="col-md-3 control-label" >Mode Of Payment</label>
                                                    <div class="col-md-9">
                                                    <select required="" data-title="Select Payment Mode" id="mode" name="mode" class="selectpicker" data-style="btn-info btn-fill" data-menu-style="dropdown-blue">
                                                        <option value="cash">Cash</option>
                                                        <option value="cheque">Cheque</option>
                                                    
                                                    </select>
													  </div>
                                                </div>
												  </div>

                                                <div id="cheque">
                                                    <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Bank Name</label>
														<div class="col-md-9">
                                                        <input type="text" required="" placeholder="Bank Name" name="bname" class="form-control cheque" >
                                                    </div>
													  </div>
													    </div>
													    <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Branch</label>
														<div class="col-md-9">
                                                        <input type="text" required="" placeholder="Bank Branch Name" name="branch" class="form-control cheque" >
                                                    </div>
													  </div>
													    </div>
                                                    <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Cheque No.</label>
														<div class="col-md-9">
                                                        <input type="text" required="" placeholder="Cheque Number" name="cheque_no" class="form-control cheque" >
                                                    </div>
                                                </div>
												  </div>
												  <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Cheque Date</label>
														<div class="col-md-9">
                                                        <input type="date" required="" placeholder="Cheque Date" name="cheque_date" class="form-control cheque" >
                                                    </div>
                                                </div>
												  </div>
												    </div>
									   
                                      
                                   
                                    
                                </div>
                                <div class="card-footer ">
                                    <div class="col-md-float-right">
                                        <center>
                                        <button type="submit" id="submit" class="btn btn-fill btn-info">Submit</button>
                                        <button type="button" id="print2" onclick="window.location='preview_voucher.php?s=doc';" disabled="true" class="btn btn-fill btn-info" style="background-color:#17a2b8;cursor: not-allowed;">Print</button>
                                        </center>
                                    </div>
                                </div>
								</form>
                           
                        </div>
                        </div>
                    </div>
                </div>


<!--	<div id="expen" style="display:none;">-->
<!--        <div class="row">-->
<!--            <div class="col-md-4">-->
<!--                <h5>Select Expense Type</h5>-->
<!--            </div>  -->
<!--                <div class="col-md-4">                                                -->
<!--                    <select data-title="Select Option"  style="margin-top:1%;" id="dd" name="currency" class="selectpicker" data-style="btn-info btn-fill btn-block" data-menu-style="dropdown-blue" style="width:29%!important;"> -->
														
<!--														<option value="Doctor Salary">Doctor Renumeration</option>-->
<!--                                                        <option value="Staff Salary">Staff Renumeration</option>-->
<!--														<option value="ad">Advance</option>-->
<!--                                                        <option value="Print & stationary">Print & stationary</option>-->
<!--                                                        <option value="Electricity Bill">Electricity Bill</option>-->
<!--                                                        <option value="Other Expense">Other Expense</option>-->
<!--                                                        <option value="Repairing">Repairing</option>-->
<!--                                                        <option value="Medicine">Medicine</option>-->
<!--                                                        <option value="Traveling">Traveling</option>-->
<!--                                                        <option value="Clothes washing & buying">Clothes washing & buying</option>-->
<!--                                                        <option value="Snacks">Snacks</option>-->
<!--                                                        <option value="Cleaning">Cleaning</option>-->
<!--                                                        <option value="Telephone">Telephone</option>-->
<!--                                                        <option value="Accounting Charge">Accounting Charge</option>-->
<!--                                                        <option value="Rent">Rent</option>-->
<!--                                                        <option value="Advertisement">Advertisement</option>-->
<!--                                                        <option value="Festivals / Programs">Festivals / Programs</option>-->
<!--                                                        <option value="Insurance Policies / Taxes">Insurance Policies / Taxes</option>-->
<!--                                                        <option value="BankOverDraft">BankOverDraft</option>-->
                                                        
<!--                        </select>-->

<!--                 </div>-->
<!--            <div class="col-md-6">-->
<!--<div id="beds">-->
<!--                                        </div>-->
<!--                                        <br>-->
            
<!--        </div>-->
    
<!--</div>                             -->
<!--<br>-->




<!--					</div>-->
					</div>
                                    
                                </div>
                            </div>
                        </div>
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
<script type="text/javascript">
$("#nav-doc").addClass("active");
    $(function() {
        
        $(".material-icons").html("<span class='pe-7s-close'></span>");
        $('#vout').change(function(){
			var selected = $('#vout').find('option:selected', this);
			var s=selected.val();
			if(s=="ex"){
				$("#expen").css('display','block');
				$("#income").hide();
				$("#bank").hide();
				$("#jv").hide();
				// $("#bank").hide();
				$("#doc").hide();
				$("#staff").hide();
				$("#ad").hide();
				$("#def").hide();
			}
			else if(s=="in"){
				$("#income").css('display','block');
				$("#expen").hide();
				$("#bank").hide();
				$("#jv").hide();
				// $("#bank").hide();
				$("#doc").hide();
				$("#staff").hide();
				$("#ad").hide();
				$("#def").hide();
			}
			else if(s=="cont"){
				$("#bank").css('display','block');
				$("#income").hide();
				$("#expen").hide();
				$("#jv").hide();
				// $("#bank").hide();
				$("#doc").hide();
				$("#staff").hide();
				$("#ad").hide();
				$("#def").hide();
			}
			else if(s=='jv'){
				$("#jv").css('display','block');
				$("#bank").hide();
				$("#income").hide();
				$("#expen").hide();
				// $("#bank").hide();
				$("#doc").hide();
				$("#staff").hide();
				$("#ad").hide();
				$("#def").hide();
			}
			
			else if(s=="Bank"){
				$("#bank").css('display','block');
				$("#def").hide();
				$("#ad").hide();
				$("#doc").hide();
				$("#staff").hide();
				$("#income").hide();
				// $("#bank").hide();
				$("#jv").hide();
				
	
           }else if(s=="Doctor Salary"){
				$("#doc").css('display','block');
				$("#bank").hide();
				$("#def").hide();
				$("#staff").hide();
				$("#ad").hide();
				$("#income").hide();
				// $("#bank").hide();
				$("#jv").hide();
			}
			else if(s=="Staff Salary"){
				$("#doc").hide();
				$("#bank").hide();
				$("#def").hide();
				$("#staff").css('display','block');
				$("#ad").hide();
				$("#income").hide();
				// $("#bank").hide();
				$("#jv").hide();
			}
			else if(s=="ad"){
				$("#ad").css('display','block');
				$("#bank").hide();
				$("#def").hide();
				$("#staff").hide();
				$("#doc").hide();
				$("#income").hide();
				// $("#bank").hide();
				$("#jv").hide();
			}
		   else{
				$("#def").css('display','block');
				// $("#abc").val(s);
				$("#bank").hide();
				$("#doc").hide();
				$("#staff").hide();
				$("#ad").hide();
				$("#income").hide();
				// $("#bank").hide();
				$("#jv").hide();
			}
		});
        $('#dd').change(function() {
            var selected = $('#dd').find('option:selected', this);
			var s=selected.val();
			
			console.log(s);
            $("#beds").html("");
            var bed = $("#beds");
			if(s=="Bank"){
				$("#bank").css('display','block');
				$("#def").hide();
				$("#ad").hide();
				$("#doc").hide();
				$("#staff").hide();
				
	
           }else if(s=="Doctor Salary"){
				$("#doc").css('display','block');
				$("#bank").hide();
				$("#def").hide();
				$("#staff").hide();
				$("#ad").hide();
			}
			else if(s=="Staff Salary"){
				$("#doc").hide();
				$("#bank").hide();
				$("#def").hide();
				$("#staff").css('display','block');
				$("#ad").hide();
			}
			else if(s=="ad"){
				$("#ad").css('display','block');
				$("#bank").hide();
				$("#def").hide();
				$("#staff").hide();
				$("#doc").hide();
			}
		   else{
				$("#def").css('display','block');
				$("#abc").val(s);
				$("#bank").hide();
				$("#doc").hide();
				$("#staff").hide();
				$("#ad").hide();
			}
        });

   
    });
</script>
<script type="text/javascript">

    $("#addVoucherForm").submit(function(e) {
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
                                //window.location.href = 'vouchers.php'; 
								$("#print").attr("disabled", false);
								$("#print").css("cursor", 'pointer');
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
<script type="text/javascript">

    $("#addBankForm").submit(function(e) {
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
                                //window.location.href = 'vouchers.php'; 
								$("#print1").attr("disabled", false);
								$("#print1").css("cursor", 'pointer');
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
<script type="text/javascript">

    $("#addDocsalForm").submit(function(e) {
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
                                //window.location.href = 'vouchers.php'; 
								$("#print2").attr("disabled", false);
								$("#print2").css("cursor", 'pointer');
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
<script type="text/javascript">

    $("#addStaffsalForm").submit(function(e) {
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
                                //window.location.href = 'vouchers.php'; 
								$("#print3").attr("disabled", false);
								$("#print3").css("cursor", 'pointer');
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
<script type="text/javascript">

    $("#addinForm").submit(function(e) {
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
                                //window.location.href = 'vouchers.php'; 
								$("#print4").attr("disabled", false);
								$("#print4").css("cursor", 'pointer');
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
<script type="text/javascript">

    $("#addjvForm").submit(function(e) {
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
                                //window.location.href = 'vouchers.php'; 
								$("#print5").attr("disabled", false);
								$("#print5").css("cursor", 'pointer');
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
<script type="text/javascript">

    $("#addadForm").submit(function(e) {
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
                                //window.location.href = 'vouchers.php'; 
								$("#print6").attr("disabled", false);
								$("#print6").css("cursor", 'pointer');
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
<script>
var card = $("#card");
            var cheque = $("#cheque");
            card.hide();
            $("[id=cheque]").hide();
            $("#patient").hide();
            $("[id=mode]").change(function(){
                var val = $(this).val();
                if(val=="cash"){        
                    card.hide();
                    $(".ccard").removeAttr("required");
                    $("[id=cheque]").hide();
                    $(".cheque").removeAttr("required");
                }else if(val=="cheque"){
                    card.hide();
                    $(".ccard").removeAttr("required");
                    $("[id=cheque]").show();
                    // $(".cheque").attr("required","required");
                }else{
                    // $("[id=cheque]").hide();
                    // $(".cheque").removeAttr("required");
                    // card.show();
                    // $(".ccard").attr("required","required");
                }
            });
</script>




