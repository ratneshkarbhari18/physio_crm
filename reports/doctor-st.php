<?php
    include 'includes/session.php';
    include '../includes/db.php';
    redirect();
    $title = "Doctor Reports";
    $tef=0;
$new=0;
function calculate($id, $pid, $base, $other){
    $total = 0;
    global $conn;
    $t = array(json_decode($base,true)['id']);
    $b = $t[0];
    $array = json_decode($other,true);
    foreach($array as $i){
        array_push($t,$i['id']);
    }
    $first = false;
    foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r);
        if($b == $i)
            $a = $row["amount"];
        else
            $a = 10;
        $first = true;    
        $total+=$a;
    }
    $total += 25;
    $query = "SELECT MIN(id) FROM reports WHERE p_id=$pid";
    $r = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        $row = mysqli_fetch_array($r);
        if($id==$row[0]){
            $total +=10;
            $GLOBALS['tef'] +=10;
            $GLOBALS['new'] +=1;
        }
    }
    return $total;
  }
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
                        <form action="functions/export-doctor.php" id="exportDoctorForm">            
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
                                            <th data-field="name" data-sortable="true">Name Of Doctor</th>
                                            <th data-field="type">No. Of Patients</th>
                                            <th data-field="tef">Total Enterance Fee</th>
                                            <th data-field="visit">Patients visit</th>
                                            <th data-field="rev">Redevelopment Fee</th>
                                            <th data-field="cov">COVID-19 Fee</th>
                                            <th data-field="t-cost">Treatment Cost</th>
                                            <th data-field="t-amount">Total Amount</th>
                                            <th data-field="percent">Percentage</th>
                                            <th data-field="amount">Doctor %</th>
                                             <th data-field="centre">Centre %</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $query = "SELECT * FROM users WHERE type='doctor'";
                                                $res = mysqli_query($conn,$query);
                                                $covid=0;
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $per=$row['doc_percent']/100;
                                                    
                                                    $id = $row['id'];
                                                    $q = "SELECT * FROM reports WHERE doc_id=$id AND paid=1";
                                                    $r = mysqli_query($conn, $q);
                                                    $count = mysqli_num_rows($r);
                                                    $np="SELECT * FROM `reports` where doc_id=$id AND paid=1 GROUP BY p_id";
                                                    $nrp=mysqli_query($conn, $np);
                                                    //var_dump($nrp);
                                                    $count1 = mysqli_num_rows($nrp);
                                                    //$tef=10*$count1;
                                                    $red=25*$count;
                                                    $amount = 0;
                                                    while($rw = mysqli_fetch_assoc($r)){
                                                        if($rw['covid']==10){
                                                            $covid+=10;
                                                        }
                                                        $amount+=calculate($rw['id'],$rw['p_id'],$rw['base_treatment'],$rw['treatments']);
                                                    }
                                                    $peram=$amount-$tef-$red;
                                            ?>
                                            <tr>
                                                <td><?php echo $row['name']?></td>
                                                <td><?php echo $new?></td>
                                                <td><?php echo $tef?></td>
                                                <td><?php echo $count?></td>
                                                <td><?php echo $red." Rs"?></td>
                                                <td><?php echo $covid." Rs"?></td>
                                                <td><?php echo $peram." Rs"?></td>
                                                <td><?php echo $amount +$covid." Rs"?></td>
                                                <td><?php echo $row['doc_percent']." %"?></td>
                                                <td><?php echo $peram*$per." Rs"?></td>
                                                 <td><?php echo ($peram -($peram*$per))+$covid+$tef+$red." Rs"?></td>
                                            </tr>
                                            <?php
                                            $tef=0;
                                            $new=0;
                                            $covid=0;
                                                }
                                            ?>
											<?php
											$q1="select * from users where type='consultant'";
											$r1=mysqli_query($conn,$q1);
											$covid=0;
											while($rw=mysqli_fetch_array($r1)){
												$per=$rw['doc_percent']/100;
												 $id = $rw['id'];
												$q2 = "SELECT * FROM consultant WHERE doc_id=$id AND paid=1";
                                                    $r2 = mysqli_query($conn, $q2);
													 $count = mysqli_num_rows($r2);
													 $tef=25*$count;
													 while($rw2=mysqli_fetch_array($r2))
													 {
													     if($rw2['covid']==10){
                                                            $covid+=10;
                                                        }
														 $amount1+=$rw2['cost'];
													 }
													 $amount1 +=$tef;
												$pera=$amount1-$tef;
											
												?>
												 <tr>
                                                <td><?php echo $rw['name']?></td>
                                                <td><?php echo $count?></td>
                                                <td><?php echo "0 Rs"?></td>
                                                <td><?php echo $count?></td>
                                                <td><?php echo $tef." Rs"?></td>
                                                <td><?php echo $covid." Rs"?></td>
                                                <td><?php echo $pera." Rs"?></td>
                                                <td><?php echo $amount1 +$covid." Rs"?></td>
                                                <td><?php echo $rw['doc_percent']." %"?></td>
                                                <td><?php echo $pera*$per." Rs"?></td>
                                                 <td><?php echo $pera -($pera*$per) +$covid+$tef." Rs"?></td>
                                            </tr>
												<?php
													$tef=0;
											        $covid=0;
											}
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
    $("#nav-doctorst").addClass("active");
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
    
    $("#exportDoctorForm").submit(function(e) {
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