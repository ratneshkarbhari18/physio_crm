<?php
include '../includes/session.php';
include '../../includes/db.php';
//session_start();
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $name = $_POST['name'];
	$treat='General';
	$cost=$_POST['cost'];
// 		$mode = $_POST["mode"];
// 	$payment_details['mode'] = $mode;
// 	$pd = json_encode($payment_details);
	$date=$_POST['date'];
    $success = false;
    $msg = "There was a problem";
    $id = 0;
    //var_dump($_SESSION['doctor_id']);
    $mode = '{"mode":"cash"}';
    $query = "INSERT INTO consultant(patient_name,treatment,cost,date,doc_id,covid,mode,paid) VALUES('$name','$treat','$cost','$date',".$_SESSION['doctor_id'].",10,'$mode',1)";
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Patient was successfully added";
        $id = mysqli_insert_id($conn);
        echo '<script>window.location = "../add-patientx.php";</script>';
    }else {
        echo mysqli_error($conn);
    }
}else{
    $msg = "Invalid Session";
}
?>