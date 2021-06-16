<?php    include '../includes/db.php';
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
    <?php 
    $getFieldsQuery = "SELECT `COLUMN_NAME` 
    FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA`='crm' 
        AND `TABLE_NAME`='past_year_amounts'";
    
    $fieldsRes = mysqli_query($conn,$getFieldsQuery);

    $past_amounts_query = "SELECT * FROM past_year_amounts LIMIT 1";
    $past_amounts_res = mysqli_query($conn,$past_amounts_query); 


    
    ?>
    <div class="wrapper">
        <?php include 'includes/sidebar.php'?>
        <div class="main-panel">
            <?php include 'includes/header.php'?>
            <div class="content">
                <div class="container-fluid">
                    <form action="functions/last_year_amounts_submit.php" method="post">
                    <?php while($field = mysqli_fetch_assoc($fieldsRes)): if($field["COLUMN_NAME"]!="id"):  ?>
                        <div class="form-group">
                            <label for="type"><?php echo ucfirst(str_replace('_',' ',$field["COLUMN_NAME"])); ?></label>
                            <input  type="text" name="<?php echo $field["COLUMN_NAME"]; ?>" id="<?php echo $field; ?>" class="form-control">
                        </div>
                    <?php endif; endwhile; ?>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
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