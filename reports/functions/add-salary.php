<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $name = $_POST['name'];
    $days = $_POST['days'];
    $month = $_POST['month'];
    $gross = $_POST['gross'];
    $success = false;
    $msg = "There was a problem";
    
    $query = "INSERT INTO salary(name,days,month,gross) VALUES('$name',$days,'$month',$gross)";
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Salary was successfully added";
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