<?php
include('../../includes/db.php');
include('../includes/session.php');
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$success = false;
$msg = "Login Failed";
if(!check()){
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = hash("sha512", $_POST['password']);
        $query = "SELECT * FROM users WHERE username='$username' and password='$password' and type='billing'";
        $res = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)>0){
            $success = true;
            $msg = "Login Successfull";
            $row = mysqli_fetch_assoc($res);
            $_SESSION['billing_id'] = $row['id'];
            $_SESSION['billing_name'] = $row['name'];
            $_SESSION['billing'] = true;
        }
    }else{
        $msg = "Please fill all the fields";
    }
}else{
    $msg = "Already Logged In";
}
die(json_encode(array('success'=>$success, 'msg'=>$msg)));
?>