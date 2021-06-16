<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
	$id = $_GET['id'];
	$query="Delete from users where id=$id";
	//var_dump($query);
	if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "users details successfully updated";
        $id = mysqli_insert_id($conn);
    }
	display($success,$msg);

	
}
	function display($success, $msg){
	header("Location:../users.php");
}
?>