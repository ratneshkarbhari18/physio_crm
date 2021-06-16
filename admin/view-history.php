<?php
    include 'includes/session.php';
    include '../includes/db.php';
    redirect();
    $title = "View Patient Hisory";
    if(!isset($_GET['id'])){
        header('location:add-report.php');
    }
    $id = $_GET['id'];
    $sql = "SELECT fname,lname,gender,TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age FROM patients WHERE id=$id";
    $res = mysqli_query($conn,$sql);
    if(mysqli_affected_rows($conn)<1){
        header('location:add-report.php');
    }
    $row = mysqli_fetch_assoc($res);
    $g = array("M"=>"Male","F"=>"Female","O"=>"Other");
    $name = $row["fname"]." ".$row["lname"];
    $age = $row["age"];
    $gender = $g[$row["gender"]];
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card-body">
                                            Patient ID: <strong><?php echo $id?></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card-body">
                                            Name: <strong><?php echo $name?></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card-body">
                                            Age: <strong><?php echo $age?></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card-body">
                                            Gender: <strong><?php echo $gender?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                            <div class="card bootstrap-table">
                                <div class="card-body table-full-width">
                                    <div class="toolbar" style="margin: 0 85px;">
                                        <button onclick="window.location.href='functions/export-history.php?id=<?php echo $id?>'" class="btn btn-success btn-wd">
                                            Export History
                                            <span class="btn-label btn-label-right">
                                                <i class="fa fa-table"></i>
                                            </span>
                                            
                                        </button>
                                    </div>
                                    <table id="bootstrap-table" class="table">
                                        <thead>
                                            <th data-field="id" data-sortable="true" class="text-center">Bill ID</th>
                                            <th data-field="name" data-sortable="true">Treatment</th>
                                            <th data-field="age">Doctor</th>
                                            <th data-field="gender">Date</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $query = "SELECT r.id,r.base_treatment,r.treatments,r.time_stamp,d.name FROM reports r, users d WHERE r.doc_id=d.id AND p_id=$id ORDER BY r.time_stamp DESC";
                                                $res = mysqli_query($conn,$query);
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $ts = "";
                                                    $t = array(json_decode($row['base_treatment'],true)["id"]);
                                                    $array = json_decode($row['treatments'],true);
                                                    foreach($array as $i){
                                                        array_push($t,$i['id']);
                                                    }
                                                    $first = true;
                                                    foreach($t as $i){
                                                        $sql = "SELECT name FROM treatments WHERE id=$i";
                                                        $r = mysqli_fetch_assoc(mysqli_query($conn,$sql));
                                                        if(!$first){
                                                            $ts.=", ";
                                                        }
                                                        $ts.=$r['name'];
                                                        $first=false;
                                                    }
                                                    
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id']?></td>
                                                <td><?php echo $ts?></td>
                                                <td><?php echo $row['name']?></td>
                                                <td><?php echo $row['time_stamp']?></td>
                                            </tr>
                                            <?php
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


<script type="text/javascript">
    var $table = $('#bootstrap-table');

   
    $().ready(function() {
      
        $table.bootstrapTable({
            toolbar: ".toolbar",
            pagination: true,
            toolbarAlign: 'right',
            pageSize: 8,
            clickToSelect: false,
            pageList: [8, 10, 25, 50, 100],

            formatShowingRows: function(pageFrom, pageTo, totalRows) {
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

        $('[rel="tooltip"]').tooltip();

        $(window).resize(function() {
            $table.bootstrapTable('resetView');
        });


    });
</script>
</html>