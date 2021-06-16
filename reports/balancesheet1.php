<!--<table border=1>
    <thead>
        <tr>
            <th rowspan="2" colspan="1" >
                Client Name
            </th>
            <th rowspan="2" colspan="1">
                Date
            </th>
            <th rowspan="1" colspan="5">
                All Appointments
            </th>
            <th rowspan="1" colspan="3" >
                Fulfilled Appointments
            </th>
        </tr>
        <tr>
            <th>Total number of individual appointments</th>
            <th >Hours Of Care Delivered</th>
            <th>Total Value</th>
            <th>Average Cost Per Hour</th>
            <th>Average Cost Per Hour Per Carer</th>
            <th>Total Number</th>
            <th>Hours Of Care Fulfilled</th>
            <th>Total Value</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>--->
<?php
    include 'includes/session.php';
    include '../includes/db.php';
    redirect();
    $title = "Balance Sheet";
	$d=date("Y-m-d");
	$query="select * from docsal where DATE(date)='".$d."'";
	$res=mysqli_query($conn,$query);
	$sal1=0;
	$sal2=0;
	$n=mysqli_num_rows($res);
	//echo $n;
	while($r=mysqli_fetch_array($res)){
		 $payd=json_decode($r['mode'],true);
		if($payd['mode']=='cash'){
			//echo $r['amount'];
		$sal1=$sal1 + $r['amount'];
	}
	else if($payd['mode']=='cheque'){
		//echo $r['amount'];
		$sal2=$sal2 + $r['amount'];
	}	
	}
	$query1="select * from staffsal where DATE(date)='".$d."'";
	$res1=mysqli_query($conn,$query1);
	while($r1=mysqli_fetch_array($res1)){
			 $payd=json_decode($r1['mode'],true);
		
		if($payd['mode']=='cash'){
			
		$sal1=$sal1 + $r1['ns'];
	}
	else if($payd['mode']=='cheque'){
		$sal2=$sal2 + $r1['ns'];
	}
	}
	$don1=0;
	$don2=0;
	$query2="select * from donations where DATE(payment_time)='".$d."'";
	$res2=mysqli_query($conn,$query2);
	while($r2=mysqli_fetch_array($res2)){
		 $payd=json_decode($r2['payment_details'],true);
		
		if($payd['mode']=='cash'){
			
		$don1=$don1 + $r2['amount'];
	}
	else if($payd['mode']=='cheque'){
		$don2=$don2 + $r2['amount'];
	}
	}

		$total=0;
		$total1=0;
		$q="select * from reports where DATE(pay_time)='".$d."'";
		$r=mysqli_query($conn,$q);
		$n=mysqli_num_rows($r);
		//echo $q;
		while($rw=mysqli_fetch_array($r)){
		$payd=json_decode($rw['payment_details'],true);
		//echo $payd['mode']."<br>";
		if($payd['mode']=='cash'){
		$t = array(json_decode($rw['base_treatment'],true)['id']);
		$b = $t[0];
		$array = json_decode($rw['treatments'],true);
		foreach($array as $i){
			array_push($t,$i['id']);
		}
		foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r2 = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r2);
        if($b == $i)
            $a = $row["amount"];
        else
            $a = 10;
        $first = true;    
        $total+=$a;
    }
    $total += 25;
    
			
		}
		if($payd['mode']=='cheque'){
		$t = array(json_decode($rw['base_treatment'],true)['id']);
		$b = $t[0];
		$array = json_decode($rw['treatments'],true);
		foreach($array as $i){
			array_push($t,$i['id']);
		}
		foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r2 = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r2);
        if($b == $i)
            $a = $row["amount"];
        else
            $a = 10;
        $first = true;    
        $total1+=$a;
    }
    $total1 += 25;
    
			}
    }
	$query = "select DISTINCT(p_id) from reports where DATE(pay_time)='".$d."'";
    $r1 = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        while($row = mysqli_fetch_array($r1)){
            $total +=10;
		}
		}
		$q10="select * from consultant where DATE(date)='".$d."'";
		$r10=mysqli_query($conn,$q10);
		while($rw10=mysqli_fetch_array($r10)){
			$payd=json_decode($rw10['mode'],true);
			if($payd['mode']=='cash'){
				//echo "jlj";
				$total=$total+$rw10['cost'];
			}
			else if($payd['mode']=='cheque'){
				$total1=$total1+$rw10['cost'];
			}
		}

		$con1=0;
	$con2=0;
	$query5="select * from vouchers where DATE(date)='".$d."'";
	$res5=mysqli_query($conn,$query5);
	while($r5=mysqli_fetch_array($res5)){
		 $payd=json_decode($r5['mode'],true);
		
		if($payd['mode']=='cash'){
			
		$con1=$con1 + $r5['amount'];
	}
	else if($payd['mode']=='cheque'){
		$con2=$con2 + $r5['amount'];
	}
	}
	include "monthcalc.php";
	include "yearcalc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Hospital | <?php echo $title?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />
    <style>
    /* Styles for wrapping the search box */

.main {
    width: 50%;
    margin: 50px auto;
}
.bt{
	padding:10px;
}
/* Bootstrap 4 text input with search icon */
.bars{
	text-align:center
}
.pull-left{
	float:none;
}
.has-search .form-control {
    padding-left: 2.375rem;
	display:none;
}


.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: none;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}

    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'includes/sidebar.php'?>
        <div class="main-panel">
            <?php include 'includes/header.php'?>
            <div class="content">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bootstrap-table">
							<div class="toolbar">
									<div class="text-center"><div class="fc-button-group">
									<button type="button" id="d" onclick="daily()" class="btn bt btn-fill btn-success">Day</button>
									<button type="button" id="m" onclick="monthly()" class="btn btn-fill bt btn-success">Month</button>
									<button type="button" id="y" onclick="yearly()" class="btn btn-fill bt btn-success">Year</button>
									</div></div>
									</div>
                                <div class="card-body table-full-width">
                                    
                                    <table id="bootstrap-table" class="table">
                                        <thead>
										<tr>
                                            <th data-field="receipt-no" data-sortable="false" class="text-center" rowspan="2" colspan="1"><b>Sr No.</b></th>
                                            <th data-field="name" data-sortable="false" rowspan="2" colspan="1"><b>Expences/Income</b></th>
                                            <th data-field="type" class="text-center" rowspan="1" colspan="2"><b>Receipt</b></th>
                                            <th data-field="amount" class="text-right" rowspan="1" colspan="2"><b>Payment</b></th>
											</tr>
											<tr>
											<th data-field="c">Cheque</th>
											<th data-field="ch">Cash</th>
											<th data-field="ca">cheque</th>
											<th data-field="cheque">Cash</th>
											</tr>
                                        </thead>
                                        <tbody>
                                     
                                            <tr>
                                                <td class="text-center">1</td>
												 <td>Salary</td>
												 <td>-</td>
												
												    <td>-</td>
													 <td id=salch><?php echo $sal2; ?> Rs</td>
													   <td id=salc><?php echo $sal1; ?> Rs</td>
													 
                                            </tr>
											<tr>
                                                <td class="text-center">2</td>
												 <td>Convections</td>
												
												    <td>-</td>
													 <td>-</td>
													  <td id=conch><?php echo $con2; ?> Rs</td>
												  <td id=conc><?php echo $con1; ?> Rs</td>
													 
                                            </tr>
											<tr>
                                                <td class="text-center">3</td>
												 <td>Donation</td>
												 <td id=donch><?php echo $don2; ?> Rs</td>
												  <td id=donc><?php echo $don1; ?> Rs</td>
												    <td>-</td>
													 <td>-</td>
													 
                                            </tr>
											<tr>
                                                <td class="text-center">4</td> 		
												 <td>Patient Collection</td>
												 <td id=colch><?php echo $total1; ?> Rs</td>
												  <td id=colc><?php echo $total; ?> Rs</td>
												    <td>-</td>
													 <td>-</td>
													 
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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

<script>
    $("#nav-sheet").addClass("active");
</script>
<script type="text/javascript">
    var $table = $('#bootstrap-table');

    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $().ready(function() {
        $table.bootstrapTable({
            toolbar: ".toolbar",
            search: true,
            pagination: true,
            searchAlign: 'left',
            pageSize: 8,
            clickToSelect: false,
            pageList: [8, 10, 25, 50, 100],

            formatShowingRows: function(pageFrom, pageTo, totalRows) {
                //do nothing here, we don't want to show the text "showing x of y from..."
            },
            formatRecordsPerPage: function(pageNumber) {
                return pageNumber + " rows visible";
            },
            icons: {
                refresh: 'fa fa-refresh',
                toggle: 'fa fa-th-list',
                columns: 'fa fa-columns',
                detailOpen: 'fa fa-plus-circle',
                detailClose: 'fa fa-minus-circle'
            }
        });

        $(window).resize(function() {
            $table.bootstrapTable('resetView');
        });


    });
    
</script>

<script type="text/javascript">
    
    $("#exportDonationForm").submit(function(e) {
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
                    var color = "danger";
                    var icon = "nc-notification-70";
                    var func = undefined;
                    var msg = "No Data Found";
                    try{
                    console.log(data);
                    var obj = JSON.parse(data);
                    $("#submit").attr("disabled", false);
                    var resp = JSON.parse(data);
                    if(resp.success){
                        color = "success";
                        icon = "nc-check-2";
                        func = function(){
                                window.location.href = resp.url; 
                            }
                        msg = "Data Found! Downloading";
                    }
                    }catch(err){
                        msg = "Error Ocurred";
                    }
                    showNotification(color, icon, msg, func);
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
function daily() {
	document.getElementById("d").style.backgroundColor = "#FFFFFF";
	document.getElementById("d").style.color = "#23CCEF";
	document.getElementById("m").style.color = "#FFFFFF";
	document.getElementById("y").style.color = "#FFFFFF";
	document.getElementById("m").style.backgroundColor = "#23CCEF";
	document.getElementById("y").style.backgroundColor = "#23CCEF";
  document.getElementById("salch").innerHTML = "<?php echo $sal2; ?> Rs";
  document.getElementById("salc").innerHTML = "<?php echo $sal1; ?> Rs";
  document.getElementById("conch").innerHTML = "<?php echo $con2; ?> Rs";
  document.getElementById("conc").innerHTML = "<?php echo $con1; ?> Rs";
  document.getElementById("donch").innerHTML = "<?php echo $don2; ?> Rs";
  document.getElementById("donc").innerHTML = "<?php echo $don1; ?> Rs";
  document.getElementById("colch").innerHTML = "<?php echo $total1; ?> Rs";
  document.getElementById("colc").innerHTML = "<?php echo $total; ?> Rs";
}
function monthly() {
	document.getElementById("m").style.backgroundColor = "#FFFFFF";
	document.getElementById("m").style.color = "#23CCEF";
	document.getElementById("d").style.color = "#FFFFFF";
	document.getElementById("y").style.color = "#FFFFFF";
	document.getElementById("y").style.backgroundColor = "#23CCEF";
	document.getElementById("d").style.backgroundColor = "#23CCEF";
  document.getElementById("salch").innerHTML = "<?php echo $salm2; ?> Rs";
  document.getElementById("salc").innerHTML = "<?php echo $salm1; ?> Rs";
  document.getElementById("conch").innerHTML = "<?php echo $conm2; ?> Rs";
  document.getElementById("conc").innerHTML = "<?php echo $conm1; ?> Rs";
  document.getElementById("donch").innerHTML = "<?php echo $donm2; ?> Rs";
  document.getElementById("donc").innerHTML = "<?php echo $donm1; ?> Rs";
  document.getElementById("colch").innerHTML = "<?php echo $totalm1; ?> Rs";
  document.getElementById("colc").innerHTML = "<?php echo $totalm; ?> Rs";
}
function yearly() {
	document.getElementById("y").style.backgroundColor = "#FFFFFF";
	document.getElementById("y").style.color = "#23CCEF";
	document.getElementById("d").style.color = "#FFFFFF";
	document.getElementById("m").style.color = "#FFFFFF";
	document.getElementById("m").style.backgroundColor = "#23CCEF";
	document.getElementById("d").style.backgroundColor = "#23CCEF";
  document.getElementById("salch").innerHTML = "<?php echo $saly2; ?> Rs";
  document.getElementById("salc").innerHTML = "<?php echo $saly1; ?> Rs";
  document.getElementById("conch").innerHTML = "<?php echo $cony2; ?> Rs";
  document.getElementById("conc").innerHTML = "<?php echo $cony1; ?> Rs";
  document.getElementById("donch").innerHTML = "<?php echo $dony2; ?> Rs";
  document.getElementById("donc").innerHTML = "<?php echo $dony1; ?> Rs";
  document.getElementById("colch").innerHTML = "<?php echo $totaly1; ?> Rs";
  document.getElementById("colc").innerHTML = "<?php echo $totaly; ?> Rs";
}
</script>
</html>