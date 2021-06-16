<?php
    include 'includes/session.php';
    include '../includes/db.php';
    redirect();
    $title = "Add Treatment";

    if(!isset($_GET['id'])){
        header("location:add-report.php");
    }
    $id = $_GET['id'];
    $query = "SELECT fname,lname,gender, age FROM patients WHERE id=$id";
    $res = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)==0){
        header("add-report.php");
    }
    $row = mysqli_fetch_assoc($res);
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
	.ch{
		//padding:10px !important;
	}
  .mar{
    margin-bottom: 0px;
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
                            <div class="card stacked-form">
                                <div class="card-header ">
                                    <h4 class="card-title">Create Report</h4>
                                </div>
                                <div class="card-body ">
                                    <form action="functions/add-report.php" method="POST" id="addReportForm">
                                      <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>Patient's ID:</label>
                                            <input type="hidden" name="id" value="<?php echo $id?>">
                                            <b> <label><?php echo $id?></label></b>
                                        </div>
                                        <div class='form-group col-md-3'>
                                            <label>Patient's Name:</label>
                                            <b> <label><?php echo $row['fname']." ".$row['lname']?></label></b>
                                        </div>

                                        <div class='form-group col-md-3'>
                                            <label>Patient's Age:</label>
                                            <b> <label><?php echo $row['age']?></label></b>
                                        </div>
                                        <div class='form-group col-md-3'>
                                            <label>Patient's Gender:</label>
                                            <b> <label><?php echo $row['gender']?></label></b>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Base Treatment Type </label>

                                            <select required="" data-title="Select Base Treatment" id="base-treatment" name="base-treatment" class="selectpicker" data-style="btn-success btn-fill btn-block" data-menu-style="dropdown-green">
                                                <?php
                                                    $query = "SELECT * FROM treatments";
                                                    $res = mysqli_query($conn,$query);
                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                ?>
                                                <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
											                                 <div class='form-group col-md-12'>
                                                    <label>Time Required (in mins.)</label>
                                                    <input type='number' required="" name='base-time' min="0" max=20 class='form-control' >
                                                </div>
                                          <!--  <div class="row">
                                                <div class='form-group col-md-6'>
                                                    <label>Base Treatment Bed No. </label>
                                                    <input type='number' required="" name='base-bed' min="0" value="0" max="12" class='form-control' >
                                                </div>
                                                <div class='form-group col-md-6'>
                                                    <label>Time Required (in mins.)</label>
                                                    <input type='number' required="" name='base-time' min="0" class='form-control' >
                                                </div>
                                            </div>-->
                                          <!--  <select multiple data-title="Select Additional Treatment" id="treatment" name="treat[]" class="selectpicker" data-style="btn-success btn-fill btn-block" data-menu-style="dropdown-green">
                                                <?php/*
                                                    $query = "SELECT * FROM treatments";
                                                    $res = mysqli_query($conn,$query);
                                                    while ($row = mysqli_fetch_assoc($res)) {

                                                <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>

                                                    }*/
                                                ?>
                                            </select>-->
                                            <?php if($_SESSION['doctor_name']=="attented"){?>
                                                <div class='form-group col-md-12'>
                                                    <label>Treated By: </label>
													<select  data-title="Select Doctor" id="doc-name" name="other" class="selectpicker" data-style="btn-success btn-fill btn-block" data-menu-style="dropdown-green">
                                                <?php
                                                    $query = "SELECT * FROM users where type='doctor'";
                                                    $res = mysqli_query($conn,$query);
                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                ?>
                                                <option value="<?php echo $row['name']?>"><?php if($row['id']!=1){?>Dr. <?php }?><?php echo $row['name']?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                                </div>

										<?php }	?>
											</div>


                                        <div class="form-group col-md-6">
                                            <label>Reffered Doctor</label>
                                            <select  data-title="Select Doctor" id="doc-id" name="doc-id" class="selectpicker" data-style="btn-success btn-fill btn-block" data-menu-style="dropdown-green">
                                                <?php
                                                    $query = "SELECT * FROM referring_doc";
                                                    $res = mysqli_query($conn,$query);
                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                ?>
                                                <option value="<?php echo $row['id']?>"><?php if($row['id']!=1){?>Dr. <?php }?><?php echo $row['name']?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        <div class="form-group col-md-12">
                                            <label>Name of Reffered Doctor</label>
                                            <input type="text"  name="rdname" class="form-control" >
                                        </div>
										 <div class="form-group col-md-12" >
                                            <label>Phone No.</label>
                                            <input type="number" pattern="\d{10,10}" title="Enter valid 10 digit phone number" name="rdphone" class="form-control" >
                                        </div>
                                       <!-- <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input name="doc_present" class="form-check-input" type="checkbox" id="doc" checked value="">
                                                    <span class="form-check-sign"></span>
                                                    Doctor is present
                                                </label>
                                            </div>
                                        </div> -->
										
                  </div>
                  </div>
                                        <center><button id="submit" type="submit" class="btn btn-fill btn-success">Submit</button></center>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
            						<div class="card stacked-form">
                                            <div class="card-header ">
                                                <h4 class="card-title">Additional Treatments:</h4>
                                            </div>
                                            <div class="card-body ">
                                              <div class="form-group">

                        											 <div class="row">
                        											<?php
                        											$query = "SELECT * FROM treatments";
                                                                            $res = mysqli_query($conn,$query);
                                                                            while ($row = mysqli_fetch_assoc($res)) {
                        											?>

                        											<div class="form-check ch col-md-2">
                                                                                    <label class="form-check-label">
                                                                                        <input class="form-check-input" id="<?php echo $row['id']?>" name="add[]" type="checkbox" value="<?php echo $row['id']?>">
                                                                                        <span class="form-check-sign"></span>
                                                                                        <?php echo $row['name']?>
                                                                                    </label>
                                                                                </div>
                        														 <div class="form-group mar col-md-2">
                                                                    <input type="number" min=0 max=<?php echo $row['max_time'] ?>  name="time[<?php echo $row['id']?>]" placeholder="Time(Max <?php echo $row['max_time'] ?> min )" class="form-control" >
                                                                </div>
                        											<?php
                                                                            }
                                                                        ?>
                                                                </div>
                        										</div>
                                                    </form>
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
    $(function() {

        $(".material-icons").html("<span class='pe-7s-close'></span>");

        //$('#treatment').change(function() {
            //var selected = $(this).find('option:selected', this);
           // $("#beds").html("");
           // var bed = $("#beds");
            //selected.each(function() {
            //    $("<div class='row'><div class='form-group col-md-6'><label>"+ $(this).html() +"'s Bed No. </label><input required='' type='number' min='0' value='0' max='12' name='bed["+ $(this).val() +"]' class='form-control' ></div><div class='form-group col-md-6'><label>Time (in mins) </label><input required='' type='number' min='0' name='time["+ $(this).val() +"]' class='form-control' ></div></div>").appendTo("div#beds");
           // });
        //});


        $('#base-treatment').change(function() {
            var val = $(this).val();
            $('#treatment').children('option').attr("disabled",false);
			$("input.form-check-input").removeAttr("disabled");
            $('#treatment').children('option[value="'+val+'"]').attr("disabled",true);
            $('#treatment').children('option[value="'+val+'"]').prop("selected",false);
			$('input:checkbox[value="'+val+'"]').prop('disabled', true);
            $('#treatment').selectpicker('render');

        });
    });
</script>


<script type="text/javascript">
    $("#addReportForm").submit(function(e) {
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
                    try{
                        console.log(data);
                        var obj = JSON.parse(data);
                        $("#submit").attr("disabled", false);
                        var color = "danger";
                        var icon = "nc-notification-70";
                        var fun = undefined;
                        if(obj.success){
                            // color = "success";
                            // icon = "nc-check-2";
                            // func = function(){
                            //         window.location.href = 'add-report.php';
                            //     }
                                showNotification("success", "nc-check-2", obj.msg, function(){
                            window.location = "add-report.php";
                        });
                        }
                        else{
                        showNotification("danger", "nc-notification-70", obj.msg);
                      }
                        //showNotification(color, icon, obj.msg, func);
                    }catch(err){
                      func = function(){
                              window.location.href = 'add-report.php';
                          }
                          $("#submit").css("display","none");
                        showNotification("success", "nc-notification-70", "Report was successfully added",func);
                         //window.location.href = 'add-report.php';
                        //$("#submit").attr("disabled", false);
                    }
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
                    align: "right"
                },
                onClose: func
            });
    }
</script>
<script type="text/javascript">
    $(function () {
        $("#doc").click(function () {
            if ($(this).is(":checked")) {
                $("#other").hide();
				$('#other').attr("value", "");
            } else {
                $("#other").show();

            }
        });
    });
</script>
</html>
