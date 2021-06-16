<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $location = $_POST['location'];
    $aadhaar = isset($_POST['aadhaar']) ? $_POST['aadhaar'] : "";
    $r_phone = $_POST['r_phone'];
    $success = false;
    $msg = "There was a problem";
    $id = 0;
    
    $query = "SELECT id FROM patients WHERE UPPER(fname)=UPPER('$fname') AND UPPER(lname)=UPPER('$lname') AND dob='$dob' AND gender='$gender'";
    mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        display($success,"Patient already exists",$id);
    }
    
    $query = "INSERT INTO patients(fname,lname,dob,gender,aadhaar,address,r_phone,pincode,location) VALUES('$fname','$lname','$dob','$gender','$aadhaar','$address','$r_phone','$pincode','$location')";
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