<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
	$mob= $_POST['phone'];
    $fname = $_POST['fname'];
    $address = $_POST['address'];
	
	//var_dump($_POST['phone']);
    $success = false;
    $msg = "There was a problem";
    $id = 0;
    
    $query = "SELECT id FROM referring_doc WHERE UPPER(name)=UPPER('$fname')";
    mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        display($success,"user already exists",$id);
    }
    $query = "INSERT INTO referring_doc(name,mobile,address) VALUES('$fname','$mob','$address')";
    //var_dump($query);
	if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "user was successfully added";
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