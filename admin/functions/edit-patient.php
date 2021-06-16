<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
	$doj = $_POST['doj'];
    $gender = $_POST['gender'];
	$type = $_POST['type'];
    $address = $_POST['address'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $id = $_POST['id'];
    $mob=$_POST['phone'];
	$per=$_POST['percent'];

	$hashpass=hash('sha512',$pass);
    $query = "UPDATE users SET name='$fname',dob='$dob',doj='$doj',gender='$gender',email='$email',type='$type',mobile='$mob',doc_percent='$per',address='$address',username='$uname',password='$hashpass' WHERE id=$id";
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Users details successfully updated";
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