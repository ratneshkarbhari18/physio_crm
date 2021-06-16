<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $fname = $_POST['fname'];
    $cost = $_POST['cost'];
    $max = $_POST['max'];
    $min = $_POST['min'];
    $success = false;
    $msg = "There was a problem";
    $id = 0;

    $query = "SELECT id FROM treatments WHERE UPPER(name)=UPPER('$fname')";
    mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        display($success,"Treatment already exists",$id);
    }
    $query = "INSERT INTO treatments(name,amount,max_time,min_time) VALUES('$fname','$cost',$max,$min)";
    //var_dump($query);
	if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Treatment was successfully added";
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
