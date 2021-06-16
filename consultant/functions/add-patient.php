<?php
include '../includes/session.php';
include '../../includes/db.php';
//session_start();
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $name = $_POST['name'];
	$treat=$_POST['treat'];
	$cost=$_POST['cost'];
// 		$mode = $_POST["mode"];
// 	$payment_details['mode'] = $mode;
// 	$pd = json_encode($payment_details);
	$date=date("Y-m-d");
    $success = false;
    $msg = "There was a problem";
    $id = 0;
    //var_dump($_SESSION['doctor_id']);
    $query = "INSERT INTO consultant(patient_name,treatment,cost,date,doc_id,covid) VALUES('$name','$treat','$cost','$date',".$_SESSION['doctor_id'].",10)";
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Patient was successfully added";
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