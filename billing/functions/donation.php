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
    $payment_details['cheque_no'] = $_POST['cheque_no'];    
}else if($mode=="card"){
    $payment_details['card_no'] = $_POST['card_no'];
}
$pd = json_encode($payment_details);
$type = $_POST['donor'];
if($type == "patient"){
    $p_id = $_POST['p_id'];
	$success = true;
        $msg = "Voucher was successfully added";
    $query = "UPDATE donations SET paid=b'1', payment_time=now(), payment_details='$pd' WHERE p_id=$p_id";
}else{
    $name = $_POST['name'];
    $type = $_POST['donor'];
    $amount = $_POST['donation'];
    $donation_date = $_POST['donation_date'];
	$success = true;
        $msg = "Donation was successfully added";
    $query = "INSERT INTO donations(name, type, amount, payment_time, payment_details, paid) VALUES('$name', '$type', $amount, '$donation_date', '$pd', b'1')";
}
if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Donation was successfully added";
        $id = mysqli_insert_id($conn);
    }
display($success,$msg);
function display($success, $msg){
	die(json_encode(array("success"=>$success, "msg"=>$msg)));
} 
//if(mysqli_query($conn,$query)){
  //  die("Donation Received");
//}else{
  //  die("There was an error: ".mysqli_error($conn));
//}
?>