<?php
    include 'includes/session.php';
    include '../includes/db.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
  
    $title = "Profit And Loss Date Range Result";
    redirect();
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
<style>
*{
    font-size: 0.9rem;
}
</style>
    <div class="wrapper">
        <?php include 'includes/sidebar.php'?>
        <div class="main-panel">
            <?php include 'includes/header.php'?>
            <div class="content">
                <div class="container-fluid">
                    <?php

                    function getTotalForTable($date_from,$date_to,$table_name,$date_field_name,$amount_field_name){
                        $query = "SELECT * FROM ".$table_name;
                        $amountSum = 0.00;
                        include '../includes/db.php';

                        $res = mysqli_query($conn,$query);
                        $resultObj = array();
                        while ($row = mysqli_fetch_assoc($res)) {
                            if($row["date"]>$date_from&&$row["date"]<$date_to){
                                $amountSum=$amountSum+$row[$amount_field_name];
                            }
                        }
                        return $amountSum;
                    }
                    function getTotalForVoucherType($date_from,$date_to,$table_name,$date_field_name,$amount_field_name,$voucher_type){
                        $query = "SELECT * FROM ".$table_name;
                        $amountSum = 0.00;
                        include '../includes/db.php';

                        $res = mysqli_query($conn,$query);
                        $resultObj = array();
                        while ($row = mysqli_fetch_assoc($res)) {
                            if($row["date"]>$date_from&&$row["date"]<$date_to&&$row["type"]==$voucher_type){
                                $amountSum=$amountSum+$row["amount"];
                            }
                        }
                        return $amountSum;
                    }
                    $addIncome = getTotalForTable($_POST["date_start"],$_POST["date_end"],"ex_income","date","cost");
                    $docSalSum = getTotalForTable($_POST["date_start"],$_POST["date_end"],"docsal","date","amount");
                    
                    $query = "SELECT * FROM donations";
                    $doantionRes = mysqli_query($conn,$query);
                    $donationSum = 0.00;
                    
                    while ($row = mysqli_fetch_assoc($doantionRes)) {
                        $rowDate = strtotime($row["payment_time"]);
                        $rowDate = date("Y-m-d",$rowDate);
                    //    if($rowDate>$date_from&&$rowDate<$date_to){
                            $donationSum=+$row['amount'];
                    //    }
                    }   
                    $query = "SELECT * FROM staffsal";
                    $staffSalRes = mysqli_query($conn,$query);
                    $staffSalSum = 0.00;
                    while ($row = mysqli_fetch_assoc($staffSalRes)) {
                        $staffSalSum+=$row["ns"];
                    }                    
                    $electricityBillSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Electricity Bill");                    
                    $otherExpenseSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Other Expense");
                    $medSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Medicine");
                    $printingStatSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Printing and stationary");
                    $repairingSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Repairing");
                    $travellingSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Traveling");
                    $clothesWashingBuyingSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Clothes washing and buying");
                    $clothesWashingBuyingSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Clothes washing and buying");
                    $snacksSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Snacks");
                    $cleaningSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Cleaning");
                    $telePhoneSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Telephone");
                    $accountingSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Accounting Charge");
                    $lockerRentSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Locker Rent");
                    $adSum = getTotalForTable($_POST["date_start"],$_POST["date_end"],"ad","date","amount");
                    $festivalProgramSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Festivals / Programs");
                    $insurancePoliciesTaxesSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","Insurance Policies / Taxes");
                    $bankOverDraftsSum = getTotalForVoucherType($_POST["date_start"],$_POST["date_end"],"vouchers","date","amount","BankOverDraft");
                    $query = "select DISTINCT(p_id) from reports";
                    $res = mysqli_query($conn,$query);
                    $newPatientFeesAmt = 0.00;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $newPatientFeesAmt+=10;
                    }
                    $query = "SELECT * FROM `reports`";
                    $res = mysqli_query($conn,$query);
                    $patientCollectionAmt = 0.00;
                    $covidTotal = 0.00;
                    while ($row = mysqli_fetch_assoc($res)) {
                        if(($row["pay_time"]>$_POST["date_start"])&&($row["pay_time"]<$_POST["date_end"])){
                            $covidTotal = $covidTotal + $row["covid"];
                            $baseTreatmentId = json_decode($row["base_treatment"],TRUE)["id"];
                            $otherTreatments = array();
                            if(!empty(json_decode($row["treatments"],TRUE))){
                                $otherTreatments[] = json_decode($row["treatments"],TRUE);
                            }
                            $baseTreatmentRes = mysqli_query($conn,"SELECT * FROM treatments WHERE id=$baseTreatmentId");
                            while ($rowBaseTreatment = mysqli_fetch_assoc($baseTreatmentRes)) {
                                $patientCollectionAmt+=$rowBaseTreatment["amount"];
                            }  
                            foreach (json_decode($row["treatments"],TRUE) as $treatment) {
                                $treatmentId = $treatment["id"];
                                $secondaryTreatmentRes = mysqli_query($conn,"SELECT * FROM treatments WHERE id=$treatmentId");
                                while ($rowSecondaryTreatment = mysqli_fetch_assoc($secondaryTreatmentRes)) {
                                    $patientCollectionAmt+$rowSecondaryTreatment["amount"];
                                }
                            } 
                        }
                    }
                    ?>                   
                    <div class="container-fluid">
                        <h4 class="text-center">All Amounts are in ₹ between <?php echo $_POST["date_start"].' and '.$_POST["date_end"]; ?></h4>
                        <div class="row">
                            <div class="col-md-6" style="padding:0 2%;">
                                <div class="card bootstrap-table" style="border-right: none;">
                                    <div class="card-body table-full-width">
                                        <table id="bootstrap-table" class="table">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left: 5% !important;">Expenses</th>
                                                    <th style="padding-left: 5% !important;">Amount</th>
                                                </tr>
                                            
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Doctor Salary</td>
                                                    <td><?php echo $docSalSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Staff Salary</td>
                                                    <td><?php echo $staffSalSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Printing and stationary</td>
                                                    <td><?php echo $printingStatSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Electricity Bill</td>
                                                    <td><?php echo $electricityBillSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Other Expense</td>
                                                    <td><?php echo $otherExpenseSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Repairing</td>
                                                    <td><?php echo $repairingSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Medicine</td>
                                                    <td><?php echo $medSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Travelling</td>
                                                    <td><?php echo $medSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Clothes washing and buying</td>
                                                    <td><?php echo $clothesWashingBuyingSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Snacks</td>
                                                    <td><?php echo $snacksSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Cleaning</td>
                                                    <td><?php echo $cleaningSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Telephone</td>
                                                    <td><?php echo $telePhoneSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Accounting Charge</td>
                                                    <td><?php echo $accountingSum; ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Locker Rent</td>
                                                    <td><?php echo $lockerRentSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Advertisment</td>
                                                    <td><?php echo $adSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Festivals / Programs</td>
                                                    <td><?php echo $festivalProgramSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Insurance Policies / Taxes</td>
                                                    <td><?php echo $insurancePoliciesTaxesSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Bank OD</td>
                                                    <td><?php echo $bankOverDraftsSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td><?php echo $insurancePoliciesTaxesSum+$bankOverDraftsSum+$adSum+$accountingSum+$festivalProgramSum+$lockerRentSum+$snacksSum+$telePhoneSum+$travellingSum+$electricityBillSum+$docSalSum+$staffSalSum+$printingStatSum+$otherExpenseSum+$clothesWashingBuyingSum; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding:0 2%;">
                                <div class="card bootstrap-table" style="border-right: none;">
                                    <div class="card-body table-full-width">
                                        <table id="bootstrap-table" class="table">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left: 5% !important;">Income</th>
                                                    <th style="padding-left: 5% !important;">Amount</th>
                                                </tr>
                                            
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Patient Collection</td>
                                                    <td><?php echo $patientCollectionAmt; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>New Patient Fee</td>
                                                    <td><?php echo $newPatientFeesAmt; ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Donations</td>
                                                    <td><?php echo $donationSum; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Covid Charges</td>
                                                    <td><?php echo $covidTotal; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Additional income</td>
                                                    <td><?php echo $addIncome; ?></td>
                                                </tr>
                                                <?php
                                                    for ($i=0; $i < 13; $i++) { 
                                                        echo '<tr><td><br></td><td><br></td></tr>';
                                                    }
                                                ?>
                                                <tr>
                                                    <td>Total</td>
                                                    <td><?php echo $newPatientFeesAmt+$patientCollectionAmt+$donationSum; ?></td>
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
</html>