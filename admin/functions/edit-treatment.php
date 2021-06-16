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
    $id = $_POST['id'];
   /*  $query = "SELECT id FROM treatments WHERE UPPER(name)=UPPER('$fname')";
    mysqli_query($conn,$query);
    if(!mysqli_affected_rows($conn)>0){
        display($success,"treatment already exists");
    }
 */
    $query = "UPDATE treatments SET name='$fname',amount='$cost',max_time=$max,min_time=$min WHERE id=$id";
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Treatment details successfully updated";
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
