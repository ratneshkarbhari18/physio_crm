<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
	$name=$_POST['name'];
	$nop=$_POST['nop'];
	$amount=$_POST['amount'];


    $success = false;
    $msg = "There was a problem";
    $id=0;
	$date=date("M");
$date1=date("Y/m/d");
    $query = "INSERT INTO docsal(name,nop,amount,month,date) VALUES('$name','$nop','$amount','$date','$date1');";
	//var_dump($query);
	//var_dump(mysqli_query($conn,$query));
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Details was successfully added";
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