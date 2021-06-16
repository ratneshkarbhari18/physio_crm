<?php
    include 'includes/session.php';
    include '../includes/db.php';
    redirect();
    $title = "Edit Patient";
    if(!isset($_GET['id'])){
        header("location:add-report.php");
    }
    $id = $_GET['id'];
    $query = "SELECT * FROM patients WHERE id=$id";
    $res = mysqli_query($conn,$query);
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
</head>

<body>
    <div class="wrapper">
        <?php include 'includes/sidebar.php'?>
        <div class="main-panel">
            <?php include 'includes/header.php'?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card stacked-form">
                                <div class="card-header ">
                                    <h4 class="card-title">Edit Patient</h4>
                                </div>
                                <div class="card-body ">
                                    <form action="functions/edit-patient.php" id="editPatientForm">
                                        <input type="hidden" name="id" value='<?php echo $id?>'>
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" value="<?php echo $row['fname']?>" name="fname" class="form-control" >
                                        </div>

                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" value="<?php echo $row['lname']?>" name="lname" class="form-control" >
                                        </div>


                                        <div class="form-group">
                                                <label>Age</label>
                                                <input type="text" value="<?php echo $row['age']?>" name="dob" class="form-control" >
                                        </div>

                                        <div class="form-group">
                                            <label>Gender</label>

                                            <select required="" data-title="Select Gender" name="gender" class="selectpicker" data-style="btn-success btn-fill" data-menu-style="dropdown-green">
                                                <option value="M" selected="selected" >Male</option>
                                                <option value="F"<?php if($row['gender']=="F"){echo 'selected="selected"';} ?>>Female</option>
                                                <option value="O"<?php if($row['gender']=="O"){echo 'selected="selected"';} ?>>Other</option>
                                            </select>
                                        </div>


                                        <br>

                                        <div class="form-group">
                                            <label>Aadhaar No.</label>
                                            <input type="text" name="aadhaar" pattern="\d{12,12}" title="Enter valid 12 digit aadhaar number" class="form-control" value="<?php echo $row['aadhaar']?>" >
                                        </div>
										<div class="form-group">
                                            <label>Phone No.</label>
                                            <input type="text" required="" pattern="\d{10,10}" title="Enter valid 10 digit phone number" name="phone" class="form-control"  value="<?php echo $row['phone']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Relative's Phone No. (Emergency)</label>
                                            <input type="text" required="" pattern="\d{10,10}" title="Enter valid 10 digit phone number" name="r_phone" class="form-control"  value="<?php echo $row['r_phone']?>">
                                        </div>

                                        <div class="form-group">
                                                <label>Address</label>
                                                <textarea required="" name="address" class="form-control"><?php echo $row['address']?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" required="" name="location" class="form-control"   value="<?php echo $row['location']?>">
                                        </div>


                                        <div class="form-group">
                                            <label>Pincode</label>
                                            <input type="text" required="" pattern="\d{6,6}" title="Enter valid pincode" name="pincode" class="form-control"  value="<?php echo $row['pincode']?>" >
                                        </div>
                                        <center><button id="submit" type="submit" class="btn btn-fill btn-success">Submit</button></center>

                                </div>
                            </div>
                        </div>
						<div class="col-md-6">
						<div class="card stacked-form">
                                <div class="card-header ">
                                    <h4 class="card-title">Patient Standard history</h4>
                                </div>
                                <div class="card-body ">


                                        <div class="form-group">
                                            <label>C/O<sup style="color:#ff0000;font-size:15px;">*</sup></label>
                                            <input type="text" required="" name="co" value="<?php echo $row['CO']?>" class="form-control" >
                                        </div>

                                        <div class="form-group">
                                            <label>H/O<sup style="color:#ff0000;font-size:15px;">*</sup></label>
                                            <input type="text" required="" name="ho" value="<?php echo $row['HO']?>" class="form-control" >
                                        </div>


                                        <div class="form-group">
                                                <label>M/H/O<sup style="color:#ff0000;font-size:15px;">*</sup></label>
                                                <input type="text" required="" name="mho" value="<?php echo $row['MHO']?>" class="form-control" >
                                        </div>

                                        <div class="form-group">
                                            <label>IX<sup style="color:#ff0000;font-size:15px;">*</sup></label>
                                            <input type="text" required="" name="ix" value="<?php echo $row['IX']?>" class="form-control" >
                                        </div>

										<div class="form-group">
                                            <img src="../assets/img/triangle.png"> <sup style="color:#ff0000;font-size:15px;">*</sup>
                                            <input type="text" required="" name="tri" value="<?php echo $row['tri']?>" class="form-control" >
                                        </div>



                                        </form>
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

        $('#treatment').change(function() {
            var selected = $(this).find('option:selected', this);
            $("#beds").html("");
            var bed = $("#beds");
            selected.each(function() {
                $("<div class='row'><div class='form-group col-md-6'><label>"+ $(this).html() +"'s Bed No. </label><input required='' type='number' min='0' value='0' max='12' name='bed["+ $(this).val() +"]' class='form-control' ></div><div class='form-group col-md-6'><label>Time (in mins) </label><input required='' type='number' min='0' name='time["+ $(this).val() +"]' class='form-control' ></div></div>").appendTo("div#beds");
            });
        });


        $('#base-treatment').change(function() {
            var val = $(this).val();
            $('#treatment').children('option').attr("disabled",false);
            $('#treatment').children('option[value="'+val+'"]').attr("disabled",true);
            $('#treatment').children('option[value="'+val+'"]').prop("selected",false);
            $('#treatment').selectpicker('render');
        });
    });
</script>


<script type="text/javascript">
    $("#editPatientForm").submit(function(e) {
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
                                window.location.href = 'add-report.php';
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
