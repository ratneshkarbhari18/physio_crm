<?php
include 'includes/session.php';
include '../includes/db.php';
$title = "All Vouchers";
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

    </style>
</head>
<body>

<div class="wrapper">
    
    <?php
        include 'includes/side-panel.php'
    ?>

    <div class="main-panel">
        
        <?php include 'includes/header.php' ?>

        <div class="main-content-area" style="width: 95%; margin: 0 auto;">
            <table id="bootstrap-table" class="table bootstrapTable">
                <thead>
                    <th data-field="type" data-sortable="true" class="text-center">Type</th>
                    <th data-field="convection" data-sortable="true" class="text-center">Convection</th>
                    <th data-field="narration" data-sortable="true">Narration</th>
                    <th data-field="amount">Amount</th>
                    <th data-field="date" class="text-center">Date</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM vouchers";
                        $res = mysqli_query($conn,$query);
                        while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr>
                        <td><?php echo $row['type']?></td>
                        <td><?php echo $row['convection']?></td>
                        <td><?php echo $row['narration']?></td>
                        <td><?php echo $row["amount"]; ?></td>
                        <td class="text-center"><?php echo $row["date"]; ?></td>
                        <td>
                        <a type="button" class="btn btn-danger"  href="edit_voucher.php?id=<?php echo $row["id"]; ?>">Edit</a>
                        <button type="button" style="background-color: red; color: white;" class="btn btn-danger"  data-toggle="modal" data-target="#deleteRecordModal-<?php echo $row["id"]; ?>">Delete</button>
                        <div class="modal fade" id="deleteRecordModal-<?php echo $row["id"]; ?>" tabindex="-1" aria-labelledby="<?php echo $row["id"]; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="functions/delete_voucher.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                        <h4>Are you sure to delete these record?</h4>
                                        <button style="background-color: red; color: white;" class="btn btn-danger" type="submit" >Yes, Delete it</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
           
    </div>
</div>


</body>
<script>
    
</script>
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
  <?php  /* <!--   Core JS Files  -->
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

	<!--  Checkbox, Radio, Switch and Tags Input Plugins -->
		<script src="../assets/js/bootstrap-switch-tags.min.js"></script>

	<!--  Charts Plugin -->
	<script src="../assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/bootstrap-notify.js"></script>

    <!-- Sweet Alert 2 plugin -->
	<script src="../assets/js/sweetalert2.js"></script>
<script src="../assets/js/plugins/sweetalert2.min.js" type="text/javascript"></script>
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
	<script src="../assets/js/plugins/bootstrap-table.js"></script> */ ?>



    <script>
$("li#all-vouchers").addClass("active");
var $table = $('#bootstrap-table');

$table.bootstrapTable({
        toolbar: ".toolbar",
        search: true,
        pagination: true,
        searchAlign: 'left',
        toolbarAlign: 'right',
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
    </script>

</html>
