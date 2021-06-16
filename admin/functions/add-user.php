<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
	$email = $_POST['email'];
    $dob = $_POST['dob'];
	$doj = $_POST['doj'];
    $gender = $_POST['gender'];
	$type = $_POST['type'];
    $address = $_POST['address'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
	$mob=$_POST['phone'];
	$per=$_POST['percent'];
    //$aadhaar = isset($_POST['aadhaar']) ? $_POST['aadhaar'] : "";
    //$r_phone = $_POST['r_phone'];
    $success = false;
    $msg = "There was a problem";
    $id = 0;
    
    $query = "SELECT id FROM users WHERE UPPER(name)=UPPER('$fname $lname') AND email='$email' AND dob='$dob' AND gender='$gender'";
    mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        display($success,"user already exists",$id);
    }
    $hashpass=hash('sha512',$pass);
    $query = "INSERT INTO users(name,doj,email,dob,gender,type,address,username,password,mobile,doc_percent) VALUES('$fname $lname','$doj','$email','$dob','$gender','$type','$address','$uname','$hashpass','$mob','$per')";
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