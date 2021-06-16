<?php
    include 'includes/session.php';
    include '../includes/db.php';
    redirect();
    $title = "Daily Cashbook";
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
                        <form action="functions/export-donation.php" id="exportDonationForm">            
                        <div class="col-md-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card-body">
                                            <input type="text" required="" name="from" class="form-control datepicker" placeholder="From Date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card-body">
                                            <input type="text" required="" name="to" class="form-control datepicker" placeholder="To Date">
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
                        <div class="col-md-12">
                            <div class="card bootstrap-table">
                                <div class="card-body table-full-width">
                                    <div class="toolbar">
                                    </div>
                                    <table id="bootstrap-table" class="table">
                                        <thead>
                                            <th data-field="sr-no" data-sortable="true" class="text-center">Sr No.</th>
                                            <th data-field="date" data-sortable="true">Date</th>
                                            <th data-field="number">Opening Balance</th>
                                            <th data-field="number1">Credit</th>
                                            <th data-field="number2">Debit</th>
                                            <th data-field="number3">Balance</th>
                                        </thead>
                                        <tbody>
										<?php
										$debit=0;
										$date=date('Y-m-d');
										$ndate=date('Y/m/d', strtotime(' +1 day'));
										$query1="select * from cashbook where date<='$date'";
										$result1=mysqli_query($conn,$query1);
										//var_dump($query1);
										while($row1=mysqli_fetch_array($result1)){
											
											if($row1['date']==$date){
												
										$query="select * from vouchers where date='$date'";
										$result=mysqli_query($conn,$query);

										$query7="select * from bank where date='$date'";
										$result7=mysqli_query($conn,$query7);
										
										$query8="select * from docsal where date='$date'";
										$result8=mysqli_query($conn,$query8);

										$query9="select * from staffsal where date='$date'";
										$result9=mysqli_query($conn,$query9);
										
										while($row=mysqli_fetch_array($result)){
										$debit=$debit + $row['amount'];
										}
			
										while($row7=mysqli_fetch_array($result7)){
										$debit=$debit + $row7['amount'];
										}

										while($row8=mysqli_fetch_array($result8)){
										$debit=$debit + $row8['amount'];
										}
			
										while($row9=mysqli_fetch_array($result9)){
										$debit=$debit + $row9['ns'];
										}
											
										
										?>
                                            <tr>
                                                <td><?php echo $row1['id'];?></td>
                                                <td><?php echo date('d/m/Y')?></td>
                                                <td><?php $op=(int)$row1['opening'];echo $row1['opening'];?></td>
                                                <td><?php include 'daily-calc.php' ?></td>
												<td><?php echo $debit; ?></td>
												<td><?php $bal=($op+$gt)-$debit; echo $bal; ?></td>
										<?php 										$query4="update `cashbook` set  `balance`='$bal',`credit`='$gt',`debit`='$debit' where `date`= '$date'";
										$result4=mysqli_query($conn,$query4);
										$query5="update `cashbook` set  `opening`='$bal' where `date`= '$ndate'";
										$result5=mysqli_query($conn,$query5);}else{
											
											echo '<tr>
                                                <td>'.$row1['id'].'</td>
                                                <td>'.$row1['date'].'</td>
                                                <td>'.$row1['opening'].'</td>
                                                <td>'.$row1['credit'].'</td>
												<td>'.$row1['debit'].'</td>
												<td>'.$row1['balance'].'</td>';
										}echo '</tr>';}
										$query2="select * from cashbook order by date DESC";
										$result2=mysqli_query($conn,$query2);
										$row2=mysqli_fetch_array($result2);
										$ndate=date('Y/m/d', strtotime(' +1 day'));
										if($row2['date']!=date('Y-m-d', strtotime(' +1 day'))){
										$query3="INSERT INTO `cashbook` (`opening`, `balance`,`credit`,`debit`, `date`) VALUES ('$bal', '$bal','$gt','$debit', '$ndate')";
										$result3=mysqli_query($conn,$query3);

										}
										else{
											
										}
										//var_dump($query4);
										?>
                                            
                                          
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
    $("#nav-daily").addClass("active");
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
</html>