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
    $aadhaar = isset($_POST['aadhaar']) ? $_POST['aadhaar'] : "";
	$phone=$_POST['phone'];
    $r_phone = $_POST['r_phone'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $location = $_POST['location'];
	$co=$_POST['co'];
	$ho=$_POST['ho'];
	$mho=$_POST['mho'];
	$ix=$_POST['ix'];
	$tri=$_POST['tri'];
    $id = $_POST['id'];
    $query = "SELECT id FROM patients WHERE UPPER(fname)=UPPER('$fname') AND UPPER(lname)=UPPER('$lname') AND age='$dob' AND gender='$gender' AND id!=$id";
    mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        display($success,"Patient already exists");
    }

    $query = "UPDATE patients SET fname='$fname',lname='$lname',age='$dob',gender='$gender',aadhaar='$aadhaar',phone='$phone',r_phone='$r_phone',address='$address',pincode='$pincode',location='$location', CO='$co',HO='$ho',MHO='$mho',tri='$tri',IX='$ix' WHERE id=$id";
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Patient details successfully updated";
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
