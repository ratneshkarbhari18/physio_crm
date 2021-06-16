<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $fname = $_POST['fname'];
    $address = $_POST['address'];
    $id = $_POST['id'];
    $mob=$_POST['phone'];


	$hashpass=hash('sha512',$pass);
    $query = "UPDATE referring_doc SET name='$fname',mobile='$mob',address='$address' WHERE id=$id";
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Details successfully updated";
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