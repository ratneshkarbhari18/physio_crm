<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
	$convection=$_POST['pay'];
	$amount=$_POST['amount'];
	$amount_word =$_POST['amount-word'];
	$mode = $_POST["mode"];
	$payment_details['mode'] = $mode;
	if($mode=="cheque"){
    $payment_details['bank'] = $_POST['bname'];
    $payment_details['branch'] = $_POST['branch'];    
    $payment_details['cheque_no'] = $_POST['cheque_no']; 
    $payment_details['cheque_date'] = $_POST['cheque_date']; 
}
	$pd = json_encode($payment_details);
	$date=date('Y/m/d');
    $success = false;
    $msg = "There was a problem";
    $id=0;
    $query = "INSERT INTO ad(name,amount,amount_word,date,mode) VALUES('$convection','$amount','$amount_word','$date','$pd');";
	//var_dump($query);
	//var_dump(mysqli_query($conn,$query));
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Voucher was successfully added";
        $id = mysqli_insert_id($conn);
    }   
}else{
    $msg = "Invalid Session";
}
display($success,$msg);
function display($success, $msg){
	die(json_encode(array("success"=>$success, "msg"=>$msg)));
}
?>