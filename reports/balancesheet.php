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
error_reporting(E_ERROR | E_PARSE);

    include 'includes/session.php';
    include '../includes/db.php';
    redirect();
    $ft=0;
    $ftly=0;
    $fti=0;
    $ftlyi=0;
    $title = "Balance Sheet";
    $d=date("Y-m-d");
    $ly = (int)date("Y") - 1;
    $queryly="select * from docsal where  YEAR(date)=".$ly."";
	$resly=mysqli_query($conn,$queryly);
	$salydly=0;
	$salysly=0;
	$n=mysqli_num_rows($resly);
	//echo $n;
	while($rly=mysqli_fetch_array($resly)){
		 $payd=json_decode($rly['mode'],true);
		$salydly=$salydly + $rly['amount'];
	}
	$ftly=$salydly;
	$query1ly="select * from staffsal where  YEAR(date)=".$ly."";
	$res1ly=mysqli_query($conn,$query1ly);
	while($r1ly=mysqli_fetch_array($res1ly)){
			 $payd=json_decode($r1ly['mode'],true);
		
		$salysly=$salysly + $r1ly['ns'];

	}
	$ftly=$ftly+$salysly;
	$query="select * from docsal where  YEAR(date)=YEAR('".$d."')";
	$res=mysqli_query($conn,$query);
	$salyd=0;
	$salys=0;
	$n=mysqli_num_rows($res);
	//echo $n;
	while($r=mysqli_fetch_array($res)){
		 $payd=json_decode($r['mode'],true);
		$salyd=$salyd + $r['amount'];
	}
	$ft+=$salyd;
	$query1="select * from staffsal where  YEAR(date)=YEAR('".$d."')";
	$res1=mysqli_query($conn,$query1);
	while($r1=mysqli_fetch_array($res1)){
			 $payd=json_decode($r1['mode'],true);
		
		$salys=$salys + $r1['ns'];

	}
	$ft+=$salys;
	$dony=0;
	$query2="select * from donations where  YEAR(payment_time)=YEAR('".$d."')";
	$res2=mysqli_query($conn,$query2);
	while($r2=mysqli_fetch_array($res2)){
		$dony=$dony + $r2['amount'];
	
	}
    $fti+=$dony;
		$totaly=0;
		$q="select * from reports where  YEAR(pay_time)=YEAR('".$d."')";
		$r=mysqli_query($conn,$q);
		$n=mysqli_num_rows($r);
		//echo $q;
		while($rw=mysqli_fetch_array($r)){
		$t = array(json_decode($rw['base_treatment'],true)['id']);
		$b = $t[0];
		if($rw['covid']==10){
		    $totaly+=10;
		}
		$array = json_decode($rw['treatments'],true);
		foreach($array as $i){
			array_push($t,$i['id']);
		}
		foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r2 = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r2);
        if($b == $i){
            $a = $row["amount"];}
        else{
            $a = 10;}
        $first = true;    
        $totaly+=$a;
    }
    $totaly += 25;
    }
    $nf=0;
    $query = "select DISTINCT(p_id) from reports where  YEAR(pay_time)=YEAR('".$d."')";
    $r1 = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        while($row = mysqli_fetch_array($r1)){
            $nf +=10;
		}
		}
		$fti+=$nf;
		$q10="select * from consultant where YEAR(date)=YEAR('".$d."')";
		$r10=mysqli_query($conn,$q10);
		while($rw10=mysqli_fetch_array($r10)){
		    if($rw10['covid']==10){
		    $totaly+=10;
		}
				$totaly=$totaly+$rw10['cost'];
		}
    $fti+=$totaly;
    $donly=0;
	$query2ly="select * from donations where  YEAR(payment_time)=".$ly."";
	$res2ly=mysqli_query($conn,$query2ly);
	while($r2ly=mysqli_fetch_array($res2ly)){
		$donly=$donly + $r2ly['amount'];
	
	}
    $ftlyi+=$donly;
		$totalyly=0;
		$qly="select * from reports where  YEAR(pay_time)=".$ly."";
		$rly=mysqli_query($conn,$qly);
		$nly=mysqli_num_rows($rly);
		//echo $q;
		while($rw=mysqli_fetch_array($rly)){
		$t = array(json_decode($rw['base_treatment'],true)['id']);
		if($rw['covid']==10){
		    $totalyly+=10;
		}
		$b = $t[0];
		$array = json_decode($rw['treatments'],true);
		foreach($array as $i){
			array_push($t,$i['id']);
		}
		foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r2 = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r2);
        if($b == $i){
            $a = $row["amount"];}
        else{
            $a = 10;}
        $first = true;    
        $totalyly+=$a;
    }
    $totalyly += 25;
    }
    $nfly=0;
    $queryly = "select DISTINCT(p_id) from reports where  YEAR(pay_time)=".$ly."";
    $r1ly = mysqli_query($conn,$queryly);
    if(mysqli_affected_rows($conn)>0){
        while($row = mysqli_fetch_array($r1ly)){
            $nfly +=10;
		}
		}
		$ftlyi+=$nfly;
		$q10ly="select * from consultant where YEAR(date)=".$ly."";
		$r10ly=mysqli_query($conn,$q10);
		while($rw10=mysqli_fetch_array($r10ly)){
				$totalyly=$totalyly+$rw10['cost'];
				if($rw10['covid']==10){
		    $totalyly+=10;
		}
		}
	$ftlyi+=$totalyly;
	//include "monthcalc.php";
	//include "yearcalc.php";
	                            $op=array("Printing and stationary",
                                "Electricity Bill",
                                "Other Expense",
                                "Repairing",
                                "Medicine",
                                "Traveling",
                                "Clothes washing and buying",
                                "Snacks",
                                "Cleaning",
                                "Telephone",
                                "Accounting Charge",
                                "Rent",
                               "Advertisement",
                                "Festivals / Programs",
                                "Insurance Policies / Taxes",
                                "BankOverDraft");
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
                        <form action="functions/export-bal.php" id="exportDonationForm">            
                        <div class="col-md-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <input type="text" required="" name="from" class="form-control datepicker" placeholder="Select Year">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card-body">
                                            <button id="submit" type="submit" class="btn btn-fill btn-success">
                                                Export To Excel    
                                                <span class="btn-label btn-label-right">
                                                    <i class="fa fa-table"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="padding:0px">
                            <div class="card bootstrap-table" style="border-right: none;">
                                <div class="card-body table-full-width">
                                    <table id="bootstrap-table" class="table">
                                        <thead>
										<tr>
                                            <th data-field="a" class="text-center"  rowspan="1" colspan="1"><b><?php echo $ly; ?></b></th>
                                            <th data-field="b" data-sortable="false" rowspan="2" colspan="1"><b>Expences</b></th>
                                            <th data-field="c"  rowspan="1" colspan="1"><b><?php echo (int)date("Y"); ?></b></th>
                                            <!--<th data-field="d"  rowspan="1" colspan="1"><b><?php echo $ly; ?></b></th>-->
                                            <!--<th data-field="e" data-sortable="false" rowspan="2" colspan="1"><b>Income</b></th>-->
                                            <!--<th data-field="f"  rowspan="1" colspan="1"><b><?php echo (int)date("Y"); ?></b></th>-->
											</tr>
											<tr>
											<th class="text-center" data-field="c" >Rupee</th>
											<th data-field="fsc" >Rupee</th>
											<!--<th data-field="c1" >money</th>-->
											<!--<th data-field="fsc1" >money</th>-->
											</tr>
                                        </thead>
                                        <tbody>
                                     
                                            <tr>
                                                <td class="text-center"><?php echo $salydly; ?> Rs</td>
												 <td>Doctor Salary</td>
												 <td><?php echo $salyd; ?> Rs</td>
												
												  <!--  <td>-</td>-->
													 <!--<td id=salch>Patient Collection</td>-->
													 <!--  <td id=salc><?php echo $totaly; ?> Rs</td>-->
													 
                                            </tr>
                                            <tr>
                                                <td class="text-center"><?php echo $salysly; ?> Rs</td>
												 <td>Staff Salary</td>
												 <td><?php echo $salys; ?> Rs</td>
												
												  <!--  <td>-</td>-->
													 <!--<td id=salch> Rs</td>-->
													 <!--  <td id=salc> Rs</td>-->
													 
                                            </tr>
                                            
                                            <?php
                                            foreach($op as $i){
                                                //echo $i;
                                                 $query5="select SUM(amount)as am,type from vouchers where YEAR(date)=".$ly." and type='".$i."' group by type";
	                                           $res5=mysqli_query($conn,$query5);
	                                           $r5=mysqli_fetch_array($res5);
	                                           
	                                           $query6="select SUM(amount)as am,type from vouchers where  YEAR(date)=YEAR('".$d."') and type='".$i."' group by type";
                                              $res6=mysqli_query($conn,$query6);
                                              $r6=mysqli_fetch_array($res6);
	                                           echo ' <tr>';
	                                           if($r5==null){
	                                               echo ' <td class="text-center">0 Rs</td>';
	                                           }
	                                           else{
	                                               echo ' <td class="text-center">'.$r5['am'].' Rs</td>';
	                                           }
	                                          
	                                           
	                                           echo '<td>'.$i.'</td>';
	                                           if($r6==null){
	                                               echo ' <td>0 Rs</td>';
	                                           }
	                                           else{
	                                               echo '<td>'.$r6['am'].' Rs</td>';
	                                           }
	                                            
	                                           
	                                           
	                                          echo ' </tr>
	                                           ';
	                                           $ftly=$ftly + $r5['am'];
	                                           $ft=$ft + $r6['am'];
                                            }
                                            
            //                                 $query5="select SUM(amount)as am,type from vouchers where YEAR(date)=".$ly." group by type";
	           //                             $res5=mysqli_query($conn,$query5);
	                                        
            //                             	while($r5=mysqli_fetch_array($res5)){
                                        	    
            //                             		echo '
            //                             		<tr>
            //                                     <td class="text-center">'.$r5['am'].' Rs</td>
												//  <td>'.$r5['type'].'</td>';
												//  $f=1;
												//  $ftly=$ftly + $r5['am'];
												//  $query6="select SUM(amount)as am,type from vouchers where  YEAR(date)=YEAR('".$d."') group by type";
            //                                     	$res6=mysqli_query($conn,$query6);
            //                                     	while($r6=mysqli_fetch_array($res6)){
            //                                     		if($r6['type']== $r5['type']){
            //                                     			echo '<td>'.$r6['am'].' Rs</td>';
            //                                     			$ft=$ft + $r6['am'];
            //                                     			$f=0;
            //                                     			break;
            //                                     	}
            //                                     	else{
            //                                     	    $f=1;
            //                                     	}
            //                                     	}
            //                                     	if($f != 0){
            //                                     	    echo '<td>0 Rs</td>';
            //                                     	}
												//  echo '
												   
													 
            //                                 </tr>
            //                             		';
                                        	
            //                             	}
                                            ?>
											<tr>
                                                <td class="text-center"><?php echo $ftly; ?> Rs</td>
												 <td></td>
												    <td><?php echo $ft; ?> Rs</td>
													 
                                            </tr>
											<!--<tr>-->
           <!--                                     <td class="text-center">3</td>-->
											<!--	 <td>Donation</td>-->
											<!--	 <td id=donch><?php echo $don2; ?> Rs</td>-->
											<!--	  <td id=donc><?php echo $don1; ?> Rs</td>-->
											<!--	    <td>-</td>-->
											<!--		 <td>-</td>-->
													 
           <!--                                 </tr>-->
											<!--<tr>-->
           <!--                                     <td class="text-center">4</td> 		-->
											<!--	 <td>Patient Collection</td>-->
											<!--	 <td id=colch><?php echo $total1; ?> Rs</td>-->
											<!--	  <td id=colc><?php echo $total; ?> Rs</td>-->
											<!--	    <td>-</td>-->
											<!--		 <td>-</td>-->
													 
           <!--                                 </tr>-->
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding:0px">
                            <div class="card bootstrap-table" style="border-left: none;">
                                <div class="card-body table-full-width">
                                    <table id="bootstrap-table1" class="table">
                                        <thead>
										<tr>
                                            <!--<th data-field="a" class="text-center"  rowspan="1" colspan="1"><b><?php echo $ly; ?></b></th>-->
                                            <!--<th data-field="b" data-sortable="false" rowspan="2" colspan="1"><b>Expences</b></th>-->
                                            <!--<th data-field="c"  rowspan="1" colspan="1"><b><?php echo (int)date("Y"); ?></b></th>-->
                                            <th data-field="d" class="text-center"  rowspan="1" colspan="1"><b><?php echo $ly; ?></b></th>
                                            <th data-field="e" data-sortable="false" rowspan="2" colspan="1"><b>Income</b></th>
                                            <th data-field="f"  rowspan="1" colspan="1"><b><?php echo (int)date("Y"); ?></b></th>
											</tr>
											<tr>
											<!--<th class="text-center" data-field="c" >money</th>-->
											<!--<th data-field="fsc" >money</th>-->
											<th class="text-center" data-field="c1" >Rupee</th>
											<th data-field="fsc1" >Rupee</th>
											</tr>
                                        </thead>
                                        <tbody>
                                     
                                            <tr>
             <!--                                   <td class="text-center"><?php echo $salydly; ?> Rs</td>-->
												 <!--<td>Doctor Salary</td>-->
												 <!--<td><?php echo $salyd; ?> Rs</td>-->
												
												    <td class="text-center"><?php echo $totalyly; ?> Rs</td>
													 <td id=salch>Patient Collection</td>
													   <td id=salc><?php echo $totaly; ?> Rs</td>
													 
                                            </tr>
                                            <tr>
             <!--                                   <td class="text-center"><?php echo $salysly; ?> Rs</td>-->
												 <!--<td>Staff Salary</td>-->
												 <!--<td><?php echo $salys; ?> Rs</td>-->
												
												    <td class="text-center"><?php echo $nfly; ?> Rs</td>
													 <td id=salch>New Patient Fee</td>
													   <td id=salc><?php echo $nf; ?> Rs</td>
													 
                                            </tr>
                                            <tr>
             <!--                                   <td class="text-center"><?php echo $salysly; ?> Rs</td>-->
												 <!--<td>Staff Salary</td>-->
												 <!--<td><?php echo $salys; ?> Rs</td>-->
												
												    <td class="text-center"><?php echo $donly; ?> Rs</td>
													 <td id=salch>Donations</td>
													   <td id=salc><?php echo $dony; ?> Rs</td>
													 
                                            </tr>
                                            <?php
                                            for ($i=0;$i<sizeof($op)-1;$i++){
                                                echo '
                                        		<tr>
                                                <td class="text-center">-</td>
												 <td>-</td>';
                                                echo '<td>-</td>';
												 echo '</tr>';
                                            }
                                        		
                    
                                            ?>
											<tr>
                                                <td class="text-center"><?php echo $ftlyi; ?> Rs</td>
												 <td></td>
												    <td><?php echo $fti; ?> Rs</td>
													 
                                            </tr>
											<!--<tr>-->
           <!--                                     <td class="text-center">3</td>-->
											<!--	 <td>Donation</td>-->
											<!--	 <td id=donch><?php echo $don2; ?> Rs</td>-->
											<!--	  <td id=donc><?php echo $don1; ?> Rs</td>-->
											<!--	    <td>-</td>-->
											<!--		 <td>-</td>-->
													 
           <!--                                 </tr>-->
											<!--<tr>-->
           <!--                                     <td class="text-center">4</td> 		-->
											<!--	 <td>Patient Collection</td>-->
											<!--	 <td id=colch><?php echo $total1; ?> Rs</td>-->
											<!--	  <td id=colc><?php echo $total; ?> Rs</td>-->
											<!--	    <td>-</td>-->
											<!--		 <td>-</td>-->
													 
           <!--                                 </tr>-->
                                            
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
    var $table1 = $('#bootstrap-table1');
    $('.datepicker').datetimepicker({
        format: 'YYYY'
    });

    $().ready(function() {
        $table.bootstrapTable({
            toolbar: ".toolbar",
            search: true,
            pagination: false,
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
        $table1.bootstrapTable({
            toolbar: ".toolbar",
            search: true,
            pagination: false,
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