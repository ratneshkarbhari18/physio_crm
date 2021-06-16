<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$payment_details = array();
$mode = $_POST["mode"];
$payment_details['mode'] = $mode;
if($mode=="cheque"){
    $payment_details['bank'] = $_POST['bname'];
    $payment_details['branch'] = $_POST['branch'];    
    $payment_details['cheque_no'] = $_POST['cheque_no']; 
    $payment_details['cheque_date'] = $_POST['cheque_date']; 
}
$pd = json_encode($payment_details);
$type = $_POST['desc'];
$convection=$_POST['pay'];
    $amount = $_POST['amount'];
	$success = true;
        $msg = "Voucher was successfully added";
    $query = "INSERT INTO ex_income(name,des, mode, cost, date) VALUES('$convection','$type','$pd', $amount, now())";

if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Voucher was successfully added";
        $id = mysqli_insert_id($conn);
    }
display($success,$msg);
function display($success, $msg){
	die(json_encode(array("success"=>$success, "msg"=>$msg)));
} 
?>