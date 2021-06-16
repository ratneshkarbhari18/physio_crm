<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
	$convection=$_POST['convection'];
	$narration=$_POST['narration'];
	$amount=$_POST['amount'];
	$amount_word =$_POST['amount-word'];
	$type=$_POST['t'];
	$date=date('Y/m/d');
    $success = false;
    $msg = "There was a problem";
    $id=0;
    $query = "INSERT INTO vouchers(type,convection,narration,amount,amount_word,date) VALUES('$type','$convection','$narration','$amount','$amount_word','$date');";
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