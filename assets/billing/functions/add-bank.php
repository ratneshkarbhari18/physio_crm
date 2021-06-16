<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
	$name=$_POST['name'];
	$acno=$_POST['acno'];
	$bname=$_POST['bname'];
	$ifsc =$_POST['ifsc'];
	$amount=$_POST['amount'];
	$date=date('Y/m/d');
    $success = false;
    $msg = "There was a problem";
    $id=0;
    $query = "INSERT INTO bank(name,acno,bname,amount,ifsc,date) VALUES('$name','$acno','$bname','$amount','$ifsc','$date');";
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