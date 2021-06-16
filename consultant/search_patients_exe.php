<?php
    include '../includes/db.php';
    $search_query_term = $_POST["patient_name_search_query"];
    $sql=" SELECT * FROM patients WHERE fname like '%".$search_query_term."%' OR lname like '%".$search_query_term."%'";
    $search_results = mysqli_query($conn,$sql);
    $title = "Patient Search Results";
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
            <div class="content container">
                <div class="row">
                    <div class="col-lg-2 col-md-12 col-sm-12"></div>
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <table id="bootstrap-table" class="table">
                            <thead>
                                <th data-field="id" data-sortable="true" class="text-center"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patient ID </th>
                                <th data-field="name" data-sortable="true">Name</th>
                                <th data-field="age">Age</th>
                                <th data-field="gender">Gender</th>
                                <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Actions</th>
                            </thead>
                            <tbody>
                                <?php
                                ini_set('display_errors', 'Off');
                                    $res = $search_results;
                                    //var_dump($res);
                                    $s="SELECT year(getdate())-year(age) as age1 from patients";
                                    $r=mysqli_query($conn,$s);
                                    while($ro = mysqli_fetch_assoc($r)){echo $ro['age1'];}
                                    while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id']?></td>
                                    <td><?php echo $row['fname']." ".$row['lname']?></td>
                                    <td><?php echo $row['age']?></td>
                                    <td><?php echo $row['gender']?></td>
                                    <td style="text-align: center;">
                                        <a href="create-reportx.php?id=<?php echo $row['id']; ?>">
                                        <i style="color: red;" class="fa fa-plus-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12"></div>
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
