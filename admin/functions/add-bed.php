<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
    $fname = $_POST['nob'];
    $success = false;
    $msg = "There was a problem";
	
	$query1="select * from bed";
	$result1=mysqli_query($conn,$query1);
	$row=mysqli_fetch_array($result1);
    $nb=$row['no_of_beds']+1;
    $query = "UPDATE `bed` SET `no_of_beds`=$nb WHERE 1";
    //var_dump($query);
	if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Bed was successfully added";
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